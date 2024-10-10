<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Chỉ định tên bảng mà model sẽ tương tác(mặc định sẽ là bảng có tên giống tên model)
    // protected $table = 'my_custom_table_name';

    protected $fillable = ['id', 'name', 'status']; // Thêm các thuộc tính khác mà bạn muốn cho phép gán hàng loạt

    // Model Relationship: Thiết lập mối quan hệ giữa Product và Category trong các model tương ứng.
    // Category có mối quan hệ một-nhiều với Product (hasMany).
    // Product có mối quan hệ nhiều-một với Category (belongsTo).

    // Định nghĩa mối quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
