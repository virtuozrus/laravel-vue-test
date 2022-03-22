<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (strpos($request->getRequestUri(), '/bitva/login/vk') === 0
            || strpos($request->getRequestUri(), '/bitva/login/facebook') === 0) {
                return $next($request);
            }

            return redirect('/bitva');
        }

        return $next($request);
    }
}
