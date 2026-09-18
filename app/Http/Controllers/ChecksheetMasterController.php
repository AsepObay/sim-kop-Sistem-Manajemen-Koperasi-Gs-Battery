<?php

namespace App\Http\Controllers;

use App\Models\ChecksheetMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChecksheetMasterController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->input('category', ChecksheetMaster::CATEGORY_PALLET);
        $search = trim((string) $request->input('search'));
        $selectedItem = trim((string) $request->input('item'));
        $palletType = trim((string) $request->input('pallet_type'));
        $month = $request->input('month');
        $date = $request->input('date');
        $year = $request->input('year');
        $filterDateColumn = $category === ChecksheetMaster::CATEGORY_PRODUCT ? 'tanggal_kedatangan' : 'tanggal';

        $items = ChecksheetMaster::query()
            ->when(in_array($category, [ChecksheetMaster::CATEGORY_PALLET, ChecksheetMaster::CATEGORY_PRODUCT], true), fn ($query) => $query->where('category', $category))
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->when($category === ChecksheetMaster::CATEGORY_PRODUCT, function ($query) use ($selectedItem) {
                $productItems = $selectedItem !== ''
                    ? (ChecksheetMaster::PRODUCT_ITEM_OPTIONS[$selectedItem] ?? [$selectedItem])
                    : ['__no_product_selected__'];

                $query->whereIn('name', $productItems);
            })
            ->when($category === ChecksheetMaster::CATEGORY_PALLET && $selectedItem !== '', function ($query) use ($selectedItem) {
                $query->where('name', $selectedItem);
            })
            ->when($palletType !== '' && $category === ChecksheetMaster::CATEGORY_PALLET, fn ($query) => $query->where('name', $palletType))
            ->when($month, fn ($query) => $query->whereMonth($filterDateColumn, (int) substr($month, 5, 2)))
            ->when($date, fn ($query) => $query->whereDate($filterDateColumn, $date))
            ->when($year, fn ($query) => $query->whereYear($filterDateColumn, (int) $year))
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $masterOptions = ChecksheetMaster::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $palletTypes = ChecksheetMaster::PALLET_TYPES;
        $productOptions = ChecksheetMaster::PRODUCT_ITEM_OPTIONS[$selectedItem] ?? $masterOptions->where('category', 'produk')->unique('name')->pluck('name')->values()->all();

        return view('admin.checksheet-masters.index', compact('items', 'category', 'search', 'selectedItem', 'masterOptions', 'palletTypes', 'productOptions', 'palletType', 'month', 'date', 'year'));
    }

    public function create(): View
    {
        $masterOptions = ChecksheetMaster::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $palletTypes = ChecksheetMaster::PALLET_TYPES;

        return view('admin.checksheet-masters.create', compact('masterOptions', 'palletTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:pallet,produk',
            'name' => ['required', 'string', 'max:100', Rule::when($request->input('category') === ChecksheetMaster::CATEGORY_PALLET, Rule::in(ChecksheetMaster::PALLET_TYPES))],
            'tanggal' => 'nullable|date',
            'tanggal_kedatangan' => 'nullable|date',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_archived'] = $request->boolean('is_archived');
        ChecksheetMaster::create($validated);

        $returnCategory = $request->input('return_category', $validated['category']);
        $returnItem = trim((string) $request->input('return_item'));
        $redirectParams = ['category' => $returnCategory];

        if ($returnCategory === ChecksheetMaster::CATEGORY_PRODUCT && $returnItem !== '') {
            $redirectParams['item'] = $returnItem;
        }

        return redirect()->route('checksheet-masters.index', $redirectParams)->with('success', 'Data checksheet berhasil ditambahkan.');
    }

    public function edit(ChecksheetMaster $checksheetMaster): View
    {
        $masterOptions = ChecksheetMaster::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $palletTypes = ChecksheetMaster::PALLET_TYPES;
        $returnItem = $this->productParentItem($checksheetMaster->name);

        return view('admin.checksheet-masters.edit', compact('checksheetMaster', 'masterOptions', 'palletTypes', 'returnItem'));
    }

    public function update(Request $request, ChecksheetMaster $checksheetMaster): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:pallet,produk',
            'name' => ['required', 'string', 'max:100', Rule::when($request->input('category') === ChecksheetMaster::CATEGORY_PALLET, Rule::in(ChecksheetMaster::PALLET_TYPES))],
            'tanggal' => 'nullable|date',
            'tanggal_kedatangan' => 'nullable|date',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_archived'] = $request->boolean('is_archived');
        $checksheetMaster->update($validated);

        $returnCategory = $request->input('return_category', $validated['category']);
        $returnItem = trim((string) $request->input('return_item'));
        $redirectParams = ['category' => $returnCategory];

        if ($returnCategory === ChecksheetMaster::CATEGORY_PRODUCT && $returnItem !== '') {
            $redirectParams['item'] = $returnItem;
        }

        return redirect()->route('checksheet-masters.index', $redirectParams)->with('success', 'Data checksheet berhasil diperbarui.');
    }

    public function destroy(ChecksheetMaster $checksheetMaster): RedirectResponse
    {
        $checksheetMaster->delete();

        $returnCategory = request()->input('return_category', $checksheetMaster->category);
        $returnItem = trim((string) request()->input('return_item'));
        $redirectParams = ['category' => $returnCategory];

        if ($returnCategory === ChecksheetMaster::CATEGORY_PRODUCT && $returnItem !== '') {
            $redirectParams['item'] = $returnItem;
        }

        return redirect()->route('checksheet-masters.index', $redirectParams)->with('success', 'Data checksheet berhasil dihapus.');
    }

    private function productParentItem(string $item): string
    {
        foreach (ChecksheetMaster::PRODUCT_ITEM_OPTIONS as $parent => $options) {
            if (in_array($item, $options, true)) {
                return $parent;
            }
        }

        return $item;
    }
}
