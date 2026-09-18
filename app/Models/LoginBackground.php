<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginBackground extends Model
{
    protected $table = 'login_backgrounds';

    protected $fillable = [
        'type',
        'file_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
