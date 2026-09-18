<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Purchase Orders
        $pos = [
            [
                'no_po' => 'PO-001-2025',
                'jenis_po' => 'Material',
                'tanggal_po' => now()->subDays(30),
                'total_qty' => 100,
                'used_qty' => 85,
                'status' => 'open',
            ],
            [
                'no_po' => 'PO-002-2025',
                'jenis_po' => 'Service',
                'tanggal_po' => now()->subDays(20),
                'total_qty' => 50,
                'used_qty' => 40,
                'status' => 'open',
            ],
            [
                'no_po' => 'PO-003-2025',
                'jenis_po' => 'Material',
                'tanggal_po' => now()->subDays(15),
                'total_qty' => 200,
                'used_qty' => 150,
                'status' => 'open',
            ],
            [
                'no_po' => 'PO-004-2025',
                'jenis_po' => 'Material',
                'tanggal_po' => now()->subDays(10),
                'total_qty' => 80,
                'used_qty' => 79,
                'status' => 'open',
            ],
            [
                'no_po' => 'PO-005-2025',
                'jenis_po' => 'Service',
                'tanggal_po' => now()->subDays(5),
                'total_qty' => 120,
                'used_qty' => 120,
                'status' => 'closed',
            ],
        ];

        $createdPos = [];
        foreach ($pos as $po) {
            $createdPos[] = PurchaseOrder::create($po);
        }

        // Create Invoices with Invoice Items
        $invoices = [
            [
                'no_invoice' => 'INV-001-2025',
                'purchase_order_id' => $createdPos[0]->id,
                'tipe' => 'PO',
                'tanggal_invoice' => now()->subDays(25),
                'items' => [
                    ['deskripsi' => 'Material A', 'qty' => 50, 'harga_satuan' => 100000, 'subtotal' => 5000000],
                    ['deskripsi' => 'Material B', 'qty' => 35, 'harga_satuan' => 150000, 'subtotal' => 5250000],
                ],
            ],
            [
                'no_invoice' => 'INV-002-2025',
                'purchase_order_id' => $createdPos[1]->id,
                'tipe' => 'PO',
                'tanggal_invoice' => now()->subDays(18),
                'items' => [
                    ['deskripsi' => 'Service A', 'qty' => 40, 'harga_satuan' => 200000, 'subtotal' => 8000000],
                ],
            ],
            [
                'no_invoice' => 'INV-003-2025',
                'purchase_order_id' => null,
                'tipe' => 'NON_PO',
                'tanggal_invoice' => now()->subDays(12),
                'items' => [
                    ['deskripsi' => 'Consulting', 'qty' => 10, 'harga_satuan' => 500000, 'subtotal' => 5000000],
                ],
            ],
            [
                'no_invoice' => 'INV-004-2025',
                'purchase_order_id' => $createdPos[2]->id,
                'tipe' => 'PO',
                'tanggal_invoice' => now()->subDays(8),
                'items' => [
                    ['deskripsi' => 'Material C', 'qty' => 80, 'harga_satuan' => 75000, 'subtotal' => 6000000],
                    ['deskripsi' => 'Material D', 'qty' => 70, 'harga_satuan' => 100000, 'subtotal' => 7000000],
                ],
            ],
            [
                'no_invoice' => 'INV-005-2025',
                'purchase_order_id' => null,
                'tipe' => 'NON_PO',
                'tanggal_invoice' => now()->subDays(3),
                'items' => [
                    ['deskripsi' => 'Equipment', 'qty' => 5, 'harga_satuan' => 1000000, 'subtotal' => 5000000],
                ],
            ],
        ];

        foreach ($invoices as $invoiceData) {
            $items = $invoiceData['items'];
            unset($invoiceData['items']);

            $invoice = Invoice::create($invoiceData);

            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    ...$item,
                ]);
            }
        }
    }
}
