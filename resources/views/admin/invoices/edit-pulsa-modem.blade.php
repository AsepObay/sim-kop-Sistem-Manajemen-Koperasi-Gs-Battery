@extends('layouts.template')

@section('title', 'Edit Invoice Pulsa Modem')

@section('main-content')
<style>
  .edit-invoice-page {
    background: #F8FAFC;
    padding: 18px 0 32px;
  }

  .edit-invoice-page .invoice-voucher-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .edit-invoice-page .invoice-voucher-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    max-width: 1080px;
    margin: 18px auto 0;
  }

  .edit-invoice-page .invoice-voucher-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-voucher-header h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-voucher-body {
    padding: 20px 24px 24px;
  }

  .edit-invoice-page .invoice-voucher-alerts {
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-voucher-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-voucher-field {
    margin-bottom: 0;
  }

  .edit-invoice-page .invoice-voucher-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .edit-invoice-page .invoice-voucher-label .text-danger {
    color: #DC2626;
  }

  .edit-invoice-page .invoice-voucher-form-control {
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

  .edit-invoice-page .invoice-voucher-form-control:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-voucher-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .edit-invoice-page .invoice-voucher-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .edit-invoice-page .invoice-voucher-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-voucher-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .edit-invoice-page .invoice-voucher-items-table {
    width: 100%;
    min-width: 820px;
    margin: 0;
    border-collapse: collapse;
  }

  .edit-invoice-page .invoice-voucher-items-table thead th,
  .edit-invoice-page .invoice-voucher-items-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .edit-invoice-page .invoice-voucher-items-table tbody td,
  .edit-invoice-page .invoice-voucher-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .edit-invoice-page .invoice-voucher-items-table tbody tr {
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-voucher-items-table tbody tr:hover {
    background: #F8FAFC;
  }

  .edit-invoice-page .invoice-voucher-row-input {
    width: 100%;
    height: 38px;
    padding: 0 10px;
    border: 1px solid #CBD5E1;
    border-radius: 7px;
    background: #FFFFFF;
    color: #0F172A;
    font-size: 12px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .edit-invoice-page .invoice-voucher-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-voucher-btn {
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

  .edit-invoice-page .invoice-voucher-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .edit-invoice-page .invoice-voucher-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-voucher-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .edit-invoice-page .invoice-voucher-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-voucher-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .edit-invoice-page .invoice-voucher-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .edit-invoice-page .invoice-voucher-header small {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #64748B;
    line-height: 1.5;
  }

  .edit-invoice-page .invoice-voucher-card {
    max-width: 1120px;
  }

  .edit-invoice-page .invoice-voucher-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  @media (max-width: 767.98px) {
    .edit-invoice-page .invoice-voucher-card {
      margin-top: 12px;
      border-radius: 12px;
    }

    .edit-invoice-page .invoice-voucher-header,
    .edit-invoice-page .invoice-voucher-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .edit-invoice-page .invoice-voucher-grid {
      grid-template-columns: 1fr;
    }

    .edit-invoice-page .invoice-voucher-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .edit-invoice-page .invoice-voucher-btn {
      width: 100%;
    }
  }
</style>

<div class="edit-invoice-page">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @include('layouts.dashboard-breadcrumb', ['current' => 'Edit Invoice Pulsa Modem'])
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-voucher-shell">
    <div class="row mx-0">
        <div class="col-12">
            <div class="invoice-voucher-card">
                <div class="invoice-voucher-header">
                    <h5>Edit Tagihan Pulsa Modem</h5>
                    <small>Perbarui informasi transaksi pulsa modem.</small>
                </div>
                <div class="invoice-voucher-body">
                    <div class="invoice-voucher-alerts">
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

                    <form action="{{ route('invoices.update', $invoice->id) }}?return={{ urlencode($returnUrl) }}" method="POST" id="invoicePulsaModemForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="return" value="{{ $returnUrl }}">
                        <input type="hidden" name="items_json" id="items_json" value="">

                        <div class="invoice-voucher-grid">
                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="no_invoice">Nomor Invoice <span class="text-danger">*</span></label>
                                <input type="text" name="no_invoice" id="no_invoice" class="invoice-voucher-form-control @error('no_invoice') is-invalid @enderror" value="{{ old('no_invoice', $invoice->no_invoice) }}" required>
                                @error('no_invoice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="no_po_manual">Nomor PO Manual <span class="text-danger">*</span></label>
                                <input type="text" name="no_po_manual" id="no_po_manual" class="invoice-voucher-form-control @error('no_po_manual') is-invalid @enderror" value="{{ old('no_po_manual', $invoice->no_po_manual) }}" required>
                                @error('no_po_manual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="no_so">Nomor SO <span class="text-danger">*</span></label>
                                <input type="text" name="no_so" id="no_so" class="invoice-voucher-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so', $invoice->no_so) }}" required>
                                @error('no_so')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-voucher-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', optional($invoice->tanggal_invoice)->format('Y-m-d')) }}" required>
                                @error('tanggal_invoice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="invoice-voucher-divider"></div>

                        <div class="invoice-voucher-section-head">
                            <h5 class="invoice-voucher-section-title">Item Invoice</h5>
                            <button type="button" class="invoice-voucher-btn invoice-voucher-btn-primary" id="addItemBtn">
                                <i class="ti ti-plus"></i> Tambah Baris
                            </button>
                        </div>

                        <div class="invoice-voucher-table-wrap">
                            <table class="invoice-voucher-items-table" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Item</th>
                                        <th width="12%">Qty</th>
                                        <th width="13%">Unit</th>
                                        <th width="18%">Harga</th>
                                        <th width="17%">Jumlah</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Total Qty:</strong></td>
                                        <td><strong id="totalQty">0</strong></td>
                                        <td class="text-end"><strong>Grand total:</strong></td>
                                        <td colspan="3"><strong id="grandTotal" class="text-primary">Rp 0</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="invoice-voucher-actions">
                            <button type="submit" class="invoice-voucher-btn invoice-voucher-btn-primary">
                                <i class="ti ti-device-floppy"></i> Update Invoice
                            </button>
                            <a href="{{ $returnUrl }}" class="invoice-voucher-btn invoice-voucher-btn-secondary">
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

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addItemBtn').addEventListener('click', function () {
        addItemRow();
    });

    document.getElementById('invoicePulsaModemForm').addEventListener('submit', function (e) {
        const rows = document.querySelectorAll('#itemsBody tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item.');
            return false;
        }

        const payload = Array.from(rows).map(row => ({
            nama_item: row.querySelector('input[name*="[nama_item]"]')?.value || '',
            qty: row.querySelector('input[name*="[qty]"]')?.value || 0,
            unit: row.querySelector('select[name*="[unit]"]')?.value || '',
            harga: row.querySelector('input[name*="[harga]"]')?.value || 0,
        }));

        const validRows = payload.filter(item => item.nama_item && Number(item.qty) > 0);
        if (validRows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item.');
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

    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="text-center row-number"></td>
        <td>
            <input type="text" name="items[${itemIndex}][nama_item]" class="form-control form-control-sm" value="${item?.nama_item || ''}" placeholder="Nama item" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][qty]" class="form-control form-control-sm item-qty" min="1" value="${item?.qty || 1}" required>
        </td>
        <td>
            <select name="items[${itemIndex}][unit]" class="form-select form-select-sm item-unit" required>
                ${['PCS','PULSA','UNIT','SET','LS'].map(unit => `<option value="${unit}" ${((item?.unit || 'PCS') === unit) ? 'selected' : ''}>${unit}</option>`).join('')}
            </select>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][harga]" class="form-control form-control-sm item-harga" min="0" step="0.01" value="${item?.harga || 0}" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm item-subtotal" value="Rp 0" readonly>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="ti ti-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    itemIndex++;

    row.querySelector('.item-qty').addEventListener('input', () => calculateRowSubtotal(row));
    row.querySelector('.item-harga').addEventListener('input', () => calculateRowSubtotal(row));
    row.querySelector('.remove-item').addEventListener('click', function () {
        row.remove();
        refreshRowNumbers();
        calculateTotals();
    });

    calculateRowSubtotal(row);
    calculateTotals();
}

function calculateRowSubtotal(row) {
    const qty = parseInt(row.querySelector('.item-qty').value) || 0;
    const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
    row.querySelector('.item-subtotal').value = formatRupiah(qty * harga);
    refreshRowNumbers();
    calculateTotals();
}

function refreshRowNumbers() {
    document.querySelectorAll('#itemsBody tr').forEach((row, idx) => {
        row.querySelector('.row-number').textContent = idx + 1;
    });
}

function calculateTotals() {
    let totalQty = 0;
    let grandTotal = 0;

    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const qty = parseInt(row.querySelector('.item-qty').value) || 0;
        const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
        totalQty += qty;
        grandTotal += qty * harga;
    });

    document.getElementById('totalQty').textContent = totalQty;
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount);
}
</script>
@endpush
@endsection
