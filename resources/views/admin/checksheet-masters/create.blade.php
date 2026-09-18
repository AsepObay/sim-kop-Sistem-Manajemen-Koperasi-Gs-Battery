@extends('layouts.template')

@section('title', 'Tambah Master Checksheet')

@section('main-content')
<div class="page-header"><div class="page-block">@include('layouts.dashboard-breadcrumb', ['current' => 'Tambah Master Checksheet'])</div></div>
<div class="row"><div class="col-lg-8 mx-auto"><div class="card"><div class="card-header"><h5 class="mb-0">Tambah Data Master</h5></div><div class="card-body">
<form method="POST" action="{{ route('checksheet-masters.store') }}">@csrf
<input type="hidden" name="category" id="master-category" value="{{ old('category', 'produk') }}">
<div class="mb-3"><label class="form-label">Item</label><select id="master-item" class="form-select" required><option value="">Pilih item</option><option value="Pallet" @selected(old('category') === 'pallet')>Pallet</option>@foreach($masterOptions->where('category', 'produk')->unique('name') as $item)<option value="{{ $item->name }}" @selected(old('name') === $item->name)>{{ $item->name }}</option>@endforeach</select></div>
<div class="mb-3" id="pallet-type-wrap" hidden><label class="form-label">Jenis Pallet</label><select name="name" id="master-name" class="form-select @error('name') is-invalid @enderror" required><option value="">Pilih jenis pallet</option>@foreach($palletTypes as $palletType)<option value="{{ $palletType }}" @selected(old('name') === $palletType)>{{ $palletType === 'Box' ? 'Peti Box' : $palletType }}</option>@endforeach</select>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="row"><div class="col-md-6 mb-3" id="stamp-date-wrap"><label class="form-label">Tanggal Stempel</label><input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror">@error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror</div><div class="col-md-6 mb-3"><label class="form-label">Tanggal Kedatangan</label><input type="date" name="tanggal_kedatangan" value="{{ old('tanggal_kedatangan') }}" class="form-control @error('tanggal_kedatangan') is-invalid @enderror">@error('tanggal_kedatangan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
<div class="mb-3"><label class="form-label">Quantity</label><input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" class="form-control @error('quantity') is-invalid @enderror" required>@error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="form-check mb-4"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is-active" checked><label class="form-check-label" for="is-active">Aktif</label></div>
<div class="form-check mb-4"><input type="checkbox" name="is_archived" value="1" class="form-check-input" id="is-archived"><label class="form-check-label" for="is-archived">Sudah diarsipkan</label></div>
<div class="d-flex gap-2"><a href="{{ route('checksheet-masters.index') }}" class="btn btn-light border">Batal</a><button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan</button></div>
</form></div></div></div></div>
<script>
const itemSelect = document.getElementById('master-item');
const categorySelect = document.getElementById('master-category');
const nameSelect = document.getElementById('master-name');
const palletTypeWrap = document.getElementById('pallet-type-wrap');
const stampDateWrap = document.getElementById('stamp-date-wrap');
const stampDateInput = stampDateWrap.querySelector('input');
const productOptions = @json($masterOptions->where('category', 'produk')->unique('name')->values());

function refreshMasterItem() {
	const isPallet = itemSelect.value === 'Pallet';
	categorySelect.value = isPallet ? 'pallet' : 'produk';
	palletTypeWrap.hidden = !isPallet;
	stampDateWrap.hidden = !isPallet;
	stampDateInput.disabled = !isPallet;
	nameSelect.required = isPallet;
	if (!isPallet) {
		nameSelect.required = false;
		nameSelect.innerHTML = '<option value="">Pilih item</option>';
		productOptions.forEach(item => nameSelect.add(new Option(item.name, item.name)));
		nameSelect.value = itemSelect.value;
	}
}

itemSelect.addEventListener('change', refreshMasterItem);
refreshMasterItem();
</script>
@endsection
