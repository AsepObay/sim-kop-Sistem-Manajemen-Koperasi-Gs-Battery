@extends('layouts.template')

@section('title', 'Detail Invoice Mesin Vending')

@section('main-content')
    @include('admin.invoices._detail', ['invoice' => $invoice])
        <div class="row">
            <div class="col-12">

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Item Invoice</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="invoice-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="35%">No Faktur</th>
                                        <th width="20%">Total</th>
                                        <th width="25%">Revenue Sharing 5%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ optional($item->tanggal_item)->format('d/m/Y') }}</td>
                                            <td>{{ $item->nama_item }}</td>
                                            <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    @php
                                        $totalNilai = $invoice->items->sum('harga');
                                        $totalRevenue = $invoice->items->sum('subtotal');
                                        $totalPpn = $totalRevenue * 0.11;
                                        $totalPph = $totalRevenue * 0.10;
                                        $grandTotal = $totalRevenue + $totalPpn - $totalPph;
                                    @endphp
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total Nilai:</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>PPN 11%:</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($totalPpn, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>PPh -10%:</strong></td>
                                        <td class="text-end"><strong>- Rp {{ number_format($totalPph, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                        <td class="text-end"><strong class="text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
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
