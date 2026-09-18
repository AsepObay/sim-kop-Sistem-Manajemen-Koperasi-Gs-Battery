@extends('layouts.template')

@section('title', 'Edit Invoice PO')

@section('main-content')
<style>
  .edit-invoice-page {
    background: #F8FAFC;
    padding: 18px 0 32px;
  }

  .edit-invoice-page .invoice-po-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .edit-invoice-page .invoice-po-card {
    max-width: 1080px;
    margin: 18px auto 0;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    overflow: hidden;
  }

  .edit-invoice-page .invoice-po-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-po-header h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-po-header small {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #64748B;
    line-height: 1.5;
  }

  .edit-invoice-page .invoice-po-body {
    padding: 20px 24px 24px;
  }

  .edit-invoice-page .invoice-po-alerts {
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-po-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-po-field {
    margin-bottom: 0;
  }

  .edit-invoice-page .invoice-po-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .edit-invoice-page .invoice-po-label .text-danger {
    color: #DC2626;
  }

  .edit-invoice-page .invoice-po-form-control,
  .edit-invoice-page .invoice-po-form-select,
  .edit-invoice-page .invoice-po-row-input {
    width: 100%;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0F172A;
    font-size: 13px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .edit-invoice-page .invoice-po-form-control:focus,
  .edit-invoice-page .invoice-po-form-select:focus,
  .edit-invoice-page .invoice-po-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-po-info {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px 16px;
    background: #EFF6FF;
    border: 1px solid #DBEAFE;
    border-radius: 10px;
    padding: 16px 18px;
    margin-top: 6px;
    color: #1F2937;
  }

  .edit-invoice-page .invoice-po-info-title {
    grid-column: 1 / -1;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 4px;
    font-size: 12px;
    font-weight: 700;
    color: #1D4ED8;
    letter-spacing: 0.02em;
    text-transform: uppercase;
  }

  .edit-invoice-page .invoice-po-info-title i {
    width: 16px;
    height: 16px;
    font-size: 16px;
  }

  .edit-invoice-page #poInfoText {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 6px 16px;
    font-size: 12px;
    color: #334155;
  }

  .edit-invoice-page #poInfoText strong {
    color: #475569;
    font-weight: 600;
    margin-right: 6px;
  }

  .edit-invoice-page .invoice-po-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .edit-invoice-page .invoice-po-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .edit-invoice-page .invoice-po-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-po-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-po-items-table {
    width: 100%;
    min-width: 820px;
    margin: 0;
    border-collapse: collapse;
  }

  .edit-invoice-page .invoice-po-items-table thead th,
  .edit-invoice-page .invoice-po-items-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .edit-invoice-page .invoice-po-items-table tbody td,
  .edit-invoice-page .invoice-po-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .edit-invoice-page .invoice-po-items-table tbody tr {
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-po-items-table tbody tr:hover {
    background: #F8FAFC;
  }

  .edit-invoice-page .invoice-po-check-card {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 16px 18px;
    margin-top: 18px;
  }

  .edit-invoice-page .invoice-po-check-title {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 700;
    color: #0F172A;
  }

  .edit-invoice-page .invoice-po-check-title i {
    width: 16px;
    height: 16px;
    font-size: 16px;
    color: #2563EB;
  }

  .edit-invoice-page .invoice-po-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
  }

  .edit-invoice-page .invoice-po-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .edit-invoice-page .invoice-po-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-po-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .edit-invoice-page .invoice-po-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-po-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .edit-invoice-page .invoice-po-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .edit-invoice-page .invoice-po-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 22px;
  }

  @media (max-width: 767.98px) {
    .edit-invoice-page .invoice-po-header,
    .edit-invoice-page .invoice-po-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .edit-invoice-page .invoice-po-grid,
    .edit-invoice-page .invoice-po-info {
      grid-template-columns: 1fr;
    }

    .edit-invoice-page .invoice-po-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .edit-invoice-page .invoice-po-btn {
      width: 100%;
    }
  }
