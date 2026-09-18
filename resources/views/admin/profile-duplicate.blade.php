@extends('layouts.template')

@section('title', 'Profile')
@section('main-content')
<div class="page-header mt-4 mx-3">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        @include('layouts.dashboard-breadcrumb', ['current' => 'Profile'])
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 mx-3">
  <!-- Profile Card -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
        @if(!$user)
          <div class="alert alert-warning mb-0">Silakan login untuk melihat profil.</div>
        @else
        <div class="row align-items-center">
          <div class="col-md-3 text-center">
            <div class="mb-3">
              <img id="profilePreview" src="{{ $user->profile_photo_url }}" alt="user-image" class="img-fluid rounded-circle" width="200">
            </div>
            <h4 class="mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-3">
              <span class="badge bg-primary">{{ $user->position ?? 'Belum diisi' }}</span>
            </p>
          </div>
          <div class="col-md-9">
            <div class="table-responsive">
              <table class="table table-borderless mb-0">
                <tbody>
                  <tr>
                    <td class="fw-bold" width="30%">Email</td>
                    <td>{{ $user->email }}</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Jabatan</td>
                    <td><span class="badge bg-primary">{{ $user->position ?? '-' }}</span></td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Departemen</td>
                    <td>{{ $user->department ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Status</td>
                    <td><span class="badge bg-{{ ($user->status ?? 'aktif') === 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($user->status ?? 'aktif') }}</span></td>
                  </tr>
                  <tr>
                    <td class="fw-bold">Bergabung</td>
                    <td>{{ $user->created_at?->format('d F Y') ?? '-' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@if($user)
<!-- Additional Info Cards -->
<div class="row mt-4 mx-3">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5>Informasi Kontak</h5>
      </div>
      <div class="card-body">
        <p class="mb-2">
          <strong>Email:</strong><br>
          {{ $user->email }}
        </p>
        <p class="mb-2">
          <strong>Telepon:</strong><br>
          {{ $user->phone ?? '-' }}
        </p>
        <p class="mb-0">
          <strong>Alamat:</strong><br>
          {{ $user->address ?? '-' }}
        </p>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5>Informasi Pekerjaan</h5>
      </div>
      <div class="card-body">
        <p class="mb-2">
          <strong>Posisi:</strong><br>
          {{ $user->position ?? '-' }}
        </p>
        <p class="mb-2">
          <strong>Departemen:</strong><br>
          {{ $user->department ?? '-' }}
        </p>
        <p class="mb-0">
          <strong>Manager:</strong><br>
          -
        </p>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 mx-3">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>Edit Profil</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="aktif" {{ old('status', $user->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Departemen</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}">
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <input type="file" name="profile_photo" class="form-control" accept="image/*" id="profilePhotoInput">
                <small class="text-muted">JPG/PNG, max 2MB, min 100x100</small>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Simpan Profil
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
<script>
  const photoInput = document.getElementById('profilePhotoInput');
  const preview = document.getElementById('profilePreview');

  if (photoInput && preview) {
    photoInput.addEventListener('change', function () {
      const file = this.files && this.files[0];
      if (!file) return;

      if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar.');
        this.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }
</script>
@endpush
