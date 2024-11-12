<?php

namespace App\Models;


class Cart
{
    public $cartItems = [];
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct()
    {
        $products = isset(session('cart')['products']) ? session('cart')['products'] : [];
        $this->cartItems['products'] = $products;
        $toppings = isset(session('cart')['toppings']) ? session('cart')['toppings'] : [];
        $this->cartItems['toppings'] = $toppings;

        $this->totalPrice = $this->getTotalPrice();
        $this->totalQuantity = $this->getTotalQuantity();
    }

    // thêm vào giỏ hàng
    public function addProduct($product, $quantity = 1)  
    {
        if(isset($this->cartItems['products'][$product->id])){
            $this->cartItems['products'][$product->id]->quantity += $quantity;

        }else{
            $item = (object)[
                'id' => $product->id,
                'name' => $product->name,
                'pro_number' => $product->pro_number,
                'thumbnail' => $product->thumbnail,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
            $this->cartItems['products'][$product->id] = $item;
        }

        session(['cart' => $this->cartItems]);
    }

    // cập nhật số lượng
    public function updateProduct($id, $quantity)  
    {
        if(isset($this->cartItems['products'][$id])){
            $this->cartItems['products'][$id]->quantity = $quantity;
        }
        session(['cart' => $this->cartItems]);
    }

    // xóa sản phẩm
    public function deleteProduct($id)  
    {
        if(isset($this->cartItems['products'][$id])){
            unset($this->cartItems['products'][$id]);

        }
        session(['cart' => $this->cartItems]); 
    }


    public function addTopping($product, $quantity = 1)  
    {
        if(isset($this->cartItems['toppings'][$product->id])){
            $this->cartItems['toppings'][$product->id]->quantity += $quantity;

        }else{
            $item = (object)[
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
            $this->cartItems['toppings'][$product->id] = $item;
        }

        session(['cart' => $this->cartItems]);
    }

    // cập nhật số lượng
    public function updateTopping($id, $quantity)  
    {
        if(isset($this->cartItems['toppings'][$id])){
            $this->cartItems['toppings'][$id]->quantity = $quantity;
        }
        session(['cart' => $this->cartItems]);
    }

    // xóa sản phẩm
    public function deleteTopping($id)  
    {
        if(isset($this->cartItems['toppings'][$id])){
            unset($this->cartItems['toppings'][$id]);

        }
        session(['cart' => $this->cartItems]); 
    }




    // xóa giỏ hàng
    public function clear()  
    {
        $this->cartItems = [];
        session(['cart' => $this->cartItems]); 

    }

    // tính tổng số lượng
    private function getTotalQuantity()
    {
        $total = 0;
        foreach($this->cartItems['products'] as $item){
            $total +=  $item->quantity;
        }
        foreach($this->cartItems['toppings'] as $item){
            $total +=  $item->quantity;
        }
        return $total;
    }

    // tính tổng giá tiền
    private function getTotalPrice()
    {
        $total = 0;
        foreach($this->cartItems['products'] as $item){
            $total +=  $item->price * $item->quantity;
        }
        foreach($this->cartItems['toppings'] as $item){
            $total +=  $item->price * $item->quantity;
        }
        return $total;
    }
}
