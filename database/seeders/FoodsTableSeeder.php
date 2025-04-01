<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodsTableSeeder extends Seeder
{
    public function run(): void
    {

        // Thêm các món ăn trực tiếp với category_id
        Food::create(['name' => 'Pizza', 'description' => 'Pizza phô mai ngon tuyệt', 'price' => 200000, 'image' => 'pizza.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Burger', 'description' => 'Bánh burger thịt bò mọng nước', 'price' => 120000, 'image' => 'burger.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Pasta', 'description' => 'Mì Ý sốt kem Alfredo', 'price' => 150000, 'image' => 'pasta.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Salad', 'description' => 'Salad rau củ tươi ngon', 'price' => 80000, 'image' => 'salad.jpg', 'category_id' => 4]);
        Food::create(['name' => 'Sushi', 'description' => 'Món sushi đa dạng', 'price' => 250000, 'image' => 'sushi.jpg', 'category_id' => 3]);
        Food::create(['name' => 'Bánh mì', 'description' => 'Bánh mì thịt đầy đủ', 'price' => 30000, 'image' => 'banhmi.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Cơm tấm', 'description' => 'Cơm tấm sườn nướng', 'price' => 70000, 'image' => 'comtam.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Gỏi cuốn', 'description' => 'Gỏi cuốn tôm thịt', 'price' => 50000, 'image' => 'goicuon.jpg', 'category_id' => 4]);
        Food::create(['name' => 'Mì Quảng', 'description' => 'Mì Quảng tôm thịt', 'price' => 90000, 'image' => 'miquang.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Bún chả', 'description' => 'Bún chả Hà Nội', 'price' => 80000, 'image' => 'bunchahanoi.jpg', 'category_id' => 1]);
        Food::create(['name' => 'Chả giò', 'description' => 'Chả giò chiên giòn', 'price' => 60000, 'image' => 'chagio.jpg', 'category_id' => 4]);
        Food::create(['name' => 'Tàu hủ ky', 'description' => 'Tàu hủ ky chiên giòn', 'price' => 40000, 'image' => 'tauhuky.jpg', 'category_id' => 4]);
        Food::create(['name' => 'Trà sữa', 'description' => 'Trà sữa trân châu', 'price' => 50000, 'image' => 'trasua.jpg', 'category_id' => 3]);
        Food::create(['name' => 'Cà phê', 'description' => 'Cà phê sữa đá', 'price' => 30000, 'image' => 'caphe.jpg', 'category_id' => 3]);
        Food::create(['name' => 'Kem', 'description' => 'Kem ốc quế', 'price' => 25000, 'image' => 'kem.jpg', 'category_id' => 2]);
        Food::create(['name' => 'Bánh flan', 'description' => 'Bánh flan caramel', 'price' => 20000, 'image' => 'banhflan.jpg', 'category_id' => 2]);
        Food::create(['name' => 'Sữa chua', 'description' => 'Sữa chua trái cây', 'price' => 30000, 'image' => 'suachua.jpg', 'category_id' => 2]);
        Food::create(['name' => 'Nước ngọt', 'description' => 'Nước ngọt có ga', 'price' => 15000, 'image' => 'nuocngot.jpg', 'category_id' => 3]);
        Food::create(['name' => 'Sinh tố', 'description' => 'Sinh tố xoài', 'price' => 60000, 'image' => 'sinhtho.jpg', 'category_id' => 3]);
        Food::create(['name' => 'Bánh bông lan', 'description' => 'Bánh bông lan vanilla', 'price' => 35000, 'image' => 'banhbonglan.jpg', 'category_id' => 2]);
    }
}
