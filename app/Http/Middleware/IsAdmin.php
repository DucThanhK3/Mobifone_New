<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login'); // 👈 nếu đang ở admin, về admin login
            }

            return route('login'); // 👈 nếu không phải admin, về user login
        }
    }
}
