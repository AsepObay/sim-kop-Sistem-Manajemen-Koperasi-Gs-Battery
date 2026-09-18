@extends('layouts.template')

@section('title', 'Detail Invoice Voucher')

@section('main-content')
    @include('admin.invoices._detail', ['invoice' => $invoice])
    <div class="row">
    <div class="col-12">

        <div class="card mt-3">
            <div class="card-header">
                <h5>Rincian Voucher</h5>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                    <table class="invoice-table">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Item</th>
                                <th width="15%">Qty</th>
                                <th width="20%">Harga</th>
                                <th width="25%">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoice->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_item }}</td>
                                    <td class="text-center">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"><em>Belum ada item voucher</em></td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            @php
                                $subtotalQty = (int) $invoice->items->sum('qty');
                                $totalHarga = $invoice->items->sum('subtotal');
                            @endphp
                            <tr>
                                <td colspan="2" class="text-end"><strong>Sub Total Qty</strong></td>
                                <td class="text-center"><strong>{{ number_format($subtotalQty, 0, ',', '.') }}</strong></td>
                                <td class="text-end"><strong>Total Harga</strong></td>
                                <td class="text-end"><strong class="text-primary">Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @php
            $backUrl = request()->query('return', route('invoices.index'));
        @endphp

        <div class="card mt-3">
            <div class="card-body d-flex gap-2 flex-wrap">
                <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary">
                    <i class="ti ti-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
