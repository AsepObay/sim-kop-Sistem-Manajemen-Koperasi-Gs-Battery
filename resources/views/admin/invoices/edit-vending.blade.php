@extends('layouts.template')

@section('title', 'Edit Invoice Mesin Vending')

@section('main-content')
<style>
  .edit-invoice-page {
    background: #F8FAFC;
    padding: 18px 0 32px;
  }

  .edit-invoice-page .invoice-vending-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .edit-invoice-page .invoice-vending-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    max-width: 1080px;
    margin: 18px auto 0;
  }

  .edit-invoice-page .invoice-vending-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-vending-header h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-vending-body {
    padding: 20px 24px 24px;
  }

  .edit-invoice-page .invoice-vending-alerts {
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-vending-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
    margin-bottom: 18px;
  }

  .edit-invoice-page .invoice-vending-field {
    margin-bottom: 0;
  }

  .edit-invoice-page .invoice-vending-label {
    display: inline-block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .edit-invoice-page .invoice-vending-label .text-danger {
    color: #DC2626;
  }

  .edit-invoice-page .invoice-vending-form-control {
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

  .edit-invoice-page .invoice-vending-form-control:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-vending-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 8px 0 18px;
  }

  .edit-invoice-page .invoice-vending-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
  }

  .edit-invoice-page .invoice-vending-section-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .edit-invoice-page .invoice-vending-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    overflow: hidden;
  }

  .edit-invoice-page .invoice-vending-items-table {
    width: 100%;
    min-width: 860px;
    margin: 0;
    border-collapse: collapse;
  }

  .edit-invoice-page .invoice-vending-items-table thead th,
  .edit-invoice-page .invoice-vending-items-table tfoot td {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    border-color: #E2E8F0;
    padding: 10px 10px;
    vertical-align: middle;
  }

  .edit-invoice-page .invoice-vending-items-table tbody td,
  .edit-invoice-page .invoice-vending-items-table tfoot td {
    padding: 10px 10px;
    font-size: 12px;
    border-color: #E2E8F0;
    vertical-align: middle;
    color: #334155;
  }

  .edit-invoice-page .invoice-vending-items-table tbody tr {
    background: #FFFFFF;
  }

  .edit-invoice-page .invoice-vending-items-table tbody tr:hover {
    background: #F8FAFC;
  }

  .edit-invoice-page .invoice-vending-row-input {
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

  .edit-invoice-page .invoice-vending-row-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .edit-invoice-page .invoice-vending-btn {
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

  .edit-invoice-page .invoice-vending-btn-primary {
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
  }

  .edit-invoice-page .invoice-vending-btn-primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-vending-btn-secondary {
    background: #FFFFFF;
    color: #475569;
    border: 1px solid #CBD5E1;
  }

  .edit-invoice-page .invoice-vending-btn-secondary:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .edit-invoice-page .invoice-vending-btn-danger {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    border: 1px solid rgba(220, 38, 38, 0.12);
    background: #FEF2F2;
    color: #DC2626;
  }

  .edit-invoice-page .invoice-vending-btn-danger:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .edit-invoice-page .invoice-vending-header small {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #64748B;
    line-height: 1.5;
  }

  .edit-invoice-page .invoice-vending-card {
    max-width: 1120px;
  }

  .edit-invoice-page .invoice-vending-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    flex-wrap: wrap;
  }

  @media (max-width: 767.98px) {
    .edit-invoice-page .invoice-vending-card {
      margin-top: 12px;
      border-radius: 12px;
    }

    .edit-invoice-page .invoice-vending-header,
    .edit-invoice-page .invoice-vending-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .edit-invoice-page .invoice-vending-grid {
      grid-template-columns: 1fr;
    }

    .edit-invoice-page .invoice-vending-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .edit-invoice-page .invoice-vending-btn {
      width: 100%;
    }
  }
</style>

        <div class="edit-invoice-page">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            @include('layouts.dashboard-breadcrumb', ['current' => 'Edit Invoice Mesin Vending'])
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-vending-shell">
            <div class="row mx-0">
                <div class="col-12">
                    <div class="invoice-vending-card">
                        <div class="invoice-vending-header">
                            <h5>Edit Tagihan Vending</h5>
                            <small>Perbarui informasi transaksi vending.</small>
                        </div>
                        <div class="invoice-vending-body">
                            <div class="invoice-vending-alerts">
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

                            <form action="{{ route('invoices.update', $invoice->id) }}?return={{ urlencode($returnUrl) }}" method="POST" id="invoiceVendingForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="return" value="{{ $returnUrl }}">
                                <input type="hidden" name="items_json" id="items_json" value="">

                                <div class="invoice-vending-grid">
                                    <div class="invoice-vending-field">
                                        <label class="invoice-vending-label" for="no_invoice">Nomor Invoice <span class="text-danger">*</span></label>
                                        <input type="text" name="no_invoice" id="no_invoice" class="invoice-vending-form-control @error('no_invoice') is-invalid @enderror" value="{{ old('no_invoice', $invoice->no_invoice) }}" required>
                                        @error('no_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="invoice-vending-field">
                                        <label class="invoice-vending-label" for="tanggal_invoice">Tanggal Invoice <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_invoice" id="tanggal_invoice" class="invoice-vending-form-control @error('tanggal_invoice') is-invalid @enderror" value="{{ old('tanggal_invoice', optional($invoice->tanggal_invoice)->format('Y-m-d')) }}" required>
                                        @error('tanggal_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="invoice-vending-divider"></div>

                                <div class="invoice-vending-section-head">
                                    <h5 class="invoice-vending-section-title">Item Invoice</h5>
                                    <button type="button" class="invoice-vending-btn invoice-vending-btn-primary" id="addItemBtn">
                                        <i class="ti ti-plus"></i> Tambah Baris
                                    </button>
                                </div>

                                <div class="invoice-vending-table-wrap">
                                    <table class="invoice-vending-items-table" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="18%">Tanggal</th>
                                                <th width="32%">No Faktur</th>
                                                <th width="20%">Total</th>
                                                <th width="20%">Revenue Sharing 5%</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody"></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Total Nilai:</strong></td>
                                                <td><strong id="totalNilai">Rp 0</strong></td>
                                                <td colspan="2"><strong id="totalRevenue">Rp 0</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>PPN 11%:</strong></td>
                                                <td colspan="2"><strong id="totalPpn">Rp 0</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>PPh -10%:</strong></td>
                                                <td colspan="2"><strong id="totalPph">Rp 0</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                                <td colspan="2"><strong id="grandTotal" class="text-primary">Rp 0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="invoice-vending-actions">
                                    <button type="submit" class="invoice-vending-btn invoice-vending-btn-primary">
                                        <i class="ti ti-device-floppy"></i> Update Invoice
                                    </button>
                                    <a href="{{ $returnUrl }}" class="invoice-vending-btn invoice-vending-btn-secondary">
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
            'no_faktur' => $item->nama_item,
            'total' => $item->harga,
            'revenue_sharing' => $item->subtotal,
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

    document.getElementById('invoiceVendingForm').addEventListener('submit', function (e) {
        const rows = document.querySelectorAll('#itemsBody tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 item.');
            return false;
        }

        const payload = Array.from(rows).map(row => ({
            tanggal_item: row.querySelector('input[name*="[tanggal_item]"]')?.value || '',
            no_faktur: row.querySelector('input[name*="[no_faktur]"]')?.value || '',
            harga: row.querySelector('input[name*="[harga]"]')?.value || 0,
            revenue_sharing: row.querySelector('input[name*="[revenue_sharing]"]')?.value || 0,
        }));

        const validRows = payload.filter(item => item.no_faktur && Number(item.harga) >= 0);
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
    const today = new Date().toISOString().split('T')[0];

    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="text-center row-number"></td>
        <td>
            <input type="date" name="items[${itemIndex}][tanggal_item]" class="form-control form-control-sm" value="${item?.tanggal_item || today}" required>
        </td>
        <td>
            <input type="text" name="items[${itemIndex}][no_faktur]" class="form-control form-control-sm" value="${item?.no_faktur || ''}" placeholder="No faktur" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][harga]" class="form-control form-control-sm item-total" min="0" step="0.01" value="${item?.harga || 0}" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm item-revenue-display" value="Rp 0" readonly>
            <input type="hidden" name="items[${itemIndex}][revenue_sharing]" class="item-revenue" value="${item?.revenue_sharing || 0}">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="ti ti-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    itemIndex++;

    row.querySelector('.item-total').addEventListener('input', () => calculateRowRevenue(row));
    row.querySelector('.remove-item').addEventListener('click', function () {
        row.remove();
        refreshRowNumbers();
        calculateTotals();
    });

    calculateRowRevenue(row);
    refreshRowNumbers();
}

function calculateRowRevenue(row) {
    const total = parseFloat(row.querySelector('.item-total').value) || 0;
    const revenue = total * 0.05;
    row.querySelector('.item-revenue').value = revenue.toFixed(2);
    row.querySelector('.item-revenue-display').value = formatRupiah(revenue);
    calculateTotals();
}

function refreshRowNumbers() {
    document.querySelectorAll('#itemsBody tr').forEach((row, idx) => {
        row.querySelector('.row-number').textContent = idx + 1;
    });
}

function calculateTotals() {
    let totalNilai = 0;
    let totalRevenue = 0;

    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const total = parseFloat(row.querySelector('.item-total').value) || 0;
        const revenue = parseFloat(row.querySelector('.item-revenue').value) || 0;
        totalNilai += total;
        totalRevenue += revenue;
    });

    document.getElementById('totalNilai').textContent = formatRupiah(totalNilai);
    document.getElementById('totalRevenue').textContent = formatRupiah(totalRevenue);

    const totalPpn = totalRevenue * 0.11;
    const totalPph = totalRevenue * 0.10;
    const grandTotal = totalRevenue + totalPpn - totalPph;

    document.getElementById('totalPpn').textContent = formatRupiah(totalPpn);
    document.getElementById('totalPph').textContent = '- ' + formatRupiah(totalPph);
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
}

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount);
}
</script>
@endpush
@endsection
