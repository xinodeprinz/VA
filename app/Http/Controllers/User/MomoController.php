<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Help;
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
    protected $canWithdraw = true;

    public function __construct()
    {
        $this->client = new PaymentOperation(env('MESOMB_APP'), env('MESOMB_ACCESS'), env('MESOMB_SECRET'));
    }

    public function show(Request $request, $type)
    {
        abort_if(!in_array($type, Help::paymentTypes()), 404);
        $title = $type;
        $details = null;
        $user = Auth::user();
        $phone_number = $request->user()->phone_number;

        if ($type === 'invest') {
            if (!$request->session()->has('details')) {
                return redirect()->route('invest');
            }
            $details = $request->session()->get('details');
        } elseif ($type === 'withdrawal') {
            $details = $user->investment->toArray();
        }
        // Flashing message to the session if its a plan or deposit.
        $alertTypes = ['deposit', 'invest'];
        if (in_array($type, $alertTypes)) {
            $request->session()->flash('info', __('main.payment-alert'));
        }

        return view('pages.user.payment', compact(
            'type',
            'details',
            'title',
            'phone_number',
            'user'
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
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function processInvestment(Request $request)
    {
        // Protecting route
        if (!$request->session()->has('details')) {
            return redirect()->route('invest');
        }

        $details = $request->session()->get('details');
        $user = Auth::user();

        $data = [
            'phone_number' => $user->phone_number,
            'amount' => $details['amount'],
        ];

        $success = $this->depositHelper($data);

        if (!$success) {
            return back()->with('error', __('main.Transaction failed!'));
        }

        // Storing investment info
        if (!$user->investment)
            $user->investment()->create($details);
        else
            $user->investment()->update($details);

        // Giving referral bonus
        Help::referralBonus($details['amount']);

        $user->transactions()->create([
            'amount' => $details['amount'],
            'type' => 'plan',
        ]);

        $request->session()->forget('details');

        return redirect()->route('home')
            ->with('success', __('main.Investment successful'));
    }

    public function processDeposit(Request $request)
    {
        $request->validate(['amount' => "required|integer|min:250|max:1000000"]);
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

    public function processWithdrawal(Request $request)
    {
        $user = $request->user();
        $request->validate(['amount' => "required|integer|min:{$user->investment->min_withdrawal}"]);
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
            $success = $this->withdrawalHelper($this->data);
            if (!$success) {
                $this->canWithdraw = false;
                return false;
            }
            $this->user->update(['balance' => $this->user->balance - $this->amount]);
            $this->user->transactions()->create([
                'amount' => $this->amount,
                'type' => 'withdrawal',
            ]);
        }, 600); //Run 1 time in 10 minutes.

        // Max attempts passed or an error occured
        if (!$executed || !$this->canWithdraw) {
            return redirect()->route('home')
                ->with('info', __("main.You can't withdraw at the moment. Please try again later."));
        }

        return redirect()->route('home')
            ->with('success', __("main.Your withdrawal of :amount FCFA was successful.", ['amount' => $this->amount]));
    }
}
