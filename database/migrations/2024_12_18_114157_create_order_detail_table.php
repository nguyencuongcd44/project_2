<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade')
                ->comment('ID của đơn hàng');

            $table->unsignedBigInteger('item_id')
                ->comment('ID của sản phẩm hoặc topping');
            $table->string('item_type')
                ->comment('Loại item: products hoặc toppings');

            $table->integer('quantity')
                ->comment('Số lượng của sản phẩm hoặc topping');
            $table->integer('unit_price')
                ->comment('Giá mỗi đơn vị sản phẩm hoặc topping');
            $table->integer('total_price')
                ->comment('Tổng giá = quantity * price');

            $table->string('notes')
                ->nullable()
                ->comment('Chú thích sản phẩm hoặc topping');

            $table->timestamps();

            // Index for polymorphic relation
            $table->index(['item_id', 'item_type'], 'order_details_item_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
