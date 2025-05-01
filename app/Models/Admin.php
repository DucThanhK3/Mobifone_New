<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'email',
        'password',
        'name', // Thêm nếu cần
    ];

    protected $hidden = [
        'password',
    ];
}