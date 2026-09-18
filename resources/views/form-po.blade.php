@extends('layouts.template')

@php
  $purchaseOrder = isset($purchaseOrder) ? $purchaseOrder : null;
@endphp

@section('main-content')
<div class="page-header mt-4 mx-3">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('kelola-po.index') }}">Kelola PO</a></li>
          <li class="breadcrumb-item active">{{ $purchaseOrder ? 'Edit PO' : 'Tambah PO' }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 mx-3">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h5>{{ $purchaseOrder ? 'Edit Purchase Order' : 'Tambah Purchase Order Baru' }}</h5>
      </div>
      <div class="card-body">
        @if ($purchaseOrder)
          <form action="{{ route('kelola-po.update', ['kelola_po' => $purchaseOrder->id]) }}" method="POST">
        @else
          <form action="{{ route('kelola-po.store') }}" method="POST">
        @endif
          @csrf
          @if ($purchaseOrder)
            @method('PUT')
          @endif

          <div class="form-group mb-3">
            <label class="form-label">Nomor PO</label>
            <input type="text" name="no_po" class="form-control @error('no_po') is-invalid @enderror" 
              value="{{ old('no_po', $purchaseOrder?->no_po ?? '') }}" placeholder="Contoh: PO-001">
            @error('no_po')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Jenis PO</label>
            <input type="text" name="jenis_po" class="form-control @error('jenis_po') is-invalid @enderror" 
              value="{{ old('jenis_po', $purchaseOrder?->jenis_po ?? '') }}" placeholder="Contoh: Pembelian, Penjualan, Internal">
            @error('jenis_po')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Tanggal PO</label>
            <input type="date" name="tanggal_po" class="form-control @error('tanggal_po') is-invalid @enderror" 
              value="{{ old('tanggal_po', $purchaseOrder ? $purchaseOrder->tanggal_po->format('Y-m-d') : '') }}">
            @error('tanggal_po')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Total Quantity</label>
            <input type="number" name="total_qty" class="form-control @error('total_qty') is-invalid @enderror" 
              value="{{ old('total_qty', $purchaseOrder?->total_qty ?? '') }}" placeholder="Minimal 1" min="1">
            @error('total_qty')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          @if ($purchaseOrder)
            <div class="form-group mb-3">
              <label class="form-label">Used Quantity</label>
              <input type="number" name="used_qty" class="form-control" value="{{ $purchaseOrder->used_qty }}" disabled>
              <small class="form-text text-muted">Field ini tidak bisa diubah manual. Update melalui invoice/penggunaan.</small>
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Status</label>
              <input type="text" class="form-control" value="{{ ucfirst($purchaseOrder->status) }}" disabled>
              <small class="form-text text-muted">
                Status otomatis: Open (used < total) | Closed (used >= total)
              </small>
            </div>
          @endif

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              {{ $purchaseOrder ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('kelola-po.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
