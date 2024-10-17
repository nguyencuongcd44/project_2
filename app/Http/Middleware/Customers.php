<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Customers 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::guard('cus')->check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            session()->flash('error', 'Vui lòng đăng nhập !');
            return redirect()->route('account.login');
        }

        // Lấy người dùng hiện tại từ Auth guard 'cus'
        $customer = Auth::guard('cus')->user();

        // Kiểm tra xem tài khoản đã được xác thực
        if ($customer->email_verified_at === null) {
            Auth::guard('cus')->logout();
            // Nếu chưa xác thực, chuyển hướng về trang đăng nhập với thông báo
            session()->flash('error', 'Tài khoản của bạn chưa được kích hoạt, vui lòng kiểm tra email để xác thực!');
            return redirect()->route('account.login');
        }

        // Nếu tài khoản đã được kích hoạt, cho phép tiếp tục
        return $next($request);

    }
}
