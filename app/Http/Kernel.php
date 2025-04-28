<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Các middleware được chạy toàn bộ ứng dụng.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class, // ⚡ cần thêm
        \Illuminate\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class, // ⚡ cần thêm
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class, // ⚡ cần thêm
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
    

    /**
     * Các middleware được áp dụng cho từng route.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        'isUser' => \App\Http\Middleware\IsUser::class,
        // Các middleware khác bạn tạo sẽ được thêm vào đây
    ];
}
