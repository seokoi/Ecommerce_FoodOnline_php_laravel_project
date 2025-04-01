<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
       // Tạo vai trò nếu chưa tồn tại
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Thêm người dùng và gán vai trò
        User::create([
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@a.com',
            'password' => bcrypt('12345678'),
            'verification_code' => Str::random(10),
            'phone' => '123456789',
            'address' => '123 Admin St.',
        ])->assignRole($adminRole); // Gán vai trò admin

        User::create([
            'id' => 2,
            'name' => 'Binh User',
            'email' => 'binh@a.com',
            'password' => bcrypt('12345678'),
            'verification_code' => Str::random(10),
            'phone' => '234567890',
            'address' => '234 Binh St.',
        ])->assignRole($adminRole); // Gán vai trò manager

        User::create([
            'id' => 3,
            'name' => 'Hieu User',
            'email' => 'hieu@a.com',
            'password' => bcrypt('12345678'),
            'verification_code' => Str::random(10),
            'phone' => '345678901',
            'address' => '345 Hieu Ave.',
        ])->assignRole($staffRole); // Gán vai trò staff

        User::create([
            'id' => 4,
            'name' => 'Thien User',
            'email' => 'thien@a.com',
            'password' => bcrypt('12345678'),
            'verification_code' => Str::random(10),
            'phone' => '456789012',
            'address' => '456 Thien Blvd.',
        ])->assignRole($customerRole); // Gán vai trò customer
    }
}
