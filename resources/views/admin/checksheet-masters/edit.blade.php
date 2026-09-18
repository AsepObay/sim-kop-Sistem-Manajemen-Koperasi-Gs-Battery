@extends('layouts.template')

@section('title', 'Edit Master Checksheet')

@section('main-content')
<style>
	.checksheet-edit-page { --edit-ink:#132238; --edit-muted:#6b7b91; --edit-line:#e5ebf2; --edit-blue:#2563eb; }
	.checksheet-edit-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:18px; margin-bottom:22px; }
	.checksheet-edit-kicker { color:var(--edit-blue); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; margin-bottom:7px; }
	.checksheet-edit-title { color:var(--edit-ink); font-size:28px; font-weight:750; letter-spacing:-.03em; margin:0; }
	.checksheet-edit-description { color:var(--edit-muted); font-size:14px; margin:7px 0 0; }
	.checksheet-edit-page .card { border:1px solid var(--edit-line); border-radius:14px; box-shadow:0 8px 26px rgba(19,34,56,.06); overflow:hidden; }
	.checksheet-edit-page .card-header { display:flex; align-items:center; gap:13px; padding:18px 22px; background:linear-gradient(100deg,#f5f9ff,#fff); border-bottom:1px solid var(--edit-line); }
	.checksheet-edit-icon { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:11px; background:#dbeafe; color:var(--edit-blue); font-size:20px; }
	.checksheet-edit-heading { color:var(--edit-ink); font-size:15px; font-weight:800; margin:0; }
	.checksheet-edit-caption { color:var(--edit-muted); font-size:12px; margin:3px 0 0; }
	.checksheet-edit-page .card-body { padding:24px; }
	.checksheet-edit-page .form-section { padding:17px; border:1px solid #e7edf5; border-radius:12px; background:#fbfcfe; }
	.checksheet-edit-page .form-section + .form-section { margin-top:15px; }
	.checksheet-edit-page .form-section-title { display:flex; align-items:center; gap:8px; color:var(--edit-ink); font-size:12px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; margin:0 0 14px; }
	.checksheet-edit-page .form-section-title i { color:var(--edit-blue); font-size:17px; }
	.checksheet-edit-page .form-label { color:#52657c; font-size:12px; font-weight:750; margin-bottom:7px; }
	.checksheet-edit-page .form-control, .checksheet-edit-page .form-select { min-height:44px; border-color:#d9e3ee; border-radius:10px; background:#fff; }
	.checksheet-edit-page .form-control:focus, .checksheet-edit-page .form-select:focus { border-color:#7aa2e8; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
	.checksheet-edit-page .form-control[readonly] { color:#52657c; background:#f4f7fb; }
	.checksheet-edit-status { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:14px 16px; border:1px solid #e7edf5; border-radius:11px; background:#fff; }
	.checksheet-edit-status + .checksheet-edit-status { margin-top:10px; }
	.checksheet-edit-status-label { color:var(--edit-ink); font-size:13px; font-weight:700; }
	.checksheet-edit-status-caption { color:var(--edit-muted); font-size:11px; margin-top:2px; }
	.checksheet-edit-status .form-check-input { width:2.25em; height:1.2em; margin:0; cursor:pointer; }
	.checksheet-edit-actions { display:flex; justify-content:flex-end; gap:10px; padding-top:20px; }
	.checksheet-edit-actions .btn { min-height:42px; border-radius:9px; padding:9px 17px; font-weight:750; }
	.checksheet-edit-actions .btn-primary { border:0; box-shadow:0 6px 14px rgba(37,99,235,.2); }
	@media (max-width:575.98px) { .checksheet-edit-hero { align-items:flex-start; flex-direction:column; } .checksheet-edit-page .card-body { padding:16px; } .checksheet-edit-actions { flex-direction:column-reverse; } .checksheet-edit-actions .btn { width:100%; } }
</style>
<div class="checksheet-edit-page">
	<div class="page-header"><div class="page-block">@include('layouts.dashboard-breadcrumb', ['current' => 'Edit Master Checksheet'])</div></div>
	<div class="checksheet-edit-hero">
		<div><div class="checksheet-edit-kicker">Data Master / Edit</div><h1 class="checksheet-edit-title">Edit Checksheet</h1><p class="checksheet-edit-description">Perbarui informasi master checksheet dengan data terbaru.</p></div>
	</div>
	<div class="row"><div class="col-xl-8 col-lg-9 mx-auto"><div class="card">
		<div class="card-header"><span class="checksheet-edit-icon"><i class="ti ti-edit"></i></span><div><h5 class="checksheet-edit-heading">Edit Data Master</h5><p class="checksheet-edit-caption">Pastikan identitas, waktu, jumlah, dan status data sudah sesuai.</p></div></div>
		<div class="card-body">
			<form method="POST" action="{{ route('checksheet-masters.update', $checksheetMaster) }}">@csrf @method('PUT')
				<input type="hidden" name="category" value="{{ old('category', $checksheetMaster->category) }}">
				<input type="hidden" name="return_category" value="{{ $checksheetMaster->category }}">
				<input type="hidden" name="return_item" value="{{ $checksheetMaster->category === 'produk' ? $returnItem : '' }}">
				<div class="form-section">
					<p class="form-section-title"><i class="ti ti-tag"></i> Identitas Data</p>
					@if(old('category', $checksheetMaster->category) === 'pallet')
						<label class="form-label" for="master-name">Jenis Pallet</label><select name="name" id="master-name" class="form-select @error('name') is-invalid @enderror" required><option value="">Pilih jenis pallet</option>@foreach($palletTypes as $palletType)<option value="{{ $palletType }}" @selected(old('name', $checksheetMaster->name) === $palletType)>{{ $palletType === 'Box' ? 'Peti Box' : $palletType }}</option>@endforeach</select>
					@else
						<label class="form-label" for="master-name">Item Produk</label><input type="text" id="master-name" class="form-control" value="{{ $checksheetMaster->name }}" readonly><input type="hidden" name="name" value="{{ $checksheetMaster->name }}">
					@endif
					@error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
				</div>
				<div class="form-section">
					<p class="form-section-title"><i class="ti ti-calendar-event"></i> Waktu dan Jumlah</p>
					<div class="row g-3">
						@if(old('category', $checksheetMaster->category) === 'pallet')<div class="col-md-6"><label class="form-label" for="master-stamp-date">Tanggal Stempel</label><input type="date" name="tanggal" id="master-stamp-date" value="{{ old('tanggal', $checksheetMaster->tanggal?->format('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror">@error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>@endif
						<div class="{{ old('category', $checksheetMaster->category) === 'pallet' ? 'col-md-6' : 'col-12' }}"><label class="form-label" for="master-arrival-date">Tanggal Kedatangan</label><input type="date" name="tanggal_kedatangan" id="master-arrival-date" value="{{ old('tanggal_kedatangan', $checksheetMaster->tanggal_kedatangan?->format('Y-m-d')) }}" class="form-control @error('tanggal_kedatangan') is-invalid @enderror">@error('tanggal_kedatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
						<div class="col-12"><label class="form-label" for="master-quantity">Quantity</label><input type="number" name="quantity" id="master-quantity" value="{{ old('quantity', $checksheetMaster->quantity) }}" min="0" class="form-control @error('quantity') is-invalid @enderror" required>@error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
					</div>
				</div>
				<div class="form-section">
					<p class="form-section-title"><i class="ti ti-adjustments-horizontal"></i> Status Data</p>
					<div class="checksheet-edit-status"><div><div class="checksheet-edit-status-label">Aktif</div><div class="checksheet-edit-status-caption">Data dapat digunakan dalam checksheet.</div></div><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is-active" @checked(old('is_active', $checksheetMaster->is_active))></div>
					<div class="checksheet-edit-status"><div><div class="checksheet-edit-status-label">Sudah diarsipkan</div><div class="checksheet-edit-status-caption">Tandai data sebagai arsip.</div></div><input type="checkbox" name="is_archived" value="1" class="form-check-input" id="is-archived" @checked(old('is_archived', $checksheetMaster->is_archived))></div>
				</div>
				<div class="checksheet-edit-actions"><a href="{{ route('checksheet-masters.index', ['category' => $checksheetMaster->category, 'item' => $checksheetMaster->category === 'produk' ? $returnItem : null]) }}" class="btn btn-light border"><i class="ti ti-arrow-left me-1"></i> Batal</a><button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Perbarui Data</button></div>
			</form>
		</div>
	</div></div></div>
</div>
@endsection
