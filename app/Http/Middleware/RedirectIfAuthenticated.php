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
           // dd($request);exit;
            if(Auth::guard($guard)->user()->type="superAdmin" || Auth::guard($guard)->user()->type="admin")
            {
                return redirect('adminDashboard');
            }
            else
            {
                return redirect('customerDashboard');
            }
            
        }

        return $next($request);
    }
}
