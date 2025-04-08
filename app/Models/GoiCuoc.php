<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoiCuoc extends Model
{
    use HasFactory;

    protected $table = 'goi_cuoc';

    protected $fillable = ['ten_goi', 'gia', 'mo_ta', 'cu_phap_dang_ky'];
    public function sims()
    {
        return $this->hasMany(Sim::class, 'goi_cuoc_id');
    }
}

