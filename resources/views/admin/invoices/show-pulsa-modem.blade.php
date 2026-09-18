@extends('layouts.template')

@section('title', 'Detail Invoice Pulsa Modem')

@section('main-content')
    @include('admin.invoices._detail', ['invoice' => $invoice])
    <div class="row">
    <div class="col-12">

        <div class="card mt-3">
            <div class="card-header"><h5>Item Invoice</h5></div>
            <div class="card-body">
                <div class="invoice-po-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Item</th>
                                <th width="12%">Qty</th>
                                <th width="13%">Unit</th>
                                <th width="20%">Harga</th>
                                <th width="20%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_item }}</td>
                                    <td class="text-center">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->unit }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $totalNilai = $invoice->items->sum('subtotal');
                                $totalQty = $invoice->items->sum('qty');
                            @endphp
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total Qty:</strong></td>
                                <td class="text-center"><strong>{{ number_format($totalQty, 0, ',', '.') }}</strong></td>
                                <td class="text-end"><strong>Grand Total:</strong></td>
                                <td colspan="2" class="text-end"><strong class="text-primary">Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong></td>
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
