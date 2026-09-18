@extends('layouts.template')

@section('title', 'Laporan Invoice NON PO')

@section('main-content')
<style>
    .rekap-nonpo-page { --ink:#132238; --muted:#6b7b91; --line:#e5ebf2; --blue:#2563eb; --blue-soft:#eff6ff; }
    .rekap-nonpo-page .page-header { margin-bottom:18px; }
    .rekap-nonpo-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:18px; margin-bottom:22px; }
    .rekap-nonpo-kicker { color:var(--blue); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; margin-bottom:7px; }
    .rekap-nonpo-title { color:var(--ink); font-size:28px; font-weight:750; letter-spacing:-.03em; margin:0; }
    .rekap-nonpo-description { color:var(--muted); font-size:14px; margin:7px 0 0; }
    .rekap-nonpo-count { padding:12px 16px; border:1px solid #dbe7f5; border-radius:12px; background:var(--blue-soft); color:#1d4ed8; text-align:right; white-space:nowrap; }
    .rekap-nonpo-count strong { display:block; color:var(--ink); font-size:22px; line-height:1; }
    .rekap-nonpo-count span { display:block; font-size:11px; margin-top:5px; }
    .rekap-nonpo-page .card { border:1px solid var(--line); border-radius:14px; box-shadow:0 5px 20px rgba(19,34,56,.045); }
    .rekap-nonpo-page .card-header { padding:19px 22px; background:#fff; border-bottom:1px solid var(--line); }
    .rekap-nonpo-page .card-header h5 { color:var(--ink); margin:0; font-weight:750; }
    .rekap-nonpo-page .form-label { color:#4b5d73; font-size:12px; font-weight:700; margin-bottom:7px; }
    .rekap-nonpo-page .form-control { border-color:#d9e3ee; border-radius:9px; min-height:42px; }
    .rekap-nonpo-page .form-control:focus { border-color:#93b4ee; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .rekap-nonpo-page .btn-primary { min-height:42px; border:0; border-radius:9px; background:var(--blue); font-weight:700; }
    .rekap-nonpo-page .rekap-nonpo-results .card-body { padding:18px; background:#fbfcfe; }
    .rekap-nonpo-invoice { overflow:hidden; margin-bottom:14px; border:1px solid var(--line); border-radius:12px; background:#fff; box-shadow:0 3px 12px rgba(19,34,56,.03); }
    .rekap-nonpo-invoice:last-child { margin-bottom:0; }
    .rekap-nonpo-invoice-head { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:16px 18px; border-bottom:1px solid var(--line); }
    .rekap-nonpo-invoice-label { color:var(--muted); font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
    .rekap-nonpo-invoice-number { color:var(--ink); font-size:16px; font-weight:750; margin:3px 0 4px; }
    .rekap-nonpo-invoice-meta { color:var(--muted); font-size:12px; }
    .rekap-nonpo-invoice-actions { display:flex; gap:7px; }
    .rekap-nonpo-invoice-actions .btn { width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; }
    .rekap-nonpo-invoice-actions .btn-info { color:#2563eb; border-color:#bfdbfe; background:#eff6ff; }
    .rekap-nonpo-invoice-actions .btn-danger { color:#dc2626; border-color:#fecaca; background:#fff1f2; }
    .rekap-nonpo-invoice-body { padding:0 18px 18px; }
    .rekap-nonpo-invoice-body hr { border-color:var(--line); margin:0 0 16px; opacity:1; }
    .rekap-nonpo-page .table { margin:0; border-color:var(--line); }
    .rekap-nonpo-page .table thead th { padding:11px 12px; background:#f4f7fb; color:#52657c; border-bottom:1px solid #dce5ef; font-size:11px; letter-spacing:.03em; text-transform:uppercase; }
    .rekap-nonpo-page .table tbody td { padding:12px; color:#27384e; font-size:13px; vertical-align:middle; }
    .rekap-nonpo-page .table tbody tr:hover { background:#f8fbff; }
    .rekap-nonpo-page .table tfoot td { padding:13px 12px; color:var(--ink); border-top:2px solid #dce5ef; font-size:13px; }
    .rekap-nonpo-page .card-footer { padding:16px 22px; background:#fff; border-top:1px solid var(--line); }
    @media (max-width:575.98px) { .rekap-nonpo-hero,.rekap-nonpo-invoice-head { align-items:flex-start; flex-direction:column; } .rekap-nonpo-count { width:100%; text-align:left; } .rekap-nonpo-invoice-actions { align-self:flex-end; margin-top:-48px; } }
</style>
<div class="rekap-nonpo-page">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Laporan Invoice NON PO'])
                    </div>

                </div>
            </div>
        </div>

        <div class="rekap-nonpo-hero">
            <div>
                <div class="rekap-nonpo-kicker">Laporan Keuangan</div>
                <h1 class="rekap-nonpo-title">Rekap Invoice Non PO</h1>
                <p class="rekap-nonpo-description">Ringkasan invoice tanpa Purchase Order dan detail nilai transaksinya.</p>
            </div>
            <div class="rekap-nonpo-count">
                <strong>{{ $invoicePivots->count() }}</strong>
                <span>Invoice Non PO ditemukan</span>
            </div>
        </div>

        <!-- Filter -->
        <div class="row rekap-nonpo-results">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter Laporan</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.non-po') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Supplier (Opsional)</label>
                                    <input type="text" name="supplier" class="form-control" value="{{ $supplier }}" placeholder="Nama supplier">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Rekap Invoice NON PO (Per Invoice)</h5>
                    </div>
                    <div class="card-body">
                        @if($invoicePivots->isEmpty())
                            <div class="alert alert-warning mb-0">
                                Data Invoice NON PO tidak ditemukan
                            </div>
                        @else
                            @foreach($invoicePivots as $pivot)
                                <div class="rekap-nonpo-invoice">
                                    <div class="rekap-nonpo-invoice-head">
                                        <div>
                                            <div class="rekap-nonpo-invoice-label">Invoice Non PO</div>
                                            <div class="rekap-nonpo-invoice-number">{{ $pivot['invoice']->no_invoice }}</div>
                                            <div class="rekap-nonpo-invoice-meta"><i class="ti ti-calendar me-1"></i>{{ $pivot['invoice']->tanggal_invoice?->format('d M Y') ?? '-' }} &nbsp; · &nbsp; SO {{ $pivot['invoice']->no_so ?? '-' }}</div>
                                        </div>
                                        <div class="rekap-nonpo-invoice-actions">
                                            <a href="{{ route('invoice-non-po.show', $pivot['invoice']->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $pivot['invoice']->id) }}" method="POST" class="d-inline delete-form" data-invoice-no="{{ $pivot['invoice']->no_invoice }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Invoice">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="rekap-nonpo-invoice-body"><hr>

                                    @if($pivot['rows']->isEmpty())
                                        <div class="alert alert-warning mb-0">
                                            Data Invoice NON PO tidak ditemukan
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Item Barang</th>
                                                        <th width="15%">Jumlah Item</th>
                                                        <th width="25%">Total Nilai</th>
                                                        <th width="20%">DPP (11/12)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pivot['rows'] as $index => $row)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $row->nama_item }}</td>
                                                            <td class="text-center">{{ number_format($row->jumlah_item, 0, ',', '.') }}</td>
                                                            <td class="text-end">Rp {{ number_format($row->total_nilai, 0, ',', '.') }}</td>
                                                            <td class="text-end">Rp {{ number_format($row->dpp, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-light">
                                                    <tr>
                                                        <td colspan="2" class="text-end"><strong>TOTAL</strong></td>
                                                        <td class="text-center"><strong>{{ number_format($pivot['totalQty'], 0, ',', '.') }}</strong></td>
                                                        <td class="text-end"><strong>Rp {{ number_format($pivot['totalNilai'], 0, ',', '.') }}</strong></td>
                                                        <td class="text-end"><strong>Rp {{ number_format($pivot['totalDpp'], 0, ',', '.') }}</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#28a745',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    @endif

    // Konfirmasi sebelum hapus
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const invoiceNo = this.dataset.invoiceNo;
            
            const result = await Swal.fire({
                title: 'Hapus Invoice?',
                html: `Yakin ingin menghapus invoice <strong>${invoiceNo}</strong>?<br><small class="text-muted">Data tidak dapat dikembalikan.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            });
            
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endpush
