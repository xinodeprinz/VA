<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Help;
use App\Models\Plan;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use MeSomb\Operation\PaymentOperation;
use MeSomb\Signature;

class MomoController extends Controller
{

    protected $client;
    protected $data;
    protected $user;
    protected $amount;

    public function __construct()
    {
        $this->client = new PaymentOperation(env('MESOMB_APP'), env('MESOMB_ACCESS'), env('MESOMB_SECRET'));
    }

    public function show(Request $request, $type)
    {
        abort_if(!in_array($type, Help::paymentTypes()), 404);
        $title = $type;
        $plan = null;
        $user = Auth::user();
        $phone_number = $request->user()->phone_number;

        if ($type === 'plan') {
            if (!$request->session()->has('planId')) {
                return redirect()->route('plans');
            }
            $planId = $request->session()->get('planId');
            $plan = Plan::findOrFail($planId);
            $title = $plan->title;
        }
        // Flashing message to the session if its a plan or deposit.
        $alertTypes = ['deposit', 'plan'];
        if (in_array($type, $alertTypes)) {
            $request->session()->flash('info', __('main.payment-alert'));
        }

        return view('pages.user.payment', compact(
            'type', 'plan', 'title', 'phone_number', 'user'
        ));
    }

    protected function depositHelper(array $data)
    {
        try {
            $this->client->makeCollect(
                $data['amount'],
                $this->payService($data['phone_number']),
                $data['phone_number'],
                new DateTime(),
                Signature::nonceGenerator()
            );
            return true;
        } catch (\Throwable$th) {
            return false;
        }
    }

    private function payService(string $phone): string
    {
        if ($phone[1] == 9) {
            return "ORANGE";
        }

        if ($phone[1] == 5 && $phone[2] > 5) {
            return "ORANGE";
        }

        return "MTN";
    }

    protected function withdrawalHelper(array $data)
    {
        try {
            $this->client->makeDeposit(
                $data['amount'],
                $this->payService($data['phone_number']),
                $data['phone_number'],
                new DateTime(),
                Signature::nonceGenerator()
            );
            return true;
        } catch (\Throwable$th) {
            return false;
        }
    }

    public function processPlan(Request $request)
    {
        // Protecting route
        if (!$request->session()->has('planId')) {
            return redirect()->route('plans');
        }

        $planId = $request->session()->get('planId');
        $plan = Plan::findOrFail($planId);
        $user = Auth::user();

        $data = [
            'phone_number' => $user->phone_number,
            'amount' => $plan->amount,
        ];

        $success = $this->depositHelper($data);

        if (!$success) {
            return back()->with('error', __('main.Transaction failed!'));
        }

        $user->plan_id = $plan->id;
        $user->expires_on = Help::planExpiryDate($plan->duration);
        $user->update();

        // Giving referral bonus
        Help::referralBonus($plan->amount);

        $user->transactions()->create([
            'amount' => $plan->amount,
            'type' => 'plan',
        ]);

        $request->session()->forget('planId');

        return redirect()->route('home')
            ->with('success', __('main.Your plan purchase was successful.'));
    }

    public function processDeposit(Request $request)
    {
        $min = Plan::first()->amount;
        $request->validate(['amount' => "required|integer|min:$min"]);
        $user = Auth::user();

        $data = [
            'phone_number' => $user->phone_number,
            'amount' => $request->amount,
        ];

        $success = $this->depositHelper($data);

        if (!$success) {
            return back()->with('error', __('main.Deposit failed!'));
        }

        // End of processing

        $user->balance += $request->amount;
        $user->update();

        // Giving referral bonus
        Help::referralBonus($request->amount);

        $user->transactions()->create([
            'amount' => $request->amount,
            'type' => 'deposit',
        ]);

        return redirect()->route('home')
            ->with('success', __("main.Your deposit of :amount FCFA was successful.", [
                'amount' => $request->amount,
            ]));
    }

    public function sendWithdrawalEmail(Request $request)
    {
        $user = $request->user();
        $request->validate(['amount' => "required|integer|min:{$user->plan->min_withdrawal}"]);
        if ($user->balance < $request->amount) {
            return back()
                ->onlyInput('amount')
                ->with('error', __('main.Insufficient account balance.'));
        }

        // Sending money
        $charges = (env('WITHDRAWAL_CHARGES_PERCENTAGE') * $request->amount) / 100;

        $this->data = [
            'phone_number' => $user->phone_number,
            'amount' => $request->amount - $charges,
        ];

        $this->user = $user;
        $this->amount = $request->amount;

        $executed = RateLimiter::attempt('withdrawal:' . $user->id, 1, function () {
            $this->user->update(['balance' => $this->user->balance - $this->amount]);
            $success = $this->withdrawalHelper($this->data);
            if (!$success) {
                return false;
            }
            $this->user->transactions()->create([
                'amount' => $this->amount,
                'type' => 'withdrawal',
            ]);
        }, 600); //Run 1 time in 10 minutes.

        // Max attempts passed or an error occured
        if (!$executed) {
            return redirect()->route('home')
                ->with('info', __('main.An error occured. Please try again later.'));
        }

        return redirect()->route('home')
            ->with('success', __("main.Your withdrawal of :amount FCFA was successful.", ['amount' => $this->amount]));
    }
}
