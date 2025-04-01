<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
            UsersTableSeeder::class,
            RolePermissionSeeder::class,
            FoodsTableSeeder::class,
            CategoriesTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            CartItemsTableSeeder::class,
    ]);

    }
}