</style>

<div class="edit-invoice-page">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @include('layouts.dashboard-breadcrumb', ['current' => 'Edit Invoice PO'])
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-po-shell">
        <div class="row mx-0">
            <div class="col-12">
                <div class="invoice-po-card">
                    <div class="invoice-po-header">
                        <h5>Edit Tagihan PO</h5>
                        <small>Perbarui informasi invoice dan item tagihan.</small>
                    </div>

                    <div class="invoice-po-body">
                        <div class="invoice-po-alerts">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Terdapat kesalahan:</strong>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        @php
                            $returnUrl = request()->query('return', route('invoices.index'));
                        @endphp

                        <form action="{{ route('invoices.update', $invoice->id) }}?return={{ urlencode($returnUrl) }}" method="POST" id="invoiceForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="return" value="{{ $returnUrl }}">
                            <input type="hidden" name="items_json" id="items_json" value="">

                            <div class="invoice-po-grid">
                                <div class="invoice-po-field">
                                    <label class="invoice-po-label" for="purchase_order_id">Purchase Order <span class="text-danger">*</span></label>
                                    <select name="purchase_order_id" id="purchase_order_id" class="invoice-po-form-select @error('purchase_order_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih PO --</option>
                                        @foreach($purchaseOrders as $po)
                                            <option value="{{ $po->id }}"
                                                data-no-po="{{ $po->no_po }}"
                                                data-jenis-po="{{ $po->jenis_po }}"
                                                data-total-qty="{{ $po->total_qty }}"
                                                data-used-qty="{{ $po->used_qty }}"
                                                data-remaining-qty="{{ $po->remainingQty() }}"
                                                {{ old('purchase_order_id', $invoice->purchase_order_id) == $po->id ? 'selected' : '' }}>
                                                {{ $po->no_po }} - {{ $po->jenis_po }} (Sisa: {{ $po->remainingQty() }} unit)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('purchase_order_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div id="poInfo" class="invoice-po-info d-none">
                                        <div class="invoice-po-info-title">
                                            <i class="ti ti-info-circle"></i>
                                            Informasi Purchase Order
                                        </div>
                                        <div id="poInfoText"></div>
                                    </div>
                                </div>

                                <div class="invoice-po-field">
                                    <label class="invoice-po-label" for="no_invoice">Nomor Invoice <span class="text-danger">*</span></label>
                                    <input type="text" name="no_invoice" id="no_invoice" class="invoice-po-form-control @error('no_invoice') is-invalid @enderror" value="{{ old('no_invoice', $invoice->no_invoice) }}" required>
                                    @error('no_invoice')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label class="invoice-po-label" for="no_so" style="margin-top: 18px;">Nomor SO</label>
                                    <input type="text" name="no_so" id="no_so" class="invoice-po-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so', $invoice->no_so) }}">
                                    @error('no_so')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label class="invoice-po-label" for="tanggal_invoice" style="margin-top: 18px;">Tanggal Invoice <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-po-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', optional($invoice->tanggal_invoice)->format('Y-m-d')) }}" required>
                                    @error('tanggal_invoice')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="invoice-po-divider"></div>

                            <div class="invoice-po-section-head">
                                <h5 class="invoice-po-section-title">Item Invoice</h5>
                                <button type="button" class="invoice-po-btn invoice-po-btn-primary" id="addItemBtn">
                                    <i class="ti ti-plus"></i> Tambah Item
                                </button>
                            </div>

                            <div class="invoice-po-table-wrap">
                                <table class="invoice-po-items-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">Tanggal</th>
                                            <th width="24%">Nama Item</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">Unit</th>
                                            <th width="18%">Harga</th>
                                            <th width="16%">Jumlah</th>
                                            <th width="5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody"></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end"><strong>Total Qty:</strong></td>
                                            <td><strong id="totalQty">0</strong></td>
                                            <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                                            <td colspan="2"><strong id="totalSubtotal">Rp 0</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>PPN 11%:</strong></td>
                                            <td colspan="2"><strong id="totalPpn">Rp 0</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td colspan="2"><strong id="grandTotal">Rp 0</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="invoice-po-check-card">
                                <div class="invoice-po-check-title">
                                    <i class="ti ti-calculator"></i>
                                    Fitur Cek Harga Jual PO
                                </div>
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="invoice-po-label">Harga Satuan</label>
                                        <input type="number" id="cek_harga_satuan" class="invoice-po-form-control" min="0" step="0.01" placeholder="Masukkan harga satuan">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="invoice-po-label">Output 11%</label>
                                        <input type="text" id="cek_output_11" class="invoice-po-form-control" value="Rp 0" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="invoice-po-label">Hasil Akhir</label>
                                        <input type="text" id="cek_hasil_akhir" class="invoice-po-form-control" value="Rp 0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-po-actions">
                                <button type="submit" class="invoice-po-btn invoice-po-btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Invoice
                                </button>
                                <a href="{{ $returnUrl }}" class="invoice-po-btn invoice-po-btn-secondary">
                                    <i class="ti ti-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@php
    $initialItems = old('items', $invoice->items->map(function ($item) {
        return [
            'tanggal_item' => optional($item->tanggal_item)->format('Y-m-d'),
            'nama_item' => $item->nama_item,
            'qty' => $item->qty,
            'unit' => $item->unit,
            'harga' => $item->harga,
        ];
    })->values()->toArray());
@endphp
<script>
let itemIndex = 0;
let remainingQty = 0;
const originalPoId = Number(@json($invoice->purchase_order_id));
const originalInvoiceQty = Number(@json((int) $invoice->items->sum('qty')));
const initialItems = @json($initialItems);

document.addEventListener('DOMContentLoaded', function() {
    const poSelect = document.getElementById('purchase_order_id');
    const poInfo = document.getElementById('poInfo');
    const poInfoText = document.getElementById('poInfoText');

    function updatePoInfo() {
        const selectedOption = poSelect.options[poSelect.selectedIndex];

        if (poSelect.value) {
            const selectedPoId = parseInt(poSelect.value, 10);
            const currentRemaining = parseInt(selectedOption.dataset.remainingQty || '0', 10);
            const allowedQty = selectedPoId === originalPoId ? currentRemaining + originalInvoiceQty : currentRemaining;
            remainingQty = allowedQty;

            poInfoText.innerHTML = `
                <strong>No PO:</strong> ${selectedOption.dataset.noPo}<br>
                <strong>Jenis PO:</strong> ${selectedOption.dataset.jenisPo}<br>
                <strong>Total Qty:</strong> ${selectedOption.dataset.totalQty}<br>
                <strong>Used Qty:</strong> ${selectedOption.dataset.usedQty}<br>
                <strong>Maks Qty Invoice Ini:</strong> ${allowedQty}
            `;
            poInfo.classList.remove('d-none');
        } else {
            remainingQty = 0;
            poInfo.classList.add('d-none');
        }

        calculateTotals();
    }

    poSelect.addEventListener('change', updatePoInfo);

    document.getElementById('addItemBtn').addEventListener('click', function() {
        addItemRow();
    });

    document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('#itemsBody tr');

        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item!');
            return false;
        }

        const payload = Array.from(rows).map(row => ({
            tanggal_item: row.querySelector('input[name*="[tanggal_item]"]')?.value || '',
            nama_item: row.querySelector('input[name*="[nama_item]"]')?.value || '',
            qty: row.querySelector('input[name*="[qty]"]')?.value || 0,
            unit: row.querySelector('input[name*="[unit]"]')?.value || '',
            harga: row.querySelector('input[name*="[harga]"]')?.value || 0,
        }));

        const validRows = payload.filter(item => item.nama_item && item.qty && Number(item.qty) > 0);
        if (validRows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item.');
            return false;
        }

        document.getElementById('items_json').value = JSON.stringify(payload);

        const totalQty = calculateTotalQty();
        if (remainingQty > 0 && totalQty > remainingQty) {
            e.preventDefault();
            alert(`Total qty invoice (${totalQty}) melebihi batas qty yang diizinkan (${remainingQty})!`);
            return false;
        }
    });

    if (initialItems.length) {
        initialItems.forEach(item => addItemRow(item));
    } else {
        addItemRow();
    }

    updatePoInfo();
});

