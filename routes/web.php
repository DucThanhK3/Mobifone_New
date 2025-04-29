<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\SoDienThoaiController;
use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Admin\DangKyGoiCuocController;
use App\Http\Controllers\Frontend\GoiCuocController as FrontendGoiCuocController;
use App\Http\Controllers\Frontend\TinTucController as FrontendTinTucController;
use App\Http\Controllers\Frontend\LoaiThueBaoController;
use App\Http\Controllers\Frontend\GoiCuocLoaiController;
use App\Http\Controllers\Frontend\GoiCuocDichVuFrontendController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->group(function () {
    // Login, Register
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [AdminAuthController::class, 'register'])->name('admin.register.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Các route yêu cầu đăng nhập
    Route::middleware(['auth:admin', 'isAdmin'])->group(function () {
        Route::get('/home', function () {
            return view('admin.home');
        })->name('admin.home');

        Route::resource('so_dien_thoai', SoDienThoaiController::class);
        Route::put('so_dien_thoai/{id}', [SoDienThoaiController::class, 'update'])->name('so_dien_thoai.update');
        Route::delete('so_dien_thoai/{id}', [SoDienThoaiController::class, 'destroy'])->name('so_dien_thoai.destroy');

        Route::resource('sims', SimController::class);
        Route::put('sims/{so_id}', [SimController::class, 'update'])->name('sims.update');

        Route::resource('goi_cuoc', GoiCuocController::class);

        Route::resource('tintuc', TinTucController::class);
        Route::post('tintuc', [TinTucController::class, 'store'])->name('tintuc.store');
        Route::put('tintuc/{id}', [TinTucController::class, 'update'])->name('tintuc.update');
        Route::delete('tintuc/{id}', [TinTucController::class, 'destroy'])->name('tintuc.destroy');

        Route::get('dang-ky-goi-cuoc', [DangKyGoiCuocController::class, 'index'])->name('dang_ky_goi_cuoc.index');
        Route::get('dang-ky-goi-cuoc/{id}/approve', [DangKyGoiCuocController::class, 'approve'])->name('dang_ky_goi_cuoc.approve');
        Route::get('dang-ky-goi-cuoc/{id}/reject', [DangKyGoiCuocController::class, 'reject'])->name('dang_ky_goi_cuoc.reject');
    });
});

// ========== FRONTEND ROUTES ==========
Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.home');

Route::get('/goi_cuoc', [FrontendGoiCuocController::class, 'index'])->name('frontend.goicuoc');
Route::post('/dang_ky_goi_cuoc', [FrontendGoiCuocController::class, 'dangKy'])->name('frontend.dangky');
Route::get('/lich_su_dang_ky', [FrontendGoiCuocController::class, 'lichSu'])->name('frontend.lichsu');

Route::get('/tin-tuc', [FrontendTinTucController::class, 'index'])->name('frontend.tin_tuc.index');
Route::get('/tin-tuc/{id}', [FrontendTinTucController::class, 'show'])->name('frontend.tin_tuc.show');

Route::prefix('dich-vu/loai-thue-bao')->name('frontend.goicuocloai.')->group(function () {
    Route::get('/', [GoiCuocLoaiController::class, 'index'])->name('index');
    Route::get('/{id}', [GoiCuocLoaiController::class, 'show'])->name('show');
});

Route::get('/dich-vu/dang-ky-goi-cuoc', [GoiCuocDichVuFrontendController::class, 'index'])->name('frontend.goicuocdichvu.index');

// Đăng nhập, đăng ký cho khách hàng
Route::get('login', [FrontendAuthController::class, 'showLoginForm'])->name('frontend.login');
Route::post('login', [FrontendAuthController::class, 'login'])->name('frontend.login.post');
Route::get('register', [FrontendAuthController::class, 'showRegisterForm'])->name('frontend.register');
Route::post('register', [FrontendAuthController::class, 'register'])->name('frontend.register.post');
Route::post('logout', [FrontendAuthController::class, 'logout'])->name('frontend.logout');