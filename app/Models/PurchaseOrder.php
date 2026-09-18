<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'no_po',
        'jenis_po',
        'tanggal_po',
        'total_qty',
        'used_qty',
        'status',
        'closed_at'
    ];

    protected $casts = [
        'tanggal_po' => 'date',
        'closed_at' => 'datetime',
    ];

    // Auto update status
    public function refreshStatus()
    {
        if ($this->used_qty >= $this->total_qty) {
            $this->status = 'closed';
            $this->closed_at = $this->closed_at ?? now();
            $this->save();
        }
    }

    public function remainingQty(): int
    {
        return max(0, $this->total_qty - $this->used_qty);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
