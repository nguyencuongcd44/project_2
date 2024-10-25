<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{

    // index
    public function index()
    {
        return view('admin/index');
    }

    // Register
    public function register()
    {
        return view('admin/account/register');
    }

    public function check_register(AdminRegisterRequest $request)
    {
        $request->validated();
        $data = $request->all('email', 'name', 'role');

        // mã hóa mật khẩu
        $data['password'] = bcrypt(request('password'));
        User::create($data);
        return redirect()->route('admin.login');
    }

    //Login
    public function login()
    {
        if(!Auth::check()){
            return view('admin/account/login');

        }else{
            return redirect()->route('admin.index');
        }
    }

    public function check_login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $data = request()->only('email', 'password');

        // nếu thông tin đăng nhập đúng -> đăng nhập thành công
        if (Auth::attempt($data)) {
            return redirect()->route('admin.index');
        }
        // nếu thông tin đăng nhập sai sẽ back cùng với lỗi
        return redirect()->back()->withErrors('error', 'Email or password was incorrect');
        
    }

     //Logout
     public function logout(Request $request)
     {
        Auth::logout();

        // Xóa session hiện tại
        $request->session()->invalidate();

        // Tạo lại token để bảo vệ
        $request->session()->regenerateToken();

        // Chuyển hướng người dùng về trang trước đó hoặc về trang chủ
        return redirect('/');
     }
}
