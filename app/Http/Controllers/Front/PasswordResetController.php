<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PasswordResetTokens;

class PasswordResetController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('front.account.reset-password');
    }

    public function sendResetLink(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email của bạn.',
            'email.exists' => 'Địa chỉ email không tồn tại.',
            'email.email' => 'Vui lòng nhập định dạng email.',
        ]);
        
        // Kiểm tra lỗi và chuyển lỗi vào error bag 'frontErrors' nếu có
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'frontErrors')
                ->withInput();
        }
        
        $token = md5(rand(1, 10) . microtime());
        $email = $request->email;

        // Lưu vào bảng password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $link = route('password.reset', $token);

        // Send email with link
        Mail::to('nguyencuongcd44@gmail.com')->send(new PasswordReset($link));

        return redirect()->back()->with('success', 'Reset link sent to your email');
    }
}
