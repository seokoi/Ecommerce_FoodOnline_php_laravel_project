<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa tất cả đơn hàng trước khi thêm mới
        Order::truncate();

        // Thêm các đơn hàng trực tiếp
        Order::create([
            'user_id' => 1,
            'staff_id' => null,
            'total' => 15.98,
            'phone' => '123456789',
            'address' => '123 Admin St.',
            'status' => 'đã duyệt',
        ]);

        Order::create([
            'user_id' => 2,
            'staff_id' => null,
            'total' => 29.99,
            'phone' => '987654321',
            'address' => '456 User Ave.',
            'status' => 'đang chờ',
        ]);

        Order::create([
            'user_id' => 3,
            'staff_id' => 1,
            'total' => 45.50,
            'phone' => '555555555',
            'address' => '789 Customer Rd.',
            'status' => 'đã giao',
        ]);

        Order::create([
            'user_id' => 1,
            'staff_id' => null,
            'total' => 19.99,
            'phone' => '123123123',
            'address' => '321 Another St.',
            'status' => 'đã duyệt',
        ]);

        Order::create([
            'user_id' => 2,
            'staff_id' => 2,
            'total' => 22.00,
            'phone' => '678678678',
            'address' => '654 Sample Rd.',
            'status' => 'đang chờ',
        ]);
    }
}
