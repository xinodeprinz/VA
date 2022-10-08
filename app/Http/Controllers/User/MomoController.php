<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Malico\MeSomb\Deposit;
use Malico\MeSomb\Payment;

class MomoController extends Controller
{
    public function deposit()
    {
        $data = (object) [
            'title' => 'deposit',
            'isMomo' => true,
            'type' => 'deposit',
            'btnText' => 'Deposit Now',
        ];
        return view('pages.user.payment', compact('data'));
    }

    public function withdrawal()
    {
        $user = Auth::user();

        $data = (object) [
            'title' => 'withdrawal',
            'isMomo' => true,
            'type' => 'withdrawal',
            'btnText' => 'Withdraw Now',
            'code' => $user->code,
            'phone_number' => $user->phone_number,
        ];
        return view('pages.user.payment', compact('data'));
    }

    public function plan(Request $request)
    {
        if (!$request->session()->has('plan')) {
            return redirect()->route('plans');
        }

        $plan = $request->session()->get('plan');

        $data = (object) [
            'title' => $plan->title,
            'isMomo' => true,
            'type' => 'plan',
            'btnText' => 'Buy Now',
            'amount' => $plan->amount,
        ];
        return view('pages.user.payment', compact('data'));
    }

    protected function depositHelper(array $data)
    {
        $request = new Payment("+237" . $data['phone_number'], $data['amount']);

        try {
            $payment = $request->pay();
        } catch (\Throwable$th) {
            return false;
        }

        if ($payment->success) {
            return true;
        } else {
            return false;
        }
    }

    protected function withdrawalHelper(array $data)
    {
        $trans = new Deposit($data['phone_number'], $data['amount']);
        try {
            $payment = $trans->pay();
        } catch (\Throwable$th) {
            return false;
        }

        if ($payment->success) {
            return true;
        } else {
            return false;
        }
    }

    public function processPlan(Request $request)
    {
        $request->validate(['phone_number' => 'required|string|size:9']);

        if (!$request->session()->has('plan')) {
            return redirect()->route('plans');
        }

        $plan = $request->session()->get('plan');

        $data = [
            'phone_number' => $request->phone_number,
            'amount' => $plan->amount,
        ];

        $user = Auth::user();

        $success = $this->depositHelper($data);

        if (!$success) {
            return back()->with('error', "Transaction failed!");
        }

        $user->plan_id = $plan->id;
        $user->expires_in = $plan->duration;
        $user->update();

        // Giving 10% to referral
        if ($user->referral()->exists()) {
            $referral = $user->referral()->first();
            $referral->account_balance += (0.1 * $plan->amount);
            $referral->update();
        }

        $user->transactions()->create([
            'phone_number' => "+237" . $request->phone_number,
            'method' => 'mobile-money',
            'amount' => $plan->amount,
            'type' => 'plan',
        ]);

        $request->session()->forget('plan');

        return redirect()->route('home')
            ->with('success', "Your plan purchase was successful.");
    }

    public function processDeposit(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|size:9',
            'amount' => 'required|integer|min:5000',
        ]);

        $user = Auth::user();

        $success = $this->depositHelper($request->all());

        if (!$success) {
            return back()->with('error', "Deposit failed!");
        }

        $user->account_balance += $request->amount;
        $user->update();

        // Giving 10% to referral
        if ($user->referral()->exists()) {
            $referral = $user->referral()->first();
            $referral->account_balance += (0.1 * $request->amount);
            $referral->update();
        }

        $user->transactions()->create([
            'phone_number' => "+237" . $request->phone_number,
            'method' => 'mobile-money',
            'amount' => $request->amount,
            'type' => 'deposit',
        ]);

        return redirect()->route('home')
            ->with('success', "Your deposit of {$request->amount} FCFA was successful.");
    }

    public function processWithdrawal(Request $request)
    {
        $request->validate(['amount' => 'required|integer|min:1000|max:5000']);

        $user = Auth::user();

        // Limiting daily withdrawals to 1;
        if ($user->has_withdrawn) {
            return back()->with('error', 'You have already withdrawn today. Wait for tomorrow to place a withdrawal.');
        }

        // Avoiding overdrafts
        if ($user->account_balance < $request->amount) {
            return back()->with('error', 'Overdraft! Insufficient account balance.');
        }

        // Restricting withdrawal for accounts with plans greater than 100,000frs.
        if ($user->plan()->exists()) {
            $plan = $user->plan()->first();

            if ($plan->amount > 100000) {
                return back()->with('error', 'Withdrawal failed!');
            }
        }

        // Getting the phone number from the database for better security.
        $phone_number = '+' . strval($user->code) . $user->phone_number;

        $data = [
            'amount' => 0.93 * $request->amount,
            'phone_number' => $phone_number,
        ];

        $success = $this->withdrawalHelper($data);

        if (!$success) {
            return back()->with('error', "Withdrawal failed!");
        }

        $user->account_balance -= $request->amount;
        $user->has_withdrawn = true;
        $user->update();

        $user->transactions()->create([
            'phone_number' => $phone_number,
            'method' => 'mobile-money',
            'amount' => $request->amount,
            'type' => 'withdrawal',
        ]);

        return redirect()->route('home')
            ->with('success', "Your withdrawal of {$request->amount} FCFA was successful.");
    }
}