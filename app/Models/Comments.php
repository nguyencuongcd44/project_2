<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'text', 
        'product_id',
        'user_id',
        'created_at'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
