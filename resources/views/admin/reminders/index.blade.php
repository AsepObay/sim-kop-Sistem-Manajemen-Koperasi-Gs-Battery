@extends('layouts.template')

@section('title', 'Pengingat Tagihan')

@section('main-content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @include('layouts.dashboard-breadcrumb', ['current' => 'Pengingat Tagihan'])
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengingat Tagihan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @if(empty($reminders))
                        <div class="alert alert-light border mb-0">
                            Tidak ada reminder tagihan yang aktif saat ini.
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($reminders as $reminder)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold text-primary mb-1">🔔 {{ $reminder['label'] }}</div>
                                            <div class="mb-1"><strong>{{ $reminder['kode'] }}</strong></div>
                                            <div class="text-muted">Rp {{ number_format((float) $reminder['amount'], 0, ',', '.') }}</div>
                                        </div>
                                        <span class="badge bg-warning text-dark">Pengingat</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
