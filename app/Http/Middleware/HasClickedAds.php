<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasClickedAds
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
        $user = Auth::user();

        if (!$user->plan()->exists()) {
            return redirect()->route('home')->with('error', "You don't have a plan. Purhcase one to start earning.");
        }

        if ($user->has_clicked_ads) {
            return redirect()->route('home')->with('error', 'You have clicked all your ads of today. Wait for tomorrow to continue clicking ads.');
        }

        $today_clicks = $user->clickedAds()->whereDate('created_at', Carbon::today())->count();

        $plan = $user->plan()->first();

        $required_clicks = $plan->daily_ads;

        if ($today_clicks >= $required_clicks) {
            $user->has_clicked_ads = true;
            $user->update();
            return redirect()->route('home')->with('error', 'You have clicked all your ads of today. Wait for tomorrow to continue clicking ads.');
        }

        return $next($request);
    }
}