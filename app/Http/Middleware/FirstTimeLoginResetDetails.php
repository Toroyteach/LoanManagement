<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class FirstTimeLoginResetDetails
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

        if ($user->email_verified_at == null) {

            return redirect()->route('users.details');
        }

        return $next($request);
    }
}
