<?php

namespace App\Http\Controllers\Front;

use Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPasswordResetRequest;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    private function checkToken($created_at)
    {
        if(Carbon::parse($created_at)->addMinutes(60)->isBefore(now())){
            return false;
        }
        return true;
    }
    // show form nhập mail để gửi link reset password
    public function showForgotPasswordForm()
    {
        if(Auth::guard('cus')->check()){
            return redirect()->back();
        }
        return view('front.account.forgot-password');
    }

    // gửi link reset password qua email
    public function sendResetLink(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email của bạn.',
            'email.exists' => 'Địa chỉ email không tồn tại.',
            'email.email' => 'Vui lòng nhập định dạng email.',
        ]);
        
        // Kiểm tra lỗi validation và chuyển hướng
        $this->handleValidationErrors(self::FRONT_END_ERRORS, $validator);
        
        $token = md5(rand(1, 10) . microtime());
        $email = $request->email;

        // Lưu vào bảng password_reset_tokens
        $db = DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
        // if($db){
        //     $link = route('password.reset', $token);

        //     // Send email with link
        //     try {
        //         Mail::to('nguyencuongcd44@gmail.com')->send(new PasswordReset($link));
        //         return redirect()->back()->with('success', 'Gửi email thành công. Vui lòng kiểm tra email để reset mật khẩu.');

        //     } catch (\Exception $e) {
        //         // Ghi log lỗi (nên làm để debug sau này)
        //         Log::error('(F)Lỗi khi gửi email reset password: ' . $e->getMessage());
        //         return redirect()->back()->with('error', 'Gửi email thất bại. Vui lòng thử lại sau.');
        //     }
        // }

        Log::error('(F)Đã xảy ra lỗi khi lưu dữ liệu: ' . 'email:'.$email);
        return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại sau.');
    }

    // show form nhập mật khẩu mới
    public function showResetPasswordForm($token)
    {
        $tokenRecord = DB::table('password_reset_tokens')->where('token', $token)->first();
        if(!$tokenRecord || !$this->checkToken($tokenRecord->created_at)){
            return redirect()->route('password.forgot')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }
        return view('front.account.reset-password-form', compact('tokenRecord'));
    }

    // reset mật khẩu
    public function resetPassword(AccountPasswordResetRequest $request)
    {
        $request->validated();

        $token = $request->token;
        $tokenRecord = DB::table('password_reset_tokens')->where('token', $token)->first();
        if(!$this->checkToken($tokenRecord->created_at)){
            return redirect()->route('password.forgot')->with('error', 'Token đã hết hạn.');
        }

        $email = $tokenRecord->email;
        $password = bcrypt($request->password);

        // Cập nhật mật khẩu mới
        $db = DB::table('customers')->where('email', $email)->update(['password' => $password]);
        if($db){
            // Xóa token
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return redirect()->route('account.login')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
        }

        Log::error('(F)Đã xảy ra lỗi khi cập nhật mật khẩu: email:'.$email);
        return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại sau.');
    }
}
