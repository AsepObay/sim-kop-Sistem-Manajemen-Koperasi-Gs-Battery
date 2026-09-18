<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanNonPOController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $supplier = $request->input('supplier');

        $invoices = \App\Models\Invoice::query()
            ->where('tipe', 'NON_PO')
            ->when($from, function ($q) use ($from) {
                $q->whereDate('tanggal_invoice', '>=', $from);
            })
            ->when($to, function ($q) use ($to) {
                $q->whereDate('tanggal_invoice', '<=', $to);
            })
            ->when($supplier, function ($q) use ($supplier) {
                $q->where('no_so', 'like', '%' . $supplier . '%');
            })
            ->orderBy('tanggal_invoice', 'desc')
            ->get();

        $invoicePivots = $invoices->map(function ($invoice) {
            $rows = InvoiceItem::query()
                ->select(
                    'invoice_items.nama_item',
                    DB::raw('SUM(invoice_items.qty) as jumlah_item'),
                    DB::raw('SUM(invoice_items.subtotal) as total_nilai'),
                    DB::raw('ROUND(SUM(invoice_items.subtotal) * 11 / 12) as dpp')
                )
                ->where('invoice_items.invoice_id', $invoice->id)
                ->groupBy('invoice_items.nama_item')
                ->orderByDesc('total_nilai')
                ->get();

            $totalQty = $rows->sum('jumlah_item');
            $totalNilai = $rows->sum('total_nilai');
            $totalDpp = round($totalNilai * 11 / 12);

            return [
                'invoice' => $invoice,
                'rows' => $rows,
                'totalQty' => $totalQty,
                'totalNilai' => $totalNilai,
                'totalDpp' => $totalDpp,
            ];
        });

        return view('admin.laporan.non_po', [
            'invoicePivots' => $invoicePivots,
            'from' => $from,
            'to' => $to,
            'supplier' => $supplier,
        ]);
    }
}
