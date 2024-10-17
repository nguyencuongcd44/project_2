<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'image',
        'price',
        'contents',
        'category_id',
        'status',
    ];

    // Model Relationship: Thiết lập mối quan hệ giữa Product và Category trong các model tương ứng.
    // Category có mối quan hệ một-nhiều với Product (hasMany).
    // Product có mối quan hệ nhiều-một với Category (belongsTo).
    
    // Định nghĩa mối quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id', 'id');
    }
}
