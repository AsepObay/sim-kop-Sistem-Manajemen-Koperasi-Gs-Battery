@extends('layouts.template')

@section('title', 'Detail Purchase Order')

@section('main-content')
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Detail PO'])
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Purchase Order</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi PO</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%"><strong>No PO</strong></td>
                                        <td>: {{ $purchaseOrder->no_po }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis PO</strong></td>
                                        <td>: {{ $purchaseOrder->jenis_po }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal PO</strong></td>
                                        <td>: {{ $purchaseOrder->tanggal_po->format('d/m/Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%"><strong>Total Qty</strong></td>
                                        <td>: {{ number_format($purchaseOrder->total_qty, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Used Qty</strong></td>
                                        <td>: {{ number_format($purchaseOrder->used_qty, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>: <span class="badge bg-{{ $purchaseOrder->status === 'open' ? 'success' : 'secondary' }}">{{ ucfirst($purchaseOrder->status) }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Invoice Terkait</h5>
                    </div>
                    <div class="card-body">
                        @if($purchaseOrder->invoices->isEmpty())
                            <div class="alert alert-warning mb-0">Belum ada invoice untuk PO ini.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>No.Invoice</th>
                                            <th>No.SO</th>
                                            <th>Tipe</th>
                                            <th>Tanggal</th>
                                            <th class="text-end">Total Nilai</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchaseOrder->invoices as $index => $invoice)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $invoice->no_invoice }}</td>
                                                <td>{{ $invoice->no_so ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $invoice->tipe === 'PO' ? 'primary' : 'secondary' }}">
                                                        {{ $invoice->tipe }}
                                                    </span>
                                                </td>
                                                <td>{{ $invoice->tanggal_invoice->format('d/m/Y') }}</td>
                                                <td class="text-end">Rp {{ number_format($invoice->items->sum('subtotal'), 0, ',', '.') }}</td>
                                                <td>
                                                    @if($invoice->tipe === 'NON_PO')
                                                        <a href="{{ route('invoice-non-po.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection
