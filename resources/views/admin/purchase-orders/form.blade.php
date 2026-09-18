@extends('admin.app')

@php
  $purchaseOrder = isset($purchaseOrder) ? $purchaseOrder : null;
@endphp

@section('content')
<style>
  .purchase-order-form-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .purchase-order-form-wrap {
    max-width: 1000px;
    margin: 18px auto 0;
  }

  .purchase-order-form-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    overflow: hidden;
  }

  .purchase-order-form-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .purchase-order-form-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .purchase-order-form-subtitle {
    margin: 6px 0 0;
    font-size: 12px;
    color: #64748B;
    line-height: 1.45;
  }

  .purchase-order-form-body {
    padding: 22px 24px 24px;
  }

  .purchase-order-field-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
  }

  .purchase-order-form-group {
    margin-bottom: 0;
  }

  .purchase-order-form-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #334155;
    line-height: 1.35;
  }

  .purchase-order-form-label .required-mark {
    color: #DC2626;
    font-weight: 700;
  }

  .purchase-order-form-control {
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

  .purchase-order-form-control::placeholder {
    color: #94A3B8;
  }

  .purchase-order-form-control:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    outline: none;
  }

  .purchase-order-form-control.is-invalid {
    border-color: #DC2626;
    background-image: none;
  }

  .purchase-order-form-control[disabled] {
    background: #F8FAFC;
    color: #64748B;
    cursor: not-allowed;
  }

  .purchase-order-form-input-wrap {
    position: relative;
  }

  .purchase-order-form-input-wrap .input-icon {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #64748B;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    pointer-events: none;
  }

  .purchase-order-form-input-wrap .input-icon i,
  .purchase-order-form-input-wrap .input-icon svg {
    width: 18px;
    height: 18px;
    font-size: 18px;
    line-height: 1;
  }

  .purchase-order-form-input-wrap .purchase-order-form-control {
    padding-left: 38px;
  }

  .purchase-order-form-note {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #64748B;
    line-height: 1.45;
  }

  .purchase-order-form-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 24px;
    padding-top: 8px;
  }

  .purchase-order-submit-btn,
  .purchase-order-cancel-btn {
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
    border: 1px solid transparent;
    cursor: pointer;
  }

  .purchase-order-submit-btn {
    background: #2563EB;
    color: #FFFFFF;
    box-shadow: none;
  }

  .purchase-order-submit-btn:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .purchase-order-cancel-btn {
    background: #FFFFFF;
    color: #64748B;
    border-color: #CBD5E1;
  }

  .purchase-order-cancel-btn:hover {
    background: #F8FAFC;
    color: #334155;
    text-decoration: none;
  }

  .purchase-order-form-invalid {
    width: 100%;
    margin-top: 6px;
    font-size: 12px;
    color: #DC2626;
  }

  @media (max-width: 767.98px) {
    .purchase-order-form-wrap {
      margin-top: 12px;
      padding: 0 10px;
    }

    .purchase-order-field-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }

    .purchase-order-form-header,
    .purchase-order-form-body {
      padding-left: 16px;
      padding-right: 16px;
    }

    .purchase-order-form-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .purchase-order-submit-btn,
    .purchase-order-cancel-btn {
      width: 100%;
    }
  }
</style>

<div class="page-header mt-4 mx-3">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        @include('layouts.dashboard-breadcrumb', ['current' => $purchaseOrder ? 'Edit PO' : 'Tambah PO'])
      </div>
    </div>
  </div>
</div>

