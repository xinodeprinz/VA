<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class PayPalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_SECRET_ID'));
        $this->gateway->setTestMode(true);
    }

    public function deposit()
    {
        $data = (object) [
            'title' => 'deposit',
            'isMomo' => false,
            'type' => 'deposit',
            'btnText' => 'Pay with PayPal',
        ];
        return view('pages.user.payment', compact('data'));
    }

    public function withdrawal()
    {
        $data = (object) [
            'title' => 'withdrawal',
            'isMomo' => false,
            'type' => 'withdrawal',
            'btnText' => 'Withdraw with PayPal',
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
            'isMomo' => false,
            'type' => 'plan',
            'btnText' => 'Buy with PayPal',
            'amount' => $plan->amount / env('EXCHANGE_RATE'),
        ];
        return view('pages.user.payment', compact('data'));
    }

    public function processPlan(Request $request)
    {
        if (!$request->session()->has('plan')) {
            return redirect()->route('plans');
        }

        $plan = $request->session()->get('plan');

        $this->paypalHelper($plan->amount / env('EXCHANGE_RATE'), 'plan');
    }

    public function processDeposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $this->paypalHelper($request->amount, 'deposit');
    }

    public function processWithdrawal(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:10',
        ]);
        // Needs adjustments.
        $user = Auth::user();

        if ($user->account_balance < $request->amount * env('EXCHANGE_RATE')) {
            return back()->with('error', 'Overdraft! Insufficient account balance');
        }

        return redirect()->route('home')->with('error', 'An error occurred! Please try again after 10 minutes.');
    }

    public function success(Request $request, $type)
    {
        $user = Auth::user();

        if ($request->paymentId && $request->PayerID) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->PayerID,
                'transactionReference' => $request->paymentId,
            ]);

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $data = $response->getData();

                $amount = $data['transactions'][0]['amount']['total'];

                $user->transactions()->create([
                    'email' => $data['payer']['payer_info']['email'],
                    'type' => $type,
                    'method' => 'paypal',
                    'amount' => $amount * env('EXCHANGE_RATE'),
                ]);

                // Performing deposit or plan magic
                $user = Auth::user();

                // Giving referral bonus (10%)
                if (in_array($type, ['plan', 'deposit'])) {
                    if ($user->referral()->exists()) {
                        $referral = $user->referral()->first();
                        $referral->account_balance += (0.1 * $amount * env('EXCHANGE_RATE'));
                        $referral->update();
                    }
                }

                if ($type === 'deposit') {
                    $user->account_balance += ($amount * env('EXCHANGE_RATE'));
                    $user->update();
                } else if ($type === 'plan') {
                    $plan = $request->session()->get('plan');
                    $user->plan_id = $plan->id;
                    $user->expires_in = $plan->duration;
                    $user->update();
                    $request->session()->forget('plan');
                } else {
                    return redirect()->route("home")->with('error', "An error occurred!");
                }

                return redirect()->route("home")->with('success', "Payment successful!");
            }

            return redirect()->route("paypal-{$type}")->with('error', $response->getMessage());
        }

        return redirect()->route("paypal-{$type}")->with('error', "Payment declined!");
    }

    public function getError($type)
    {
        return redirect()->route("paypal-{$type}")->with('error', 'User declined the payment');
    }

    protected function paypalHelper($amount, $type)
    {
        try {
            $response = $this->gateway->purchase([
                'amount' => round($amount, 2),
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('success', ['type' => $type]),
                'cancelUrl' => route('error', ['type' => $type]),
            ])->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return redirect()->route("paypal-{$type}")->with('error', $response->getMessage());
            }
        } catch (\Throwable$th) {
            return redirect()->route("paypal-{$type}")->with('error', $th->getMessage());
        }
    }
}