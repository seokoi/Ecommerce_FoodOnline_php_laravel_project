<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;

class OrderItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa tất cả mục đơn hàng trước khi thêm mới
        OrderItem::truncate();

        // Thêm các mục đơn hàng trực tiếp
        OrderItem::create([
            'order_id' => 1,
            'food_id' => 1,
            'quantity' => 2,
            'price' => 9.99, // Giá của món ăn
        ]);

        OrderItem::create([
            'order_id' => 1,
            'food_id' => 2,
            'quantity' => 1,
            'price' => 5.99, // Giá của món ăn
        ]);

        OrderItem::create([
            'order_id' => 2,
            'food_id' => 3,
            'quantity' => 3,
            'price' => 7.99, // Giá của món ăn
        ]);

        OrderItem::create([
            'order_id' => 2,
            'food_id' => 4,
            'quantity' => 1,
            'price' => 4.99, // Giá của món ăn
        ]);

        OrderItem::create([
            'order_id' => 3,
            'food_id' => 5,
            'quantity' => 2,
            'price' => 12.99, // Giá của món ăn
        ]);
    }
}
