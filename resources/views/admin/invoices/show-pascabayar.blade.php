@extends('layouts.template')

@section('title', 'Detail Invoice Tagihan Pascabayar')

@section('main-content')
    @include('admin.invoices._detail', ['invoice' => $invoice])
        <div class="row">
            <div class="col-12">

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Item Invoice</h5>
                    </div>
                    <div class="card-body">
                        @if($invoice->items->isEmpty())
                            <div class="alert alert-warning mb-0">
                                Item invoice belum tersedia.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="invoice-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">Tanggal</th>
                                            <th>Nama Item</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">Unit</th>
                                            <th width="15%">Harga</th>
                                            <th width="18%">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalQtyItem = 0; @endphp
                                        @foreach($invoice->items as $key => $item)
                                            @php $totalQtyItem += $item->qty; @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->tanggal_item?->format('d/m/Y') ?? '-' }}</td>
                                                <td>{{ $item->nama_item }}</td>
                                                <td class="text-center">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                                <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        @php
                                            $subtotalItems = $invoice->items->sum('subtotal');
                                        @endphp
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Qty:</strong></td>
                                            <td class="text-center"><strong>{{ number_format($totalQtyItem, 0, ',', '.') }}</strong></td>
                                            <td colspan="2" class="text-end"><strong>Total Tagihan:</strong></td>
                                            <td class="text-end"><strong class="text-primary fs-5">Rp {{ number_format($subtotalItems, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Pivot Item Invoice (Per Invoice)</h5>
                    </div>
                    <div class="card-body">
                        @if($rows->isEmpty())
                            <div class="alert alert-warning mb-0">
                                Data invoice tidak ditemukan.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="invoice-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Item Barang</th>
                                            <th width="15%">Jumlah Item</th>
                                            <th width="25%">Total Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row->nama_item }}</td>
                                                <td class="text-center">{{ number_format($row->jumlah_item, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($row->total_nilai, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="2" class="text-end"><strong>TOTAL</strong></td>
                                            <td class="text-center"><strong>{{ number_format($totalQty, 0, ',', '.') }}</strong></td>
                                            <td class="text-end"><strong>Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
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
