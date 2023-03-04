<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Help;
use App\Mail\Withdrawal;
use App\Models\Plan;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use MeSomb\Operation\PaymentOperation;
use MeSomb\Signature;

class MomoController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new PaymentOperation(env('MESOMB_APP'), env('MESOMB_ACCESS'), env('MESOMB_SECRET'));
    }

    public function show(Request $request, $type)
    {
        abort_if(!in_array($type, Help::paymentTypes()), 404);
        $title = $type;
        $plan = null;
        $phone_number = $request->user()->phone_number;

        if ($type === 'plan') {
            if (!$request->session()->has('planId')) {
                return redirect()->route('plans');
            }
            $planId = $request->session()->get('planId');
            $plan = Plan::findOrFail($planId);
            $title = $plan->title;
        }
        return view('pages.user.payment', compact('type', 'plan', 'title', 'phone_number'));
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
            return back()->with('error', "Transaction failed!");
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
            ->with('success', "Your plan purchase was successful.");
    }

    public function processDeposit(Request $request)
    {
        $request->validate(['amount' => 'required|integer|min:1000']);
        $user = Auth::user();

        $data = [
            'phone_number' => $user->phone_number,
            'amount' => $request->amount,
        ];

        $success = $this->depositHelper($data);

        if (!$success) {
            return back()->with('error', "Deposit failed!");
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
            ->with('success', "Your deposit of {$request->amount} FCFA was successful.");
    }

    public function processWithdrawal(Request $request)
    {
        $request->validate(['amount' => 'required|integer|min:1000']);

        // if (!$this->canWithdraw()) {
        //     return back()->with('error', 'Withdrawal failed.');
        // }

        $user = Auth::user();

        // Avoiding overdrafts
        if ($user->account_balance < $request->amount) {
            return back()->with('error', 'Overdraft! Insufficient account balance.');
        }

        $token = $this->randomString(50);

        // Storing relevant info in session.
        $request->session()->put('withdrawal', [
            'token' => $token,
            'amount' => $request->amount,
        ]);

        Mail::to($user->email)->send(new Withdrawal([
            'token' => $token,
            'username' => $user->username,
        ]));

        return redirect()->route('home')->with('info', 'A withdrawal link has been sent to your email address. Click the link to continue.');
    }

    public function completeWithdrawal(Request $request, string $token)
    {
        if (!$request->session()->has('withdrawal')) {
            return redirect()->route('home')->with('error', "The link has expired.");
        }

        $withdrawal = $request->session()->get('withdrawal');

        if ($withdrawal['token'] !== $token) {
            return abort(403);
        }

        $user = $request->user();

        $withdrawal['phone_number'] = $user->phone_number;

        if ($request->isMethod('GET')) {
            return view('pages.user.complete-payment', compact('withdrawal'));
        }

        // Request is method POST

        // if (!$this->canWithdraw()) {
        //     return redirect()->route('home')->with('error', 'Withdrawal failed.');
        // }

        if ($withdrawal['amount'] < 1000) {
            return redirect()->route('home')->with('error', 'The amount should not be less than 1000 frs.');
        }

        if ($user->account_balance < $withdrawal['amount']) {
            return redirect()->route('home')->with('error', 'Overdraft! Insufficient account balance.');
        }

        $data = [
            'amount' => $withdrawal['amount'],
            'phone_number' => $user->phone_number,
        ];

        $success = $this->withdrawalHelper($data);

        if (!$success) {
            return back()->with('error', "Withdrawal failed!");
        }

        $request->session()->forget('withdrawal');

        $user->account_balance -= $withdrawal['amount'];
        $user->withdrawed_on = $this->withdrawalDates();
        $user->update();

        $user->transactions()->create([
            'phone_number' => $user->phone_number,
            'method' => 'mobile-money',
            'amount' => $withdrawal['amount'],
            'type' => 'withdrawal',
        ]);

        return redirect()->route('home')
            ->with('success', "Your withdrawal of {$withdrawal['amount']} FCFA was successful.");
    }
}
