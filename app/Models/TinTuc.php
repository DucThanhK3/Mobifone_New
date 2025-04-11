<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    use HasFactory;

    protected $fillable = ['tieu_de', 'hinh_anh', 'noi_dung'];  // Các trường có thể điền vào
}
