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
        'password.forgot',
        'forgotPassword.sendEmail',
        'password.reset',
        'password.reset.form'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('cus')->check()){
            // Lưu URL hiện tại vào session
            if (!Route::currentRouteNamed($this->except)) {
                session(['url.intended' => url()->current()]);
            }
        }
        return $next($request);
    }

}
