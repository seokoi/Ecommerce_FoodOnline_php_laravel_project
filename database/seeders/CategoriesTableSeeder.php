<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa tất cả danh mục trước khi thêm mới
        Category::truncate();

        // Thêm các danh mục một cách trực tiếp
        Category::create([
            'name' => 'Thức ăn nhanh', // Fast Food
            'slug' => 'thuc-an-nhanh',
            'description' => 'Các món ăn nhanh',
        ]);

        Category::create([
            'name' => 'Món tráng miệng', // Desserts
            'slug' => 'mon-trang-mieng',
            'description' => 'Các món ngọt',
        ]);

        Category::create([
            'name' => 'Đồ uống', // Beverages
            'slug' => 'do-uong',
            'description' => 'Các loại đồ uống',
        ]);

        Category::create([
            'name' => 'Salad', // Salads
            'slug' => 'salad',
            'description' => 'Salad tươi ngon',
        ]);

        Category::create([
            'name' => 'Đồ ăn nhẹ', // Snacks
            'slug' => 'do-an-nhe',
            'description' => 'Các món ăn nhẹ',
        ]);
    }
}
