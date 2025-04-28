<?php

use App\Http\Controllers\Admin\SoDienThoaiController;
use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Admin\DangKyGoiCuocController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // Đăng nhập, đăng ký, đăng xuất admin
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Các route yêu cầu đăng nhập và là admin
    Route::middleware(['auth', 'isAdmin'])->group(function () {

        // Trang chủ admin
        Route::get('/home', function () {
            return view('admin.home');
        })->name('home');

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
