<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SoDienThoaiController;
use App\Http\Controllers\Admin\SimController;
use App\Http\Controllers\Admin\GoiCuocController;
use App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Frontend\GoiCuocController as FrontendGoiCuocController;
use App\Http\Controllers\Frontend\DangKyGoiCuocController;
use App\Http\Controllers\Frontend\TinTucController as FrontendTinTucController;

use App\Http\Controllers\Frontend\LoaiThueBaoController;
use App\Http\Controllers\Frontend\GoiCuocLoaiController;
use App\Http\Controllers\Frontend\GoiCuocDichVuFrontendController;






// Trang chính cho khách hàng (frontend)
Route::get('/', function () {
    return view('frontend.home');
});

// Trang gói cước cho khách hàng
Route::get('/goi_cuoc', [FrontendGoiCuocController::class, 'index'])->name('frontend.goicuoc');
Route::post('/dang_ky_goi_cuoc', [FrontendGoiCuocController::class, 'dangKy'])->name('frontend.dangky');
Route::get('/lich_su_dang_ky', [FrontendGoiCuocController::class, 'lichSu'])->name('frontend.lichsu');

// Trang tin tức cho khách hàng
// Trang tin tức cho khách hàng
Route::get('/tin-tuc', [FrontendTinTucController::class, 'index'])->name('frontend.tin_tuc.index');
Route::get('/tin-tuc/{id}', [FrontendTinTucController::class, 'show'])->name('frontend.tin_tuc.show');





// Nhóm loại thuê bao
Route::prefix('dich-vu/loai-thue-bao')->name('frontend.goicuocloai.')->group(function () {
    Route::get('/', [GoiCuocLoaiController::class, 'index'])->name('index');
    Route::get('/{id}', [GoiCuocLoaiController::class, 'show'])->name('show');
});



Route::prefix('dich-vu/dang-ky-goi-cuoc')->name('frontend.goicuocdichvu.')->group(function(){
    Route::get('/', [GoiCuocDichVuFrontendController::class, 'index'])->name('index');
    Route::post('/dang-ky', [GoiCuocDichVuFrontendController::class, 'dangKy'])->name('dangky');
    Route::get('/lich-su', [GoiCuocDichVuFrontendController::class, 'lichSu'])->name('lichsu');
    Route::delete('/{id}', [GoiCuocDichVuFrontendController::class, 'destroy'])->name('destroy');
});



Route::get('/admin/home', function () {
    return view('admin.home');
})->name('admin.home');

// Nhóm route dành cho admin
Route::prefix('admin')->group(function () {
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
    
    // Thêm mới tin tức
    Route::post('/admin/tintuc', [TinTucController::class, 'store'])->name('admin.tintuc.store');
    
    // Sửa tin tức
    Route::put('/admin/tintuc/{id}', [TinTucController::class, 'update'])->name('admin.tintuc.update');
    
    // Xóa tin tức
    Route::delete('/admin/tintuc/{id}', [TinTucController::class, 'destroy'])->name('admin.tintuc.destroy');
});





