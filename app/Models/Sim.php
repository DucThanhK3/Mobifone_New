<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Sim extends Model
{
    use HasFactory;

    protected $table = 'sims';
    protected $fillable = ['so_id', 'network_provider', 'status'];
    
    public $timestamps = true; // Cần đồng bộ với Migration
}

