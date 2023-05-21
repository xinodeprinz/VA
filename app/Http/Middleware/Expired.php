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

        if ($user->investment && $today >= $user->investment->expires_on) {
            // Plan has expired.
            $user->investment()->delete();
            return redirect()->route('home')->with('info', __('main.Your plan has expired.'));
        }

        return $next($request);
    }
}
