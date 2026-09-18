@extends('admin.app')

@section('content')
<style>
  .po-list-shell {
    background: #F8FAFC;
    padding: 0 0 32px;
  }

  .po-list-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    overflow: hidden;
  }

  .po-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 20px;
    border-bottom: 1px solid #E2E8F0;
    background: #FFFFFF;
  }

  .po-header-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .po-header-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #EFF6FF;
    color: #2563EB;
    flex-shrink: 0;
  }

  .po-header-icon i {
    font-size: 16px;
    line-height: 1;
  }

  .po-header-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
  }

  .po-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .po-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .po-search-field {
    position: relative;
  }

  .po-search-input {
    width: 200px;
    height: 40px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0F172A;
    font-size: 13px;
    padding: 0 12px 0 38px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .po-search-input::placeholder {
    color: #94A3B8;
  }

  .po-search-input:focus {
    outline: none;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
  }

  .po-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748B;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    width: 16px;
    height: 16px;
  }

  .po-search-icon i {
    font-size: 16px;
    line-height: 1;
  }

  .po-search-button {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #CBD5E1;
    background: #FFFFFF;
    color: #64748B;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }

  .po-search-button:hover {
    border-color: #CBD5E1;
    background: #F8FAFC;
    color: #2563EB;
  }

  .po-primary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    padding: 0 16px;
    border-radius: 8px;
    background: #2563EB;
    color: #FFFFFF;
    border: 1px solid #2563EB;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .po-primary-btn:hover {
    background: #1D4ED8;
    color: #FFFFFF;
    text-decoration: none;
  }

  .po-primary-btn i {
    font-size: 16px;
    line-height: 1;
  }

  .po-table-body {
    background: #FFFFFF;
  }

  .po-table-wrap {
    width: 100%;
    overflow-x: auto;
  }

  .po-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    min-width: 860px;
  }

  .po-table thead th {
    background: #F8FAFC;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.01em;
    text-transform: none;
    padding: 12px 14px;
    border-bottom: 1px solid #E2E8F0;
    vertical-align: middle;
  }

  .po-table tbody td {
    padding: 13px 14px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #EEF2F7;
    vertical-align: middle;
  }

  .po-table tbody tr {
    transition: background 0.15s ease;
  }

  .po-table tbody tr:hover {
    background: #F8FAFC;
  }

  .po-no-value {
    font-weight: 700;
    color: #0F172A;
  }

  .po-qty-value {
    color: #334155;
    font-weight: 500;
  }

  .po-sisa-value {
    color: #0F172A;
    font-weight: 700;
  }

  .po-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.3;
    letter-spacing: 0.01em;
    text-transform: uppercase;
  }

  .po-status-badge--open {
    background: #EFF6FF;
    color: #2563EB;
  }

  .po-status-badge--closed {
    background: #F1F5F9;
    color: #64748B;
  }

  .po-status-badge--success {
    background: #ECFDF5;
    color: #16A34A;
  }

  .po-action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .po-action-group form {
    display: inline-flex;
    margin: 0;
  }

  .po-action-button {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #E2E8F0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    line-height: 1;
    transition: all 0.2s ease;
    padding: 0;
    background: #F8FAFC;
  }

  .po-action-button i {
    font-size: 15px;
    line-height: 1;
  }

  .po-action-button--edit {
    color: #2563EB;
    background: #EFF6FF;
    border-color: rgba(37, 99, 235, 0.12);
  }

  .po-action-button--edit:hover {
    background: #DBEAFE;
    color: #1D4ED8;
  }

  .po-action-button--delete {
    color: #DC2626;
    background: #FEF2F2;
    border-color: rgba(220, 38, 38, 0.12);
  }

  .po-action-button--delete:hover {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .po-action-button--close {
    color: #D97706;
    background: #FFF7ED;
    border-color: rgba(217, 119, 6, 0.12);
  }

  .po-action-button--close:hover {
    background: #FFEDD5;
    color: #B45309;
  }

  .po-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 42px 20px 36px;
    text-align: center;
  }

  .po-empty-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    margin-bottom: 14px;
  }

  .po-empty-icon i {
    font-size: 22px;
    line-height: 1;
  }

  .po-empty-title {
    margin: 0 0 6px;
    color: #0F172A;
    font-size: 18px;
    font-weight: 600;
  }

  .po-empty-text {
    margin: 0 0 18px;
    color: #64748B;
    font-size: 13px;
    line-height: 1.5;
  }

  .po-table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    padding: 14px 20px;
    border-top: 1px solid #E2E8F0;
    background: #FFFFFF;
    color: #64748B;
    font-size: 12px;
  }

  .po-table-footer strong {
    color: #334155;
  }

  .po-pagination {
    margin: 0;
  }

  .po-pagination .pagination {
    margin: 0;
  }

  .po-pagination .page-item .page-link {
    border-radius: 8px;
    margin-left: 4px;
    border: 1px solid #E2E8F0;
    color: #475569;
    font-size: 12px;
    padding: 0.4rem 0.7rem;
    background: #FFFFFF;
  }

  .po-pagination .page-item.active .page-link {
    background: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
  }

  @media (max-width: 767.98px) {
    .po-list-header {
      align-items: flex-start;
    }

    .po-header-title-wrap {
      width: 100%;
    }

    .po-toolbar {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr;
    }

    .po-search-form {
      width: 100%;
    }

    .po-search-field {
      width: 100%;
      flex: 1 1 auto;
    }

    .po-search-input {
      width: 100%;
    }

    .po-primary-btn {
      width: 100%;
    }

    .po-table-footer {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<div class="page-header mt-4 mx-3">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        @include('layouts.dashboard-breadcrumb', ['current' => 'Kelola PO'])
      </div>
    </div>
  </div>
</div>

<div class="po-list-shell">
  <div class="row mt-4 mx-3">nano resources/views/admin/purchase-orders/index.blade.php
    <div class="col-md-12">
      <div class="po-list-card">
        <div class="po-list-header">
          <div class="po-header-title-wrap">
            <span class="po-header-icon" aria-hidden="true"><i class="ti ti-package"></i></span>
            <h5 class="po-header-title">Daftar Purchase Order</h5>
          </div>

          <div class="po-toolbar">
            <form class="po-search-form" method="GET" action="{{ route('purchase-orders.index') }}">
              <div class="po-search-field">
                <span class="po-search-icon" aria-hidden="true"><i class="ti ti-search"></i></span>
                <input type="text" name="q" class="po-search-input" placeholder="Cari No PO..." value="{{ $search }}">
              </div>
              <button class="po-search-button" type="submit" aria-label="Cari">
                <i class="ti ti-search"></i>
              </button>
            </form>

            <a href="{{ route('purchase-orders.create') }}" class="po-primary-btn">
              <i class="ti ti-plus"></i>
              Tambah PO
            </a>
          </div>
        </div>

        <div class="po-table-body">
          @if ($purchaseOrders->count() > 0)
            <div class="po-table-wrap">
              <table class="po-table align-middle">
                <thead>
                  <tr>
                    <th>No PO</th>
                    <th>Jenis PO</th>
                    <th>Tanggal</th>
                    <th>Total Qty</th>
                    <th>Used Qty</th>
                    <th>Sisa Qty</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($purchaseOrders as $po)
                    @php
                      $sisaQty = $po->remainingQty();
                      $statusKey = $po->status === 'open' ? 'open' : 'closed';
                      $statusLabel = strtoupper($po->status ?? 'closed');
                    @endphp
                    <tr>
                      <td><span class="po-no-value">{{ $po->no_po }}</span></td>
                      <td>{{ $po->jenis_po }}</td>
                      <td>{{ $po->tanggal_po->format('d M Y') }}</td>
                      <td><span class="po-qty-value">{{ $po->total_qty }}</span></td>
                      <td><span class="po-qty-value">{{ $po->used_qty }}</span></td>
                      <td><span class="po-sisa-value">{{ $sisaQty }}</span></td>
                      <td>
                        @if ($po->status === 'open')
                          <span class="po-status-badge po-status-badge--open">Open</span>
                        @else
                          <span class="po-status-badge po-status-badge--closed">Closed</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <div class="po-action-group">
                          @if ($po->status === 'open')
                            <a href="{{ route('purchase-orders.edit', $po->id) }}" class="po-action-button po-action-button--edit" title="Edit">
                              <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" class="delete-po-form" data-po-no="{{ $po->no_po }}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="po-action-button po-action-button--delete" title="Hapus">
                                <i class="ti ti-trash"></i>
                              </button>
                            </form>
                            <form action="{{ route('purchase-orders.close', $po->id) }}" method="POST" class="close-po-form" data-po-no="{{ $po->no_po }}">
                              @csrf
                              <button type="submit" class="po-action-button po-action-button--close" title="Tutup PO">
                                <i class="ti ti-lock"></i>
                              </button>
                            </form>
                          @else
                            <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" class="delete-po-form" data-po-no="{{ $po->no_po }}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="po-action-button po-action-button--delete" title="Hapus">
                                <i class="ti ti-trash"></i>
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="po-empty-state">
              <div class="po-empty-icon" aria-hidden="true"><i class="ti ti-package"></i></div>
              <h4 class="po-empty-title">Belum Ada Purchase Order</h4>
              
              <p class="po-empty-text">Data Purchase Order belum tersedia.</p>
              <a href="{{ route('purchase-orders.create') }}" class="po-primary-btn">
                <i class="ti ti-plus"></i>
                Tambah PO
              </a>
            </div>
          @endif
        </div>

        <div class="po-table-footer">
          <div>
            Menampilkan <strong>{{ $purchaseOrders->firstItem() ?? 0 }}</strong> sampai
            <strong>{{ $purchaseOrders->lastItem() ?? 0 }}</strong> dari
            <strong>{{ $purchaseOrders->total() }}</strong> PO
          </div>
          <div class="po-pagination">
            {{ $purchaseOrders->links('pagination::bootstrap-5') }}
          </div>
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

    // Konfirmasi sebelum hapus PO
    document.querySelectorAll('.delete-po-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const poNo = this.dataset.poNo;
            
            const result = await Swal.fire({
                title: 'Hapus Purchase Order?',
                html: `Yakin ingin menghapus PO <strong>${poNo}</strong>?<br><small class="text-muted">Data tidak dapat dikembalikan.</small>`,
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

    // Konfirmasi sebelum tutup PO
    document.querySelectorAll('.close-po-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const poNo = this.dataset.poNo;
            
            const result = await Swal.fire({
                title: 'Tutup Purchase Order?',
                html: `Yakin ingin menutup PO <strong>${poNo}</strong>?<br><small class="text-muted">PO yang sudah ditutup tidak dapat diedit lagi.</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-lock"></i> Ya, Tutup!',
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
