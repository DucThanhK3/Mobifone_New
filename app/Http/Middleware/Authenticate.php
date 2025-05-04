<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = ['web'];
        }

        foreach ($guards as $guard) {
            if (!Auth::guard($guard)->check()) {
                return $this->redirectTo($request);
            }
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Lưu thông báo vào session
            session()->flash('error', 'Vui lòng đăng nhập để sử dụng chức năng này.');
            // Chuyển hướng về trang chủ frontend
            return route('frontend.home');
        }

        return null;
    }
}