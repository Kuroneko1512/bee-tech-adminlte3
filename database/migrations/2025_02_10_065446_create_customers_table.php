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
            // Primary key
            $table->id();

            // Thông tin tài khoản
            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 11)->unique(); // Số điện thoại dùng để login
            $table->string('password');
            $table->string('reset_password')->nullable();

            // Thông tin cá nhân
            $table->string('full_name', 100);
            $table->date('birthday');

            // Thông tin địa chỉ - foreign keys
            $table->string('address', 255)->nullable();
            $table->foreignId('province_id')->nullable()->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->foreignId('commune_id')->nullable()->constrained();

            // Trạng thái
            $table->string('status');
            $table->boolean('flag_delete')->default(0);

            // Timestamps
            $table->timestamps();

            // Indexes cho tìm kiếm
            $table->index(['email', 'phone', 'status']);
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
