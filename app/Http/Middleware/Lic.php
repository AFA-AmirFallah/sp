<?php

namespace App\Http\Middleware;

use App\myappenv;
use Closure;
use Illuminate\Http\Request;

class Lic
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
        return $next($request);
    }
    public static function check($LicName){
        return myappenv::Lic[$LicName] ?? false;
    }
}
