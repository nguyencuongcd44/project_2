<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 
        'product_id',
        'user_id',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'user_id','id');
    }
}
