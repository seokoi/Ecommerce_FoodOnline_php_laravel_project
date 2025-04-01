<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Tạo quyền
        Permission::create(['name' => 'manage food']); // Quản lý thực phẩm
        Permission::create(['name' => 'manage users']); // Quản lý người dùng
        Permission::create(['name' => 'manage orders']); // Quản lý đơn hàng
        Permission::create(['name' => 'view reports']); // Xem báo cáo

        // Tạo vai trò
        $admin = Role::create(['name' => 'admin']); // Vai trò quản trị viên
        $manager = Role::create(['name' => 'manager']); // Vai trò quản lý
        $staff = Role::create(['name' => 'staff']); // Vai trò nhân viên
        $customer = Role::create(['name' => 'customer']); // Vai trò khách hàng

        // Gán quyền cho vai trò
        $admin->givePermissionTo(Permission::all()); // Quản trị viên có tất cả quyền
        $manager->givePermissionTo(['manage food', 'manage orders']); // Quản lý có quyền quản lý thực phẩm và đơn hàng
        $staff->givePermissionTo(['manage users']); // Nhân viên có quyền quản lý người dùng
        $customer->givePermissionTo([]); // Khách hàng không có quyền nào
    }
}