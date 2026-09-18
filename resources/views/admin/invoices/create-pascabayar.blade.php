@extends('layouts.template')

@section('title', 'Tambah Invoice Tagihan Pascabayar')

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
    grid-template-columns: repeat(4, minmax(0, 1fr));
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

  .invoice-po-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .invoice-po-items-table,
  .invoice-po-options-table {
    width: 100%;
    min-width: 760px;
    margin: 0;
    border-collapse: collapse;
  }

  .invoice-po-items-table thead th,
  .invoice-po-options-table thead th,
  .invoice-po-items-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .invoice-po-items-table tbody td,
  .invoice-po-options-table tbody td,
  .invoice-po-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .invoice-po-items-table tbody tr,
  .invoice-po-options-table tbody tr {
    background: #FFFFFF;
  }

  .invoice-po-items-table tbody tr:hover,
  .invoice-po-options-table tbody tr:hover {
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

  .invoice-po-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 38px;
    padding: 0 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
  }

  .invoice-po-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .invoice-po-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .invoice-po-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .invoice-po-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .invoice-po-btn-success {
    background: #16A34A;
    color: #FFFFFF;
    border: 1px solid #16A34A;
  }

  .invoice-po-btn-success:hover {
    background: #15803D;
    color: #FFFFFF;
    text-decoration: none;
  }

  .invoice-po-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .invoice-po-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .invoice-po-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  .invoice-po-inline-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 12px;
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

    .invoice-po-grid {
      grid-template-columns: 1fr;
    }

    .invoice-po-actions,
    .invoice-po-inline-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .invoice-po-btn,
    .invoice-po-btn-primary,
    .invoice-po-btn-secondary,
    .invoice-po-btn-success {
      width: 100%;
    }
  }
