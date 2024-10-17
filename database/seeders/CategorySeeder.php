<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạo 10 bản ghi giả
        for ($i = 1; $i <= 10; $i++) {
            DB::table('categories')->insert([
                'name' => 'Category ' . $i,
                'status' => rand(0, 1), // Giả lập status ngẫu nhiên: 0 hoặc 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
