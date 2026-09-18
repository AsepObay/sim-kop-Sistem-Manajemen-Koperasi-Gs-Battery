<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of purchase orders
     */
    public function index(Request $request): View
    {
        $search = $request->input('q');

        $purchaseOrders = PurchaseOrder::query()
            ->when($search, function ($query, $search) {
                $query->where('no_po', 'like', '%' . $search . '%');
            })
            ->orderBy('tanggal_po', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.purchase-orders.index', compact('purchaseOrders', 'search'));
    }

    /**
     * Show the form for creating a new purchase order
     */
    public function create(): View
    {
        $purchaseOrder = null;
        return view('admin.purchase-orders.form', compact('purchaseOrder'));
    }

    /**
     * Store a newly created purchase order in storage
     */
    public function store(StorePurchaseOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['used_qty'] = 0;
        $validated['status'] = 'open';

        PurchaseOrder::create($validated);

        return redirect()->route('purchase-orders.index')
                       ->with('success', 'Purchase Order berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified purchase order
     */
    public function edit(PurchaseOrder $purchaseOrder): View|RedirectResponse
    {
        // Cegah edit untuk PO dengan status closed
        if ($purchaseOrder->status === 'closed') {
            return redirect()->route('purchase-orders.index')
                           ->with('error', 'PO dengan status closed tidak bisa diedit');
        }

        return view('admin.purchase-orders.form', compact('purchaseOrder'));
    }

    /**
     * Display the specified purchase order
     */
    public function show(PurchaseOrder $purchaseOrder): View
    {
        $purchaseOrder->load('invoices.items');

        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Update the specified purchase order in storage
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        // Cegah update untuk PO dengan status closed
        if ($purchaseOrder->status === 'closed') {
            return redirect()->route('purchase-orders.index')
                           ->with('error', 'PO dengan status closed tidak bisa diubah');
        }

        $validated = $request->validated();

        $purchaseOrder->fill($validated);
        if ($purchaseOrder->used_qty >= $purchaseOrder->total_qty) {
            $purchaseOrder->status = 'closed';
            $purchaseOrder->closed_at = $purchaseOrder->closed_at ?? now();
        }
        $purchaseOrder->save();

        return redirect()->route('purchase-orders.index')
                       ->with('success', 'Purchase Order berhasil diperbarui');
    }

    /**
     * Remove the specified purchase order from storage
     */
    public function destroy(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
                       ->with('success', 'Purchase Order berhasil dihapus');
    }

    /**
     * Close the specified purchase order
     */
    public function close(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        if ($purchaseOrder->status === 'closed') {
            return redirect()->route('purchase-orders.index')
                            ->with('error', 'PO sudah ditutup');
        }

        $purchaseOrder->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->route('purchase-orders.index')
                        ->with('success', 'Purchase Order berhasil ditutup');
    }
}
