<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccount;
use App\Models\Customer;
use Illuminate\Http\Request;
// use Mail;
use Illuminate\Support\Facades\Mail;

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
        if($cus){
            if($cus->email_verified_at == null){
                $data = $request->only('email', 'password');
                $check = auth('cus')->attempt($data);
                return redirect()->back()->with('error', 'Tài khoản chưa được xác minh , vui lòng kiểm tra mail.');

            }else{
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công.');
            }
        }
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    // register
    public function register(){
        return view('front.account.register');
    }

    public function check_register(Request $request){

        $request->validate([
            'name' => 'required|min:6|max:100',
            'phone' => 'required|regex:/^\+?[0-9]{9,13}$/|unique:customers',
            'email' => 'required|email|min:6|max:100|unique:customers',
            'password' => 'required|min:4',
            'confimr_password' => 'required|same:password',

        ], [
            'name.required' => 'Tên không được để trống.',
            'name.min' => 'Tên phải có ít nhất :min ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số điện thoại hợp lệ.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.min' => 'Email phải có ít nhất :min ký tự.',
            'email.max' => 'Email không được vượt quá :max ký tự.',
            'email.unique' => 'Email đã tồn tại.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',

            'confimr_password.required' => 'Vui lòng xác nhận mật khẩu.',
            'confimr_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.',
        ]);

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
    
}
