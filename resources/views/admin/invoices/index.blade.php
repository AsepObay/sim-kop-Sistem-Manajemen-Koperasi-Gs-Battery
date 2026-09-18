@extends('layouts.template')

@section('title', 'Daftar Invoice')

@section('main-content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                @include('layouts.dashboard-breadcrumb', ['current' => 'Daftar Invoice'])
            </div>
        </div>
    </div>
</div>

<style>
    .invoice-index-shell {
        padding: 0 0 20px;
    }

    .invoice-index-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .invoice-index-card-header {
        padding: 20px 22px 16px;
        border-bottom: 1px solid #E2E8F0;
        background: #FFFFFF;
    }

    .invoice-index-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .invoice-index-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .invoice-index-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #0F172A;
        line-height: 1.4;
    }

    .invoice-index-subtitle {
        margin: 0;
        font-size: 12px;
        color: #64748B;
    }

    .invoice-index-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .invoice-index-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 14px;
        height: 40px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .invoice-index-btn i {
        font-size: 16px;
    }

    .invoice-index-btn-primary {
        background: #2563EB;
        color: #FFFFFF;
        border-color: #2563EB;
    }

    .invoice-index-btn-primary:hover {
        background: #1D4ED8;
        color: #FFFFFF;
    }

    .invoice-index-btn-secondary {
        background: #FFFFFF;
        color: #475569;
        border-color: #CBD5E1;
    }

    .invoice-index-btn-secondary:hover {
        background: #F8FAFC;
        color: #0F172A;
    }

    .invoice-index-dropdown {
        position: relative;
    }

    .invoice-index-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 220px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        padding: 8px;
        display: none;
        z-index: 20;
    }

    .invoice-index-dropdown.open .invoice-index-dropdown-menu {
        display: block;
    }

    .invoice-index-dropdown-link {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 10px 12px;
        color: #334155;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }

    .invoice-index-dropdown-link:hover {
        background: #F8FAFC;
        color: #0F172A;
        text-decoration: none;
    }

    .invoice-index-body {
        padding: 18px 22px 20px;
    }

    .invoice-index-filter-wrap {
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        background: #F8FAFC;
        padding: 14px;
    }

    .invoice-index-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .invoice-index-toolbar-field {
        min-width: 170px;
        flex: 1 1 180px;
    }

    .invoice-index-toolbar-field.search-field {
        flex: 1 1 280px;
    }

    .invoice-index-toolbar-field .form-control,
    .invoice-index-toolbar-field .form-select {
        width: 100%;
        height: 40px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        background: #FFFFFF;
        color: #0F172A;
        font-size: 13px;
        padding: 0 12px;
    }

    .invoice-index-toolbar-field .form-control:focus,
    .invoice-index-toolbar-field .form-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        outline: none;
    }

    .invoice-index-toolbar-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
        flex-wrap: wrap;
    }

    .invoice-index-advanced-toggle {
        background: transparent;
        border: 1px solid #CBD5E1;
        color: #475569;
        border-radius: 8px;
        height: 40px;
        padding: 0 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .invoice-index-advanced-filter {
        display: none;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #E2E8F0;
    }

    .invoice-index-advanced-filter.open {
        display: block;
    }

    .invoice-index-advanced-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .invoice-index-form-label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        color: #475569;
        font-weight: 500;
    }

    .invoice-index-filter-actions {
        display: flex;
        align-items: end;
        gap: 8px;
        height: 100%;
        flex-wrap: wrap;
    }

    .invoice-index-action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
        margin-bottom: 14px;
    }

    .invoice-index-download-btn {
        background: #FFFFFF;
        color: #475569;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        height: 38px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .invoice-index-download-btn:hover {
        background: #F8FAFC;
        color: #0F172A;
    }

    .invoice-index-help-text {
        font-size: 12px;
        color: #64748B;
    }

    .invoice-index-table-wrap {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        overflow: hidden;
    }

    .invoice-index-table {
        width: 100%;
        min-width: 1160px;
        border-collapse: collapse;
        margin: 0;
    }

    .invoice-index-table thead th {
        background: #F8FAFC;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        border-color: #E2E8F0;
        padding: 12px 10px;
        vertical-align: middle;
    }

    .invoice-index-table tbody td {
        padding: 12px 10px;
        font-size: 13px;
        color: #334155;
        border-color: #E2E8F0;
        vertical-align: middle;
        background: #FFFFFF;
    }

    .invoice-index-table tbody tr:hover td {
        background: #F8FAFC;
    }

    .invoice-index-table tbody td strong {
        color: #0F172A;
    }

    .invoice-index-table a {
        color: #2563EB;
        text-decoration: none;
    }

    .invoice-index-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 88px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .invoice-index-badge--nonpo {
        background: #F1F5F9;
        color: #475569;
    }

    .invoice-index-badge--po {
        background: #EFF6FF;
        color: #2563EB;
    }

    .invoice-index-badge--other {
        background: #F1F5F9;
        color: #475569;
    }

    .invoice-index-action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .invoice-index-icon-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 8px;
        background: transparent;
        color: #64748B;
        transition: all 0.2s ease;
        padding: 0;
    }

    .invoice-index-icon-btn i {
        font-size: 16px;
    }

    .invoice-index-icon-btn:hover {
        background: #F1F5F9;
        color: #2563EB;
    }

    .invoice-index-icon-btn.delete:hover {
        background: #FEE2E2;
        color: #DC2626;
    }

    .invoice-index-empty {
        text-align: center;
        padding: 42px 18px 28px;
    }

    .invoice-index-empty-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #F8FAFC;
        color: #64748B;
        font-size: 20px;
        margin-bottom: 14px;
    }

    .invoice-index-empty h6 {
        margin: 0 0 6px;
        font-size: 16px;
        color: #0F172A;
        font-weight: 600;
    }

    .invoice-index-empty p {
        margin: 0;
        font-size: 13px;
        color: #64748B;
    }

    .invoice-index-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px 10px 0;
        margin-top: 12px;
    }

    .invoice-index-footer small {
        font-size: 12px;
        color: #64748B;
    }

    .invoice-index-pagination .pagination {
        margin: 0;
        gap: 6px;
    }

    .invoice-index-pagination .page-link {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        color: #475569;
    }

    .invoice-index-pagination .page-item.active .page-link {
        background: #2563EB;
        border-color: #2563EB;
        color: #FFFFFF;
    }

    @media (max-width: 767.98px) {
        .invoice-index-header-row,
        .invoice-index-toolbar,
        .invoice-index-toolbar-actions,
        .invoice-index-action-row,
        .invoice-index-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .invoice-index-header-actions {
            width: 100%;
            margin-left: 0;
        }

        .invoice-index-dropdown {
            width: 100%;
        }

        .invoice-index-btn,
        .invoice-index-advanced-toggle,
        .invoice-index-download-btn {
            width: 100%;
        }

        .invoice-index-advanced-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="invoice-index-shell">
    <div class="row">
        <div class="col-12">
            <div class="invoice-index-card">
                <div class="invoice-index-card-header">
                    <div class="invoice-index-header-row">
                        <div class="invoice-index-title-wrap">
                            <h5 class="invoice-index-title"><i class="ti ti-file-text" style="font-size: 20px; margin-right: 8px; vertical-align: middle;"></i>Daftar Invoice</h5>
                            <p class="invoice-index-subtitle">Kelola dan pantau seluruh invoice.</p>
                        </div>

                        <div class="invoice-index-header-actions">
                            <div class="invoice-index-dropdown" id="invoiceCreateDropdown">
                                <button type="button" class="invoice-index-btn invoice-index-btn-primary" id="invoiceCreateDropdownToggle">
                                    <i class="ti ti-plus"></i> Tambah Invoice
                                </button>
                                <div class="invoice-index-dropdown-menu">
                                    <a href="{{ route('invoices.create-po') }}" class="invoice-index-dropdown-link"><i class="ti ti-plus"></i> Tambah Invoice PO</a>
                                    <a href="{{ route('invoices.create-sementara') }}" class="invoice-index-dropdown-link"><i class="ti ti-file"></i> Tagihan Sementara</a>
                                    <a href="{{ route('invoices.create-vending') }}" class="invoice-index-dropdown-link"><i class="ti ti-plus"></i> Invoice Mesin Vending</a>
                                    <a href="{{ route('invoices.create-pulsa-modem') }}" class="invoice-index-dropdown-link"><i class="ti ti-plus"></i> Invoice Pulsa Modem</a>
                                    <a href="{{ route('invoices.create-voucher') }}" class="invoice-index-dropdown-link"><i class="ti ti-plus"></i> Invoice Voucher</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="invoice-index-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('invoices.index') }}" method="GET" class="invoice-index-filter-wrap">
                        <div class="invoice-index-toolbar">
                            <div class="invoice-index-toolbar-field">
                                <label class="form-label visually-hidden" for="business_internal">Bisnis Internal</label>
                                <select id="business_internal" name="business_internal" class="form-select">
                                    <option value="">Semua Bisnis</option>
                                    @foreach($businessOptions as $business)
                                        <option value="{{ $business }}" {{ $businessFilter === $business ? 'selected' : '' }}>{{ $business }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="invoice-index-toolbar-field search-field">
                                <label class="form-label visually-hidden" for="search">Cari Invoice</label>
                                <input id="search" type="text" name="search" class="form-control" placeholder="Cari Invoice..." value="{{ $search ?? '' }}">
                            </div>

                            <div class="invoice-index-toolbar-actions">
                                <button type="button" class="invoice-index-advanced-toggle" id="advancedFilterToggle">
                                    <i class="ti ti-filter"></i> Filter Lanjutan
                                </button>
                                <button type="submit" class="invoice-index-btn invoice-index-btn-primary">
                                    <i class="ti ti-search"></i> Filter
                                </button>
                            </div>
                        </div>

                        <div class="invoice-index-advanced-filter" id="advancedFilterPanel">
                            <div class="invoice-index-advanced-grid">
                                <div>
                                    <label class="invoice-index-form-label" for="bulan">Filter Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $monthFilter ?? '' }}">
                                </div>
                                <div>
                                    <label class="invoice-index-form-label" for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ $dateFrom ?? '' }}">
                                </div>
                                <div>
                                    <label class="invoice-index-form-label" for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $dateTo ?? '' }}">
                                </div>
                                <div>
                                    <label class="invoice-index-form-label" for="per_page">Tampilkan</label>
                                    <select id="per_page" name="per_page" class="form-select">
                                        @foreach(['10','25','50','100','200','500','1000'] as $option)
                                            <option value="{{ $option }}" {{ ($perPage ?? '10') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                        <option value="all" {{ $showAll ? 'selected' : '' }}>Semua</option>
                                    </select>
                                </div>
                            </div>

                            <div class="invoice-index-filter-actions" style="margin-top: 12px;">
                                <button type="submit" class="invoice-index-btn invoice-index-btn-primary">
                                    <i class="ti ti-filter"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('invoices.index') }}" class="invoice-index-btn invoice-index-btn-secondary">Reset Filter</a>
                                @if(!$showAll)
                                    <a href="{{ route('invoices.index', array_merge(request()->except(['page', 'per_page']), ['per_page' => 'all'])) }}" class="invoice-index-btn invoice-index-btn-secondary">
                                        <i class="ti ti-layout-list"></i> Tampilkan Semua
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="invoice-index-action-row">
                        <button id="download-selected-invoices" class="invoice-index-download-btn" type="button">
                            <i class="ti ti-download"></i> Unduh Excel Terpilih
                        </button>
                        <span class="invoice-index-help-text">Pilih invoice dengan checkbox lalu unduh.</span>
                    </div>

                    <form id="invoice-export-form" action="{{ route('invoices.export') }}" method="POST" class="d-none">
                        @csrf
                        <div id="export-selected-inputs"></div>
                    </form>

                    <div class="invoice-index-table-wrap">
                        <table class="invoice-index-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 1%;">
                                        <input type="checkbox" id="select-all-invoices">
                                    </th>
                                    <th>No</th>
                                    <th>No Invoice</th>
                                    <th>Bisnis Internal</th>
                                    <th>No SO</th>
                                    <th>No PO</th>
                                    <th>Tipe</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Total Nilai</th>
                                    <th class="text-end">Total Nilai + PPN</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $key => $invoice)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <input type="checkbox" class="select-invoice" value="{{ $invoice->id }}">
                                        </td>
                                        <td>{{ $invoices->firstItem() + $key }}</td>
                                        <td><strong>{{ $invoice->no_invoice }}</strong></td>
                                        <td>
                                            {{ $invoice->tipe_bisnis ? strtoupper($invoice->tipe_bisnis) : ($invoice->internal_business ? strtoupper($invoice->internal_business) : '-') }}
                                        </td>
                                        <td>{{ $invoice->no_so ?? '-' }}</td>
                                        <td>
                                            @if($invoice->purchaseOrder)
                                                <a href="{{ route('purchase-orders.show', $invoice->purchaseOrder->id) }}">
                                                    {{ $invoice->purchaseOrder->no_po }}
                                                </a>
                                            @else
                                                {{ $invoice->display_po }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $invoiceType = $invoice->tipe;
                                                $badgeClass = 'invoice-index-badge--other';
                                                if ($invoiceType === 'PO') {
                                                    $badgeClass = 'invoice-index-badge--po';
                                                } elseif ($invoiceType === 'NON_PO') {
                                                    $badgeClass = 'invoice-index-badge--nonpo';
                                                }
                                            @endphp
                                            <span class="invoice-index-badge {{ $badgeClass }}">{{ $invoiceType }}</span>
                                        </td>
                                        <td>{{ $invoice->tanggal_invoice->format('d/m/Y') }}</td>
                                        @php
                                            $subtotal = $invoice->items->sum('subtotal');
                                            $hasPPN = in_array($invoice->tipe, ['PO', 'NON_PO', 'MESIN_VENDING']);
                                            $totalWithPpn = $hasPPN ? $subtotal + ($subtotal * 0.11) : null;
                                        @endphp
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            @if($hasPPN)
                                                <strong>Rp {{ number_format($totalWithPpn, 0, ',', '.') }}</strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="invoice-index-action-group">
                                                @php
                                                    $detailReturnUrl = urlencode(request()->fullUrl());
                                                @endphp

                                                @if($invoice->tipe === 'NON_PO')
                                                    <a href="{{ route('invoice-non-po.show', $invoice->id) }}?return={{ $detailReturnUrl }}" class="invoice-index-icon-btn" title="Lihat Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @elseif($invoice->tipe === 'PASCABAYAR')
                                                    <a href="{{ route('invoice-pascabayar.show', $invoice->id) }}?return={{ $detailReturnUrl }}" class="invoice-index-icon-btn" title="Lihat Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('invoices.show', $invoice->id) }}?return={{ $detailReturnUrl }}" class="invoice-index-icon-btn" title="Lihat Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('invoices.edit', $invoice->id) }}?return={{ urlencode(request()->fullUrl()) }}" class="invoice-index-icon-btn" title="Edit Invoice">
                                                    <i class="ti ti-edit"></i>
                                                </a>

                                                <a href="{{ route('invoices.download', $invoice->id) }}" class="invoice-index-icon-btn" title="Download PDF">
                                                    <i class="ti ti-download"></i>
                                                </a>

                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline delete-invoice-form" data-invoice-no="{{ $invoice->no_invoice }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="invoice-index-icon-btn delete" title="Hapus Invoice">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="invoice-index-empty">
                                            <div class="invoice-index-empty-icon"><i class="ti ti-file-text"></i></div>
                                            <h6>Belum Ada Invoice</h6>
                                            <p>Belum ada data invoice yang tersedia.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="invoice-index-footer">
                        <small>
                            Menampilkan <strong>{{ $invoices->firstItem() ?? 0 }}</strong> sampai
                            <strong>{{ $invoices->lastItem() ?? 0 }}</strong> dari
                            <strong>{{ $invoices->total() }}</strong> invoice
                        </small>

                        @if(!$showAll)
                            <div class="invoice-index-pagination">
                                {{ $invoices->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const flashSuccess = @json(session('success'));
    const flashError = @json(session('error'));

    const invoiceCreateDropdown = document.getElementById('invoiceCreateDropdown');
    const invoiceCreateDropdownToggle = document.getElementById('invoiceCreateDropdownToggle');
    const advancedFilterToggle = document.getElementById('advancedFilterToggle');
    const advancedFilterPanel = document.getElementById('advancedFilterPanel');

    if (invoiceCreateDropdownToggle && invoiceCreateDropdown) {
        invoiceCreateDropdownToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            invoiceCreateDropdown.classList.toggle('open');
        });

        document.addEventListener('click', function (event) {
            if (!invoiceCreateDropdown.contains(event.target)) {
                invoiceCreateDropdown.classList.remove('open');
            }
        });
    }

    if (advancedFilterToggle && advancedFilterPanel) {
        advancedFilterToggle.addEventListener('click', function () {
            advancedFilterPanel.classList.toggle('open');
            const isOpen = advancedFilterPanel.classList.contains('open');
            advancedFilterToggle.innerHTML = isOpen
                ? '<i class="ti ti-filter"></i> Tutup Filter'
                : '<i class="ti ti-filter"></i> Filter Lanjutan';
        });
    }

    if (typeof Swal !== 'undefined') {
        if (flashSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: flashSuccess,
                timer: 1800,
                showConfirmButton: false,
            });
        } else if (flashError) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: flashError,
            });
        }
    }

    document.querySelectorAll('.delete-invoice-form').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const invoiceNo = this.dataset.invoiceNo || '';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus Invoice?',
                    html: `Yakin ingin menghapus invoice <strong>${invoiceNo}</strong>?<br><small class="text-muted">Data tidak dapat dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-trash"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return;
            }

            if (confirm(`Yakin ingin menghapus invoice ${invoiceNo}? Data tidak dapat dikembalikan.`)) {
                form.submit();
            }
        });
    });

    const selectAllCheckbox = document.getElementById('select-all-invoices');
    const invoiceCheckboxes = document.querySelectorAll('.select-invoice');
    const downloadButton = document.getElementById('download-selected-invoices');
    const exportForm = document.getElementById('invoice-export-form');
    const exportInputs = document.getElementById('export-selected-inputs');

    function updateSelectAllState() {
        const total = invoiceCheckboxes.length;
        const checked = document.querySelectorAll('.select-invoice:checked').length;
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = total > 0 && checked === total;
            selectAllCheckbox.indeterminate = checked > 0 && checked < total;
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            invoiceCheckboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }

    invoiceCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateSelectAllState);
    });

    if (downloadButton) {
        downloadButton.addEventListener('click', function () {
            const selectedIds = Array.from(document.querySelectorAll('.select-invoice:checked'))
                .map((checkbox) => checkbox.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Invoice',
                    text: 'Pilih minimal satu invoice untuk diunduh.',
                });
                return;
            }

            exportInputs.innerHTML = '';
            selectedIds.forEach((id) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_ids[]';
                hiddenInput.value = id;
                exportInputs.appendChild(hiddenInput);
            });

            exportForm.submit();
        });
    }

    updateSelectAllState();
});
</script>
@endpush
@endsection
