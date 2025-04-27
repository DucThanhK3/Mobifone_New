<?php

use App\Http\Controllers\Frontend\GoiCuocController as FrontendGoiCuocController;
use App\Http\Controllers\Frontend\TinTucController as FrontendTinTucController;
use App\Http\Controllers\Frontend\LoaiThueBaoController;
use App\Http\Controllers\Frontend\GoiCuocLoaiController;
use App\Http\Controllers\Frontend\GoiCuocDichVuFrontendController;
use App\Http\Controllers\Frontend\AuthController;

// Trang chính cho khách hàng (frontend)
Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.home');

// Trang gói cước cho khách hàng
Route::get('/goi_cuoc', [FrontendGoiCuocController::class, 'index'])->name('frontend.goicuoc');
Route::post('/dang_ky_goi_cuoc', [FrontendGoiCuocController::class, 'dangKy'])->name('frontend.dangky');
Route::get('/lich_su_dang_ky', [FrontendGoiCuocController::class, 'lichSu'])->name('frontend.lichsu');

// Trang tin tức cho khách hàng
Route::get('/tin-tuc', [FrontendTinTucController::class, 'index'])->name('frontend.tin_tuc.index');
Route::get('/tin-tuc/{id}', [FrontendTinTucController::class, 'show'])->name('frontend.tin_tuc.show');

// Nhóm loại thuê bao
Route::prefix('dich-vu/loai-thue-bao')->name('frontend.goicuocloai.')->group(function () {
    Route::get('/', [GoiCuocLoaiController::class, 'index'])->name('index');
    Route::get('/{id}', [GoiCuocLoaiController::class, 'show'])->name('show');
});

// Đăng ký gói cước
Route::get('/dich-vu/dang-ky-goi-cuoc', [GoiCuocDichVuFrontendController::class, 'index'])->name('frontend.goicuocdichvu.index');

// Đăng nhập, đăng ký và đăng xuất cho khách hàng
Route::get('login', [AuthController::class, 'showLoginForm'])->name('frontend.login');
Route::post('login', [AuthController::class, 'login'])->name('frontend.login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('frontend.register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('frontend.logout');
