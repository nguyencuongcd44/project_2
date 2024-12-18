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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique()->comment('Mã đơn hàng, duy nhất');
            $table->integer('total_price')->unsigned()->comment('Tổng giá tiền của đơn hàng');
            $table->string('status')->default('pending')->comment('Trạng thái đơn hàng: Awaiting, Accepted, Rejected, Unpaid, Paid, Progress, Completed, Cancelled');
            $table->string('reject_reason')->nullable()->comment('Lý do từ chối đơn hàng nếu bị hủy');
            $table->json('order_details_json')->comment('Lưu trữ thông tin chi tiết đơn hàng dưới dạng JSON');
            $table->string('notes')->nullable()->comment('Chú thích đơn hàng');

            // Thông tin người dùng
            $table->string('customer_name')->comment('Tên khách hàng');
            $table->string('customer_email')->comment('Email của khách hàng');
            $table->string('customer_phone')->comment('Số điện thoại của khách hàng');

            // Thông tin giao hàng
            $table->string('shipping_address')->comment('Địa chỉ giao hàng');
            $table->string('shipping_city')->comment('Thành phố giao hàng');
            $table->string('shipping_district')->nullable()->comment('Quận/huyện giao hàng');
            $table->string('shipping_zip_code')->nullable()->comment('Mã bưu điện giao hàng');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
