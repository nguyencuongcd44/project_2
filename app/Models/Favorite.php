<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite
{
    public $favoriteItems = array();

    public function __construct()
    {
        $this->favoriteItems = session('favorite') ? session('favorite') : [];
    }

    // thêm vào giỏ hàng
    public function add($productId)  
    {
        if(!array_search($productId, $this->favoriteItems)){
            $this->favoriteItems[$productId] = $productId;
        }

        session(['favorite' => $this->favoriteItems]);
    }

    // xóa sản phẩm
    public function delete($productId)  
    {
        if(array_search($productId, $this->favoriteItems)){
            unset($this->favoriteItems[$productId]);
        }
        session(['favorite' => $this->favoriteItems]); 
    }

    // xóa favorite
    public function clear()  
    {
        $this->favoriteItems = [];
        session(['favorite' => $this->favoriteItems]); 
    }
}
