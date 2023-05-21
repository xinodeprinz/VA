<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Withdraw
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
        $path = $request->path();
        $split_array = explode('/', $path);
        $type = array_pop($split_array);

        if ($type === 'withdrawal') {
            $user = $request->user();
            if (!$user->investment) {
                return redirect()->route('home')
                    ->with('info', __("main.withdraw-alert"));
            }
        }

        return $next($request);
    }
}
