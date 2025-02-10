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
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->char('code', 20)->unique();
            $table->string('name', 100);
            $table->string('type', 50);
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            // Index cho tìm kiếm và relationship
            $table->index('code');
            $table->index(['district_id', 'name']); // Composite index cho search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communes');
    }
};
