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
            $guards = [null];
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
        if (! $request->expectsJson()) {
            // Kiểm tra xem người dùng là admin hay không
            if ($request->is('admin/*')) {
                return route('admin.login'); // Nếu là admin thì chuyển đến login admin
            }

            return route('frontend.login'); // Nếu không phải admin thì chuyển đến login frontend
        }
    }
}
