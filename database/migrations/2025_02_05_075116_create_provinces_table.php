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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->char('code', 20)->unique(); // Mã tỉnh/thành phố
            $table->string('name', 100);           // Tên tỉnh/thành phố
            $table->string('type', 50);           // Loại (tỉnh/thành phố)
            $table->timestamps();
            $table->softDeletes();

            // Index cho tìm kiếm và join
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
