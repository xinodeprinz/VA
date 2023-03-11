<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function buyPlan(Request $request)
    {
        $request->validate(['plan_id' => 'required|integer|min:1']);

        try {
            $plan = Plan::findOrFail($request->plan_id);
        } catch (\Throwable$th) {
            return back()->with('error', __('main.The selected plan does not exists.'));
        }

        $user = Auth::user();

        // Purchasing plan if the user has sufficient account balance.
        if ($user->balance >= $plan->amount) {
            $user->plan_id = $plan->id;
            $user->expires_on = Help::planExpiryDate($plan->duration);
            $user->balance -= $plan->amount;
            $user->update();

            return redirect()->route('home')->with('success', __('main.Plan bought successfully.'));
        }

        $request->session()->put('planId', $plan->id);

        return redirect()->route('momo-plan');
    }
}
