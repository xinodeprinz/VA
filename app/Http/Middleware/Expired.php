<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class Expired
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
        $today = Carbon::today()->format('Y-m-d');

        // Reset user's plan or plan expiry date if one is lacking
        if (
            ($user->plan && !$user->expires_on) ||
            (!$user->plan && $user->expires_on)
        ) {
            $user->plan_id = 0;
            $user->expires_on = null;
            $user->update();
        }

        if ($user->plan && $today >= $user->expires_on) {
            // Plan has expired.
            $user->plan_id = 0;
            $user->expires_on = null;
            $user->update();
            return redirect()->route('home')->with('info', __('main.Your plan has expired.'));
        }

        return $next($request);
    }
}
