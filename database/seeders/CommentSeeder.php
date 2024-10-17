<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả lập 20 bình luận cho các sản phẩm
        for ($i = 1; $i <= 50; $i++) {
            DB::table('comments')->insert([
                'text' => 'This is a comment number ' . $i,
                'user_id' => rand(1, 3), // Giả lập ID người dùng (giả định bảng users có 10 bản ghi)
                'product_id' => rand(1, 50), // Giả lập ID sản phẩm (giả định bảng products có 50 bản ghi)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
