<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,   // Seed dữ liệu cho bảng users
            CategorySeeder::class,  // Seed dữ liệu cho bảng categories
            ProductSeeder::class,   // Seed dữ liệu cho bảng products
            CommentSeeder::class,   // Seed dữ liệu cho bảng comments
        ]);
    }
}
