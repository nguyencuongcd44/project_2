<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Mail\VerifyAccount;
use App\Models\Customer;
use Illuminate\Http\Request;
// use Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccountRegisterRequest;

class AccountController extends Controller
{

    // login
    public function login(){
        return view('front.account.login');
    }

    public function check_login(Request $request){
        $request->validate([
            'email' => 'required|email|exists:customers',
            'password' => 'required',
        ]);
        $cus = Customer::where('email',  $request->email)->first();

        if($cus->email_verified_at == null){
            return redirect()->back()->with('error', 'Tài khoản chưa được xác minh , vui lòng kiểm tra mail.');

        }else{
            $data = $request->only('email', 'password');
            if(Auth::guard('cus')->attempt($data)){
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công.');

            }else{
                return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
            }
        }
    }

    // register
    public function register(){
        return view('front.account.register');
    }

    public function check_register(AccountRegisterRequest $request){
        $request->validated();
        $data = $request->only('name', 'email', 'phone', 'gender', 'address');
        $data['password'] = bcrypt($request->password);
 
        if($acc = Customer::create($data)){
            Mail::to($acc->email)->send(new VerifyAccount($acc));

            return redirect()->route('account.login')->with('success', 'Tạo tài khoản thành công. Vui lòng kiểm tra mail xác nhận');
            
        }

        return redirect()->back()->with('error', 'Tạo tài khoản không thành công.');

    }

    // xác nhận
    public function verify($email){
        $acc = Customer::where(['email'=> $email, 'email_verified_at'=> null])->firstOrFail();
        Customer::where('email', $email)->update(['email_verified_at' => date('Y-m-d')]);

        return redirect(route('account.login'))->with('success', 'Xác nhận thành công. Bạn có thể đăng nhập');
    }


    // profile
    public function profile(){
        return view('front.account.profile');
    }

    public function check_profile(){
        
    }

    // change-password
    public function change_password(){
        return view('front.account.change-password');
    }

    public function check_change_password(){
        
    }

    // forgot-password
    public function forgot_password(){
        return view('front.account.forgot-password');
    }

    public function check_forgot_password(){
        
    }

    // reset-password
    public function reset_password(){
        return view('front.account.reset-password');
    }

    public function check_reset_password(){
        
    }


    //Logout
    public function logout(Request $request)
    {
        Auth::guard('cus')->logout();

        // Xóa session hiện tại
        $request->session()->invalidate();

        // Tạo lại token để bảo vệ
        $request->session()->regenerateToken();

        // Lưu URL hiện tại trước khi đăng xuất
        session(['url.intended' => $request->all()['url_intended']]);

        // Chuyển hướng người dùng về trang trước đó hoặc về trang chủ
        return redirect()->intended('/');
    }
    
}
