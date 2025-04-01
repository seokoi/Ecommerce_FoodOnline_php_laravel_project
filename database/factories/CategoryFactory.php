<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(), // Tên danh mục phải là duy nhất
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name']); // Tạo slug từ tên
            },
            'description' => $this->faker->sentence(),
        ];
    }
}
