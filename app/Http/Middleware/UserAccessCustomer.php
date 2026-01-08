<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\myappenv;
use Session;

class UserAccessCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->Role >= myappenv::role_customer ) {
                return $next($request);
            } else {
                return abort(403, __('Access deny'));
            }
        } else {

            Session::put('intended_url', \request()->url());
            return redirect()->route('login');
        }

    }
}
