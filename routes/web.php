<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoDienThoaiController;
use App\Http\Controllers\SimController;
use App\Http\Controllers\GoiCuocController;
use App\Http\Controllers\DichVuController;




Route::get('/', function () {
    return view('frontend.home');
});
Route::get('/customer/dichvu', [DichVuController::class, 'index'])->name('customer.dichvu');



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

});












