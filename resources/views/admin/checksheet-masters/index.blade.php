@extends('layouts.template')

@section('title', 'Data Master Checksheet')

@section('main-content')
<style>
    .checksheet-page { --ink:#132238; --muted:#6b7b91; --line:#e5ebf2; --blue:#2563eb; --blue-soft:#eff6ff; }
    .checksheet-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:18px; margin-bottom:22px; }
    .checksheet-kicker { color:var(--blue); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; margin-bottom:7px; }
    .checksheet-title { color:var(--ink); font-size:28px; font-weight:750; letter-spacing:-.03em; margin:0; }
    .checksheet-description { color:var(--muted); font-size:14px; margin:7px 0 0; }
    .checksheet-add-button { display:inline-flex; align-items:center; gap:10px; min-height:46px; padding:7px 16px 7px 9px; border:0; border-radius:11px; background:var(--blue); box-shadow:0 8px 18px rgba(37,99,235,.2); color:#fff; font-weight:800; transition:transform .2s ease, box-shadow .2s ease, background .2s ease; }
    .checksheet-add-button i { display:inline-flex; align-items:center; justify-content:center; width:31px; height:31px; border-radius:8px; background:rgba(255,255,255,.18); font-size:18px; }
    .checksheet-add-button:hover { background:#1d4ed8; color:#fff; transform:translateY(-2px); box-shadow:0 11px 22px rgba(37,99,235,.28); }
    .checksheet-add-button:focus-visible { outline:0; color:#fff; box-shadow:0 0 0 4px rgba(147,180,238,.35), 0 8px 18px rgba(37,99,235,.2); }
    .checksheet-add-button:active { transform:translateY(0); }
    .checksheet-page .card { border:1px solid var(--line); border-radius:14px; box-shadow:0 5px 20px rgba(19,34,56,.045); }
    .checksheet-page .card-header { padding:18px 20px; background:#fff; border-bottom:1px solid var(--line); }
    .checksheet-page .card-header h5 { color:var(--ink); margin:0; font-weight:750; }
    .checksheet-filter-card { overflow:hidden; border-color:#dbe7f5 !important; box-shadow:0 8px 24px rgba(37,99,235,.06) !important; }
    .checksheet-filter-card .card-header { display:flex; align-items:center; gap:12px; padding:16px 20px; background:linear-gradient(100deg,#f5f9ff,#fff); }
    .checksheet-filter-icon { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; flex:0 0 36px; border-radius:10px; background:#dbeafe; color:var(--blue); font-size:19px; }
    .checksheet-filter-heading { color:var(--ink); font-size:14px; font-weight:800; line-height:1.2; }
    .checksheet-filter-caption { margin:3px 0 0; color:var(--muted); font-size:12px; }
    .checksheet-filter-card .card-body { padding:20px; }
    .checksheet-filter-card .filter-field { position:relative; }
    .checksheet-filter-card .filter-field .form-label { display:block; color:#52657c; font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; }
    .checksheet-page .form-control, .checksheet-page .form-select { min-height:42px; border-color:#d9e3ee; border-radius:9px; }
    .checksheet-page .form-control:focus, .checksheet-page .form-select:focus { border-color:#93b4ee; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .checksheet-filter-actions { display:flex; align-items:flex-end; gap:8px; height:100%; }
    .checksheet-filter-actions .btn { min-height:42px; border-radius:9px; font-weight:750; }
    .checksheet-filter-actions .btn-primary { border:0; box-shadow:0 5px 12px rgba(37,99,235,.18); }
    .checksheet-filter-actions .btn-reset { border:1px solid #d9e3ee; background:#fff; color:#52657c; }
    .checksheet-filter-actions .btn-reset:hover { border-color:#bfdbfe; background:#eff6ff; color:var(--blue); }
    .checksheet-page .table { margin:0; }
    .checksheet-page .table th { color:#52657c; background:#f4f7fb; border-bottom:1px solid #dce5ef; font-size:11px; letter-spacing:.04em; text-transform:uppercase; }
    .checksheet-page .table td { color:#27384e; vertical-align:middle; }
    .checksheet-badge { display:inline-flex; padding:5px 9px; border-radius:999px; background:var(--blue-soft); color:#1d4ed8; font-size:11px; font-weight:700; }
    .checksheet-badge.product { background:#ecfdf5; color:#047857; }
    .checksheet-status { color:#047857; font-size:12px; font-weight:700; }
    .checksheet-status.inactive { color:#b45309; }
    .checksheet-actions { display:flex; gap:6px; }
    .checksheet-actions .btn { width:32px; height:32px; padding:0; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; }
    .checksheet-modal .modal-content { border:0; border-radius:14px; box-shadow:0 20px 50px rgba(19,34,56,.18); }
    .checksheet-modal .modal-header { padding:22px 24px 18px; border-bottom:1px solid var(--line); background:linear-gradient(135deg,#f8fbff,#fff); }
    .checksheet-modal .modal-title { color:var(--ink); font-weight:750; }
    .checksheet-modal .modal-title i { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:10px; background:#dbeafe; color:var(--blue); vertical-align:middle; }
    .checksheet-modal .modal-subtitle { margin:8px 0 0 45px; color:var(--muted); font-size:12px; }
    .checksheet-modal .checksheet-modal-close { display:inline-flex; align-items:center; justify-content:center; flex:0 0 36px; width:36px; height:36px; padding:0; border:1px solid #dce5ef; border-radius:10px; background:#fff; color:#718198; font-size:20px; line-height:1; transition:all .2s ease; }
    .checksheet-modal .checksheet-modal-close:hover { border-color:#bfdbfe; background:#eff6ff; color:var(--blue); transform:rotate(90deg); }
    .checksheet-modal .checksheet-modal-close:focus-visible { outline:0; border-color:#93b4ee; box-shadow:0 0 0 3px rgba(37,99,235,.14); }
    .checksheet-modal .modal-body { padding:24px; }
    .checksheet-modal .form-label { color:#52657c; font-size:12px; font-weight:750; margin-bottom:7px; }
    .checksheet-modal .form-control, .checksheet-modal .form-select { min-height:44px; border-color:#d9e3ee; border-radius:10px; background-color:#fbfdff; }
    .checksheet-modal .form-control:focus, .checksheet-modal .form-select:focus { background:#fff; border-color:#7aa2e8; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .checksheet-modal .form-section { padding:15px; border:1px solid #e7edf5; border-radius:12px; background:#fbfcfe; }
    .checksheet-modal .form-section + .form-section { margin-top:14px; }
    .checksheet-modal .form-section-title { display:flex; align-items:center; gap:7px; margin:0 0 13px; color:var(--ink); font-size:12px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; }
    .checksheet-modal .form-section-title i { color:var(--blue); font-size:16px; }
    .checksheet-modal .modal-footer { padding:16px 24px; border-top:1px solid var(--line); background:#fbfcfe; }
    .checksheet-modal .modal-footer .btn { min-height:40px; border-radius:9px; padding-inline:16px; font-weight:700; }
    @media (max-width:575.98px) { .checksheet-hero { align-items:flex-start; flex-direction:column; } .checksheet-hero .btn { width:100%; } }
</style>
<div class="checksheet-page">
    <div class="page-header">
        <div class="page-block">
            @include('layouts.dashboard-breadcrumb', ['current' => 'Data Master Checksheet'])
        </div>
    </div>

    <div class="checksheet-hero">
        <div>
            <div class="checksheet-kicker">Data Master</div>
            <h1 class="checksheet-title">Checksheet{{ $selectedItem !== '' ? ' - ' . $selectedItem : ($category === 'pallet' ? ' - Pallet' : '') }}</h1>
            <p class="checksheet-description">Kelola jenis pallet dan produk yang tersedia untuk kebutuhan checksheet.</p>
        </div>
        <button type="button" class="checksheet-add-button" data-bs-toggle="modal" data-bs-target="#checksheetCreateModal"><i class="ti ti-plus"></i><span>Tambah Data</span></button>
    </div>

    <div class="card checksheet-filter-card mb-4">
        <div class="card-header">
            <span class="checksheet-filter-icon"><i class="ti ti-adjustments-horizontal"></i></span>
            <div><div class="checksheet-filter-heading">Filter Data Master</div><p class="checksheet-filter-caption">Saring data berdasarkan jenis, periode, atau nama item.</p></div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('checksheet-masters.index') }}" class="row g-3 align-items-end">
                <input type="hidden" name="category" value="{{ $category }}">
                @if($category === 'pallet')
                    <div class="col-xl-3 col-md-6 filter-field"><label class="form-label">Jenis Pallet</label><select name="pallet_type" class="form-select"><option value="">Semua jenis pallet</option><option value="E3" @selected($palletType === 'E3')>E3</option><option value="GSN" @selected($palletType === 'GSN')>GSN</option><option value="Box" @selected($palletType === 'Box')>Peti Box</option></select></div>
                    <div class="col-xl-2 col-md-6 filter-field"><label class="form-label">Bulan</label><input type="month" name="month" value="{{ $month }}" class="form-control"></div>
                    <div class="col-xl-2 col-md-6 filter-field"><label class="form-label">Tanggal</label><input type="date" name="date" value="{{ $date }}" class="form-control"></div>
                    <div class="col-xl-2 col-md-6 filter-field"><label class="form-label">Tahun</label><select name="year" class="form-select"><option value="">Semua tahun</option>@for($filterYear = now()->year; $filterYear >= now()->year - 5; $filterYear--)<option value="{{ $filterYear }}" @selected((string) $year === (string) $filterYear)>{{ $filterYear }}</option>@endfor</select></div>
                @else
                    <div class="col-xl-3 col-md-6 filter-field"><label class="form-label">Bulan</label><input type="month" name="month" value="{{ $month }}" class="form-control"></div>
                    <div class="col-xl-3 col-md-6 filter-field"><label class="form-label">Tanggal</label><input type="date" name="date" value="{{ $date }}" class="form-control"></div>
                    <div class="col-xl-3 col-md-6 filter-field"><label class="form-label">Tahun</label><select name="year" class="form-select"><option value="">Semua tahun</option>@for($filterYear = now()->year; $filterYear >= now()->year - 5; $filterYear--)<option value="{{ $filterYear }}" @selected((string) $year === (string) $filterYear)>{{ $filterYear }}</option>@endfor</select></div>
                @endif
                <div class="col-xl-3 col-md-4 checksheet-filter-actions"><button class="btn btn-primary flex-fill" type="submit"><i class="ti ti-filter me-1"></i> Terapkan Filter</button><a class="btn btn-reset flex-fill" href="{{ route('checksheet-masters.index', ['category' => $category, 'item' => $selectedItem]) }}"><i class="ti ti-refresh me-1"></i> Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center"><h5>Daftar {{ $selectedItem !== '' ? $selectedItem : ($category === 'pallet' ? 'Pallet' : 'Produk') }}</h5><span class="text-muted small">{{ $items->total() }} data</span></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th class="ps-4">No</th>@if($category === 'pallet')<th>Tanggal Stempel</th>@endif<th>Kedatangan</th><th>Kategori</th><th>Quantity</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="ps-4">{{ $items->firstItem() + $loop->index }}</td>
                        @if($category === 'pallet')<td>{{ $item->tanggal?->format('d/m/Y') ?? '-' }}</td>@endif
                        <td>{{ $item->tanggal_kedatangan?->format('d/m/Y') ?? '-' }}</td>
                        <td><span class="checksheet-badge {{ $item->category === 'produk' ? 'product' : '' }}">{{ $item->category_label }} - {{ $item->name }}</span></td>
                        <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                        <td><span class="checksheet-status {{ $item->is_archived ? 'inactive' : '' }}">{{ $item->is_archived ? 'Sudah diarsipkan' : 'Belum diarsipkan' }}</span></td>
                        <td class="text-end pe-4"><div class="checksheet-actions justify-content-end"><button type="button" class="btn btn-outline-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#checksheetEditModal{{ $item->id }}"><i class="ti ti-edit"></i></button><form action="{{ route('checksheet-masters.destroy', $item) }}" method="POST" class="d-inline delete-checksheet-form" data-item-name="{{ $item->name }}">@csrf @method('DELETE')<input type="hidden" name="return_category" value="{{ $category }}"><input type="hidden" name="return_item" value="{{ $category === 'produk' ? $selectedItem : '' }}"><button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="{{ $category === 'pallet' ? 7 : 6 }}" class="text-center text-muted py-5">Belum ada data master checksheet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())<div class="card-footer d-flex justify-content-end">{{ $items->links('pagination::bootstrap-5') }}</div>@endif
    </div>
</div>

<div class="modal fade checksheet-modal" id="checksheetCreateModal" tabindex="-1" aria-labelledby="checksheetCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="checksheetCreateModalLabel"><i class="ti ti-clipboard-check me-2"></i>Tambah Data {{ $category === 'pallet' ? 'Pallet' : ($selectedItem !== '' ? $selectedItem : 'Checksheet') }}</h5>
                    <p class="modal-subtitle">Lengkapi informasi berikut untuk menyimpan data checksheet.</p>
                </div>
                <button type="button" class="checksheet-modal-close" data-bs-dismiss="modal" aria-label="Tutup"><i class="ti ti-x"></i></button>
            </div>
            <form method="POST" action="{{ route('checksheet-masters.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="category" value="{{ $category === 'pallet' ? 'pallet' : 'produk' }}">
                    <input type="hidden" name="return_category" value="{{ $category }}">
                    <input type="hidden" name="return_item" value="{{ $category === 'produk' ? $selectedItem : '' }}">
                    <div class="form-section">
                        <p class="form-section-title"><i class="ti ti-tag"></i> Identitas Data</p>
                        <div class="mb-0">
                            <label class="form-label" for="modal-pallet-name">{{ $category === 'pallet' ? 'Jenis Pallet' : 'Item' }}</label>
                            <select name="name" id="modal-pallet-name" class="form-select" required>
                                <option value="">Pilih {{ $category === 'pallet' ? 'jenis pallet' : 'item' }}</option>
                                @if($category === 'pallet')
                                    @foreach($palletTypes as $palletTypeOption)
                                        <option value="{{ $palletTypeOption }}">{{ $palletTypeOption === 'Box' ? 'Peti Box' : $palletTypeOption }}</option>
                                    @endforeach
                                @else
                                    @foreach($productOptions as $productOption)
                                        <option value="{{ $productOption }}">{{ $productOption }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-section">
                        <p class="form-section-title"><i class="ti ti-calendar-event"></i> Waktu dan Jumlah</p>
                        <div class="row">
                        @if($category === 'pallet')
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="modal-pallet-date">Tanggal Stempel</label>
                                <input type="date" name="tanggal" id="modal-pallet-date" class="form-control" required>
                            </div>
                        @endif
                        <div class="{{ $category === 'pallet' ? 'col-md-6' : 'col-12' }} mb-3">
                            <label class="form-label" for="modal-pallet-category">Kategori</label>
                            <input type="text" id="modal-pallet-category" class="form-control" value="{{ $category === 'pallet' ? 'Pallet' : 'Produk' }}" readonly>
                        </div>
                        </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal-pallet-arrival">Tanggal Kedatangan</label>
                        <input type="date" name="tanggal_kedatangan" id="modal-pallet-arrival" class="form-control">
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="modal-pallet-quantity">Quantity</label>
                        <input type="number" name="quantity" id="modal-pallet-quantity" class="form-control" min="0" value="0" required>
                    </div>
                    </div>
                    <input type="hidden" name="is_active" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($items as $item)
<div class="modal fade checksheet-modal" id="checksheetEditModal{{ $item->id }}" tabindex="-1" aria-labelledby="checksheetEditModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div><h5 class="modal-title" id="checksheetEditModalLabel{{ $item->id }}"><i class="ti ti-edit me-2"></i>Edit Data Checksheet</h5><p class="modal-subtitle">Perbarui informasi <strong>{{ $item->name }}</strong> tanpa meninggalkan halaman ini.</p></div>
                <button type="button" class="checksheet-modal-close" data-bs-dismiss="modal" aria-label="Tutup"><i class="ti ti-x"></i></button>
            </div>
            <form method="POST" action="{{ route('checksheet-masters.update', $item) }}">
                @csrf @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="category" value="{{ $item->category }}">
                    <input type="hidden" name="return_category" value="{{ $category }}">
                    <input type="hidden" name="return_item" value="{{ $category === 'produk' ? $selectedItem : '' }}">
                    <div class="form-section">
                        <p class="form-section-title"><i class="ti ti-tag"></i> Identitas Data</p>
                        @if($item->category === 'pallet')
                            <label class="form-label" for="edit-name-{{ $item->id }}">Jenis Pallet</label><select name="name" id="edit-name-{{ $item->id }}" class="form-select" required><option value="">Pilih jenis pallet</option>@foreach($palletTypes as $palletTypeOption)<option value="{{ $palletTypeOption }}" @selected($item->name === $palletTypeOption)>{{ $palletTypeOption === 'Box' ? 'Peti Box' : $palletTypeOption }}</option>@endforeach</select>
                        @else
                            <label class="form-label" for="edit-name-{{ $item->id }}">Item Produk</label><input type="text" id="edit-name-{{ $item->id }}" class="form-control" value="{{ $item->name }}" readonly><input type="hidden" name="name" value="{{ $item->name }}">
                        @endif
                    </div>
                    <div class="form-section">
                        <p class="form-section-title"><i class="ti ti-calendar-event"></i> Waktu dan Jumlah</p>
                        <div class="row g-3">
                            @if($item->category === 'pallet')<div class="col-md-6"><label class="form-label" for="edit-stamp-{{ $item->id }}">Tanggal Stempel</label><input type="date" name="tanggal" id="edit-stamp-{{ $item->id }}" value="{{ $item->tanggal?->format('Y-m-d') }}" class="form-control"></div>@endif
                            <div class="{{ $item->category === 'pallet' ? 'col-md-6' : 'col-12' }}"><label class="form-label" for="edit-arrival-{{ $item->id }}">Tanggal Kedatangan</label><input type="date" name="tanggal_kedatangan" id="edit-arrival-{{ $item->id }}" value="{{ $item->tanggal_kedatangan?->format('Y-m-d') }}" class="form-control"></div>
                            <div class="col-12"><label class="form-label" for="edit-quantity-{{ $item->id }}">Quantity</label><input type="number" name="quantity" id="edit-quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="0" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="form-section">
                        <p class="form-section-title"><i class="ti ti-adjustments-horizontal"></i> Status Data</p>
                        <div class="checksheet-edit-status"><div><div class="checksheet-edit-status-label">Aktif</div><div class="checksheet-edit-status-caption">Data dapat digunakan dalam checksheet.</div></div><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked($item->is_active)></div>
                        <div class="checksheet-edit-status"><div><div class="checksheet-edit-status-label">Sudah diarsipkan</div><div class="checksheet-edit-status-caption">Tandai data sebagai arsip.</div></div><input type="checkbox" name="is_archived" value="1" class="form-check-input" @checked($item->is_archived)></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal"><i class="ti ti-x me-1"></i> Batal</button><button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button></div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonText: 'OK',
            confirmButtonColor: '#2563eb',
            timer: 2200,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: @json(session('error')),
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626'
        });
    @endif

    document.querySelectorAll('.delete-checksheet-form').forEach(form => {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const result = await Swal.fire({
                icon: 'warning',
                title: 'Hapus Data?',
                text: `Data "${this.dataset.itemName}" akan dihapus dan tidak dapat dikembalikan.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endpush
