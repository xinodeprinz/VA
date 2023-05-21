<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasWatchedVideo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user->investment) {
            return redirect()->route('home')->with('info', __("main.You haven't invested yet. Invest any amount to start earning."));
        }

        if ($this->hasWatchedVideo()) {
            return redirect()->route('thanks');
        }

        return $next($request);
    }

    protected function hasWatchedVideo()
    {
        $user = Auth::user();

        $today_videos = $user->watchedVideos()->whereDate('created_at', Carbon::today())->count();

        $required_videos = 1;

        if ($today_videos >= $required_videos) {
            return true;
        }

        return false;
    }
}
