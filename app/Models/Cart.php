<?php

namespace App\Models;


class Cart
{
    public $cartItems = [];
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct()
    {
        $this->cartItems = session('cart') ? session('cart') : [];
        $this->totalPrice = $this->getTotalPrice();
        $this->totalQuantity = $this->getTotalQuantity();
    }

    // thêm vào giỏ hàng
    public function add($product, $quantity = 1)  
    {
        if(isset($this->cartItems[$product->id])){
            $this->cartItems[$product->id]->quantity += $quantity;

        }else{
            $item = (object)[
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
            $this->cartItems[$product->id] = $item;
        }

        session(['cart' => $this->cartItems]);
    }

    // cập nhật số lượng
    public function update($id, $quantity)  
    {
        if(isset($this->cartItems[$id])){
            $this->cartItems[$id]->quantity = $quantity;
        }
        session(['cart' => $this->cartItems]);
    }

    // xóa sản phẩm
    public function delete($id)  
    {
        if(isset($this->cartItems[$id])){
            unset($this->cartItems[$id]);

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
        foreach($this->cartItems as $item){
            $total +=  $item->quantity;
        }
        return $total;
    }

    // tính tổng giá tiền
    private function getTotalPrice()
    {
        $total = 0;
        foreach($this->cartItems as $item){
            $total +=  $item->price * $item->quantity;
        }
        return $total;
    }
}
