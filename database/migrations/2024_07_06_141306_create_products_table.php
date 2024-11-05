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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('image');
            $table->integer('price')->unsigned()->comment('Giá sản phẩm');
            $table->string('contents');
            $table->unsignedInteger('category_id');
            $table->tinyInteger('status')->default('0');
            $table->timestamps();

            //khóa ngoại với id của bảng categories
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