function addItemRow(item = null) {
    const tbody = document.getElementById('itemsBody');
    const today = new Date().toISOString().split('T')[0];

    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="text-center row-number"></td>
        <td>
            <input type="date" name="items[${itemIndex}][tanggal_item]" class="form-control form-control-sm" value="${item?.tanggal_item || today}" required>
        </td>
        <td>
            <input type="text" name="items[${itemIndex}][nama_item]" class="form-control form-control-sm" value="${item?.nama_item || ''}" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][qty]" class="form-control form-control-sm item-qty" min="1" value="${item?.qty || 1}" required>
        </td>
        <td>
            <input type="text" name="items[${itemIndex}][unit]" class="form-control form-control-sm" value="${item?.unit || ''}" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][harga]" class="form-control form-control-sm item-harga" min="0" step="0.01" value="${item?.harga || 0}" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm item-subtotal" readonly value="Rp 0">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="ti ti-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    itemIndex++;

    attachItemEventListeners(row);
    calculateRowSubtotal(row);
    refreshRowNumbers();
}

function attachItemEventListeners(row) {
    row.querySelector('.item-qty').addEventListener('input', () => calculateRowSubtotal(row));
    row.querySelector('.item-harga').addEventListener('input', () => calculateRowSubtotal(row));

    row.querySelector('.remove-item').addEventListener('click', function() {
        row.remove();
        refreshRowNumbers();
        calculateTotals();
    });
}

