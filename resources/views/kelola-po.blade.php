@extends('layouts.template')

@section('main-content')
<div class="page-header mt-4 mx-3">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Kelola PO</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 mx-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar PO</h5>
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary btn-sm">
          <i class="ti ti-plus"></i> Tambah PO
        </a>
      </div>
      <div class="card-body">
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No PO</th>
                <th>Jenis PO</th>
                <th>Total Qty</th>
                <th>Used Qty</th>
                <th>Tanggal PO</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($purchaseOrders as $po)
                @php
                  $sisaQty = $po->remainingQty();
                @endphp
                <tr>
                  <td><strong>{{ $po->no_po }}</strong></td>
                  <td>{{ $po->jenis_po }}</td>
                  <td>{{ $po->total_qty }}</td>
                  <td>{{ $po->used_qty }}</td>
                  <td>{{ $po->tanggal_po->format('d M Y') }}</td>
                  <td>
                    @if ($po->status === 'open')
                      <span class="badge bg-success">Open</span>
                    @else
                      <span class="badge bg-danger">Closed</span>
                    @endif
                  </td>
                  <td>
                    @if ($po->status === 'open')
                      <a href="{{ route('purchase-orders.edit', $po->id) }}" class="btn btn-sm btn-info" title="Edit">
                        <i class="ti ti-edit"></i>
                      </a>
                      <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                          <i class="ti ti-trash"></i>
                        </button>
                      </form>
                      <form action="{{ route('purchase-orders.close', $po->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tutup PO ini?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning" title="Tutup PO">
                          <i class="ti ti-lock"></i>
                        </button>
                      </form>
                    @else
                      <span class="badge bg-secondary">Tidak dapat diedit</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">Data tidak ditemukan</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-between align-items-center">
        <div class="text-muted">
          <small>
            Menampilkan <strong>{{ $purchaseOrders->firstItem() ?? 0 }}</strong> sampai 
            <strong>{{ $purchaseOrders->lastItem() ?? 0 }}</strong> dari 
            <strong>{{ $purchaseOrders->total() }}</strong> PO
          </small>
        </div>
        <div>
          {{ $purchaseOrders->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
