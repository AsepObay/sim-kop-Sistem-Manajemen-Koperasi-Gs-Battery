@extends('layouts.template')
@section('title', 'Dashboard')
@push('styles')
<style>
  .dashboard-page-shell {
    background: #F8FAFC;
    padding-top: 0;
  }

  .dashboard-summary-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1rem;
    margin-bottom: 0.75rem;
  }

  .dashboard-summary-item {
    min-width: 0;
  }

  .dashboard-summary-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    overflow: hidden;
    height: auto;
    min-height: 150px;
  }

  .dashboard-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
    border-color: #CBD5E1;
  }

  .dashboard-summary-card .card-body {
    padding: 1.05rem 1rem 0.9rem;
  }

  .dashboard-summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .dashboard-summary-meta {
    min-width: 0;
    flex: 1;
  }

  .dashboard-summary-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 0.7rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748B;
    line-height: 1.4;
    letter-spacing: 0.01em;
  }

  .dashboard-summary-label i {
    color: #2563EB;
    font-size: 1rem;
    line-height: 1;
    width: auto;
    height: auto;
    display: inline-block;
  }

  .dashboard-icon-svg {
    width: 18px;
    height: 18px;
    min-width: 18px;
    min-height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    color: currentColor;
    line-height: 1;
    flex-shrink: 0;
  }

  .dashboard-inline-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    min-width: 16px;
    min-height: 16px;
    color: #2563EB;
    flex-shrink: 0;
    line-height: 1;
  }

  .dashboard-summary-icon i,
  .dashboard-inline-icon i {
    display: inline-block !important;
    width: auto !important;
    height: auto !important;
    font-size: 20px !important;
    line-height: 1 !important;
    color: #2563EB !important;
  }

  .dashboard-summary-icon svg,
  .dashboard-inline-icon svg,
  .dashboard-icon-svg svg {
    width: 20px !important;
    height: 20px !important;
    max-width: 20px !important;
    max-height: 20px !important;
    display: block;
    stroke: currentColor;
    fill: none;
  }

  .dashboard-summary-value {
    margin: 0;
    font-size: 30px;
    line-height: 1.2;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: #0F172A;
  }

  .dashboard-summary-value--accent {
    color: #2563EB;
  }

  .dashboard-summary-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    min-height: 42px;
    border-radius: 10px;
    background: #EFF6FF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563EB;
    font-size: 20px;
    line-height: 1;
    flex-shrink: 0;
    box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.05);
  }

  .dashboard-summary-card .metric-divider {
    margin: 0.75rem 0 0.68rem;
    border-top: 1px solid #E2E8F0;
    opacity: 1;
  }

  .dashboard-summary-hint {
    display: block;
    font-size: 0.78rem;
    color: #64748B;
    line-height: 1.4;
  }

  .dashboard-panel-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
  }

  .dashboard-panel-card .card-header {
    background: transparent;
    border-bottom: 1px solid #E2E8F0;
    padding: 0.95rem 1.1rem;
    min-height: 56px;
  }

  .dashboard-panel-card .card-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    font-size: 1.04rem;
    font-weight: 700;
    color: #0F172A;
  }

  .dashboard-panel-card .card-title i {
    color: #2563EB;
    font-size: 1rem;
  }

  .dashboard-panel-card .card-body {
    padding: 1rem 1.1rem 1.1rem;
  }

  .dashboard-chart-header-right {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #64748B;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.35rem 0.6rem;
    border: 1px solid #E2E8F0;
    background: #F8FAFC;
    border-radius: 999px;
  }

  .dashboard-chart-wrap {
    margin: 0;
    border-radius: 12px;
    overflow: hidden;
    min-height: 300px;
  }

  .dashboard-download-btn {
    background: transparent;
    border: none;
    color: #64748B;
    border-radius: 8px;
    padding: 0.38rem 0.7rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .dashboard-download-btn:hover {
    background: #F8FAFC;
    color: #2563EB;
  }

  .dashboard-download-btn--primary {
    background: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
  }

  .dashboard-download-btn--primary:hover {
    background: #1D4ED8;
    color: #FFFFFF;
  }

  .dashboard-card-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64748B;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .dashboard-card-link:hover {
    color: #2563EB;
    text-decoration: none;
  }

  .dashboard-filter-form {
    margin-bottom: 1rem;
  }

  .dashboard-month-select {
    height: 36px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0F172A;
    padding: 0.45rem 0.8rem;
    font-size: 0.88rem;
  }

  .dashboard-filter-button {
    height: 36px;
    padding: 0 14px;
    border-radius: 8px;
    border: none;
    background: #2563EB;
    color: #FFFFFF;
    font-size: 0.88rem;
    font-weight: 600;
  }

  .dashboard-table thead th {
    background: #F8FAFC;
    color: #475569;
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    border-bottom: 1px solid #E2E8F0;
    padding: 0.72rem 0.8rem;
  }

  .dashboard-table td,
  .dashboard-table th {
    padding: 0.8rem 0.8rem;
    border-color: #EEF2F7;
    vertical-align: middle;
  }

  .dashboard-table tbody tr:hover {
    background: #F8FAFC;
  }

  .dashboard-table .value-strong {
    font-size: 0.9rem;
    font-weight: 700;
    color: #0F172A;
  }

  .dashboard-compact-row {
    margin-top: 0;
  }

  .dashboard-table .value-muted {
    color: #64748B;
  }

  .dashboard-invoice-badge {
    display: inline-block;
    padding: 0.28rem 0.6rem;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    border: 1px solid transparent;
    line-height: 1.2;
  }

  .dashboard-invoice-badge--po {
    background: #EFF6FF;
    color: #2563EB;
    border-color: #DBEAFE;
  }

  .dashboard-invoice-badge--nonpo {
    background: #EFF6FF;
    color: #2563EB;
    border-color: #DBEAFE;
  }

  .dashboard-alert-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
  }

  .dashboard-alert-card .card-header {
    background: #FFF7ED;
    border-bottom: 1px solid #FED7AA;
    padding: 0.9rem 1.1rem;
  }

  .dashboard-alert-card .card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0F172A;
  }

  .dashboard-alert-card .card-title i {
    color: #F59E0B;
  }

  @media (min-width: 1200px) {
    .dashboard-lower-grid .col-xl-6 {
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }
  }

  @media (max-width: 991.98px) {
    .dashboard-summary-card .card-body {
      padding: 1rem;
    }

    .dashboard-summary-value {
      font-size: 24px;
    }
  }