function refreshRowNumbers() {
    document.querySelectorAll('#itemsBody tr').forEach((row, idx) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = idx + 1;
        }
    });
}

function calculateRowSubtotal(row) {
    const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
    const harga = parseFloat(row.querySelector('.item-harga').value) || 0;

    const subtotalInput = row.querySelector('.item-subtotal');
    if (subtotalInput) {
        subtotalInput.value = formatRupiah(qty * harga);
    }

    calculateTotals();
}

function calculateTotals() {
    const rows = document.querySelectorAll('#itemsBody tr');
    let totalQty = 0;
    let totalSubtotal = 0;

    rows.forEach(row => {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
        totalQty += qty;
        totalSubtotal += qty * harga;
    });

    document.getElementById('totalQty').textContent = totalQty;
    document.getElementById('totalSubtotal').textContent = formatRupiah(totalSubtotal);
    document.getElementById('totalPpn').textContent = formatRupiah(totalSubtotal * 0.11);
    document.getElementById('grandTotal').textContent = formatRupiah(totalSubtotal * 1.11);

    if (remainingQty > 0 && totalQty > remainingQty) {
        document.getElementById('totalQty').classList.add('text-danger');
    } else {
        document.getElementById('totalQty').classList.remove('text-danger');
    }
}

function calculateTotalQty() {
    let total = 0;
    document.querySelectorAll('#itemsBody .item-qty').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount);
}

function updateCekHargaJual() {
    const input = document.getElementById('cek_harga_satuan');
    const output = document.getElementById('cek_output_11');
    const hasil = document.getElementById('cek_hasil_akhir');

    if (!input || !output || !hasil) {
        return;
    }

    const harga = parseFloat(input.value) || 0;
    const penjualan = Math.round(harga * 0.11);
    const hasilAkhir = Math.round(harga + penjualan);

    output.value = formatRupiah(penjualan);
    hasil.value = formatRupiah(hasilAkhir);
}

document.addEventListener('DOMContentLoaded', function() {
    const cekInput = document.getElementById('cek_harga_satuan');
    if (cekInput) {
        cekInput.addEventListener('input', updateCekHargaJual);
    }
});
</script>
@endpush
@endsection
