<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Help;
use App\Models\Ad;
use App\Models\Plan;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // User deposits
        $user->deposits = $user->transactions()
            ->where('type', 'deposit')
            ->orWhere(function ($query) {
                $query->where('type', 'plan')
                    ->where('user_id', Auth::id());
            })->sum('amount');

        // User withdrawals
        $user->withdrawals = $user->transactions()
            ->where('type', 'withdrawal')->sum('amount');

        // User's plan
        if ($user->plan) {
            $user->planDaysLeft = Help::daysLeft($user->expires_on);
        }

        return view('pages.user.dashboard', compact('user'));
    }

    public function transactions()
    {
        $user = Auth::user();
        return view('pages.user.transactions', compact('user'));
    }

    public function video()
    {
        $user = Auth::user();
        $video = Video::inRandomOrder()->limit(1)->first();
        return view('pages.user.video', compact('video', 'user'));
    }

    public function processAd(Request $request)
    {
        $request->validate(['id' => 'required|integer|min:1']);
        try {
            $ad = Ad::findOrFail($request->id);
        } catch (\Throwable$th) {
            return back()->with('error', 'The selected ad does not exists.');
        }

        $user = Auth::user();

        $user->clickedAds()->create(['ad_id' => $ad->id]);

        $plan = $user->plan()->first();

        $user->account_balance += $plan->ad_cost;
        $user->update();

        return redirect()->route('ads')->with('success', 'Ad clicked successfully.');
    }

    public function referrals()
    {
        $user = Auth::user();
        return view('pages.user.referrals', compact('user'));
    }

    public function thanks()
    {
        return view('pages.user.thanks');
    }
}
