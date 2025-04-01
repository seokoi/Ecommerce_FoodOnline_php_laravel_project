<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check() || !Auth::user()->can($permission)) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        return $next($request);
    }
}
