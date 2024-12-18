<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
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

    public function check_login(AdminLoginRequest $request)
    {
        if(Auth::check()){
            return redirect()->back()->with('admin_error', 'Bạn đang đăng nhập.');
        }
        $request->validated();
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            return redirect()->route('admin.index')->with('admin_success', 'Đăng nhập thành công.');
        }

        return redirect()->back()->with('admin_error', 'Email hoặc mật khẩu không đúng.');
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
