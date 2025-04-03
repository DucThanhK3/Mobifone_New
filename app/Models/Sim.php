<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sim extends Model
{
    use HasFactory;

    protected $table = 'sims';
    
    // Đặt so_id làm khóa chính
    protected $primaryKey = 'so_id';
    public $incrementing = true; // Nếu so_id là số nguyên tự động tăng, còn không thì set false
    protected $keyType = 'int'; // Nếu so_id là số nguyên

    protected $fillable = ['sodt', 'network_provider', 'status'];

    public $timestamps = true; // Cần đồng bộ với Migration
}


