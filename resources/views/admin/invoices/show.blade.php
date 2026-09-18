@extends('layouts.template')

@section('title', 'Detail Invoice')

@section('main-content')
    @include('admin.invoices._detail', ['invoice' => $invoice])

                <!-- Invoice Items (styled like form) -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Item Invoice</h5>
                    </div>
                    <div class="card-body">
                        <div class="invoice-po-table-wrap">
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="25%">Nama Item</th>
                                        <th width="10%">Qty</th>
                                        <th width="10%">Unit</th>
                                        <th width="13%">Harga</th>
                                        <th width="15%">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @php $totalQty = 0; @endphp
                                            @foreach($invoice->items as $key => $item)
                                        @php $totalQty += $item->qty; @endphp
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_item)->format('d/m/Y') }}</td>
                                            <td>{{ $item->nama_item }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @php
                                        $subtotal = $invoice->items->sum('subtotal');
                                        $ppn = $subtotal * 0.11;
                                        $grandTotal = $subtotal + $ppn;
                                    @endphp
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total Qty:</strong></td>
                                        <td class="text-center"><strong>{{ $totalQty }}</strong></td>
                                        <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end"><strong>PPN 11%:</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($ppn, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end"><strong>Grand Total:</strong></td>
                                        <td class="text-end"><strong class="text-primary fs-5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Pivot Item Invoice (Per Invoice) for PO -->
                @if($invoice->tipe === 'PO')
                    @php
                        $pivotRows = $invoice->items->groupBy('nama_item')->map(function($group, $name) {
                            $jumlah_item = $group->sum('qty');
                            $total_nilai = $group->sum('subtotal');
                            $dpp = round($total_nilai * 11 / 12);
                            return (object)[
                                'nama_item' => $name,
                                'jumlah_item' => $jumlah_item,
                                'total_nilai' => $total_nilai,
                                'dpp' => $dpp,
                            ];
                        })->values();

                        $pivotTotalQty = $pivotRows->sum('jumlah_item');
                        $pivotTotalNilai = $pivotRows->sum('total_nilai');
                        $pivotTotalDpp = $pivotRows->sum('dpp');
                    @endphp

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Pivot Item Invoice (Per Invoice)</h5>
                        </div>
                        <div class="card-body">
                            @if($pivotRows->isEmpty())
                                <div class="alert alert-warning mb-0">Data invoice tidak ditemukan</div>
                            @else
                                <div class="table-responsive">
                                    <table class="invoice-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Item Barang</th>
                                                <th width="15%">Jumlah Item</th>
                                                <th width="25%">Total Nilai</th>
                                                <th width="20%">DPP (11/12)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pivotRows as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $row->nama_item }}</td>
                                                    <td class="text-center">{{ number_format($row->jumlah_item, 0, ',', '.') }}</td>
                                                    <td class="text-end">Rp {{ number_format($row->total_nilai, 0, ',', '.') }}</td>
                                                    <td class="text-end">Rp {{ number_format($row->dpp, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="2" class="text-end"><strong>TOTAL</strong></td>
                                                <td class="text-center"><strong>{{ number_format($pivotTotalQty, 0, ',', '.') }}</strong></td>
                                                <td class="text-end"><strong>Rp {{ number_format($pivotTotalNilai, 0, ',', '.') }}</strong></td>
                                                <td class="text-end"><strong>Rp {{ number_format($pivotTotalDpp, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @php
                    $backUrl = request()->query('return', route('invoices.index'));
                @endphp

                <!-- Action Buttons -->
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
