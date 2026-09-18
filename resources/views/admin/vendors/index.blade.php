@extends('layouts.template')

@section('title', 'Vendor Kerjasama')

@section('main-content')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Vendor Kerjasama'])
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Vendor Kerjasama</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Form Input Open Table</h5></div>
                    <div class="card-body">
                        <form action="{{ route('vendors.open-table.store') }}" method="POST" id="open-table-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama Vendor</label>
                                    <input type="text" name="nama_vendor_ot" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Tanggal Open Table (Bisa beberapa tanggal)</label>
                                    <div id="tanggal-wrapper" class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <input type="date" name="tanggal_open_table[]" class="form-control" required>
                                            <button type="button" class="btn btn-outline-primary" id="add-tanggal">+ Tanggal</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ti ti-device-floppy"></i> Simpan Open Table
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Data Open Table Vendor</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Vendor</th>
                                        <th>Tanggal Open Table</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($openTables as $idx => $open)
                                        <tr>
                                            <td>{{ $openTables->firstItem() + $idx }}</td>
                                            <td><strong>{{ $open->nama_vendor }}</strong></td>
                                            <td>
                                                @foreach(($open->tanggal_open_table ?? []) as $tanggal)
                                                    <span class="badge bg-info me-1 mb-1">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center"><em>Belum ada data open table.</em></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($openTables->hasPages())
                        <div class="card-footer">{{ $openTables->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Form Input Open Table</h5></div>
                    <div class="card-body">
                        <form action="{{ route('vendors.open-table.store') }}" method="POST" id="open-table-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama Vendor</label>
                                    <input type="text" name="nama_vendor_ot" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Tanggal Open Table (Bisa beberapa tanggal)</label>
                                    <div id="tanggal-wrapper" class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <input type="date" name="tanggal_open_table[]" class="form-control" required>
                                            <button type="button" class="btn btn-outline-primary" id="add-tanggal">+ Tanggal</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ti ti-device-floppy"></i> Simpan Open Table
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Data Open Table Vendor</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Vendor</th>
                                        <th>Tanggal Open Table</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($openTables as $idx => $open)
                                        <tr>
                                            <td>{{ $openTables->firstItem() + $idx }}</td>
                                            <td><strong>{{ $open->nama_vendor }}</strong></td>
                                            <td>
                                                @foreach(($open->tanggal_open_table ?? []) as $tanggal)
                                                    <span class="badge bg-info me-1 mb-1">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center"><em>Belum ada data open table.</em></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($openTables->hasPages())
                        <div class="card-footer">{{ $openTables->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('tanggal-wrapper');
    const addButton = document.getElementById('add-tanggal');

    if (!wrapper || !addButton) {
        return;
    }

    addButton.addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'd-flex gap-2';
        row.innerHTML = `
            <input type="date" name="tanggal_open_table[]" class="form-control" required>
            <button type="button" class="btn btn-outline-danger remove-tanggal">Hapus</button>
        `;
        wrapper.appendChild(row);
    });

    wrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tanggal')) {
            e.target.parentElement.remove();
        }
    });
});
</script>
@endpush
