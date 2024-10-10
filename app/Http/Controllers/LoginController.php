<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    // Register
    public function register()
    {
        return view('register');
    }

    public function check_register()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $data = request()->all('email', 'name', 'role');

        // mã hóa mật khẩu
        $data['password'] = bcrypt(request('password'));
        User::create($data);
        return redirect()->route('login');
    }

    //Login
    public function login()
    {
        if(!Auth::check()){
            return view('/login');

        }else{
            return redirect('/');
        }
    }

    public function check_login()
    {
        request()->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
        $data = request()->all('email', 'password');

        // nếu thông tin đăng nhập đúng -> đăng nhập thành công
        if (Auth::attempt($data)) {
            return redirect()->intended('/');
        }
        // nếu thông tin đăng nhập sai sẽ back cùng với lỗi
        $errors  = new MessageBag;
        $errors->add('custom_error', 'Email or password was incorrect'); // hiện tại vẫn chưa hiển thị được lỗi 
        return redirect()->back()->withErrors($errors);
        
    }

     //Logout
     public function logout(Request $request)
     {
         Auth::logout();
 
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