<div class="purchase-order-form-shell">
  <div class="purchase-order-form-wrap">
    <div class="purchase-order-form-card">
      <div class="purchase-order-form-header">
        <h5 class="purchase-order-form-title">{{ $purchaseOrder ? 'Edit Purchase Order' : 'Tambah Purchase Order' }}</h5>
        <p class="purchase-order-form-subtitle">{{ $purchaseOrder ? 'Perbarui informasi Purchase Order di bawah ini.' : 'Lengkapi informasi Purchase Order di bawah ini.' }}</p>
      </div>
      <div class="purchase-order-form-body">
        @if ($purchaseOrder)
          <form action="{{ route('purchase-orders.update', $purchaseOrder->id) }}" method="POST">
        @else
          <form action="{{ route('purchase-orders.store') }}" method="POST">
        @endif
          @csrf
          @if ($purchaseOrder)
            @method('PUT')
          @endif

          <div class="purchase-order-field-grid">
            <div class="purchase-order-form-group">
              <label class="purchase-order-form-label" for="no_po">
                Nomor PO <span class="required-mark">*</span>
              </label>
              <div class="purchase-order-form-input-wrap">
                <span class="input-icon" aria-hidden="true"><i class="ti ti-file-text"></i></span>
                <input type="text" name="no_po" id="no_po" class="purchase-order-form-control @error('no_po') is-invalid @enderror"
                  value="{{ old('no_po', $purchaseOrder?->no_po ?? '') }}" placeholder="Contoh: KNL123123">
              </div>
              @error('no_po')
                <div class="purchase-order-form-invalid">{{ $message }}</div>
              @enderror
            </div>

            <div class="purchase-order-form-group">
              <label class="purchase-order-form-label" for="jenis_po">
                Jenis PO <span class="required-mark">*</span>
              </label>
              <div class="purchase-order-form-input-wrap">
                <span class="input-icon" aria-hidden="true"><i class="ti ti-package"></i></span>
                <input type="text" name="jenis_po" id="jenis_po" class="purchase-order-form-control @error('jenis_po') is-invalid @enderror"
                  value="{{ old('jenis_po', $purchaseOrder?->jenis_po ?? '') }}" placeholder="Contoh: PALLET, SUSU SHIFT, ULTRA 250ML">
              </div>
              @error('jenis_po')
                <div class="purchase-order-form-invalid">{{ $message }}</div>
              @enderror
            </div>

            <div class="purchase-order-form-group">
              <label class="purchase-order-form-label" for="tanggal_po">
                Tanggal PO <span class="required-mark">*</span>
              </label>
              <div class="purchase-order-form-input-wrap">
                <span class="input-icon" aria-hidden="true"><i class="ti ti-calendar-event"></i></span>
                <input type="date" name="tanggal_po" id="tanggal_po" class="purchase-order-form-control @error('tanggal_po') is-invalid @enderror"
                  value="{{ old('tanggal_po', $purchaseOrder ? $purchaseOrder->tanggal_po->format('Y-m-d') : '') }}">
              </div>
              @error('tanggal_po')
                <div class="purchase-order-form-invalid">{{ $message }}</div>
              @enderror
            </div>

            <div class="purchase-order-form-group">
              <label class="purchase-order-form-label" for="total_qty">
                Total Quantity <span class="required-mark">*</span>
              </label>
              <div class="purchase-order-form-input-wrap">
                <span class="input-icon" aria-hidden="true"><i class="ti ti-box"></i></span>
                <input type="number" name="total_qty" id="total_qty" class="purchase-order-form-control @error('total_qty') is-invalid @enderror"
                  value="{{ old('total_qty', $purchaseOrder?->total_qty ?? '') }}" placeholder="Minimal 1" min="1">
              </div>
              @error('total_qty')
                <div class="purchase-order-form-invalid">{{ $message }}</div>
              @enderror
            </div>
          </div>

          @if ($purchaseOrder)
            <div class="purchase-order-field-grid" style="margin-top: 18px;">
              <div class="purchase-order-form-group">
                <label class="purchase-order-form-label">Used Quantity</label>
                <input type="number" class="purchase-order-form-control" value="{{ $purchaseOrder->used_qty }}" disabled>
                <small class="purchase-order-form-note">Field ini tidak bisa diubah manual. Update melalui invoice/penggunaan.</small>
              </div>

              <div class="purchase-order-form-group">
                <label class="purchase-order-form-label">Status</label>
                <input type="text" class="purchase-order-form-control" value="{{ ucfirst($purchaseOrder->status) }}" disabled>
                <small class="purchase-order-form-note">Status otomatis: Open (used &lt; total) | Closed (used &gt;= total)</small>
              </div>
            </div>
          @endif

          <div class="purchase-order-form-actions">
            <button type="submit" class="purchase-order-submit-btn">
              <i class="ti ti-check" aria-hidden="true"></i>
              {{ $purchaseOrder ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('purchase-orders.index') }}" class="purchase-order-cancel-btn">
              <i class="ti ti-x" aria-hidden="true"></i>
              Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
