<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Xác thực dữ liệu
        $this->validator($request->all())->validate();

        // Tạo người dùng mới
        $user = $this->create($request->all());

        // Đăng nhập người dùng
        Auth::login($user); // Sử dụng Auth facade

        // Chuyển hướng đến trang chính hoặc trang nào đó
        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    // Xác thực dữ liệu
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Tạo người dùng mới
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}