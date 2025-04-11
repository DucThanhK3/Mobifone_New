<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SoDienThoaiController;

use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\Frontend\GoiCuocController as FrontendGoiCuocController; 
use App\Http\Controllers\Frontend\DangKyGoiCuocController;

// Trang chính cho khách hàng (frontend)
Route::get('/', function () {
    return view('frontend.home');
});

// Trang gói cước cho khách hàng

Route::get('/goi_cuoc', [FrontendGoiCuocController::class, 'index'])->name('frontend.goicuoc');
Route::post('/dang_ky_goi_cuoc', [FrontendGoiCuocController::class, 'dangKy'])->name('frontend.dangky');
Route::get('/lich_su_dang_ky', [FrontendGoiCuocController::class, 'lichSu'])->name('frontend.lichsu');




// Trang admin chính
Route::get('/admin/home', function () {
    return view('admin.home');
})->name('admin.home');

// Nhóm route dành cho admin
Route::prefix('admin')->group(function () {
    Route::resource('so_dien_thoai', SoDienThoaiController::class);
    Route::put('/so_dien_thoai/{id}', [SoDienThoaiController::class, 'update'])->name('so_dien_thoai.update');
    Route::delete('/so_dien_thoai/{id}', [SoDienThoaiController::class, 'destroy'])->name('so_dien_thoai.destroy');

    Route::resource('sims', SimController::class);
    Route::put('/sims/{so_id}', [SimController::class, 'update'])->name('sims.update');
    Route::resource('goi_cuoc', GoiCuocController::class);

    Route::resource('tintuc', TinTucController::class);
    // Thêm mới tin tức
Route::post('/admin/tintuc', [TinTucController::class, 'store'])->name('admin.tintuc.store');


// Sửa tin tức
Route::put('/admin/tintuc/{id}', [TinTucController::class, 'update'])->name('admin.tintuc.update');

// Xóa tin tức
Route::delete('/tintuc/{id}', [TinTucController::class, 'destroy'])->name('admin.tintuc.destroy');


    

    
});
















