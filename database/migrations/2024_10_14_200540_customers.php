<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 100);
            $table->string('address');  // Địa chỉ, có thể bỏ trống
            $table->string('gender');
            $table->string('phone')->unique();  // Số điện thoại, có thể bỏ trống
            $table->string('email', 100)->unique();  // Email, duy nhất
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