</style>

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Invoice Tagihan Pascabayar'])
                    </div>
                </div>
            </div>
        </div>

        <div class="invoice-po-shell">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="invoice-po-card">
                        <div class="invoice-po-header">
                            <h5>Form Tambah Invoice Tagihan Pascabayar</h5>
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

                            <form action="{{ route('invoices.store-pascabayar') }}" method="POST" id="invoiceForm">
                                @csrf

                                <div class="invoice-po-grid">
                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label">Nomor Invoice</label>
                                        <input type="text" class="invoice-po-form-control" value="INV/2026/[SEQ]/PASCA/[Bulan]" disabled>
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="no_po_manual">Nomor PO <span class="text-danger">*</span></label>
                                        <input type="text" name="no_po_manual" id="no_po_manual" class="invoice-po-form-control @error('no_po_manual') is-invalid @enderror" value="{{ old('no_po_manual') }}" required placeholder="Isi manual">
                                        @error('no_po_manual')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="no_so">Nomor SO <span class="text-danger">*</span></label>
                                        <input type="text" name="no_so" id="no_so" class="invoice-po-form-control @error('no_so') is-invalid @enderror" value="{{ old('no_so') }}" required placeholder="Isi manual">
                                        @error('no_so')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="tipe_bisnis">Tipe Bisnis Internal <span class="text-muted">(Opsional)</span></label>
                                        <input type="text" name="tipe_bisnis" id="tipe_bisnis" class="invoice-po-form-control @error('tipe_bisnis') is-invalid @enderror" value="{{ old('tipe_bisnis') }}" placeholder="Contoh: Retail, Wholesale, Dropship">
                                        @error('tipe_bisnis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-po-field">
                                        <label class="invoice-po-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-po-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" required>
                                        @error('tanggal_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="invoice-po-info">
                                    <i class="ti ti-info-circle"></i> <strong>Info:</strong> Tagihan Pascabayar diproses tanpa PPN.
                                </div>

                                <div class="invoice-po-divider"></div>

                                <div class="invoice-po-section-head">
                                    <h5 class="invoice-po-section-title">Daftar No HP Absolute</h5>
                                </div>

                                <div class="invoice-po-table-wrap">
                                    <table class="invoice-po-options-table" aria-label="Daftar nomor Pascabayar">
                                        <thead>
                                            <tr>
                                                <th width="8%">No</th>
                                                <th width="32%">No HP</th>
                                                <th>Nama</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="optionRowsBody">
                                            @foreach($pascabayarItemRows as $idx => $row)
                                                <tr>
                                                    <td class="row-no">{{ $idx + 1 }}</td>
                                                    <td>
                                                        <input type="text" name="item_options[{{ $idx }}][phone]" class="invoice-po-row-input" value="{{ $row['phone'] }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="item_options[{{ $idx }}][name]" class="invoice-po-row-input" value="{{ $row['name'] }}" required>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="invoice-po-btn invoice-po-btn-danger remove-option-row"><i class="ti ti-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="invoice-po-inline-actions">
                                    <button type="button" class="invoice-po-btn invoice-po-btn-secondary" id="addOptionRowBtn">
                                        <i class="ti ti-plus"></i> Tambah Nomor
                                    </button>
                                    <button type="button" class="invoice-po-btn invoice-po-btn-success" id="saveOptionRowsBtn">
                                        <i class="ti ti-device-floppy"></i> Simpan Daftar Nomor
                                    </button>
                                </div>

                                <div class="invoice-po-divider" style="margin-top: 20px;"></div>

                                <div class="invoice-po-section-head">
                                    <h5 class="invoice-po-section-title">Item Invoice</h5>
                                    <button type="button" class="invoice-po-btn invoice-po-btn-primary" id="addItemBtn">
                                        <i class="ti ti-plus"></i> Tambah Item
                                    </button>
                                </div>

                                <div class="invoice-po-table-wrap">
                                    <table class="table invoice-po-items-table table-bordered" id="itemsTable">
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
                                        <tbody id="itemsBody"></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="invoice-po-total-label"><strong>Total Qty:</strong></td>
                                                <td><strong id="totalQty">0</strong></td>
                                                <td colspan="2" class="invoice-po-total-label"><strong>Total Tagihan:</strong></td>
                                                <td colspan="2" class="invoice-po-total-value"><strong id="grandTotal">Rp 0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="invoice-po-actions">
                                    <button type="submit" class="invoice-po-btn invoice-po-btn-primary">
                                        <i class="ti ti-device-floppy"></i> Simpan Invoice
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="invoice-po-btn invoice-po-btn-secondary">
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
const pascabayarItemOptions = @json($pascabayarItemOptions ?? []);
const updateOptionsUrl = @json(route('invoices.update-pascabayar-options'));
const csrfToken = @json(csrf_token());
let optionRowIndex = {{ count($pascabayarItemRows ?? []) }};

function fireSweetAlert(icon, title, text) {
    const show = () => {
        Swal.fire({
            icon,
            title,
            text,
            confirmButtonText: 'OK',
            confirmButtonColor: icon === 'success' ? '#28a745' : '#dc3545',
        });
    };

    if (typeof Swal !== 'undefined') {
        show();
        return;
    }

    const existingLoader = document.getElementById('swal-loader-script');
    if (!existingLoader) {
        const script = document.createElement('script');
        script.id = 'swal-loader-script';
        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        script.onload = () => {
            if (typeof Swal !== 'undefined') show();
            else alert(text || title);
        };
        script.onerror = () => alert(text || title);
        document.head.appendChild(script);
    } else {
        setTimeout(() => {
            if (typeof Swal !== 'undefined') show();
            else alert(text || title);
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        fireSweetAlert('success', 'Berhasil', @json(session('success')));
    @endif

    addItemRow();

    document.getElementById('addItemBtn').addEventListener('click', function() {
        addItemRow();
    });

    document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        const rows = document.getElementById('itemsBody').querySelectorAll('tr');
        if (rows.length === 0) {
            e.preventDefault();
            showInlineAlert('Minimal harus ada 1 item!', 'danger');
        }
    });

    const addOptionRowBtn = document.getElementById('addOptionRowBtn');
    if (addOptionRowBtn) {
        addOptionRowBtn.addEventListener('click', addOptionRow);
    }

    const saveOptionRowsBtn = document.getElementById('saveOptionRowsBtn');
    if (saveOptionRowsBtn) {
        saveOptionRowsBtn.addEventListener('click', submitOptionRowsUpdate);
    }

    bindOptionRowActions();
});

function addOptionRow() {
    const tbody = document.getElementById('optionRowsBody');
    if (!tbody) return;

    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="row-no"></td>
        <td><input type="text" name="item_options[${optionRowIndex}][phone]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="item_options[${optionRowIndex}][name]" class="form-control form-control-sm" required></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-option-row"><i class="ti ti-trash"></i></button></td>
    `;

    tbody.appendChild(row);
    optionRowIndex++;
    bindOptionRowActions();
    refreshOptionRowNumbers();
}

function submitOptionRowsUpdate() {
    const rows = document.querySelectorAll('#optionRowsBody tr');
    if (rows.length === 0) {
        showInlineAlert('Minimal 1 nomor harus tersedia.', 'danger');
        return;
    }

    const dynamicForm = document.createElement('form');
    dynamicForm.method = 'POST';
    dynamicForm.action = updateOptionsUrl;
    dynamicForm.style.display = 'none';

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    dynamicForm.appendChild(csrfInput);

    rows.forEach((row, idx) => {
        const phone = row.querySelector('input[name*="[phone]"]')?.value?.trim() || '';
        const name = row.querySelector('input[name*="[name]"]')?.value?.trim() || '';

        const phoneInput = document.createElement('input');
        phoneInput.type = 'hidden';
        phoneInput.name = `item_options[${idx}][phone]`;
        phoneInput.value = phone;
        dynamicForm.appendChild(phoneInput);

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `item_options[${idx}][name]`;
        nameInput.value = name;
        dynamicForm.appendChild(nameInput);
    });

    document.body.appendChild(dynamicForm);
    dynamicForm.submit();
}

function bindOptionRowActions() {
    document.querySelectorAll('.remove-option-row').forEach((btn) => {
        if (btn.dataset.bound === '1') return;
        btn.dataset.bound = '1';
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            if (!row) return;
            row.remove();
            refreshOptionRowNumbers();
        });
    });
}

function refreshOptionRowNumbers() {
    document.querySelectorAll('#optionRowsBody .row-no').forEach((cell, idx) => {
        cell.textContent = idx + 1;
    });
}

function showInlineAlert(message, type = 'danger') {
    fireSweetAlert(
        type === 'success' ? 'success' : 'warning',
        type === 'success' ? 'Berhasil' : 'Perhatian',
        message
    );
}

function addItemRow() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    const optionsHtml = buildItemOptions();
    row.innerHTML = `
        <td class="text-center row-number">${document.querySelectorAll('#itemsBody tr').length + 1}</td>
        <td>
            <input type="date" name="items[${itemIndex}][tanggal_item]" class="form-control form-control-sm" value="${new Date().toISOString().split('T')[0]}" required>
        </td>
        <td>
            <select name="items[${itemIndex}][nama_item]" class="form-select form-select-sm" required>
                ${optionsHtml}
            </select>
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

    row.querySelector('.item-qty').addEventListener('input', () => calculateRowSubtotal(row));
    row.querySelector('.item-harga').addEventListener('input', () => calculateRowSubtotal(row));
    row.querySelector('.remove-item').addEventListener('click', function() {
        row.remove();
        refreshItemRowNumbers();
        calculateTotals();
    });

    calculateRowSubtotal(row);
}

function refreshItemRowNumbers() {
    document.querySelectorAll('#itemsBody tr').forEach((row, idx) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = idx + 1;
        }
    });
}

function buildItemOptions(selected = '') {
    let html = '<option value="">Pilih No HP / Nama</option>';

    pascabayarItemOptions.forEach((option) => {
        const isSelected = option === selected ? 'selected' : '';
        html += `<option value="${escapeHtml(option)}" ${isSelected}>${escapeHtml(option)}</option>`;
    });

    return html;
}

function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
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
    let grandTotal = 0;

    rows.forEach(row => {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
        totalQty += qty;
        grandTotal += qty * harga;
    });

    document.getElementById('totalQty').textContent = totalQty;
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
