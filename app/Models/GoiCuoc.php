<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoiCuoc extends Model
{
    use HasFactory;

    protected $table = 'goi_cuoc';

    protected $fillable = ['ten_goi', 'gia', 'mo_ta'];
}

