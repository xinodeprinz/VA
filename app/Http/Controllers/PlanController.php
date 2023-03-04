<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function createPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:plans',
            'amount' => 'required|integer|min:5000',
            'daily_ads' => 'required|integer',
            'ad_cost' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = (array) $validator->getMessageBag();
            $error = array_values(array_values($errors)[0])[0][0];
            return response()->json($error, 422);
        }

        Plan::create($request->all());
        return response()->json("Plan created", 201);
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
        if ($user->balance >= $plan->amount) {
            $user->plan_id = $plan->id;
            $user->expires_on = Help::planExpiryDate($plan->duration);
            $user->balance -= $plan->amount;
            $user->update();

            return redirect()->route('home')->with('success', 'Plan bought successfully.');
        }

        $request->session()->put('planId', $plan->id);

        return redirect()->route('momo-plan');
    }
}
