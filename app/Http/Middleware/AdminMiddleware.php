<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Kiểm tra xem người dùng đã đăng nhập và có vai trò admin
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng về trang khác
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
}