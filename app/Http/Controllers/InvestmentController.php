<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function calculate(Request $request)
    {
        $val = Validator::make($request->all(), [
            'amount' => 'required|integer|min:250|max:1000000',
        ]);

        if ($val->fails()) {
            return response()->json(['message' => Help::ValError($val)], 422);
        }

        return response()->json($this->generateDetails($request->amount));
    }

    public function plan(Request $request)
    {
        $request->validate(['amount' => 'required|integer|min:250|max:1000000']);
        $details = $this->generateDetails($request->amount);
        $user = Auth::user();

        $details['expires_on'] = Help::planExpiryDate($details['duration']);
        unset($details['duration']);

        if ($user->balance >= $request->amount) {
            if (!$user->investment)
                $user->investment()->create($details);
            else
                $user->investment()->update($details);

            $user->balance -= $request->amount;
            $user->update();
            return redirect()->route('home')->with('success', __('main.Investment successful'));
        }

        $request->session()->put('details', $details);
        return redirect()->route('momo-invest');
    }

    protected function generateDetails(int $amount): array
    {
        // Performing calculations
        $total = $amount * 2;
        $duration = null;
        $min_withdrawal = null;

        // Calculating duration
        if ($amount < 500)
            $duration = 2;
        elseif ($amount < 1000)
            $duration = 10;
        elseif ($amount < 2000)
            $duration = 15;
        elseif ($amount < 5000)
            $duration = 20;
        else
            $duration = 30;

        // Calculating minimum withdrawal (3 days before withdrawal)
        if ($total < 1000)
            $min_withdrawal = $total;
        elseif ($total < 2000)
            $min_withdrawal = $total / 3;
        elseif ($total < 4000)
            $min_withdrawal = $total / 5;
        elseif ($total < 10000)
            $min_withdrawal = $total / 6;
        else
            $min_withdrawal = $total / 10;

        $video_cost = round($total / $duration);

        return [
            'amount' => $amount,
            'video_cost' => $video_cost,
            'duration' => $duration,
            'total_earn' => $total,
            'min_withdrawal' => floor($min_withdrawal),
        ];
    }
}
