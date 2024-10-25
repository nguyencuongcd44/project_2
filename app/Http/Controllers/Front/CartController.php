<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //show cart
    public function cart(Cart $cart) 
    {
        return view('front.cart', compact('cart'));
    }


    public function addToCart(Cart $cart, Product $product) 
    {
        $quantity = request('quantity', 1);
        $cart->add($product, $quantity);

        return back()->with('success', 'Thêm sản phẩm thành công.');
    }

    public function update($id, Cart $cart) 
    {
        $quantity = request('quantity');
        $cart->update($id, $quantity);

        return redirect(route('cart'))->with('success', 'Update sản phẩm thành công.');
    }

    
    public function delete($id, Cart $cart) 
    {
        $cart->delete($id);

        return redirect(route('cart'))->with('success', 'Xóa sản phẩm thành công.');
    }

    public function clear(Cart $cart) 
    {
        $cart->clear();

        return redirect(route('cart'))->with('success', 'Xóa giỏ hàng thành công.');
    }
}
