<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangKyGoiCuoc extends Model
{
    protected $table = 'dang_ky_goi_cuoc';

    // Các trường có thể được gán trực tiếp vào model
    protected $fillable = [
        'so_dien_thoai_id',
        'goi_cuoc_id',
        'trang_thai',    // Cập nhật lại tên cột trạng thái thành trang_thai
        'user_id',       // Cột lưu ID người dùng
    ];

    // Mối quan hệ với bảng GoiCuoc
    public function goiCuoc()
    {
        return $this->belongsTo(GoiCuoc::class, 'goi_cuoc_id');
    }

    // Mối quan hệ với bảng SoDienThoai
    public function soDienThoai()
    {
        return $this->belongsTo(SoDienThoai::class, 'so_dien_thoai_id');
    }

    // Mối quan hệ với bảng User (người dùng đăng ký)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
