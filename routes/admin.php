<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SoDienThoaiController;
use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Admin\DangKyGoiCuocController;

// Route cho admin
Route::prefix('admin')->group(function () {

    // Login, Register
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');  // 👈 Đặt tên là admin.login
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');     // 👈 Đặt tên cho post login luôn
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [AuthController::class, 'register'])->name('admin.register.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');       // 👈 Đặt tên là admin.logout

    // Các route yêu cầu đăng nhập
    Route::middleware(['auth:admin', 'isAdmin'])->group(function () {
        
        Route::get('/home', function () {
            return view('admin.home');
        })->name('admin.home');

        // Quản lý số điện thoại
        Route::resource('so_dien_thoai', SoDienThoaiController::class);
        Route::put('so_dien_thoai/{id}', [SoDienThoaiController::class, 'update'])->name('so_dien_thoai.update');
        Route::delete('so_dien_thoai/{id}', [SoDienThoaiController::class, 'destroy'])->name('so_dien_thoai.destroy');

        // Quản lý sim
        Route::resource('sims', SimController::class);
        Route::put('sims/{so_id}', [SimController::class, 'update'])->name('sims.update');

        // Quản lý gói cước
        Route::resource('goi_cuoc', GoiCuocController::class);

        // Quản lý tin tức
        Route::resource('tintuc', TinTucController::class);
        Route::post('tintuc', [TinTucController::class, 'store'])->name('tintuc.store');
        Route::put('tintuc/{id}', [TinTucController::class, 'update'])->name('tintuc.update');
        Route::delete('tintuc/{id}', [TinTucController::class, 'destroy'])->name('tintuc.destroy');

        // Quản lý đăng ký gói cước
        Route::get('dang-ky-goi-cuoc', [DangKyGoiCuocController::class, 'index'])->name('dang_ky_goi_cuoc.index');
        Route::get('dang-ky-goi-cuoc/{id}/approve', [DangKyGoiCuocController::class, 'approve'])->name('dang_ky_goi_cuoc.approve');
        Route::get('dang-ky-goi-cuoc/{id}/reject', [DangKyGoiCuocController::class, 'reject'])->name('dang_ky_goi_cuoc.reject');
    });

});
