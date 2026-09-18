<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class InvoiceReminder extends Model
{
    protected $fillable = [
        'tagihan_id',
        'jenis_tagihan',
        'last_reminded_at',
    ];

    protected $casts = [
        'last_reminded_at' => 'datetime',
    ];

    public static function pendingForDisplay(): array
    {
        if (! Schema::hasTable((new self)->getTable())) {
            return [];
        }

        $items = [];

        foreach (PurchaseOrder::query()->orderByDesc('tanggal_po')->get() as $po) {
            $item = self::buildPoReminder($po);
            if ($item) {
                $items[] = $item;
            }
        }

        foreach (Invoice::query()->where('tipe', 'NON_PO')->orderByDesc('tanggal_invoice')->get() as $invoice) {
            $item = self::buildNonPoReminder($invoice);
            if ($item) {
                $items[] = $item;
            }
        }

        usort($items, fn ($a, $b) => ($a['sort_key'] ?? 0) <=> ($b['sort_key'] ?? 0));

        return array_reverse($items);
    }

    private static function buildPoReminder(PurchaseOrder $po): ?array
    {
        if (! Schema::hasTable((new self)->getTable())) {
            return null;
        }

        $intervalDays = 7;
        $reminder = self::firstOrCreate(
            [
                'tagihan_id' => $po->id,
                'jenis_tagihan' => 'PO',
            ],
            [
                'last_reminded_at' => $po->tanggal_po ?? $po->created_at ?? now(),
            ]
        );

        if (! $reminder->last_reminded_at) {
            $reminder->last_reminded_at = $po->tanggal_po ?? $po->created_at ?? now();
            $reminder->save();
        }

        if (! $reminder->last_reminded_at->copy()->addDays($intervalDays)->lte(now())) {
            return null;
        }

        $reminder->update(['last_reminded_at' => now()]);

        return [
            'jenis' => 'PO',
            'label' => 'Tagihan PO',
            'kode' => $po->no_po,
            'amount' => self::calculatePoAmount($po),
            'sort_key' => $reminder->last_reminded_at->timestamp,
        ];
    }

    private static function buildNonPoReminder(Invoice $invoice): ?array
    {
        if (! Schema::hasTable((new self)->getTable())) {
            return null;
        }

        $intervalDays = 3;
        $reminder = self::firstOrCreate(
            [
                'tagihan_id' => $invoice->id,
                'jenis_tagihan' => 'NON_PO',
            ],
            [
                'last_reminded_at' => $invoice->tanggal_invoice ?? $invoice->created_at ?? now(),
            ]
        );

        if (! $reminder->last_reminded_at) {
            $reminder->last_reminded_at = $invoice->tanggal_invoice ?? $invoice->created_at ?? now();
            $reminder->save();
        }

        if (! $reminder->last_reminded_at->copy()->addDays($intervalDays)->lte(now())) {
            return null;
        }

        $reminder->update(['last_reminded_at' => now()]);

        return [
            'jenis' => 'NON_PO',
            'label' => 'Tagihan Non-PO',
            'kode' => $invoice->no_invoice,
            'amount' => (float) $invoice->items()->sum('subtotal'),
            'sort_key' => $reminder->last_reminded_at->timestamp,
        ];
    }

    private static function calculatePoAmount(PurchaseOrder $po): float
    {
        return (float) $po->invoices()->with('items')->get()->sum(function ($invoice) {
            return (float) $invoice->items->sum('subtotal');
        });
    }
}
