<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comments;
use App\Models\Topping;
use App\Models\User;
use Comment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('front.index', compact(['products']));
    }

    public function category(Category $category)
    {
        // Lấy thông tin category và các sản phẩm thuộc category đó
        $category = Category::findOrFail($category->id);
        $products = Product::where('category_id', $category->id)->paginate(5);

        return view('front.category', compact('category', 'products'));
    }

    public function product_detail(Product $product)
    {
        $comments = Comments::where('product_id', $product->id)->orderBy('id', 'DESC')->get();
        $imgs = [];
        if($product->image){
            $imgs = explode('|->', $product->image);
            $imgs = array_filter($imgs);
        }
        return view('front.product-detail')->with(['product' => $product, 'imgs'=>$imgs, 'comments' => $comments]);
        
    }

    public function show_topping()
    {
        $toppings = Topping::where('type', 0)->get();
        return view('front.toppings', compact('toppings'));
    }

    public function topping_detail($id)
    {
        $topping = Topping::find($id);
        return view('front.topping-detail', compact('topping'));
    }
}
