<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;
    protected $table = 'toppings';
    protected $fillable = [
        'name',
        'image',
        'price',
        'status',
    ];

    // Mối quan hệ với sản phẩm
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_topping');
    }
}
