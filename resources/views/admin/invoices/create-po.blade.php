@extends('layouts.template')

@section('title', 'Tambah Invoice PO')

@section('main-content')
<style>
  .invoice-po-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .invoice-po-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    max-width: 1040px;
    margin: 18px auto 0;
  }

  .invoice-po-header {
    padding: 20px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .invoice-po-header h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .invoice-po-body {
    padding: 20px 24px 24px;
  }

  .invoice-po-alerts {
    margin-bottom: 18px;
  }

  .invoice-po-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .invoice-po-field {
    margin-bottom: 0;
  }

  .invoice-po-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .invoice-po-label .text-danger {
    color: #DC2626;
  }

  .invoice-po-label .text-muted {
    color: #64748B;
  }

  .invoice-po-form-control,
  .invoice-po-form-select {
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

  .invoice-po-form-control::placeholder,
  .invoice-po-form-select::placeholder {
    color: #94A3B8;
  }

  .invoice-po-form-control:focus,
  .invoice-po-form-select:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-po-form-select {
    appearance: none;
    background-image: linear-gradient(45deg, transparent 50%, #64748B 50%), linear-gradient(135deg, #64748B 50%, transparent 50%);
    background-position: calc(100% - 16px) calc(50% - 2px), calc(100% - 11px) calc(50% - 2px);
    background-size: 5px 5px, 5px 5px;
    background-repeat: no-repeat;
    padding-right: 36px;
  }

  .invoice-po-small {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #64748B;
    line-height: 1.45;
  }

  .invoice-po-info {
    margin-top: 0;
    border: 1px solid #DBEAFE;
    background: #EFF6FF;
    color: #1D4ED8;
    border-radius: 10px;
    padding: 12px 14px;
  }

  .invoice-po-info strong {
    color: #1D4ED8;
  }

  .invoice-po-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .invoice-po-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .invoice-po-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .invoice-po-add-item {
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
    transition: background 0.2s ease, border-color 0.2s ease;
  }

  .invoice-po-add-item:hover {
    background: #1D4ED8;
    border-color: #1D4ED8;
    color: #FFFFFF;
  }

  .invoice-po-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .invoice-po-items-table {
    width: 100%;
    min-width: 820px;
    margin: 0;
    border-collapse: collapse;
  }

  .invoice-po-items-table thead th {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .invoice-po-items-table tbody td,
  .invoice-po-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .invoice-po-items-table tbody tr {
    background: #FFFFFF;
  }

  .invoice-po-items-table tbody tr:hover {
    background: #F8FAFC;
  }

  .invoice-po-row-input {
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

  .invoice-po-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-po-row-input[readonly] {
    background: #F8FAFC;
    color: #475569;
  }

  .invoice-po-del-btn {
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

  .invoice-po-del-btn:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .invoice-po-del-btn i {
    font-size: 15px;
    line-height: 1;
  }

  .invoice-po-total-box {
    margin-top: 14px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    background: #FFFFFF;
    overflow: hidden;
  }

  .invoice-po-total-box .table {
    margin: 0;
  }

  .invoice-po-total-box thead th,
  .invoice-po-total-box tbody td,
  .invoice-po-total-box tfoot td {
    border-color: #E2E8F0;
    background: transparent;
    padding: 10px 12px;
    font-size: 13px;
  }

  .invoice-po-total-box .invoice-po-total-label {
    text-align: right;
    color: #334155;
    font-weight: 600;
  }

  .invoice-po-total-box .invoice-po-total-value {
    color: #0F172A;
    font-weight: 600;
  }

  .invoice-po-grand {
    font-size: 16px !important;
    font-weight: 700 !important;
    color: #0F172A !important;
  }

  .invoice-po-price-check {
    margin-top: 16px;
    background: #EFF6FF;
    border: 1px solid #DBEAFE;
    border-radius: 10px;
    padding: 14px 14px 12px;
  }

  .invoice-po-price-check-title {
    margin: 0 0 10px;
    font-size: 14px;
    font-weight: 600;
    color: #1D4ED8;
  }

  .invoice-po-price-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
  }

  .invoice-po-price-field {
    margin: 0;
  }

  .invoice-po-price-field .form-label {
    display: block;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #334155;
  }

  .invoice-po-price-field .form-control {
    width: 100%;
    height: 38px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0F172A;
    font-size: 12px;
    padding: 0 10px;
  }

  .invoice-po-price-field .form-control:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .invoice-po-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  .invoice-po-submit-btn,
  .invoice-po-back-btn {
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
  }

  .invoice-po-submit-btn {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .invoice-po-submit-btn:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .invoice-po-back-btn {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .invoice-po-back-btn:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .invoice-po-submit-btn i,
  .invoice-po-back-btn i,
  .invoice-po-add-item i,
  .invoice-po-del-btn i {
    font-size: 15px;
    line-height: 1;
  }

  @media (max-width: 767.98px) {
    .invoice-po-card {
      margin-top: 12px;
      border-radius: 12px;
    }

    .invoice-po-header,
    .invoice-po-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .invoice-po-grid,
    .invoice-po-price-grid {
      grid-template-columns: 1fr;
    }

    .invoice-po-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .invoice-po-submit-btn,
    .invoice-po-back-btn {
      width: 100%;
    }
  }
</style>

        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Invoice PO'])
                    </div>  
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="invoice-po-shell">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="invoice-po-card">
                        <div class="invoice-po-header">
                            <h5>Form Tambah Invoice dari Purchase Order</h5>
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

                            <form action="{{ route('invoices.store-po') }}" method="POST" id="invoiceForm">
                                @csrf

                                <div class="invoice-po-grid">
                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label">Nomor Invoice</label>
                                        <input type="text" class="invoice-po-form-control" value="INV/{{ date('Y') }}/[SEQ]/[Bulan Roman]" disabled>
                                    </div>

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
                                                    {{ old('purchase_order_id') == $po->id ? 'selected' : '' }}>
                                                    {{ $po->no_po }} - {{ $po->jenis_po }} (Sisa: {{ $po->remainingQty() }} unit)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('purchase_order_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="invoice-po-small">Hanya menampilkan PO dengan status Open</small>
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="no_so">Nomor SO</label>
                                        <input type="text" name="no_so" id="no_so" class="invoice-po-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so') }}">
                                        @error('no_so')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="manual_invoice_part">No Odoo <span class="text-muted">(Opsional)</span></label>
                                        <input type="text" name="manual_invoice_part" id="manual_invoice_part" class="invoice-po-form-control @error('manual_invoice_part') is-invalid @enderror" value="{{ old('manual_invoice_part') }}" placeholder="Isi nomor Odoo (contoh: 0230)">
                                        @error('manual_invoice_part')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="invoice-po-small">Nomor Odoo akan disisipkan ke format nomor invoice.</small>
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-po-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" required>
                                        @error('tanggal_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="invoice-po-grid" style="margin-bottom: 0;">
                                    <div class="invoice-po-field" style="grid-column: 1 / 2;">
                                        <label class="invoice-po-label" for="tipe_bisnis">Tipe Bisnis Internal <span class="text-muted">(Opsional)</span></label>
                                        <input type="text" name="tipe_bisnis" id="tipe_bisnis" class="invoice-po-form-control @error('tipe_bisnis') is-invalid @enderror" value="{{ old('tipe_bisnis') }}" placeholder="Contoh: Retail, Wholesale, Dropship">
                                        @error('tipe_bisnis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="invoice-po-small">Tipe bisnis internal untuk transaksi ini. Akan ditampilkan di invoice.</small>
                                    </div>
                                </div>

                                <div id="poInfo" class="invoice-po-info d-none" style="margin-top: 18px;">
                                    <strong>Info PO:</strong><br>
                                    <span id="poInfoText"></span>
                                </div>

                                <div class="invoice-po-divider"></div>

                                <div class="invoice-po-section-head">
                                    <h5 class="invoice-po-section-title">Item Invoice</h5>
                                    <button type="button" class="invoice-po-add-item" id="addItemBtn">
                                        <i class="ti ti-plus"></i> Tambah Item
                                    </button>
                                </div>

                                <div class="invoice-po-table-wrap">
                                    <table class="table invoice-po-items-table table-bordered" id="itemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Tanggal</th>
                                                <th width="25%">Nama Item</th>
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
                                                <td colspan="2"><strong id="grandTotal" class="invoice-po-grand">Rp 0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @error('items')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <div class="invoice-po-price-check">
                                    <div class="invoice-po-price-check-title">Fitur Cek Harga Jual PO</div>
                                    <div class="invoice-po-price-grid">
                                        <div class="invoice-po-price-field">
                                            <label class="form-label">Harga Satuan</label>
                                            <input type="number" id="cek_harga_satuan" class="form-control" min="0" step="0.01" placeholder="Masukkan harga satuan">
                                        </div>
                                        <div class="invoice-po-price-field">
                                            <label class="form-label">Output 11%</label>
                                            <input type="text" id="cek_output_11" class="form-control" value="Rp 0" readonly>
                                        </div>
                                        <div class="invoice-po-price-field">
                                            <label class="form-label">Hasil Akhir</label>
                                            <input type="text" id="cek_hasil_akhir" class="form-control" value="Rp 0" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-po-actions">
                                    <button type="submit" class="invoice-po-submit-btn">
                                        <i class="ti ti-device-floppy"></i> Simpan Invoice
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="invoice-po-back-btn">
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
let remainingQty = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Handle PO selection
    const poSelect = document.getElementById('purchase_order_id');
    const poInfo = document.getElementById('poInfo');
    const poInfoText = document.getElementById('poInfoText');

    poSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const noPo = selectedOption.dataset.noPo;
            const jenisPo = selectedOption.dataset.jenisPo;
            const totalQty = selectedOption.dataset.totalQty;
            const usedQty = selectedOption.dataset.usedQty;
            remainingQty = parseInt(selectedOption.dataset.remainingQty);
            
            poInfoText.innerHTML = `
                <strong>No PO:</strong> ${noPo}<br>
                <strong>Jenis PO:</strong> ${jenisPo}<br>
                <strong>Total Qty:</strong> ${totalQty}<br>
                <strong>Used Qty:</strong> ${usedQty}<br>
                <strong>Sisa Qty:</strong> ${remainingQty}
            `;
            poInfo.classList.remove('d-none');
        } else {
            poInfo.classList.add('d-none');
            remainingQty = 0;
        }
    });

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

        // Validate total qty
        const totalQty = calculateTotalQty();
        if (remainingQty > 0 && totalQty > remainingQty) {
            e.preventDefault();
            alert(`Total qty invoice (${totalQty}) melebihi sisa qty PO (${remainingQty})!`);
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
            <input type="text" name="items[${itemIndex}][unit]" class="form-control form-control-sm" placeholder="Unit" required>
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

    const totalPpn = totalSubtotal * 0.11;
    const grandTotal = totalSubtotal + totalPpn;

    document.getElementById('totalPpn').textContent = formatRupiah(totalPpn);
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);

    // Show warning if exceeds remaining qty
    if (remainingQty > 0 && totalQty > remainingQty) {
        document.getElementById('totalQty').classList.add('text-danger');
    } else {
        document.getElementById('totalQty').classList.remove('text-danger');
    }
}

function calculateTotalQty() {
    const rows = document.querySelectorAll('#itemsBody tr');
    let total = 0;
    rows.forEach(row => {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        total += qty;
    });
    return total;
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
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
