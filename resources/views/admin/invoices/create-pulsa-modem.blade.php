@extends('layouts.template')

@section('title', 'Tambah Invoice Pulsa Modem')

@section('main-content')
<style>
  .invoice-voucher-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .invoice-voucher-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    max-width: 1040px;
    margin: 18px auto 0;
  }

  .invoice-voucher-header {
    padding: 20px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .invoice-voucher-header h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .invoice-voucher-body {
    padding: 20px 24px 24px;
  }

  .invoice-voucher-alerts {
    margin-bottom: 18px;
  }

  .invoice-voucher-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .invoice-voucher-field {
    margin-bottom: 0;
  }

  .invoice-voucher-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .invoice-voucher-label .text-danger {
    color: #DC2626;
  }

  .invoice-voucher-label .text-muted {
    color: #64748B;
  }

  .invoice-voucher-form-control,
  .invoice-voucher-form-select {
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

  .invoice-voucher-form-control::placeholder,
  .invoice-voucher-form-select::placeholder {
    color: #94A3B8;
  }

  .invoice-voucher-form-control:focus,
  .invoice-voucher-form-select:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-voucher-small {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #64748B;
    line-height: 1.45;
  }

  .invoice-voucher-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .invoice-voucher-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .invoice-voucher-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .invoice-voucher-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .invoice-voucher-items-table {
    width: 100%;
    min-width: 820px;
    margin: 0;
    border-collapse: collapse;
  }

  .invoice-voucher-items-table thead th,
  .invoice-voucher-items-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .invoice-voucher-items-table tbody td,
  .invoice-voucher-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .invoice-voucher-items-table tbody tr {
    background: #FFFFFF;
  }

  .invoice-voucher-items-table tbody tr:hover {
    background: #F8FAFC;
  }

  .invoice-voucher-row-input {
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

  .invoice-voucher-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-voucher-btn {
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

  .invoice-voucher-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .invoice-voucher-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .invoice-voucher-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .invoice-voucher-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .invoice-voucher-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .invoice-voucher-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .invoice-voucher-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  @media (max-width: 767.98px) {
    .invoice-voucher-card {
      margin-top: 12px;
      border-radius: 12px;
    }

    .invoice-voucher-header,
    .invoice-voucher-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .invoice-voucher-grid {
      grid-template-columns: 1fr;
    }

    .invoice-voucher-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .invoice-voucher-btn {
      width: 100%;
    }
  }
</style>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                @include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Invoice Pulsa Modem'])
            </div>
        </div>
    </div>
</div>

<div class="invoice-voucher-shell">
    <div class="row mx-0">
        <div class="col-12">
            <div class="invoice-voucher-card">
                <div class="invoice-voucher-header">
                    <h5>Form Invoice Pulsa Modem</h5>
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

                    <form action="{{ route('invoices.store-pulsa-modem') }}" method="POST" id="invoicePulsaModemForm">
                        @csrf

                        <div class="invoice-voucher-grid">
                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label">Nomor Invoice</label>
                                <input type="text" class="invoice-voucher-form-control" value="INV/2026/[SEQ]/IT/[Bulan]" disabled>
                                <small class="invoice-voucher-small">Invoice akan otomatis digenerate dengan format: INV/YYYY/SEQ/IT/ROMAN_MONTH</small>
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="no_po_manual">Nomor PO Manual <span class="text-danger">*</span></label>
                                <input type="text" name="no_po_manual" id="no_po_manual" class="invoice-voucher-form-control @error('no_po_manual') is-invalid @enderror" value="{{ old('no_po_manual') }}" required placeholder="Contoh: PO/PM/2026/001">
                                @error('no_po_manual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="no_so">Nomor SO <span class="text-danger">*</span></label>
                                <input type="text" name="no_so" id="no_so" class="invoice-voucher-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so') }}" required placeholder="Contoh: SO/PM/2026/001">
                                @error('no_so')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="tipe_bisnis">Tipe Bisnis Internal <span class="text-muted">(Opsional)</span></label>
                                <input type="text" name="tipe_bisnis" id="tipe_bisnis" class="invoice-voucher-form-control @error('tipe_bisnis') is-invalid @enderror" value="{{ old('tipe_bisnis') }}" placeholder="Contoh: Retail, Wholesale, Dropship">
                                @error('tipe_bisnis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="invoice-voucher-field">
                                <label class="invoice-voucher-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-voucher-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" required>
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
                            <table class="table invoice-voucher-items-table table-bordered" id="itemsTable">
                                <thead class="table-light">
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
                                <i class="ti ti-device-floppy"></i> Simpan Invoice
                            </button>
                            <a href="{{ route('invoices.index') }}" class="invoice-voucher-btn invoice-voucher-btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let itemIndex = 0;

document.addEventListener('DOMContentLoaded', function () {
    addItemRow();

    document.getElementById('addItemBtn').addEventListener('click', function () {
        addItemRow();
    });

    document.getElementById('invoicePulsaModemForm').addEventListener('submit', function (e) {
        const rows = document.querySelectorAll('#itemsBody tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item.');
        }
    });
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
