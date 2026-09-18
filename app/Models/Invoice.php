<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'no_invoice',
        'no_po_manual',
        'no_so',
        'tipe_bisnis',
        'purchase_order_id',
        'tipe',
        'tanggal_invoice',
        'sudah_ditagihkan',
        'sudah_selesai',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
        'sudah_ditagihkan' => 'boolean',
        'sudah_selesai' => 'boolean',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getTotalNilaiAttribute()
    {
        return $this->items()->sum('subtotal');
    }

    public function getInternalBusinessAttribute()
    {
        $noPoManual = trim((string) $this->no_po_manual);
        if ($noPoManual !== '' && $noPoManual !== '-') {
            return $noPoManual;
        }

        if (! $this->no_invoice) {
            return null;
        }

        // More robust extraction of a custom business token from invoice
        // numbers. Strategy:
        // - Split by '/'. Ignore the first two segments (INV/KOPKAR and YEAR).
        // - Search remaining segments for the first one that contains any
        //   alphabetic character (A-Z) — this is likely the custom business
        //   part (e.g. 'KRT', 'PASCA').
        // - Ignore purely numeric segments (sequence) and typical roman
        //   month tokens (I, II, III, ...), which don't contain letters.
        $parts = array_values(array_filter(explode('/', $this->no_invoice), fn($p) => $p !== ''));

        if (count($parts) < 3) {
            return null;
        }

        // Consider segments after the first two (index >= 2)
        for ($i = 2; $i < count($parts); $i++) {
            $seg = $parts[$i];

            // Skip empty or numeric-only segments
            if ($seg === '' || ctype_digit($seg)) {
                continue;
            }

            // If the segment contains alphabetic chars, treat it as business part
            if (preg_match('/[A-Za-z]/', $seg)) {
                return $seg;
            }
        }

        return null;
    }

    public function getDisplayPoAttribute()
    {
        if ($this->purchaseOrder) {
            return $this->purchaseOrder->no_po;
        }

        if ($this->tipe === 'PO' && $this->purchase_order_id === null) {
            return '-';
        }

        $noPoManual = trim((string) $this->no_po_manual);
        return $noPoManual !== '' ? $noPoManual : '-';
    }
}
