<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả lập 10 người dùng với các vai trò khác nhau
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => $i % 2 == 0 ? 'admin' : 'user', // Gán vai trò: admin hoặc user
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
