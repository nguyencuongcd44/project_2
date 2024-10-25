<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class SavePreviousUrl 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected $except = [ // Loại trừ middleware khỏi route này
        'account.login',
        'account.check_login', 
    ];


    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('cus')->check()){
            // Lưu URL hiện tại vào session
            if (!$this->inExceptRoute($request)) {
                session(['url.intended' => url()->current()]);
            }
        }
        return $next($request);
    }

    protected function inExceptRoute(Request $request)
    {
        foreach ($this->except as $route) {
            if (Route::currentRouteNamed($route)) {
                return true;
            }
        }

        return false;
    }
}
