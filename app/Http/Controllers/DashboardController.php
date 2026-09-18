<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics and data
     */
    public function index(Request $request): View
    {
        // Total PO
        $totalPO = PurchaseOrder::count();

        // Total PO dengan status open
        $activePO = PurchaseOrder::where('status', 'open')->count();

        // Total Invoice
        $totalInvoice = Invoice::count();

        // Total nilai invoice (sum dari subtotal invoice_items)
        $totalNilaiInvoice = InvoiceItem::sum('subtotal');

        // Calculate total PPN from all invoices
        // PPN 11% for PO and NON_PO, 0% for PASCABAYAR, PULSA_MODEM, VOUCHER, MESIN_VENDING
        $totalPPN = 0;
        $invoices = Invoice::with('items')->get();
        foreach ($invoices as $invoice) {
            $invoiceTotal = $invoice->items->sum('subtotal');
            if (in_array($invoice->tipe, ['PO', 'NON_PO'])) {
                $totalPPN += $invoiceTotal * 0.11;
            }
            // PASCABAYAR dan tipe lain tidak ada PPN
        }

        // Monthly breakdown for last 12 months - using tanggal_invoice as reference
        $monthOptions = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $month = $monthDate->format('n');
            $year = $monthDate->format('Y');
            $monthName = $monthDate->isoFormat('MMMM Y');

            // Get invoices for this month BASED ON tanggal_invoice, not created_at
            $monthlyInvoices = Invoice::with('items')
                ->whereYear('tanggal_invoice', $year)
                ->whereMonth('tanggal_invoice', $month)
                ->get();

            $monthlyValue = 0;
            $monthlyPPN = 0;

            foreach ($monthlyInvoices as $invoice) {
                $invoiceTotal = $invoice->items->sum('subtotal');
                $monthlyValue += $invoiceTotal;
                
                if (in_array($invoice->tipe, ['PO', 'NON_PO'])) {
                    $monthlyPPN += $invoiceTotal * 0.11;
                }
            }

            $monthOptions[] = [
                'month' => $monthName,
                'month_num' => (int) $month,
                'year' => (int) $year,
                'value' => $monthlyValue,
                'ppn' => $monthlyPPN,
                'total' => $monthlyValue + $monthlyPPN,
            ];
        }

        $selectedMonth = (int) now()->format('n');
        $selectedYear = (int) now()->format('Y');

        if ($monthYear = $request->query('month_year')) {
            [$year, $month] = explode('-', $monthYear) + [null, null];
            $selectedMonth = $month ? (int) $month : $selectedMonth;
            $selectedYear = $year ? (int) $year : $selectedYear;
        } elseif ($request->query('month') && $request->query('year')) {
            $selectedMonth = (int) $request->query('month');
            $selectedYear = (int) $request->query('year');
        }

        $monthlyData = collect($monthOptions)
            ->filter(fn ($data) => $data['month_num'] === $selectedMonth && $data['year'] === $selectedYear)
            ->values()
            ->all();

        if (empty($monthlyData)) {
            $selectedMonth = (int) now()->format('n');
            $selectedYear = (int) now()->format('Y');
            $monthlyData = collect($monthOptions)
                ->filter(fn ($data) => $data['month_num'] === $selectedMonth && $data['year'] === $selectedYear)
                ->values()
                ->all();
        }

        // 5 Invoice terbaru (latest)
        $latestInvoices = Invoice::with('items', 'purchaseOrder')
            ->latest('tanggal_invoice')
            ->limit(5)
            ->get();

        // PO yang hampir habis (sisa qty <= 20% dari total_qty)
        $lowStockPO = PurchaseOrder::where('status', 'open')
            ->get()
            ->filter(function ($po) {
                $sisaQty = $po->total_qty - $po->used_qty;
                $persentaseSisa = ($sisaQty / $po->total_qty) * 100;
                return $persentaseSisa <= 20;
            })
            ->values()
            ->take(10);

        return view('admin.dashboard', [
            'totalPO' => $totalPO,
            'activePO' => $activePO,
            'totalInvoice' => $totalInvoice,
            'totalNilaiInvoice' => $totalNilaiInvoice,
            'totalPPN' => $totalPPN,
            'monthlyData' => $monthlyData,
            'monthOptions' => $monthOptions,
            'chartLabels' => collect($monthOptions)->pluck('month')->all(),
            'chartValues' => collect($monthOptions)->pluck('value')->all(),
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'latestInvoices' => $latestInvoices,
            'lowStockPO' => $lowStockPO,
        ]);
    }

    /**
     * Export monthly report to CSV
     */
    public function exportMonthly(Request $request)
    {
        $requestedMonth = $request->query('month');
        $requestedYear = $request->query('year');

        $monthlyData = [];

        if ($requestedMonth && $requestedYear) {
            $requestedMonth = (int) $requestedMonth;
            $requestedYear = (int) $requestedYear;
            $monthName = Carbon::createFromDate($requestedYear, $requestedMonth, 1)->isoFormat('MMMM Y');

            $monthlyInvoices = Invoice::with('items')
                ->whereYear('tanggal_invoice', $requestedYear)
                ->whereMonth('tanggal_invoice', $requestedMonth)
                ->get();

            $monthlyValue = 0;
            $monthlyPPN = 0;

            foreach ($monthlyInvoices as $invoice) {
                $invoiceTotal = $invoice->items->sum('subtotal');
                $monthlyValue += $invoiceTotal;
                
                if (in_array($invoice->tipe, ['PO', 'NON_PO'])) {
                    $monthlyPPN += $invoiceTotal * 0.11;
                }
            }

            $monthlyData[] = [
                'month' => $monthName,
                'value' => $monthlyValue,
                'ppn' => $monthlyPPN,
                'total' => $monthlyValue + $monthlyPPN,
            ];
        } else {
            // Generate monthly data (same logic as index)
            for ($i = 11; $i >= 0; $i--) {
                $monthDate = now()->subMonths($i);
                $month = $monthDate->format('n');
                $year = $monthDate->format('Y');
                $monthName = $monthDate->isoFormat('MMMM Y');

                $monthlyInvoices = Invoice::with('items')
                    ->whereYear('tanggal_invoice', $year)
                    ->whereMonth('tanggal_invoice', $month)
                    ->get();

                $monthlyValue = 0;
                $monthlyPPN = 0;

                foreach ($monthlyInvoices as $invoice) {
                    $invoiceTotal = $invoice->items->sum('subtotal');
                    $monthlyValue += $invoiceTotal;
                    
                    if (in_array($invoice->tipe, ['PO', 'NON_PO'])) {
                        $monthlyPPN += $invoiceTotal * 0.11;
                    }
                }

                $monthlyData[] = [
                    'month' => $monthName,
                    'month_num' => (int) $month,
                    'year' => (int) $year,
                    'value' => $monthlyValue,
                    'ppn' => $monthlyPPN,
                    'total' => $monthlyValue + $monthlyPPN,
                ];
            }
        }

        // Generate CSV content
        $csv = "Bulan,Total Nilai,Total PPN (11%),Total Nilai + PPN\n";
        foreach ($monthlyData as $data) {
            $csv .= "\"{$data['month']}\",{$data['value']},{$data['ppn']},{$data['total']}\n";
        }

        // Return as downloadable file
        return response()->streamDownload(
            function () use ($csv) {
                echo $csv;
            },
            'laporan_bulanan_' . now()->format('Y-m-d_His') . '.csv',
            [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="laporan_bulanan_' . now()->format('Y-m-d_His') . '.csv"',
            ]
        );
    }
}
