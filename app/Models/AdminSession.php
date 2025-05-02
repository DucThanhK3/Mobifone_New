<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSession extends Model
{
    protected $table = 'admin_sessions';

    protected $fillable = [
        'id', 'admin_id', 'ip_address', 'user_agent', 'last_activity', 'token',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}