<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
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
    // Login, Logout routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login.get');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Protected routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/home', [AdminController::class, 'index'])->name('admin.home');

        Route::resource('so_dien_thoai', SoDienThoaiController::class);
        Route::post('so_dien_thoai', [SoDienThoaiController::class, 'store'])->name('admin.so_dien_thoai.store');
        Route::resource('sims', SimController::class);
        Route::post('sims', [SimController::class, 'store'])->name('admin.sims.store');
        Route::resource('goi_cuoc', GoiCuocController::class);
        Route::post('goi_cuoc', [GoiCuocController::class, 'store'])->name('admin.goi_cuoc.store');
        Route::resource('tintuc', TinTucController::class);
        Route::post('tintuc', [TinTucController::class, 'store'])->name('admin.tintuc.store');

        Route::get('dang-ky-goi-cuoc', [DangKyGoiCuocController::class, 'index'])->name('dang_ky_goi_cuoc.index');
        Route::post('dang-ky-goi-cuoc/approve/{id}', [DangKyGoiCuocController::class, 'approve'])->name('admin.dang_ky_goi_cuoc.approve');
        Route::get('dang-ky-goi-cuoc/{id}/reject', [DangKyGoiCuocController::class, 'reject'])->name('dang_ky_goi_cuoc.reject');
    });
});

// ========== FRONTEND ROUTES ========== 
Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.home');

Route::get('/goi_cuoc', [FrontendGoiCuocController::class, 'index'])->name('frontend.goicuoc');

Route::get('/tin-tuc', [FrontendTinTucController::class, 'index'])->name('frontend.tin_tuc.index');
Route::get('/tin-tuc/{id}', [FrontendTinTucController::class, 'show'])->name('frontend.tin_tuc.show');

Route::prefix('dich-vu/loai-thue-bao')->name('frontend.goicuocloai.')->group(function () {
    Route::get('/', [GoiCuocLoaiController::class, 'index'])->name('index');
    Route::get('/{id}', [GoiCuocLoaiController::class, 'show'])->name('show');
});

// Các route yêu cầu khách hàng đăng nhập 
Route::middleware(['auth:web'])->group(function () {
    Route::get('/lich_su_dang_ky', [FrontendGoiCuocController::class, 'lichSu'])->name('frontend.lichsu');
    Route::post('/dang_ky_goi_cuoc', [FrontendGoiCuocController::class, 'dangKy'])->name('frontend.dangky');
    Route::get('/dich-vu/dang-ky-goi-cuoc', [GoiCuocDichVuFrontendController::class, 'index'])->name('frontend.goicuocdichvu.index');
});

// ========== KHÁCH HÀNG AUTH ROUTES ========== 
Route::prefix('khach-hang')->name('frontend.')->group(function () {
    Route::get('dang-nhap', [FrontendAuthController::class, 'showLoginForm'])->name('login');
    Route::post('dang-nhap', [FrontendAuthController::class, 'login'])->name('login.post');

    Route::get('dang-ky', [FrontendAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('dang-ky', [FrontendAuthController::class, 'register'])->name('register.post');

    Route::post('dang-xuat', [FrontendAuthController::class, 'logout'])->name('logout');
});

// Fallback route để không lỗi khi dùng route('login')
Route::get('/login', function () {
    return redirect()->route('frontend.login');
})->name('frontend.login.fallback');
