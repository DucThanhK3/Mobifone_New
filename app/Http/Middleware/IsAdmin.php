<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra nếu user không phải admin
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            // Đăng xuất và quay về login
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Bạn không có quyền truy cập trang quản trị.',
            ]);
        }

        return $next($request);
    }
}
