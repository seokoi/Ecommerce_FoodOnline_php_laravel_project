<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; // Sử dụng mô hình Permission từ Spatie

class NewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'manage food']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage orders']);
        Permission::firstOrCreate(['name' => 'view reports']);
    }
}