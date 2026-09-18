<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoicePORequest;
use App\Http\Requests\StoreInvoiceNonPORequest;
use App\Models\AppSetting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExport;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $businessFilter = $request->get('business_internal');
        $dateFrom = $request->get('tanggal_mulai');
        $dateTo = $request->get('tanggal_selesai');
        $monthFilter = $request->get('bulan');
        $perPage = $request->get('per_page', '10');
        $showAll = $perPage === 'all';

        // Build Bisnis Internal filter options from the explicit form input
        // `tipe_bisnis`. Prefer values provided via the form rather than
        // parsed parts of the invoice number.
        $businessOptions = Invoice::query()
            ->whereNotNull('tipe_bisnis')
            ->pluck('tipe_bisnis')
            ->map(fn($v) => trim($v))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $invoices = Invoice::with(['purchaseOrder', 'items'])
            ->when($search, function ($query) use ($search) {
                $query->where('no_invoice', 'like', "%$search%")
                    ->orWhere('no_po_manual', 'like', "%$search%")
                    ->orWhere('no_so', 'like', "%$search%")
                    ->orWhereHas('purchaseOrder', function ($q) use ($search) {
                        $q->where('no_po', 'like', "%$search%");
                    });
            })
            ->when($businessFilter, function ($query, $businessFilter) {
                $query->where(function ($q) use ($businessFilter) {
                    $q->where('tipe_bisnis', $businessFilter)
                        ->orWhere('no_po_manual', $businessFilter)
                        ->orWhere('no_invoice', 'like', "%/{$businessFilter}/%");
                });
            })
            ->when($dateFrom, function ($query, $dateFrom) {
                $query->whereDate('tanggal_invoice', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                $query->whereDate('tanggal_invoice', '<=', $dateTo);
            })
            ->when($monthFilter, function ($query, $monthFilter) {
                [$year, $month] = explode('-', $monthFilter);
                $query->whereYear('tanggal_invoice', $year)
                    ->whereMonth('tanggal_invoice', $month);
            })
            ->orderBy('created_at', 'desc');

        $allowedPerPage = ['10', '25', '50', '100', '200', '500', '1000'];
        $perPageValue = $showAll ? max($invoices->count(), 1) : (in_array($perPage, $allowedPerPage, true) ? (int) $perPage : 10);
        $invoices = $invoices->paginate($perPageValue)->withQueryString();
        
        return view('admin.invoices.index', compact('invoices', 'search', 'businessOptions', 'businessFilter', 'dateFrom', 'dateTo', 'monthFilter', 'perPage', 'showAll'));
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'selected_ids' => ['nullable', 'array'],
            'selected_ids.*' => ['integer', 'exists:invoices,id'],
        ]);

        $selectedIds = $validated['selected_ids'] ?? [];

        if (empty($selectedIds)) {
            return redirect()->route('invoices.index')
                ->with('error', 'Pilih minimal satu invoice untuk diunduh.');
        }

        $invoices = Invoice::with(['purchaseOrder', 'items'])
            ->whereIn('id', $selectedIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'invoices-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new InvoiceExport($invoices), $fileName);
    }

    public function createPO()
    {
        $purchaseOrders = PurchaseOrder::where('status', 'open')
            ->orderBy('no_po')
            ->get();
        
        return view('admin.invoices.create-po', compact('purchaseOrders'));
    }

    public function createBisnisInternal()
    {
        $invoices = Invoice::where('tipe', 'PO')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.invoices.create-bisnis-internal', compact('invoices'));
    }

    public function storeBisnisInternal(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'manual_invoice_part' => 'required|string|max:100',
        ], [
            'invoice_id.required' => 'Invoice wajib dipilih.',
            'invoice_id.exists' => 'Invoice tidak ditemukan.',
            'manual_invoice_part.required' => 'Bisnis Internal wajib diisi.',
            'manual_invoice_part.max' => 'Bisnis Internal maksimal 100 karakter.',
        ]);

        try {
            $invoice = Invoice::findOrFail($validated['invoice_id']);

            $invoice->update([
                'no_po_manual' => $validated['manual_invoice_part'],
            ]);

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Bisnis Internal berhasil ditambahkan ke invoice.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan Bisnis Internal: ' . $e->getMessage());
        }
    }

    public function storePO(StoreInvoicePORequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Generate invoice number
            $customPart = $request->input('manual_invoice_part', '');
            $no_invoice = generateInvoiceNumber('PO', $customPart);
            
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => $customPart ?: null,
                'no_so' => $request->no_so,
                'tipe_bisnis' => $request->tipe_bisnis,
                'purchase_order_id' => $request->purchase_order_id,
                'tipe' => 'PO',
                'tanggal_invoice' => $request->tanggal_invoice,
            ]);
            $totalQty = 0;
            
            foreach ($request->items as $itemData) {
                $harga = floatval($itemData['harga']);
                $qty = intval($itemData['qty']);
                $subtotal = $harga * $qty;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);
                
                $totalQty += $qty;
            }

            $po = PurchaseOrder::find($request->purchase_order_id);
            $po->used_qty += $totalQty;
            $po->save();
            $po->refreshStatus();
            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice berhasil dibuat dan PO telah diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['purchaseOrder', 'items']);

        if ($invoice->tipe === 'MESIN_VENDING') {
            return view('admin.invoices.show-vending', compact('invoice'));
        }

        if ($invoice->tipe === 'PULSA_MODEM') {
            return view('admin.invoices.show-pulsa-modem', compact('invoice'));
        }

        if ($invoice->tipe === 'VOUCHER') {
            return view('admin.invoices.show-voucher', compact('invoice'));
        }
        
        return view('admin.invoices.show', compact('invoice'));
    }
    public function showNonPO(Invoice $invoice)
    {
        if ($invoice->tipe !== 'NON_PO') {
            abort(404);
        }

        $invoice->load(['items']);

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

        return view('admin.invoices.show-non-po', [
            'invoice' => $invoice,
            'rows' => $rows,
            'totalQty' => $totalQty,
            'totalNilai' => $totalNilai,
            'totalDpp' => $totalDpp,
        ]);
    }

    /**
     * Show detail invoice Pascabayar (tanpa PPN)
     */
    public function showPascabayar(Invoice $invoice)
    {
        if ($invoice->tipe !== 'PASCABAYAR') {
            abort(404);
        }

        $invoice->load(['items']);

        $rows = InvoiceItem::query()
            ->select(
                'invoice_items.nama_item',
                DB::raw('SUM(invoice_items.qty) as jumlah_item'),
                DB::raw('SUM(invoice_items.subtotal) as total_nilai')
            )
            ->where('invoice_items.invoice_id', $invoice->id)
            ->groupBy('invoice_items.nama_item')
            ->orderByDesc('total_nilai')
            ->get();

        $totalQty = $rows->sum('jumlah_item');
        $totalNilai = $rows->sum('total_nilai');

        return view('admin.invoices.show-pascabayar', [
            'invoice' => $invoice,
            'rows' => $rows,
            'totalQty' => $totalQty,
            'totalNilai' => $totalNilai,
        ]);
    }

    /**
     * Show detail PO invoice with pivot per invoice
     */
    public function showPO(Invoice $invoice)
    {
        if ($invoice->tipe !== 'PO') {
            abort(404);
        }

        $invoice->load(['items', 'purchaseOrder']);

        $rows = InvoiceItem::query()
            ->select(
                'invoice_items.nama_item as nama_barang',
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

        return view('admin.invoices.show-po', [
            'invoice' => $invoice,
            'rows' => $rows,
            'totalQty' => $totalQty,
            'totalNilai' => $totalNilai,
            'totalDpp' => $totalDpp,
        ]);
    }

    // return view('admin.invoices.show-po')


    public function edit(Invoice $invoice)
    {
        $invoice->load(['items', 'purchaseOrder']);

        if ($invoice->tipe === 'PO') {
            $purchaseOrders = PurchaseOrder::query()
                ->where(function ($query) use ($invoice) {
                    $query->where('status', 'open')
                        ->orWhere('id', $invoice->purchase_order_id);
                })
                ->orderBy('no_po')
                ->get();

            return view('admin.invoices.edit-po', compact('invoice', 'purchaseOrders'));
        }

        if ($invoice->tipe === 'PASCABAYAR') {
            $pascabayarItemOptions = $this->getPascabayarItemOptions();
            $pascabayarItemRows = $this->getPascabayarItemRows($pascabayarItemOptions);

            return view('admin.invoices.edit-pascabayar', compact('invoice', 'pascabayarItemOptions', 'pascabayarItemRows'));
        }

        if ($invoice->tipe === 'MESIN_VENDING') {
            return view('admin.invoices.edit-vending', compact('invoice'));
        }

        if ($invoice->tipe === 'PULSA_MODEM') {
            return view('admin.invoices.edit-pulsa-modem', compact('invoice'));
        }

        if ($invoice->tipe === 'VOUCHER') {
            return view('admin.invoices.edit-voucher', compact('invoice'));
        }

        return view('admin.invoices.edit-non-po', compact('invoice'));
    }

    /**
     * Update invoice (PO / NON-PO)
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->normalizeSharedItemsPayload($request);

        if ($invoice->tipe === 'PO') {
            return $this->updatePOInvoice($request, $invoice);
        }

        if ($invoice->tipe === 'PASCABAYAR') {
            return $this->updatePascabayarInvoice($request, $invoice);
        }

        if ($invoice->tipe === 'MESIN_VENDING') {
            return $this->updateVendingInvoice($request, $invoice);
        }

        if ($invoice->tipe === 'PULSA_MODEM') {
            return $this->updatePulsaModemInvoice($request, $invoice);
        }

        if ($invoice->tipe === 'VOUCHER') {
            return $this->updateVoucherInvoice($request, $invoice);
        }

        return $this->updateNonPOInvoice($request, $invoice);
    }

    /**
     * Download invoice as PDF
     */
    public function download(Invoice $invoice)
    {
        // Load relations
        $invoice->load(['purchaseOrder', 'items']);
        
        // Calculate totals
        $subtotalQty = (int) $invoice->items->sum('qty');
        $subtotal = $invoice->items->sum('subtotal');
        $pph = 0;

        if ($invoice->tipe === 'MESIN_VENDING') {
            $ppn = $subtotal * 0.11;
            $pph = $subtotal * 0.10;
            $grandTotal = $subtotal + $ppn - $pph;
        } elseif ($invoice->tipe === 'PULSA_MODEM' || $invoice->tipe === 'VOUCHER') {
            $ppn = 0;
            $pph = 0;
            $grandTotal = $subtotal;
        } elseif ($invoice->tipe === 'PASCABAYAR') {
            $ppn = 0;
            $grandTotal = $subtotal;
        } else {
            $ppn = $subtotal * 0.11;
            $grandTotal = $subtotal + $ppn;
        }
        
        // Generate PDF
        $pdf = Pdf::loadView('admin.invoices.pdf', [
            'invoice' => $invoice,
            'subtotalQty' => $subtotalQty,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'pph' => $pph,
            'grandTotal' => $grandTotal,
            'signedBy' => auth()->user(),
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        
        // Download with filename
        $filename = 'Invoice-' . str_replace('/', '-', $invoice->no_invoice) . '.pdf';
        
        return $pdf->download($filename);
    }
    public function createNonPO()
    {
        return view('admin.invoices.create-non-po');
    }
    public function createSementara()
    {
        return view('admin.invoices.create-sementara');
    }
    public function createVending()
    {
        return view('admin.invoices.create-vending');
    }

    public function createPulsaModem()
    {
        return view('admin.invoices.create-pulsa-modem');
    }

    public function createVoucher()
    {
        return view('admin.invoices.create-voucher');
    }
    public function storeSementara(Request $request)
    {
        $validated = $request->validate([
            'no_so' => ['nullable', 'string', 'max:100'],
            'manual_invoice_part' => ['nullable', 'string', 'max:100'],
            'tipe_bisnis' => ['nullable', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tanggal_item' => ['required', 'date'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ], [
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
        ]);

        DB::beginTransaction();

        try {
            $customPart = $validated['manual_invoice_part'] ?? null;
            $no_invoice = generateInvoiceNumber('PO', $customPart);

            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => null,
                'no_so' => $validated['no_so'] ?? null,
                'tipe_bisnis' => $validated['tipe_bisnis'] ?? null,
                'purchase_order_id' => null,
                'tipe' => 'PO',
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $harga = floatval($itemData['harga']);
                $qty = intval($itemData['qty']);
                $subtotal = $harga * $qty;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice Sementara berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }
    public function createPascabayar()
    {
        $pascabayarItemOptions = $this->getPascabayarItemOptions();
        $pascabayarItemRows = $this->getPascabayarItemRows($pascabayarItemOptions);

        return view('admin.invoices.create-pascabayar', compact('pascabayarItemOptions', 'pascabayarItemRows'));
    }

    public function storeNonPO(StoreInvoiceNonPORequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Generate invoice number for NON_PO with KRT as custom part
            $no_invoice = generateInvoiceNumber('NON_PO', 'KRT');
            
            // Create invoice
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => null,
                'no_so' => $request->no_so,
                'tipe_bisnis' => $request->tipe_bisnis,
                'purchase_order_id' => null,
                'tipe' => 'NON_PO',
                'tanggal_invoice' => $request->tanggal_invoice,
            ]);

            // Create invoice items
            foreach ($request->items as $itemData) {
                $harga = floatval($itemData['harga']);
                $qty = intval($itemData['qty']);
                $subtotal = $harga * $qty;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice NON-PO berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function storeVending(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal_invoice' => 'required|date',
                'tipe_bisnis' => 'nullable|string|max:100',
                'items' => 'required|array|min:1',
                'items.*.tanggal_item' => 'required|date',
                'items.*.no_faktur' => 'required|string|max:255',
                'items.*.harga' => 'required|numeric|min:0',
                'items.*.revenue_sharing' => 'nullable|numeric|min:0',
            ], [
                'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
                'items.required' => 'Minimal harus ada 1 item.',
                'items.min' => 'Minimal harus ada 1 item.',
                'tipe_bisnis.max' => 'Bisnis Internal maksimal 100 karakter.',
            ]);

            $validated = $validator->validate();
        } catch (ValidationException $e) {
            Log::error('Validasi storeVending gagal', [
                'request' => $request->all(),
                'errors' => $e->errors(),
            ]);

            throw $e;
        }

        DB::beginTransaction();

        try {
            // Generate invoice number for MESIN_VENDING
            $no_invoice = generateInvoiceNumber('MESIN_VENDING');
            
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => null,
                'no_so' => null,
                'tipe_bisnis' => $validated['tipe_bisnis'] ?? null,
                'purchase_order_id' => null,
                'tipe' => 'MESIN_VENDING',
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $total = (float) $itemData['harga'];
                $revenueSharing = isset($itemData['revenue_sharing']) && $itemData['revenue_sharing'] !== ''
                    ? (float) $itemData['revenue_sharing']
                    : round($total * 0.05, 2);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['no_faktur'],
                    'qty' => 1,
                    'unit' => 'FAKTUR',
                    'harga' => $total,
                    'subtotal' => $revenueSharing,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice Mesin Vending berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function storePulsaModem(Request $request)
    {
        $validated = $request->validate([
            'no_po_manual' => 'required|string|max:100',
            'no_so' => 'required|string|max:100',
            'tanggal_invoice' => 'required|date',
            'tipe_bisnis' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.harga' => 'required|numeric|min:0',
        ], [
            'no_po_manual.required' => 'Nomor PO wajib diisi.',
            'no_so.required' => 'Nomor SO wajib diisi.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'tipe_bisnis.max' => 'Bisnis Internal maksimal 100 karakter.',
        ]);

        DB::beginTransaction();

        try {
            // Generate invoice number for PULSA_MODEM
            $no_invoice = generateInvoiceNumber('PULSA_MODEM');
            
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => $validated['no_po_manual'],
                'no_so' => $validated['no_so'],
                'tipe_bisnis' => $validated['tipe_bisnis'] ?? null,
                'purchase_order_id' => null,
                'tipe' => 'PULSA_MODEM',
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $validated['tanggal_invoice'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice Pulsa Modem berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function storeVoucher(Request $request)
    {
        $validated = $request->validate([
            'no_so' => 'required|string|max:100',
            'tanggal_invoice' => 'required|date',
            'tipe_bisnis' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ], [
            'no_so.required' => 'Nomor SO wajib diisi.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'tipe_bisnis.max' => 'Bisnis Internal maksimal 100 karakter.',
        ]);

        DB::beginTransaction();

        try {
            // Generate invoice number for VOUCHER
            $no_invoice = generateInvoiceNumber('VOUCHER');
            
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => null,
                'no_so' => $validated['no_so'],
                'tipe_bisnis' => $validated['tipe_bisnis'] ?? null,
                'purchase_order_id' => null,
                'tipe' => 'VOUCHER',
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $validated['tanggal_invoice'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => 'PCS',
                    'harga' => $harga,
                    'is_ppn' => false,
                    'ppn_value' => 0,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice Voucher berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function storePascabayar(Request $request)
    {
        $validated = $request->validate([
            'no_po_manual' => 'required|string|max:100',
            'no_so' => 'required|string|max:100',
            'tanggal_invoice' => 'required|date',
            'tipe_bisnis' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.tanggal_item' => 'required|date',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.harga' => 'required|numeric|min:0',
        ], [
            'no_po_manual.required' => 'Nomor PO wajib diisi.',
            'no_so.required' => 'Nomor SO wajib diisi.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'tipe_bisnis.max' => 'Bisnis Internal maksimal 100 karakter.',
        ]);

        DB::beginTransaction();

        try {
            // Generate invoice number for PASCABAYAR
            $no_invoice = generateInvoiceNumber('PASCABAYAR');
            
            $invoice = Invoice::create([
                'no_invoice' => $no_invoice,
                'no_po_manual' => $validated['no_po_manual'],
                'no_so' => $validated['no_so'],
                'tipe_bisnis' => $validated['tipe_bisnis'] ?? null,
                'purchase_order_id' => null,
                'tipe' => 'PASCABAYAR',
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            foreach ($validated['items'] as $itemData) {
                $harga = floatval($itemData['harga']);
                $qty = intval($itemData['qty']);
                $subtotal = $harga * $qty;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'is_ppn' => false,
                    'ppn_value' => 0,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice Tagihan Pascabayar berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function updatePascabayarItemOptions(Request $request)
    {
        $validated = $request->validate([
            'item_options' => ['required', 'array', 'min:1'],
            'item_options.*.phone' => ['required', 'string', 'max:30'],
            'item_options.*.name' => ['required', 'string', 'max:150'],
        ], [
            'item_options.required' => 'Daftar nomor wajib diisi.',
            'item_options.min' => 'Minimal 1 nomor harus tersedia.',
            'item_options.*.phone.required' => 'Nomor HP wajib diisi.',
            'item_options.*.name.required' => 'Nama wajib diisi.',
        ]);

        $normalized = [];

        foreach ($validated['item_options'] as $row) {
            $phone = trim((string) $row['phone']);
            $name = strtoupper(trim((string) $row['name']));

            if ($phone === '' || $name === '') {
                continue;
            }

            $normalized[] = $phone . ' (' . $name . ')';
        }

        $normalized = array_values(array_unique($normalized));

        if (empty($normalized)) {
            return redirect()->back()->withErrors([
                'item_options' => 'Daftar nomor tidak boleh kosong.',
            ]);
        }

        AppSetting::updateOrCreate(
            ['key' => 'pascabayar_item_options'],
            ['value' => json_encode($normalized)]
        );

        return redirect()->back()->with('success', 'Daftar no pascabayar berhasil di update');
    }

    /**
     * Delete invoice and rollback PO used_qty if applicable
     */
    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();
        
        try {
            // If invoice is PO type, rollback used_qty on PO
            if ($invoice->tipe === 'PO' && $invoice->purchase_order_id) {
                $totalQty = $invoice->items->sum('qty');
                $po = PurchaseOrder::find($invoice->purchase_order_id);
                
                if ($po) {
                    $po->used_qty = max(0, $po->used_qty - $totalQty);
                    $po->save();
                    $this->syncPoStatus($po);
                }
            }

            // Delete invoice items first
            $invoice->items()->delete();
            
            // Delete invoice
            $invoice->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Invoice berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus invoice: ' . $e->getMessage());
        }
    }

    private function normalizeSharedItemsPayload(Request $request): void
    {
        $items = $request->input('items');
        if (is_array($items) && count($items) > 0) {
            return;
        }

        $jsonItems = $request->input('items_json');
        if (is_string($jsonItems) && trim($jsonItems) !== '') {
            $decoded = json_decode($jsonItems, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $request->merge(['items' => $decoded]);
                return;
            }
        }

        $reconstructed = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^items\[(\d+)\]\[(.+)\]$/', $key, $matches)) {
                $rowIndex = (int) $matches[1];
                $fieldName = $matches[2];

                if (!isset($reconstructed[$rowIndex])) {
                    $reconstructed[$rowIndex] = [];
                }

                $reconstructed[$rowIndex][$fieldName] = $value;
            }
        }

        if (!empty($reconstructed)) {
            $request->merge(['items' => array_values($reconstructed)]);
        }
    }

    private function normalizeItemsPayload(Request $request): array
    {
        $this->normalizeSharedItemsPayload($request);

        $items = $request->input('items');
        return is_array($items) ? $items : [];
    }

    private function updatePOInvoice(Request $request, Invoice $invoice)
    {
        $items = $this->normalizeItemsPayload($request);

        if (empty($items)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['items' => 'Minimal harus ada 1 item.']);
        }

        $validated = $request->validate([
            'no_invoice' => ['required', 'string', 'max:100', Rule::unique('invoices', 'no_invoice')->ignore($invoice->id)],
            'manual_invoice_part' => ['nullable', 'string', 'max:100'],
            'no_so' => ['nullable', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'purchase_order_id' => ['required', 'exists:purchase_orders,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tanggal_item' => ['required', 'date'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ], [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'purchase_order_id.required' => 'Purchase Order wajib dipilih.',
            'purchase_order_id.exists' => 'Purchase Order tidak ditemukan.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'items.*.tanggal_item.required' => 'Tanggal item wajib diisi.',
            'items.*.nama_item.required' => 'Nama item wajib diisi.',
            'items.*.qty.required' => 'Qty item wajib diisi.',
            'items.*.qty.min' => 'Qty item minimal 1.',
            'items.*.unit.required' => 'Unit item wajib diisi.',
            'items.*.harga.required' => 'Harga item wajib diisi.',
            'items.*.harga.min' => 'Harga item tidak boleh negatif.',
        ]);

        DB::beginTransaction();

        try {
            $oldPo = $invoice->purchase_order_id ? PurchaseOrder::find($invoice->purchase_order_id) : null;
            $newPo = PurchaseOrder::findOrFail($validated['purchase_order_id']);

            if ($newPo->status === 'closed' && $newPo->id !== $invoice->purchase_order_id) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['purchase_order_id' => 'PO sudah ditutup, tidak bisa digunakan.']);
            }

            $oldTotalQty = (int) $invoice->items()->sum('qty');
            $newTotalQty = (int) collect($validated['items'])->sum(fn ($item) => (int) $item['qty']);
            $samePo = $oldPo && $oldPo->id === $newPo->id;

            $availableQty = $newPo->remainingQty();
            if ($samePo) {
                $availableQty += $oldTotalQty;
            }

            // Jika user hanya mengubah nama item pada PO yang sama, total qty tidak berubah.
            // Pada kondisi ini, tidak perlu menilai ulang kuantitas PO atau mengubah used_qty.
            if (!$samePo || $newTotalQty !== $oldTotalQty) {
                if ($newTotalQty > $availableQty) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['items' => "Total qty invoice ($newTotalQty) melebihi sisa qty PO ($availableQty)."]);
                }
            }

            if ($oldPo && $oldPo->id !== $newPo->id) {
                $oldPo->used_qty = max(0, $oldPo->used_qty - $oldTotalQty);
                $oldPo->save();
                $this->syncPoStatus($oldPo);
            }

            $invoice->update([
                'no_invoice' => $validated['no_invoice'],
                'no_po_manual' => $validated['manual_invoice_part'] ?? null,
                'no_so' => $validated['no_so'] ?? null,
                'purchase_order_id' => $newPo->id,
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $qty * $harga,
                ]);
            }

            if ($samePo) {
                // Jika PO tidak berubah dan qty tetap sama, jangan mengubah used_qty.
                // Ini penting saat user hanya mengedit nama item.
                if ($newTotalQty !== $oldTotalQty) {
                    $newPo->refresh();
                    $newPo->used_qty = max(0, $newPo->used_qty - $oldTotalQty) + $newTotalQty;
                    $newPo->save();
                    $this->syncPoStatus($newPo);
                }
            } else {
                $newPo->refresh();
                $newPo->used_qty += $newTotalQty;
                $newPo->save();
                $this->syncPoStatus($newPo);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice PO berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function updateNonPOInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'no_invoice' => ['required', 'string', 'max:100', Rule::unique('invoices', 'no_invoice')->ignore($invoice->id)],
            'no_so' => ['nullable', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tanggal_item' => ['required', 'date'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ], [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'items.*.tanggal_item.required' => 'Tanggal item wajib diisi.',
            'items.*.nama_item.required' => 'Nama item wajib diisi.',
            'items.*.qty.required' => 'Qty item wajib diisi.',
            'items.*.qty.min' => 'Qty item minimal 1.',
            'items.*.unit.required' => 'Unit item wajib diisi.',
            'items.*.harga.required' => 'Harga item wajib diisi.',
            'items.*.harga.min' => 'Harga item tidak boleh negatif.',
        ]);

        DB::beginTransaction();

        try {
            $invoice->update([
                'no_invoice' => $validated['no_invoice'],
                'no_po_manual' => null,
                'no_so' => $validated['no_so'] ?? null,
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice NON-PO berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function updatePascabayarInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'no_invoice' => ['required', 'string', 'max:100', Rule::unique('invoices', 'no_invoice')->ignore($invoice->id)],
            'no_po_manual' => ['required', 'string', 'max:100'],
            'no_so' => ['required', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tanggal_item' => ['required', 'date'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            $invoice->update([
                'no_invoice' => $validated['no_invoice'],
                'no_po_manual' => $validated['no_po_manual'],
                'no_so' => $validated['no_so'],
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'is_ppn' => false,
                    'ppn_value' => 0,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice Tagihan Pascabayar berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function updateVendingInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tanggal_item' => ['required', 'date'],
            'items.*.no_faktur' => ['required', 'string', 'max:255'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
            'items.*.revenue_sharing' => ['nullable', 'numeric', 'min:0'],
        ], [
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
        ]);

        DB::beginTransaction();

        try {
            $invoice->update([
                'no_po_manual' => null,
                'no_so' => null,
                'purchase_order_id' => null,
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $total = (float) $itemData['harga'];
                $revenueSharing = isset($itemData['revenue_sharing']) && $itemData['revenue_sharing'] !== ''
                    ? (float) $itemData['revenue_sharing']
                    : round($total * 0.05, 2);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $itemData['tanggal_item'],
                    'nama_item' => $itemData['no_faktur'],
                    'qty' => 1,
                    'unit' => 'FAKTUR',
                    'harga' => $total,
                    'subtotal' => $revenueSharing,
                ]);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice Mesin Vending berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function updatePulsaModemInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'no_invoice' => ['required', 'string', 'max:100', Rule::unique('invoices', 'no_invoice')->ignore($invoice->id)],
            'no_po_manual' => ['required', 'string', 'max:100'],
            'no_so' => ['required', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ], [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'no_po_manual.required' => 'Nomor PO wajib diisi.',
            'no_so.required' => 'Nomor SO wajib diisi.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
        ]);

        DB::beginTransaction();

        try {
            $invoice->update([
                'no_invoice' => $validated['no_invoice'],
                'no_po_manual' => $validated['no_po_manual'],
                'no_so' => $validated['no_so'],
                'purchase_order_id' => null,
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $validated['tanggal_invoice'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => $itemData['unit'],
                    'harga' => $harga,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice Pulsa Modem berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function updateVoucherInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'no_invoice' => ['required', 'string', 'max:100', Rule::unique('invoices', 'no_invoice')->ignore($invoice->id)],
            'no_so' => ['required', 'string', 'max:100'],
            'tanggal_invoice' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama_item' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
        ], [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'no_so.required' => 'Nomor SO wajib diisi.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
        ]);

        DB::beginTransaction();

        try {
            $invoice->update([
                'no_invoice' => $validated['no_invoice'],
                'no_po_manual' => null,
                'no_so' => $validated['no_so'],
                'purchase_order_id' => null,
                'tanggal_invoice' => $validated['tanggal_invoice'],
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['qty'];
                $harga = (float) $itemData['harga'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'tanggal_item' => $validated['tanggal_invoice'],
                    'nama_item' => $itemData['nama_item'],
                    'qty' => $qty,
                    'unit' => 'PCS',
                    'harga' => $harga,
                    'is_ppn' => false,
                    'ppn_value' => 0,
                    'subtotal' => $qty * $harga,
                ]);
            }

            DB::commit();

            return redirect()
                ->to($request->query('return', route('invoices.index')))
                ->with('success', 'Invoice Voucher berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    private function syncPoStatus(PurchaseOrder $po): void
    {
        if ($po->used_qty >= $po->total_qty) {
            $po->status = 'closed';
            $po->closed_at = $po->closed_at ?? now();
        } else {
            $po->status = 'open';
            $po->closed_at = null;
        }

        $po->save();
    }

    private function getPascabayarItemOptions(): array
    {
        $defaults = [
            '08164833821 (MICHAEL LOANDOUW)',
            '08151923504 (CATUR)',
            '081585338594 (FURQON)',
            '081519999714 (WRDIONO)',
            '081519999715 (FERRY)',
            '081511393425 (M. NURZAIN)',
            '081511395775 (WINARNO)',
            '081511395756 (WAHYU ADHIE S)',
            '081585267019 (NUUBERTUS)',
            '081585267105 (TS 02)',
            '081585267103 (TS 01)',
            '08118443200 (RIKU IMAI)',
            '0811161086 (MR. SATO KATSUYUKI)',
            '081292038071 (MR HASIMOTO)',
            '0811825417 (MR HIROFUMI UMETANI)',
        ];

        try {
            if (Schema::hasTable('app_settings')) {
                $stored = AppSetting::query()
                    ->where('key', 'pascabayar_item_options')
                    ->value('value');

                if ($stored) {
                    $decoded = json_decode($stored, true);

                    if (is_array($decoded) && !empty($decoded)) {
                        return array_values(array_filter(array_map(function ($item) {
                            return is_string($item) ? trim($item) : null;
                        }, $decoded)));
                    }
                }
            }
        } catch (\Throwable $e) {
            // fallback to config
        }

        return config('pascabayar.item_options', $defaults);
    }

    private function getPascabayarItemRows(array $options): array
    {
        $rows = [];

        foreach ($options as $option) {
            $phone = trim((string) $option);
            $name = '';

            if (preg_match('/^\s*([^\(]+)\s*\((.+)\)\s*$/', $option, $matches)) {
                $phone = trim($matches[1]);
                $name = trim($matches[2]);
            }

            $rows[] = [
                'phone' => $phone,
                'name' => $name,
            ];
        }

        return $rows;
    }
}

