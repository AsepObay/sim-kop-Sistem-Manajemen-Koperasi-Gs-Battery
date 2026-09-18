<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'tanggal_item',
        'nama_item',
        'qty',
        'unit',
        'harga',
        'is_ppn',
        'ppn_value',
        'subtotal',
    ];

    protected $casts = [
        'tanggal_item' => 'date',
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'is_ppn' => 'boolean',
        'ppn_value' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted(): void
    {
        static::creating(function (InvoiceItem $item) {
            $invoice = $item->invoice()->with('purchaseOrder')->first();

            if ($invoice?->purchaseOrder) {
                $remaining = $invoice->purchaseOrder->remainingQty();

                if ($item->qty > $remaining) {
                    throw ValidationException::withMessages([
                        'qty' => 'Qty invoice melebihi sisa qty PO.',
                    ]);
                }
            }
        });
    }
}
