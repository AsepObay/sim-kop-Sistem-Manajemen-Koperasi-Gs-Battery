@extends('layouts.template')

@section('title', 'Tambah Invoice NON-PO')

@section('main-content')
<style>
  .invoice-nonpo-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .invoice-nonpo-card {
    max-width: 1040px;
    margin: 18px auto 0;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    overflow: hidden;
  }

  .invoice-nonpo-header {
    padding: 20px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
  }

  .invoice-nonpo-header h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .invoice-nonpo-header small {
    color: #64748B;
    font-size: 12px;
  }

  .invoice-nonpo-body {
    padding: 20px 24px 24px;
  }

  .invoice-nonpo-alerts {
    margin-bottom: 18px;
  }

  .invoice-nonpo-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .invoice-nonpo-field {
    margin-bottom: 0;
  }

  .invoice-nonpo-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .invoice-nonpo-form-control {
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

  .invoice-nonpo-form-control::placeholder {
    color: #94A3B8;
  }

  .invoice-nonpo-form-control:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-nonpo-form-control[disabled] {
    background: #F8FAFC;
    color: #64748B;
    cursor: not-allowed;
  }

  .invoice-nonpo-small {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #64748B;
    line-height: 1.45;
  }

  .invoice-nonpo-note {
    margin-top: 0;
    border: 1px solid #DBEAFE;
    border-radius: 10px;
    background: #EFF6FF;
    color: #1D4ED8;
    padding: 12px 14px;
  }

  .invoice-nonpo-note i {
    font-size: 16px;
    vertical-align: middle;
  }

  .invoice-nonpo-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .invoice-nonpo-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .invoice-nonpo-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
  }

  .invoice-nonpo-add-item {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 38px;
    padding: 0 14px;
    border-radius: 8px;
    border: 1px solid #2563EB;
    background: #2563EB;
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .invoice-nonpo-add-item:hover {
    background: #1D4ED8;
    border-color: #1D4ED8;
    color: #FFFFFF;
  }

  .invoice-nonpo-add-item i {
    font-size: 15px;
    line-height: 1;
  }

  .invoice-nonpo-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .invoice-nonpo-table {
    width: 100%;
    min-width: 820px;
    border-collapse: collapse;
    margin: 0;
  }

  .invoice-nonpo-table thead th {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .invoice-nonpo-table tbody td,
  .invoice-nonpo-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    color: #334155;
    border-color: #E2E8F0;
    vertical-align: middle;
  }

  .invoice-nonpo-table tbody tr:hover {
    background: #F8FAFC;
  }

  .invoice-nonpo-row-input,
  .invoice-nonpo-row-select {
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

  .invoice-nonpo-row-input:focus,
  .invoice-nonpo-row-select:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-nonpo-row-input[readonly] {
    background: #F8FAFC;
    color: #475569;
  }

  .invoice-nonpo-del-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    transition: all 0.2s ease;
  }

  .invoice-nonpo-del-btn:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .invoice-nonpo-del-btn i {
    font-size: 15px;
    line-height: 1;
  }

  .invoice-nonpo-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  .invoice-nonpo-submit-btn,
  .invoice-nonpo-back-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .invoice-nonpo-submit-btn {
    background: #2563EB;
    border: 1px solid #2563EB;
    color: #FFFFFF;
  }

  .invoice-nonpo-submit-btn:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .invoice-nonpo-back-btn {
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    color: #475569;
  }

  .invoice-nonpo-back-btn:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  @media (max-width: 767.98px) {
    .invoice-nonpo-card {
      margin-top: 12px;
      border-radius: 12px;
    }

    .invoice-nonpo-header,
    .invoice-nonpo-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .invoice-nonpo-grid {
      grid-template-columns: 1fr;
    }

    .invoice-nonpo-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .invoice-nonpo-submit-btn,
    .invoice-nonpo-back-btn {
      width: 100%;
    }
  }
</style>

        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Invoice NON-PO'])
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="invoice-nonpo-shell">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="invoice-nonpo-card">
                        <div class="invoice-nonpo-header">
                            <h5>Form Tambah Invoice NON-PO</h5>
                            <small>Invoice tanpa Purchase Order</small>
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

                            <form action="{{ route('invoices.store-non-po') }}" method="POST" id="invoiceForm">
                                @csrf

                                <div class="invoice-nonpo-grid">
                                    <div class="invoice-nonpo-field">
                                        <label class="invoice-nonpo-label">Nomor Invoice</label>
                                        <input type="text" class="invoice-nonpo-form-control" value="INV/2026/[SEQ]/KRT/[Bulan]" disabled>
                                    </div>

                                    <div class="invoice-nonpo-field">
                                        <label class="invoice-nonpo-label" for="no_so">Nomor SO</label>
                                        <input type="text" name="no_so" id="no_so" class="invoice-nonpo-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so') }}" placeholder="Opsional">
                                        @error('no_so')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-nonpo-field">
                                        <label class="invoice-nonpo-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-nonpo-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" required>
                                        @error('tanggal_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="invoice-nonpo-grid" style="margin-bottom: 0;">
                                    <div class="invoice-nonpo-field" style="grid-column: 1 / 2;">
                                        <label class="invoice-nonpo-label" for="tipe_bisnis">Bisnis Internal</label>
                                        <input type="text" name="tipe_bisnis" id="tipe_bisnis" class="invoice-nonpo-form-control @error('tipe_bisnis') is-invalid @enderror" value="{{ old('tipe_bisnis') }}" placeholder="Contoh: Retail, Wholesale, Dropship">
                                        @error('tipe_bisnis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="invoice-nonpo-note" style="margin-top: 18px;">
                                    <i class="ti ti-info-circle"></i> <strong>Info:</strong> Invoice NON-PO tidak terkait dengan Purchase Order. Anda dapat langsung memasukkan item-item invoice.
                                </div>

                                <div class="invoice-nonpo-divider"></div>

                                <div class="invoice-nonpo-section-head">
                                    <h5 class="invoice-nonpo-section-title">Item Invoice</h5>
                                    <button type="button" class="invoice-nonpo-add-item" id="addItemBtn">
                                        <i class="ti ti-plus"></i> Tambah Item
                                    </button>
                                </div>

                                <div class="invoice-nonpo-table-wrap">
                                    <table class="table invoice-nonpo-table table-bordered" id="itemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Tanggal</th>
                                                <th width="28%">Nama Item</th>
                                                <th width="10%">Qty</th>
                                                <th width="10%">Unit</th>
                                                <th width="18%">Harga</th>
                                                <th width="17%">Jumlah</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody">
                                            <!-- Items will be added here dynamically -->
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-light">
                                                <td colspan="2" class="text-end"><strong>Total Qty:</strong></td>
                                                <td><strong id="totalQty">0</strong></td>
                                                <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                                                <td colspan="2"><strong id="totalSubtotal">Rp 0</strong></td>
                                            </tr>
                                            <tr class="table-light">
                                                <td colspan="5" class="text-end"><strong>PPN 11%:</strong></td>
                                                <td colspan="2"><strong id="totalPpn">Rp 0</strong></td>
                                            </tr>
                                            <tr class="table-light">
                                                <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                                <td colspan="2"><strong id="grandTotal">Rp 0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @error('items')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <div class="invoice-nonpo-actions">
                                    <button type="submit" class="invoice-nonpo-submit-btn">
                                        <i class="ti ti-device-floppy"></i> Simpan Invoice
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="invoice-nonpo-back-btn">
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

document.addEventListener('DOMContentLoaded', function() {
    // Add first item row on load
    addItemRow();

    // Add item button
    document.getElementById('addItemBtn').addEventListener('click', function() {
        addItemRow();
    });

    // Form validation before submit
    document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        const tbody = document.getElementById('itemsBody');
        const rows = tbody.querySelectorAll('tr');
        
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item!');
            return false;
        }
    });
});

