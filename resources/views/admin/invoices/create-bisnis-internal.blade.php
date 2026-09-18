@extends('layouts.template')

@section('title', 'Tambah Bisnis Internal')

@section('main-content')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        @include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Bisnis Internal'])
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Bisnis Internal</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Tambah Bisnis Internal untuk Invoice PO</h5>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terdapat kesalahan:</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('invoices.store-bisnis-internal') }}" method="POST" id="bisnisInternalForm">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="invoice_id">Pilih Invoice PO <span class="text-danger">*</span></label>
                                        <select name="invoice_id" id="invoice_id" class="form-select @error('invoice_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Invoice --</option>
                                            @foreach($invoices as $inv)
                                                <option value="{{ $inv->id }}" {{ old('invoice_id') == $inv->id ? 'selected' : '' }}>
                                                    {{ $inv->no_invoice }} - {{ $inv->purchaseOrder?->no_po ?? 'PO Manual' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('invoice_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="manual_invoice_part">Bisnis Internal <span class="text-danger">*</span></label>
                                        <input type="text" name="manual_invoice_part" id="manual_invoice_part" class="form-control @error('manual_invoice_part') is-invalid @enderror" value="{{ old('manual_invoice_part') }}" placeholder="Contoh: GS001" required>
                                        @error('manual_invoice_part')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Masukkan kode atau label Bisnis Internal yang ingin ditambahkan ke invoice ini.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy"></i> Simpan Bisnis Internal
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
