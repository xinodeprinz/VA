<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Help;
use App\Models\Plan;
use App\Models\Video;
use Carbon\Carbon;
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

        // Condition to show timer
        $showTimer = $user->watchedVideos()
            ->whereDate('created_at', Carbon::today())->exists() && $user->plan;

        return view('pages.user.dashboard', compact('user', 'showTimer'));
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
        session()->flash('info', "You need to watch the video till the end inorder to be rewarded. If the video doesn't appear, please refresh the page.");
        return view('pages.user.video', compact('video', 'user'));
    }

    public function referrals()
    {
        $user = Auth::user();
        return view('pages.user.referrals', compact('user'));
    }

    public function thanks()
    {
        $user = Auth::user();
        return view('pages.user.thanks', compact('user'));
    }

    public function getRandomVideo()
    {
        $video = Video::inRandomOrder()->limit(1)->first();
        return response()->json($video);
    }

    public function rewardVideo(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $user = $request->user();
        $video = Video::findOrFail($request->id);
        // Video is good.
        $user->watchedVideos()->create(['video_id' => $video->id]);
        $user->update(['balance' => $user->balance + $user->plan->video_cost]);
        return redirect()->route('thanks')
            ->with('success', "You've successfully watched the video and have been rewarded.");
    }
}
