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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Tạo cột customer_id kiểu unsignedBigInteger, cho phép null.
            // Sử dụng shorthand để thêm khoá ngoại tham chiếu đến bảng 'customers'
            // Với onDelete('set null'): khi customer bị xóa, trường customer_id sẽ được đặt thành null,
            // giúp giữ lại dữ liệu đơn hàng cho mục đích thống kê.
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');

            // Tổng số lượng sản phẩm trong đơn hàng
            $table->integer('quantity');
            // Tổng tiền của đơn hàng (ví dụ: tính theo cents hoặc đơn vị tiền tệ tương ứng)
            $table->integer('total');
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
