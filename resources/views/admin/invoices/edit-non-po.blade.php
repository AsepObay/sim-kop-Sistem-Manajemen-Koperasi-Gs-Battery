@extends('layouts.template')

@section('title', 'Edit Invoice NON-PO')

@section('main-content')
<style>
  .edit-invoice-page {
    background: #F8FAFC;
    padding: 18px 0 32px;
  }

  .edit-invoice-page .invoice-nonpo-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .edit-invoice-page .invoice-nonpo-card {
    max-width: 1080px;
    margin: 18px auto 0;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    overflow: hidden;
  }

  .edit-invoice-page .invoice-nonpo-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-nonpo-header h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-nonpo-header small {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #64748B;
    line-height: 1.5;
  }

  .edit-invoice-page .invoice-nonpo-body {
    padding: 20px 24px 24px;
  }

  .edit-invoice-page .invoice-nonpo-alerts {
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-nonpo-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-nonpo-field {
    margin-bottom: 0;
  }

  .edit-invoice-page .invoice-nonpo-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .edit-invoice-page .invoice-nonpo-label .text-danger {
    color: #DC2626;
  }

  .edit-invoice-page .invoice-nonpo-form-control,
  .edit-invoice-page .invoice-nonpo-form-select,
  .edit-invoice-page .invoice-nonpo-row-input {
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

  .edit-invoice-page .invoice-nonpo-form-control:focus,
  .edit-invoice-page .invoice-nonpo-form-select:focus,
  .edit-invoice-page .invoice-nonpo-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-nonpo-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .edit-invoice-page .invoice-nonpo-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .edit-invoice-page .invoice-nonpo-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-nonpo-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-nonpo-table {
    width: 100%;
    min-width: 820px;
    margin: 0;
    border-collapse: collapse;
  }

  .edit-invoice-page .invoice-nonpo-table thead th,
  .edit-invoice-page .invoice-nonpo-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .edit-invoice-page .invoice-nonpo-table tbody td,
  .edit-invoice-page .invoice-nonpo-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .edit-invoice-page .invoice-nonpo-table tbody tr {
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-nonpo-table tbody tr:hover {
    background: #F8FAFC;
  }

  .edit-invoice-page .invoice-nonpo-btn {
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

  .edit-invoice-page .invoice-nonpo-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .edit-invoice-page .invoice-nonpo-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-nonpo-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .edit-invoice-page .invoice-nonpo-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-nonpo-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .edit-invoice-page .invoice-nonpo-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .edit-invoice-page .invoice-nonpo-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 22px;
  }

  @media (max-width: 767.98px) {
    .edit-invoice-page .invoice-nonpo-header,
    .edit-invoice-page .invoice-nonpo-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .edit-invoice-page .invoice-nonpo-grid {
      grid-template-columns: 1fr;
    }

    .edit-invoice-page .invoice-nonpo-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .edit-invoice-page .invoice-nonpo-btn {
      width: 100%;
    }
  }
</style>

<div class="edit-invoice-page">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @include('layouts.dashboard-breadcrumb', ['current' => 'Edit Invoice NON-PO'])
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-nonpo-shell">
        <div class="row mx-0">
            <div class="col-12">
                <div class="invoice-nonpo-card">
                    <div class="invoice-nonpo-header">
                        <h5>Edit Tagihan Non PO</h5>
                        <small>Perbarui informasi invoice dan item tagihan.</small>
                    </div>

                    <div class="invoice-nonpo-body">
                        <div class="invoice-nonpo-alerts">
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

                            <div class="invoice-nonpo-grid">
                                <div class="invoice-nonpo-field">
                                    <label class="invoice-nonpo-label" for="no_invoice">Nomor Invoice <span class="text-danger">*</span></label>
                                    <input type="text" name="no_invoice" id="no_invoice" class="invoice-nonpo-form-control @error('no_invoice') is-invalid @enderror" value="{{ old('no_invoice', $invoice->no_invoice) }}" required>
                                    @error('no_invoice')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="invoice-nonpo-field">
                                    <label class="invoice-nonpo-label" for="no_so">Nomor SO</label>
                                    <input type="text" name="no_so" id="no_so" class="invoice-nonpo-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so', $invoice->no_so) }}">
                                    @error('no_so')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="invoice-nonpo-field">
                                    <label class="invoice-nonpo-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-nonpo-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', optional($invoice->tanggal_invoice)->format('Y-m-d')) }}" required>
                                    @error('tanggal_invoice')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="invoice-nonpo-divider"></div>

                            <div class="invoice-nonpo-section-head">
                                <h5 class="invoice-nonpo-section-title">Item Invoice</h5>
                                <button type="button" class="invoice-nonpo-btn invoice-nonpo-btn-primary" id="addItemBtn">
                                    <i class="ti ti-plus"></i> Tambah Item
                                </button>
                            </div>

                            <div class="invoice-nonpo-table-wrap">
                                <table class="invoice-nonpo-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">Tanggal</th>
                                            <th width="25%">Nama Item</th>
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

                            <div class="invoice-nonpo-actions">
                                <button type="submit" class="invoice-nonpo-btn invoice-nonpo-btn-primary">
                                    <i class="ti ti-device-floppy"></i> Update Invoice
                                </button>
                                <a href="{{ $returnUrl }}" class="invoice-nonpo-btn invoice-nonpo-btn-secondary">
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
const initialItems = @json($initialItems);

document.addEventListener('DOMContentLoaded', function() {
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
            unit: row.querySelector('select[name*="[unit]"]')?.value || '',
            harga: row.querySelector('input[name*="[harga]"]')?.value || 0,
        }));

        const validRows = payload.filter(item => item.nama_item && Number(item.qty) > 0);
        if (validRows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item!');
            return false;
        }

        document.getElementById('items_json').value = JSON.stringify(payload);
    });

    if (initialItems.length) {
        initialItems.forEach(item => addItemRow(item));
    } else {
        addItemRow();
    }
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
            <select name="items[${itemIndex}][unit]" class="form-select form-select-sm" required>
                <option value="PCS" ${item?.unit === 'PCS' ? 'selected' : ''}>PCS</option>
                <option value="DUS" ${item?.unit === 'DUS' ? 'selected' : ''}>DUS</option>
                <option value="BOX" ${item?.unit === 'BOX' ? 'selected' : ''}>BOX</option>
                <option value="UNIT" ${item?.unit === 'UNIT' ? 'selected' : ''}>UNIT</option>
                <option value="SET" ${item?.unit === 'SET' ? 'selected' : ''}>SET</option>
            </select>
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
    row.querySelector('.item-subtotal').value = formatRupiah(qty * harga);
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
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount);
}
</script>
@endpush
@endsection
