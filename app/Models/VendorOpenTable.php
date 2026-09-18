<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOpenTable extends Model
{
    protected $fillable = [
        'nama_vendor',
        'tanggal_open_table',
    ];

    protected $casts = [
        'tanggal_open_table' => 'array',
    ];
}
