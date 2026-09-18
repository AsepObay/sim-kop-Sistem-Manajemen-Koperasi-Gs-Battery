<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ChecksheetMaster;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Models\VendorOpenTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeaderSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q'));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $like = '%' . $query . '%';
        $results = collect();

        $features = [
            ['label' => 'Dashboard', 'detail' => 'Halaman utama', 'url' => route('dashboard')],
            ['label' => 'Kelola PO', 'detail' => 'Daftar Purchase Order', 'url' => route('purchase-orders.index')],
            ['label' => 'Tambah PO', 'detail' => 'Kelola PO', 'url' => route('purchase-orders.create')],
            ['label' => 'Daftar PO', 'detail' => 'Kelola PO', 'url' => route('purchase-orders.index')],
            ['label' => 'Kelola Tagihan', 'detail' => 'Daftar Invoice', 'url' => route('invoices.index')],
            ['label' => 'Tagihan PO', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-po')],
            ['label' => 'Tagihan Non PO', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-non-po')],
            ['label' => 'Tagihan Sementara', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-sementara')],
            ['label' => 'Tagihan Pascabayar', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-pascabayar')],
            ['label' => 'Tagihan Vending', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-vending')],
            ['label' => 'Tagihan Pulsa Modem', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-pulsa-modem')],
            ['label' => 'Invoice Voucher', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.create-voucher')],
            ['label' => 'Daftar Invoice', 'detail' => 'Kelola Tagihan', 'url' => route('invoices.index')],
            ['label' => 'Laporan', 'detail' => 'Rekap laporan', 'url' => route('laporan.rekap-po')],
            ['label' => 'Rekap PO', 'detail' => 'Laporan', 'url' => route('laporan.rekap-po')],
            ['label' => 'Rekap Non PO', 'detail' => 'Laporan', 'url' => route('laporan.non-po')],
            ['label' => 'Kelola Vendor', 'detail' => 'Vendor Open Table', 'url' => route('vendors.index')],
            ['label' => 'Reminder Tagihan', 'detail' => 'Kelola Tagihan', 'url' => route('reminders.index')],
        ];

        if (auth()->user()?->role === 'SUPER_ADMIN') {
            $features = array_merge($features, [
                ['label' => 'Setting', 'detail' => 'Pengaturan aplikasi', 'url' => route('settings.index')],
                ['label' => 'Pengaturan Background Login', 'detail' => 'Setting', 'url' => route('settings.login_background.index')],
                ['label' => 'Kelola User', 'detail' => 'Daftar user', 'url' => route('users.index')],
                ['label' => 'Daftar User', 'detail' => 'Kelola User', 'url' => route('users.index')],
                ['label' => 'Tambah User', 'detail' => 'Kelola User', 'url' => route('users.create')],
            ]);
        }

        collect($features)
            ->filter(fn ($feature) => str_contains(mb_strtolower($feature['label'] . ' ' . $feature['detail']), mb_strtolower($query)))
            ->take(10)
            ->each(fn ($feature) => $results->push(array_merge(['type' => 'Fitur'], $feature)));

        Invoice::with('purchaseOrder')
            ->where(function ($builder) use ($like) {
                $builder->where('no_invoice', 'like', $like)
                    ->orWhere('no_po_manual', 'like', $like)
                    ->orWhere('no_so', 'like', $like)
                    ->orWhereHas('purchaseOrder', fn ($po) => $po->where('no_po', 'like', $like));
            })
            ->latest('tanggal_invoice')
            ->limit(5)
            ->get()
            ->each(fn ($invoice) => $results->push([
                'type' => 'Invoice',
                'label' => $invoice->no_invoice,
                'detail' => 'PO: ' . ($invoice->display_po ?: '-') . ' | SO: ' . ($invoice->no_so ?: '-'),
                'url' => route('invoices.show', $invoice),
            ]));

        PurchaseOrder::where(function ($builder) use ($like) {
                $builder->where('no_po', 'like', $like)
                    ->orWhere('jenis_po', 'like', $like)
                    ->orWhere('status', 'like', $like);
            })
            ->latest('tanggal_po')
            ->limit(5)
            ->get()
            ->each(fn ($po) => $results->push([
                'type' => 'Purchase Order',
                'label' => $po->no_po,
                'detail' => ($po->jenis_po ?: '-') . ' | ' . strtoupper((string) $po->status),
                'url' => route('purchase-orders.show', $po),
            ]));

        VendorOpenTable::where('nama_vendor', 'like', $like)
            ->latest()
            ->limit(5)
            ->get()
            ->each(fn ($vendor) => $results->push([
                'type' => 'Vendor',
                'label' => $vendor->nama_vendor,
                'detail' => 'Open table vendor',
                'url' => route('vendors.index'),
            ]));

        if (auth()->user()?->role === 'SUPER_ADMIN') {
            User::where(function ($builder) use ($like) {
                    $builder->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('position', 'like', $like)
                        ->orWhere('department', 'like', $like);
                })
                ->latest()
                ->limit(5)
                ->get()
                ->each(fn ($user) => $results->push([
                    'type' => 'User',
                    'label' => $user->name,
                    'detail' => $user->email,
                    'url' => route('users.edit', $user),
                ]));
        }

        $checksheetParent = function (string $itemName): string {
            foreach (ChecksheetMaster::PRODUCT_ITEM_OPTIONS as $parent => $options) {
                if (in_array($itemName, $options, true)) {
                    return $parent;
                }
            }

            return $itemName;
        };

        ChecksheetMaster::where('name', 'like', $like)
            ->where('is_active', true)
            ->limit(5)
            ->get()
            ->each(function ($item) use ($results, $checksheetParent) {
                $parentItem = $item->category === ChecksheetMaster::CATEGORY_PRODUCT
                    ? $checksheetParent($item->name)
                    : '';

                $results->push([
                    'type' => 'Checksheet',
                    'label' => $item->name,
                    'detail' => $item->category_label,
                    'url' => route('checksheet-masters.index', array_filter([
                        'category' => $item->category,
                        'item' => $parentItem,
                    ])),
                ]);
            });

        return response()->json(['results' => $results->take(20)->values()]);
    }
}
