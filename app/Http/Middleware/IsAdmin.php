<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (Auth::user()->role !== 'admin') {
            // Nếu không phải admin -> trả về lỗi 403 Forbidden
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
