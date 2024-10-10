<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;


class HomeController extends Controller
{
    public function index()
    {
        // $cats = Category::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('id', 'DESC')->limit(6)->get();
        return view('front.index', compact('products'));
    }

    public function category(Category $category)
    {
        // Lấy thông tin category và các sản phẩm thuộc category đó
        $category = Category::findOrFail($category->id);
        $products = Product::where('category_id', $category->id)->paginate(5);

        return view('front.category', compact('category', 'products'));
    }

    public function detail(Product $product, Comments $comments)
    {
        $comments = Comments::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        return view('front.product', compact('product', 'comments'));
    }

    //Login
    public function login()
    {
        return view('front/login');
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
            return redirect()->intended('/'); // '/default-page' là trang mặc định nếu không có URL trước đó
        }
        // nếu thông tin đăng nhập sai sẽ back cùng với lỗi
        $errors  = new MessageBag;
        $errors->add('custom_error', 'Email or password was incorrect'); // hiện tại vẫn chưa hiển thị được lỗi 
        return redirect()->back()->withErrors($errors);
    }

   

    public function post_cmt(Request $request, $product)
    {
        $request->validate([
            'comment' => 'required',
        ]);
        $data['user_id'] = auth()->id();
        $data['product_id'] = $product;
        $data['text'] = $request->all()['comment'];
        Comments::create($data);

        return redirect()->back();
    }
}
