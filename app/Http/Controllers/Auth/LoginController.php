<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Kiểm tra thông tin đăng nhập
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Đăng nhập thành công, lấy người dùng hiện tại
        /** @var \App\Models\User */
        $user = Auth::user();
        // Kiểm tra vai trò của người dùng
        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/users'); // Chuyển hướng đến trang quản lý người dùng
        } elseif ($user->hasRole('manager')) {
            return redirect()->intended('/manager/dashboard'); // Chuyển hướng đến trang dashboard của manager
        } else {
            return redirect()->intended('/'); // Chuyển hướng đến trang chính
        }
    }

    // Đăng nhập thất bại
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ]);
}

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}