</style>
@endpush
@section('main-content')
<style>
  .dashboard-summary-card {
    height: auto;
    min-height: 150px;
  }

  .dashboard-summary-icon {
    width: 42px !important;
    height: 42px !important;
    min-width: 42px !important;
    min-height: 42px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    border-radius: 10px !important;
    background: #EFF6FF !important;
    color: #2563EB !important;
    line-height: 1 !important;
    box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.05) !important;
  }

  .dashboard-summary-icon i {
    display: inline-block !important;
    width: auto !important;
    height: auto !important;
    font-size: 20px !important;
    line-height: 1 !important;
    color: #2563EB !important;
  }
</style>
<div class="dashboard-page-shell">
<!-- [ breadcrumb ] start -->
<div class="page-header">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="dashboard-breadcrumb-wrapper">
          <div class="breadcrumb-left">
            <span class="breadcrumb-home-icon"><i class="ti ti-home"></i></span>
            <span class="breadcrumb-home"><a href="{{ url('dashboard') }}">Home</a></span>
            <span class="breadcrumb-separator">›</span>
            <span class="breadcrumb-current">Dashboard</span>
          </div>

          <div class="breadcrumb-meta">
            <div class="breadcrumb-date">
              <div class="breadcrumb-calendar"><i class="ti ti-calendar"></i></div>
              <div class="breadcrumb-date-text">
                <strong>{{ \Carbon\Carbon::now()->format('j F Y') }}</strong>
                <small>{{ \Carbon\Carbon::now()->format('l, H:i') }} WIB</small>
              </div>
            </div>

            <div class="breadcrumb-divider"></div>

            <div class="breadcrumb-online">
              <span class="online-dot"></span>
              <span>Online</span>
            </div>

            <div class="breadcrumb-divider"></div>

            <button class="breadcrumb-theme" type="button" aria-label="Toggle theme">
              <i class="ti ti-sun"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="dashboard-summary-grid">
  <!-- Summary Cards Start -->
  <!-- Total PO Card -->
  <div class="dashboard-summary-item">
    <div class="card dashboard-summary-card h-100">
      <div class="card-body">
        <div class="dashboard-summary-header">
          <div class="dashboard-summary-meta">
            <p class="dashboard-summary-label">
              <span class="dashboard-icon-svg" aria-hidden="true"><i class="ti ti-box"></i></span>
              Total PO
            </p>
            <h2 class="dashboard-summary-value">{{ $totalPO }}</h2>
          </div>
          <div class="dashboard-summary-icon" aria-label="Total PO icon">
            <i class="ti ti-box" aria-hidden="true"></i>
          </div>
        </div>
        <div class="metric-divider"></div>
        <small class="dashboard-summary-hint">Semua Purchase Order</small>
      </div>
    </div>
  </div>

  <!-- PO Aktif Card -->
  <div class="dashboard-summary-item">
    <div class="card dashboard-summary-card h-100">
      <div class="card-body">
        <div class="dashboard-summary-header">
          <div class="dashboard-summary-meta">
            <p class="dashboard-summary-label">
              <span class="dashboard-icon-svg" aria-hidden="true"><i class="ti ti-clipboard-check"></i></span>
              PO Aktif (Open)
            </p>
            <h2 class="dashboard-summary-value dashboard-summary-value--accent">{{ $activePO }}</h2>
          </div>
          <div class="dashboard-summary-icon" aria-label="PO Aktif icon">
            <i class="ti ti-clipboard-check" aria-hidden="true"></i>
          </div>
        </div>
        <div class="metric-divider"></div>
        <small class="dashboard-summary-hint">Status Open</small>
      </div>
    </div>
  </div>

  <!-- Total Invoice Card -->
  <div class="dashboard-summary-item">
    <div class="card dashboard-summary-card h-100">
      <div class="card-body">
        <div class="dashboard-summary-header">
          <div class="dashboard-summary-meta">
            <p class="dashboard-summary-label">
              <span class="dashboard-icon-svg" aria-hidden="true"><i class="ti ti-file-text"></i></span>
              Total Invoice
            </p>
            <h2 class="dashboard-summary-value">{{ $totalInvoice }}</h2>
          </div>
          <div class="dashboard-summary-icon" aria-label="Total Invoice icon">
            <i class="ti ti-file-text" aria-hidden="true"></i>
          </div>
        </div>
        <div class="metric-divider"></div>
        <small class="dashboard-summary-hint">Semua Invoice</small>
      </div>
    </div>
  </div>

  <!-- Total Nilai Card -->
  <div class="dashboard-summary-item">
    <div class="card dashboard-summary-card h-100">
      <div class="card-body">
        <div class="dashboard-summary-header">
          <div class="dashboard-summary-meta">
            <p class="dashboard-summary-label">
              <span class="dashboard-icon-svg" aria-hidden="true"><i class="ti ti-wallet"></i></span>
              Total Nilai
            </p>
            <h2 class="dashboard-summary-value">Rp {{ number_format($totalNilaiInvoice, 0, ',', '.') }}</h2>
          </div>
          <div class="dashboard-summary-icon" aria-label="Total Nilai icon">
            <i class="ti ti-wallet" aria-hidden="true"></i>
          </div>
        </div>
        <div class="metric-divider"></div>
        <small class="dashboard-summary-hint">Invoice Total</small>
      </div>
    </div>
  </div>

  <!-- Total Nilai + PPN Card -->
  <div class="dashboard-summary-item">
    <div class="card dashboard-summary-card h-100">
      <div class="card-body">
        <div class="dashboard-summary-header">
          <div class="dashboard-summary-meta">
            <p class="dashboard-summary-label">
              <span class="dashboard-icon-svg" aria-hidden="true"><i class="ti ti-cash"></i></span>
              Total Nilai + PPN
            </p>
            <h2 class="dashboard-summary-value dashboard-summary-value--accent">Rp {{ number_format($totalNilaiInvoice + $totalPPN, 0, ',', '.') }}</h2>
          </div>
          <div class="dashboard-summary-icon" aria-label="Total Nilai + PPN icon">
            <i class="ti ti-cash" aria-hidden="true"></i>
          </div>
        </div>
        <div class="metric-divider"></div>
        <small class="dashboard-summary-hint">Total Keseluruhan dengan PPN</small>
      </div>
    </div>
  </div>
  <!-- Summary Cards End -->
