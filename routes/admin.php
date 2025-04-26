<?php

use App\Http\Controllers\Admin\SoDienThoaiController;
use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Admin\DangKyGoiCuocController;
use App\Http\Controllers\Admin\AuthController;

// Trang chủ admin
Route::get('/home', function () {
    return view('admin.home');
})->name('admin.home');

// Quản lý số điện thoại
Route::resource('so_dien_thoai', SoDienThoaiController::class);
Route::put('/so_dien_thoai/{id}', [SoDienThoaiController::class, 'update'])->name('so_dien_thoai.update');
Route::delete('/so_dien_thoai/{id}', [SoDienThoaiController::class, 'destroy'])->name('so_dien_thoai.destroy');

// Quản lý sim
Route::resource('sims', SimController::class);
Route::put('/sims/{so_id}', [SimController::class, 'update'])->name('sims.update');

// Quản lý gói cước
Route::resource('goi_cuoc', GoiCuocController::class);

// Quản lý tin tức
Route::resource('tintuc', TinTucController::class);

// Thêm, sửa, xóa tin tức
Route::post('/admin/tintuc', [TinTucController::class, 'store'])->name('admin.tintuc.store');
Route::put('/admin/tintuc/{id}', [TinTucController::class, 'update'])->name('admin.tintuc.update');
Route::delete('/admin/tintuc/{id}', [TinTucController::class, 'destroy'])->name('admin.tintuc.destroy');

// Các route yêu cầu admin xác nhận đăng ký gói cước
Route::middleware('auth:admin')->group(function () {
    Route::get('/dang-ky-goi-cuoc', [DangKyGoiCuocController::class, 'index'])->name('admin.dang_ky_goi_cuoc.index');
    Route::get('/dang-ky-goi-cuoc/{id}/approve', [DangKyGoiCuocController::class, 'approve'])->name('admin.dang_ky_goi_cuoc.approve');
    Route::get('/dang-ky-goi-cuoc/{id}/reject', [DangKyGoiCuocController::class, 'reject'])->name('admin.dang_ky_goi_cuoc.reject');
});

// Đăng nhập, đăng ký và đăng xuất cho admin
Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
