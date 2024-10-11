<?php

namespace App\Http\Controllers;

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

        return back();
    }

    public function update($id, Cart $cart) 
    {
        $quantity = request('quantity');
        $cart->update($id, $quantity);

        return redirect(route('cart'));
    }

    
    public function delete($id, Cart $cart) 
    {
        $cart->delete($id);

        return redirect(route('cart'));
    }

    public function clear(Cart $cart) 
    {
        $cart->clear();

        return redirect(route('cart'));
    }
}