</div>

  <!-- Monthly Chart Start -->
  <div class="col-12">
    <div class="card dashboard-panel-card mt-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
          <span class="dashboard-inline-icon" aria-hidden="true" style="width:16px;height:16px;color:#2563EB;display:inline-flex;align-items:center;justify-content:center;"><svg viewBox="0 0 24 24"><path d="M3 18h18"></path><path d="M7 14l4-4 3 3 7-8"></path><path d="M18 5h3v3"></path></svg></span>
          Grafik Rekap Bulanan
        </h5>
        <div class="dashboard-chart-header-right">
          <span>12 Bulan Terakhir</span>
          <span class="dashboard-inline-icon" aria-hidden="true" style="width:14px;height:14px;display:inline-flex;align-items:center;justify-content:center;"><svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg></span>
        </div>
      </div>
      <div class="card-body">
        <div id="dashboard-monthly-chart" class="dashboard-chart-wrap"></div>
      </div>
    </div>
  </div>
  <!-- Monthly Chart End -->


  <div class="row dashboard-compact-row g-3 mt-0">
    <div class="col-xl-6">
      <div class="card dashboard-panel-card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">
            <span class="dashboard-inline-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M3 10h18"></path></svg></span>
            Rekapitulasi Bulanan
          </h5>
          <div class="d-flex gap-2">
            <a href="{{ route('dashboard.export-monthly') }}" class="btn btn-sm dashboard-download-btn" title="Download semua laporan bulanan">
              <span class="dashboard-inline-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 4v10"></path><path d="m7 19 5 5 5-5"></path><path d="M4 20h16"></path></svg></span>
              Unduh Semua Bulan
            </a>
            <a href="{{ route('dashboard.export-monthly', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-sm dashboard-download-btn" title="Download bulan terpilih">
              <span class="dashboard-inline-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 4v10"></path><path d="m7 19 5 5 5-5"></path><path d="M4 20h16"></path></svg></span>
              Unduh Bulan Ini
            </a>
          </div>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-end mb-4 dashboard-filter-form">
            <div class="col-auto">
              <label for="monthFilter" class="form-label mb-1">Pilih Bulan</label>
              <select id="monthFilter" name="month_year" class="form-select form-select-sm dashboard-month-select">
                @foreach ($monthOptions as $option)
                  <option value="{{ $option['year'] }}-{{ str_pad($option['month_num'], 2, '0', STR_PAD_LEFT) }}"
                    @if ($option['month_num'] === $selectedMonth && $option['year'] === $selectedYear) selected @endif>
                    {{ $option['month'] }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-sm dashboard-filter-button">Filter</button>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table dashboard-table table-hover mb-0">
              <thead>
                <tr>
                  <th>Bulan</th>
                  <th class="text-end">Total Nilai</th>
                  <th class="text-end">Total PPN (11%)</th>
                  <th class="text-end">Total Nilai + PPN</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($monthlyData as $data)
                  <tr>
                    <td><strong class="value-strong">{{ $data['month'] }}</strong></td>
                    <td class="text-end">
                      <span class="value-strong">Rp {{ number_format($data['value'], 0, ',', '.') }}</span>
                    </td>
                    <td class="text-end">
                      <span class="value-muted">Rp {{ number_format($data['ppn'], 0, ',', '.') }}</span>
                    </td>
                    <td class="text-end">
                      <span class="value-strong">Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
                    </td>
                    <td class="text-center">
                      <a href="{{ route('dashboard.export-monthly', ['month' => $data['month_num'], 'year' => $data['year']]) }}" class="btn btn-sm dashboard-download-btn">
                        <span class="dashboard-inline-icon" aria-hidden="true" style="width:14px;height:14px;display:inline-flex;align-items:center;justify-content:center;"><svg viewBox="0 0 24 24"><path d="M12 4v10"></path><path d="m7 19 5 5 5-5"></path><path d="M4 20h16"></path></svg></span>
                        Unduh
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                      <span class="dashboard-inline-icon" aria-hidden="true" style="width:14px;height:14px; margin-right:6px;"><svg viewBox="0 0 24 24"><path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5z"></path><path d="M8 9h8"></path><path d="M8 13h8"></path></svg></span>
                      Tidak ada data untuk 12 bulan terakhir
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="card dashboard-panel-card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">5 Invoice Terbaru</h5>
          <a href="#" class="dashboard-card-link">Lihat Semua <span class="dashboard-inline-icon" aria-hidden="true" style="width:13px;height:13px;display:inline-flex;align-items:center;justify-content:center;"><svg viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m13 5 7 7-7 7"></path></svg></span></a>
        </div>
        <div class="card-body">
          @if ($latestInvoices->count() > 0)
            <div class="table-responsive">
              <table class="table dashboard-table table-hover mb-0">
                <thead>
                  <tr>
                    <th>No Invoice</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                    <th>Total Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latestInvoices as $invoice)
                    <tr>
                      <td>
                        <strong class="value-strong">{{ $invoice->no_invoice }}</strong>
                      </td>
                      <td>
                        @if ($invoice->tipe === 'PO')
                          <span class="dashboard-invoice-badge dashboard-invoice-badge--po">PO</span>
                        @else
                          <span class="dashboard-invoice-badge dashboard-invoice-badge--nonpo">NON_PO</span>
                        @endif
                      </td>
                      <td class="value-muted">{{ $invoice->tanggal_invoice->format('d M Y') }}</td>
                      <td>
                        <strong class="value-strong">Rp {{ number_format($invoice->items->sum('subtotal'), 0, ',', '.') }}</strong>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="alert alert-info mb-0" role="alert">
              <span class="dashboard-inline-icon" aria-hidden="true" style="width:14px;height:14px; margin-right:6px;"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 8h.01"></path><path d="M11 12h1v4h1"></path></svg></span>
              Tidak ada data invoice.
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Low Stock PO Alert Start -->
  @if ($lowStockPO->count() > 0)
    <div class="col-12">
      <div class="card dashboard-alert-card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">
            <span class="dashboard-inline-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 2.5 18h19L12 3z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg></span>
            PO Hampir Habis
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr class="table-light">
                  <th>No PO</th>
                  <th>Total Qty</th>
                  <th>Used Qty</th>
                  <th>Sisa Qty</th>
                  <th>Persentase</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($lowStockPO as $po)
                  @php
                    $sisaQty = $po->total_qty - $po->used_qty;
                    $persentase = ($sisaQty / $po->total_qty) * 100;
                  @endphp
                  <tr>
                    <td>
                      <strong>{{ $po->no_po }}</strong>
                    </td>
                    <td>{{ $po->total_qty }}</td>
                    <td>{{ $po->used_qty }}</td>
                    <td>
                      <span class="badge bg-danger">{{ $sisaQty }}</span>
                    </td>
                    <td>
                      <div class="progress" style="height: 20px;">
                        <div
                          class="progress-bar @if ($persentase <= 10) bg-danger @elseif ($persentase <= 20) bg-warning @endif"
                          role="progressbar"
                          style="width: {{ $persentase }}%"
                          aria-valuenow="{{ $persentase }}"
                          aria-valuemin="0"
                          aria-valuemax="100"
                        >
                          {{ round($persentase, 1) }}%
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- Low Stock PO Alert End -->
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var chartElement = document.querySelector('#dashboard-monthly-chart');
    if (!chartElement || typeof ApexCharts === 'undefined') {
      return;
    }

    var options = {
      chart: {
        type: 'area',
        height: 320,
        toolbar: { show: false },
        background: '#FFFFFF',
      },
      stroke: {
        curve: 'smooth',
        width: 2.5,
        colors: ['#2563EB'],
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.45,
          opacityTo: 0.08,
          stops: [0, 90, 100]
        }
      },
      series: [{
        name: 'Total Nilai',
        data: @json($chartValues)
      }],
      xaxis: {
        categories: @json($chartLabels),
        labels: {
          style: {
            colors: '#64748B',
            fontSize: '12px',
            fontWeight: 500,
          }
        },
        tooltip: {
          enabled: true,
          theme: 'light',
          style: {
            fontSize: '13px',
            color: '#0F172A',
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: '#64748B',
            fontSize: '12px',
          },
          formatter: function (val) {
            return 'Rp ' + Intl.NumberFormat('id-ID').format(val);
          }
        }
      },
      tooltip: {
        theme: 'light',
        style: {
          fontSize: '14px',
          color: '#0F172A'
        },
        y: {
          formatter: function (val) {
            return 'Rp ' + Intl.NumberFormat('id-ID').format(val);
          }
        }
      },
      colors: ['#2563EB'],
      dataLabels: { enabled: false },
      grid: {
        borderColor: '#E2E8F0',
        strokeDashArray: 4,
        xaxis: {
          lines: { show: false }
        },
        yaxis: {
          lines: { show: true }
        }
      },
      markers: {
        size: 4,
        colors: ['#2563EB'],
        strokeColors: '#FFFFFF',
        strokeWidth: 2,
      }
    };

    var chart = new ApexCharts(chartElement, options);
    chart.render();
  });
</script>
@endpush
@endsection
