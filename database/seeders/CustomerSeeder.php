<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả lập 10 người dùng với các vai trò khác nhau
        for ($i = 1; $i <= 3; $i++) {
            DB::table('customers')->insert([
                'name' => 'User ' . $i,
                'address' => 'Address ' . $i,
                'gender' => $i % 2 == 0 ? 'male' : 'female',
                'phone' => rand(100000000, 99999999999),
                'password' => bcrypt('1111'),
                'email' => 'customer-' . $i . '@gmail.com',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
