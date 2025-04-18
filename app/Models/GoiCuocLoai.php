<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoiCuocLoai extends Model
{
    use HasFactory;

    protected $table = 'goi_cuoc_loai';

    protected $fillable = [
        'loai_thue_bao', 'tieu_de', 'hinh_anh', 'mo_ta_chi_tiet'
    ];
}
