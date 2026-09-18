<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\InvoiceReminder;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceReminderFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_reminder_route_is_available(): void
    {
        $this->assertTrue(route('reminders.index') !== null);
    }

    public function test_reminders_only_appear_after_the_required_interval(): void
    {
        $po = PurchaseOrder::create([
            'no_po' => 'PO-001',
            'jenis_po' => 'Beli',
            'tanggal_po' => now()->subDays(20),
            'total_qty' => 10,
            'used_qty' => 0,
            'status' => 'open',
        ]);

        $invoice = Invoice::create([
            'no_invoice' => 'INV-001',
            'purchase_order_id' => null,
            'tipe' => 'NON_PO',
            'tanggal_invoice' => now()->subDays(10),
        ]);

        $poReminder = InvoiceReminder::updateOrCreate(
            ['tagihan_id' => $po->id, 'jenis_tagihan' => 'PO'],
            ['last_reminded_at' => now()->subDays(6)]
        );

        $nonPoReminder = InvoiceReminder::updateOrCreate(
            ['tagihan_id' => $invoice->id, 'jenis_tagihan' => 'NON_PO'],
            ['last_reminded_at' => now()->subDays(2)]
        );

        $pending = InvoiceReminder::pendingForDisplay();

        $this->assertFalse(collect($pending)->contains(fn ($item) => $item['kode'] === 'PO-001'));
        $this->assertFalse(collect($pending)->contains(fn ($item) => $item['kode'] === 'INV-001'));

        $poReminder->update(['last_reminded_at' => now()->subDays(7)]);
        $nonPoReminder->update(['last_reminded_at' => now()->subDays(3)]);

        $pendingAfterDue = InvoiceReminder::pendingForDisplay();

        $this->assertTrue(collect($pendingAfterDue)->contains(fn ($item) => $item['kode'] === 'PO-001'));
        $this->assertTrue(collect($pendingAfterDue)->contains(fn ($item) => $item['kode'] === 'INV-001'));
    }
}
