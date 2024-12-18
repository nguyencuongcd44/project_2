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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->comment('Khóa ngoại tham chiếu đến bảng orders');
            $table->integer('amount')->unsigned()->comment('Tổng giá tiền của đơn hàng');
            $table->string('payment_method')->comment('Phương thức thanh toán: vnpay, momo, cod, etc.');
            $table->json('payment_details')->comment('Chi tiết thanh toán được lưu dưới dạng JSON');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
