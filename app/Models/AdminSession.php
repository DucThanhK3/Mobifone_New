<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSession extends Model
{
    use HasFactory;

    protected $table = 'admin_sessions';

    protected $fillable = [
        'id',
        'admin_id',
        'ip_address',
        'user_agent',
        'last_activity',
        'token',
    ];

    public $timestamps = false;
}