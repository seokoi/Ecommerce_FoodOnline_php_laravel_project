<?php

namespace App\Http\Controllers;

use App\Models\User; // Đảm bảo bạn đã import model User
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Import Role model
use Spatie\Permission\Models\Permission; // Import Permission model

class AdminController extends Controller
{
    // Phương thức để hiển thị danh sách người dùng
    public function index()
    {
        $users = User::all(); // Lấy tất cả người dùng
        $permissions = Permission::all(); // Lấy tất cả quyền
        return view('admin.users.index', compact('users', 'permissions')); // Trả về view với danh sách người dùng
    }

    // Phương thức để tạo người dùng mới
    public function create()
    {
        $roles = Role::all(); // Lấy tất cả vai trò
        $permissions = Permission::all(); // Lấy tất cả quyền
        return view('admin.users.create', compact('roles','permissions')); // Trả về view để tạo người dùng mới
    }

    // Phương thức để lưu người dùng mới
    public function store(Request $request)
{
    // Xử lý lưu người dùng mới
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|exists:roles,name', // Kiểm tra vai trò
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,name', // Kiểm tra quyền
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Gán vai trò cho người dùng
    $user->assignRole($request->role);

    // Gán quyền cho người dùng
    if ($request->has('permissions')) {
        $user->syncPermissions($request->permissions);
    }

    return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công.');
}

    // Phương thức để hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        $roles = Role::all(); // Lấy tất cả vai trò
        $permissions = Permission::all(); // Lấy tất cả quyền
        return view('admin.users.edit', compact('user', 'roles', 'permissions')); // Trả về view chỉnh sửa
    }

    // Phương thức để cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID

        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Bỏ qua email hiện tại
            'password' => 'nullable|string|min:8|confirmed', // Mật khẩu có thể để trống
            'role' => 'required|exists:roles,name', // Kiểm tra vai trò
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name', // Kiểm tra quyền
        ]);

        // Cập nhật thông tin người dùng
        $user->name = $request->name;
        $user->email = $request->email;

        // Cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save(); // Lưu thay đổi

        // Cập nhật vai trò cho người dùng
        $user->syncRoles([$request->role]);

        // Cập nhật quyền cho người dùng
        $user->syncPermissions($request->permissions);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    // Phương thức để xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        $user->delete(); // Xóa người dùng

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công.');
    }

// Phương thức để cập nhật quyền cho người dùng
public function updatePermissions(Request $request, $userId)
{
    $user = User::findOrFail($userId); // Tìm người dùng theo ID

    // Xác thực dữ liệu
    $request->validate([
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id', // Kiểm tra quyền
    ]);

    // Cập nhật quyền cho người dùng
    $user->syncPermissions($request->permissions);

    return redirect()->route('admin.users.index')->with('success', 'Quyền của người dùng đã được cập nhật thành công.');
}
}