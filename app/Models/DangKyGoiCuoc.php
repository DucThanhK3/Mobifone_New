<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangKyGoiCuoc extends Model
{
    protected $table = 'dang_ky_goi_cuoc';

    protected $fillable = [
        'so_dien_thoai_id',
        'goi_cuoc_id',
    ];

    public function goiCuoc()
    {
        return $this->belongsTo(GoiCuoc::class, 'goi_cuoc_id');
    }

    public function soDienThoai()
    {
        return $this->belongsTo(SoDienThoai::class, 'so_dien_thoai_id');
    }
}
