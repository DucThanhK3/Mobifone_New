<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoDienThoai extends Model
{
    use HasFactory;
    protected $table = 'so_dien_thoai';
    protected $fillable = ['so', 'chu_so_huu'];
}
