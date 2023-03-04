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

        if ($user->plan()->exists() && $today > $user->expires_on) {
            // Plan has expired.
            $user->plan_id = 0;
            $user->expires_on = null;
        }

        if ($user->is_advert && $today > $user->advert_expires_on) {
            // Advert has expired.
            $user->is_advert = false;
            $user->advert_expires_on = null;
        }

        $user->update();

        return $next($request);
    }
}