<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có vai trò đúng hay không\
        /** @var \App\Models\User */
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            // Chuyển hướng đến trang đăng nhập hoặc trang khác
            return redirect()->route('/0')->with('error', 'BẠN KHÔNG CÓ QUYỀN VÀO TRANG NÀY');
        }

        return $next($request);
    }
}
