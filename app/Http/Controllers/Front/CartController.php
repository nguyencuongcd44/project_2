<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Topping;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //show cart
    public function cart(Cart $cart) 
    {
        // dd($cart->cartItems['products']);
        return view('front.cart', compact('cart'));
    }


    public function addProduct(Cart $cart, Product $product) 
    {
        $quantity = request('quantity', 1);
        $cart->addProduct($product, $quantity);

        return back()->with('success', 'Thêm sản phẩm thành công.');
    }

    public function updateProduct($id, Cart $cart) 
    {
        $quantity = request('quantity');
        $cart->updateProduct($id, $quantity);

        return redirect(route('cart'))->with('success', 'Update sản phẩm thành công.');
    }

    
    public function deleteProduct($id, Cart $cart) 
    {
        $cart->deleteProduct($id);

        return redirect(route('cart'))->with('success', 'Xóa sản phẩm thành công.');
    }




    public function addTopping(Cart $cart, Topping $topping) 
    {
        $quantity = request('quantity', 1);
        $cart->addTopping($topping, $quantity);

        return back()->with('success', 'Thêm topping thành công.');
    }

    public function updateTopping($id, Cart $cart) 
    {
        $quantity = request('quantity');
        $cart->updateTopping($id, $quantity);

        return redirect(route('cart'))->with('success', 'Update topping thành công.');
    }

    
    public function deleteTopping($id, Cart $cart) 
    {
        $cart->deleteTopping($id);

        return redirect(route('cart'))->with('success', 'Xóa topping thành công.');
    }

    public function clear(Cart $cart) 
    {
        $cart->clear();

        return redirect(route('cart'))->with('success', 'Xóa giỏ hàng thành công.');
    }
}
