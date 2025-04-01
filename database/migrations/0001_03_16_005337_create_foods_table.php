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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Cột tên món ăn
            $table->text('description'); // Cột mô tả món ăn
            $table->decimal('price', 8, 2); // Cột giá món ăn
            $table->enum('status', ['available', 'out_of_stock'])->default('available'); // Trường trạng thái
            $table->string('image')->nullable(); // Cột hình ảnh (có thể null)
            $table->timestamps(); // Cột cho thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};