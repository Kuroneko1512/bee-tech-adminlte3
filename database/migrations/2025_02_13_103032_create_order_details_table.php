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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            // Cột order_id liên kết với bảng orders
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // Cột product_id liên kết với bảng products
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            // Số lượng sản phẩm mua
            $table->integer('quantity');
            // Giá của sản phẩm tại thời điểm mua
            $table->integer('price');
            // Trạng thái đơn hàng, ví dụ: 'pending', 'confirmed', ...
            $table->string('status')->default('pending');
            $table->timestamps();
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
