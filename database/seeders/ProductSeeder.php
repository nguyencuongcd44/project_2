<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả lập 10 sản phẩm
        for ($i = 1; $i <= 50; $i++) {
            DB::table('products')->insert([
                'name' => 'Product ' . $i,
                'image' => 'product' . $i . '.jpg', // Giả lập tên file ảnh
                'price' => rand(100, 1000) + rand(0, 99) / 100, // Giá ngẫu nhiên từ 100 đến 1000, với 2 chữ số thập phân
                'contents' => 'This is the content for Product ' . $i,
                'category_id' => rand(1, 10), // Giả lập liên kết với bảng categories (giả định bảng categories có 10 bản ghi)
                'status' => rand(0, 1), // Trạng thái ngẫu nhiên 0 hoặc 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
