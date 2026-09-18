<?php

namespace App\Http\Controllers;

use App\Models\VendorOpenTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorPartnershipController extends Controller
{
    public function index(): View
    {
        $openTables = VendorOpenTable::query()
            ->latest()
            ->paginate(10, ['*'], 'open_table_page');

        return view('admin.vendors.index', compact('openTables'));
    }

    

    public function storeOpenTable(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_vendor_ot' => ['required', 'string', 'max:255'],
            'tanggal_open_table' => ['required', 'array', 'min:1'],
            'tanggal_open_table.*' => ['required', 'date'],
        ]);

        $dates = collect($validated['tanggal_open_table'])
            ->filter()
            ->unique()
            ->values()
            ->all();

        VendorOpenTable::create([
            'nama_vendor' => $validated['nama_vendor_ot'],
            'tanggal_open_table' => $dates,
        ]);

        return redirect()->route('vendors.index')->with('success', 'Data Open Table vendor berhasil disimpan.');
    }
}
