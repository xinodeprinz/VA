<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function createPlan(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|unique:plans',
            'amount' => 'required|integer|min:5000',
            'daily_ads' => 'required|integer',
            'ad_cost' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        Plan::create($data);
        return response("Plan created!");
    }

    public function buyPlan(Request $request)
    {
        $request->validate(['plan_id' => 'required|integer|min:1']);

        try {
            $plan = Plan::findOrFail($request->plan_id);
        } catch (\Throwable$th) {
            return back()->with('error', 'The selected plan does not exists.');
        }

        $user = Auth::user();

        // Purchasing plan if the user has sufficient account balance.
        if ($user->account_balance >= $plan->amount) {
            $user->plan_id = $plan->id;
            $user->expires_in = $plan->duration;
            $user->account_balance -= $plan->amount;
            $user->update();

            // Giving 10% to referral
            if ($user->referral()->exists()) {
                $referral = $user->referral()->first();
                $referral->account_balance += (0.1 * $plan->amount);
                $referral->update();
            }

            return redirect()->route('home')->with('success', 'Plan bought successfully.');
        }

        $request->session()->put('plan', $plan);

        return redirect()->route('momo-plan');
    }
}