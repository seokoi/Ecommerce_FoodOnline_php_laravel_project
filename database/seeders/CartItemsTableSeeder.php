<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CartItem;

class CartItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa tất cả mục giỏ hàng trước khi thêm mới
        CartItem::truncate();

        // Thêm một số mục giỏ hàng trực tiếp
        CartItem::create([
            'user_id' => 1,
            'food_id' => 1,
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => 1,
            'food_id' => 2,
            'quantity' => 2,
        ]);

        CartItem::create([
            'user_id' => 1,
            'food_id' => 3,
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => 2,
            'food_id' => 1,
            'quantity' => 3,
        ]);

        CartItem::create([
            'user_id' => 2,
            'food_id' => 4,
            'quantity' => 1,
        ]);
    }
}