function addItemRow() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="text-center row-number">${document.querySelectorAll('#itemsBody tr').length + 1}</td>
        <td>
            <input type="date" name="items[${itemIndex}][tanggal_item]" class="form-control form-control-sm" value="${new Date().toISOString().split('T')[0]}" required>
        </td>
        <td>
            <input type="text" name="items[${itemIndex}][nama_item]" class="form-control form-control-sm" placeholder="Nama item" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][qty]" class="form-control form-control-sm item-qty" min="1" value="1" required>
        </td>
        <td>
            <select name="items[${itemIndex}][unit]" class="form-select form-select-sm" required>
                <option value="PCS">PCS</option>
                <option value="DUS">DUS</option>
                <option value="BOX">BOX</option>
                <option value="UNIT">UNIT</option>
                <option value="SET">SET</option>
            </select>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][harga]" class="form-control form-control-sm item-harga" min="0" step="0.01" value="0" required>
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

    // Attach event listeners
    attachItemEventListeners(row);
    calculateTotals();
}

function refreshItemRowNumbers() {
    document.querySelectorAll('#itemsBody tr').forEach((row, idx) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = idx + 1;
        }
    });
}

function attachItemEventListeners(row) {
    const qtyInput = row.querySelector('.item-qty');
    const hargaInput = row.querySelector('.item-harga');
    const removeBtn = row.querySelector('.remove-item');

    qtyInput.addEventListener('input', () => calculateRowSubtotal(row));
    hargaInput.addEventListener('input', () => calculateRowSubtotal(row));
    
    removeBtn.addEventListener('click', function() {
        row.remove();
        refreshItemRowNumbers();
        calculateTotals();
    });
}

function calculateRowSubtotal(row) {
    const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
    const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
    let subtotal = qty * harga;
    
    row.querySelector('.item-subtotal').value = formatRupiah(subtotal);
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

    const totalPpn = totalSubtotal * 0.11;
    const grandTotal = totalSubtotal + totalPpn;

    document.getElementById('totalPpn').textContent = formatRupiah(totalPpn);
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}
</script>
@endpush
@endsection
