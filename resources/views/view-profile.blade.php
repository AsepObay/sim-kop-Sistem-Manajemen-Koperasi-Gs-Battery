@extends('layouts.template')

@section('main-content')
@include('layouts.dashboard-breadcrumb', ['current' => 'Profile'])

@push('styles')
<style>
  /* =========================
     PROFILE HEADER
  ========================= */

  .profile-header-card {
    position: relative;
    display: grid;
    grid-template-columns: minmax(300px, 1.2fr) minmax(240px, 0.9fr) auto;
    align-items: center;
    gap: 40px;

    background: linear-gradient(
      135deg,
      #eef6ff 0%,
      #ffffff 55%,
      #f5f9ff 100%
    );

    border: 1px solid #e7edf5;
    border-radius: 18px;

    padding: 28px 32px;
    margin: 24px 0;

    box-shadow: 0 8px 30px rgba(30, 64, 175, 0.06);
    overflow: hidden;
  }

  .profile-header-card::after {
    content: "GS";
    position: absolute;
    right: 25px;
    top: -15px;

    font-size: 130px;
    font-weight: 800;
    line-height: 1;

    color: rgba(13, 110, 253, 0.035);
    pointer-events: none;
    z-index: 0;
  }

  .profile-header-left,
  .profile-header-center,
  .profile-header-right {
    position: relative;
    z-index: 1;
  }

  /* LEFT */

  .profile-header-left {
    display: flex;
    align-items: center;
    gap: 20px;
    min-width: 0;
  }

  .avatar-wrapper {
    position: relative;
    flex-shrink: 0;
  }

  .profile-avatar {
    width: 115px;
    height: 115px;
    object-fit: cover;
    border-radius: 50%;

    border: 4px solid #ffffff;

    box-shadow:
      0 10px 25px rgba(0, 0, 0, 0.10);
  }

  .avatar-camera {
    position: absolute;
    right: 0;
    bottom: 4px;

    width: 34px;
    height: 34px;

    border-radius: 50%;
    border: 1px solid #d9e1ea;

    background: #ffffff;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    cursor: pointer;
  }

  .profile-meta {
    min-width: 0;
  }

  .profile-meta h2 {
    margin: 0 0 6px;
    font-size: 27px;
    font-weight: 700;
    color: #243447;
  }

  .profile-role {
    display: inline-flex;
    align-items: center;

    padding: 5px 11px;

    border-radius: 20px;

    background: #eef2f6;
    color: #6b7280;

    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.4px;
  }

  .profile-description {
    margin: 10px 0 0;
    color: #667085;
    font-size: 13px;
    line-height: 1.6;
  }

  /* CENTER */

  .profile-header-center {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 18px;
  }

  .profile-detail-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .profile-detail-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #ffffff;
    color: #2f80ed;

    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
  }

  /* Icon sizing + inherit color to ensure icon fonts render correctly */
  .profile-detail-icon i,
  .avatar-camera i,
  .profile-status .ti,
  .profile-action-group .ti {
    font-size: 18px;
    line-height: 1;
    color: inherit;
    display: inline-block;
  }

  /* Remove duplicate icon pseudo-element from other icon font (feather) when using .icon-box */
  .icon-box::before {
    display: none !important;
    content: none !important;
  }

  .icon-box i {
    font-size: 18px;
    color: inherit;
    display: inline-block;
  }

  /* Info cards: make icon container rounded, colored, and larger */
  .info-cards .card {
    border-radius: 12px;
    overflow: visible;
  }

  .info-cards .icon-box {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 8px 20px rgba(13, 46, 120, 0.08);
    background: transparent;
    transition: transform .12s ease, box-shadow .12s ease;
    border: 1px solid rgba(255,255,255,0.06);
    overflow: visible;
  }

  .info-cards .icon-box i {
    font-size: 20px;
    line-height: 1;
    color: #ffffff;
    display: inline-block;
  }

  .info-cards .icon-box.bg-light.text-primary {
    background: linear-gradient(135deg, rgba(47,128,237,0.90), rgba(15,99,209,0.86)) !important;
  }

  .info-cards .icon-box.bg-light.text-success {
    background: linear-gradient(135deg, rgba(58,210,159,0.90), rgba(16,185,129,0.86)) !important;
  }

  .info-cards .icon-box.bg-light.text-secondary {
    background: linear-gradient(135deg, rgba(179,186,194,0.90), rgba(107,114,128,0.86)) !important;
  }

  .info-cards .icon-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(13, 46, 120, 0.10);
  }

  /* Reusable small icon for info-card headers (rounded square, soft pastel) */
  .info-card-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(2,6,23,0.06);
    font-size: 18px;
    flex-shrink: 0;
  }

  .info-card-icon i { font-size: 18px; line-height: 1; display: inline-block; }

  .info-card-icon.contact { color: #2f80ed; background: rgba(47,128,237,0.08); }
  .info-card-icon.work { color: #10b981; background: rgba(16,185,129,0.08); }
  .info-card-icon.account { color: #7c3aed; background: rgba(124,58,237,0.08); }

  /* ensure header title alignment remains consistent */
  .d-flex.align-items-center > .info-card-icon { margin-left: 0; }

  /* Small row icons inside info cards (light rounded square with blue outline/icon) */
  .info-cards .card .small-icon {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(47,128,237,0.06);
    border: 1px solid rgba(47,128,237,0.08);
    box-shadow: 0 6px 14px rgba(13,46,120,0.03);
    margin-right: 12px;q
    flex-shrink: 0;
  }

  .info-cards .card .small-icon i {
    font-size: 16px;
    color: #2f80ed;
    display: inline-block;
    line-height: 1;
  }

  /* Layout for rows inside the card to include small-icon */
  .info-cards .card .info-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 0;
  }

  .info-cards .card hr + .info-row { padding-top: 10px; }

  .profile-detail-label {
    margin-bottom: 2px;

    color: #98a2b3;
    font-size: 11px;
  }

  .profile-detail-value {
    color: #344054;
    font-size: 14px;
    font-weight: 600;
  }

  /* Status pill used in Informasi Akun */
  .info-cards .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #064e3b;
    background: linear-gradient(180deg, rgba(34,197,94,0.16), rgba(34,197,94,0.08));
    border: 1px solid rgba(16,185,129,0.12);
    box-shadow: 0 6px 14px rgba(2,6,23,0.04);
  }

  .info-cards .status-pill.inactive {
    color: #334155;
    background: linear-gradient(180deg, rgba(148,163,184,0.10), rgba(148,163,184,0.06));
    border: 1px solid rgba(148,163,184,0.08);
  }

  /* RIGHT */

  .profile-header-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 16px;

    min-width: 210px;
  }

  .profile-action-group {
    display: flex;
    gap: 8px;
    white-space: nowrap;
  }

  .profile-action-group .btn {
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
  }

  .profile-status {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 10px 15px;

    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #edf1f5;

    border-radius: 12px;

    min-width: 135px;

    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
  }

  .status-dot {
    width: 9px;
    height: 9px;

    border-radius: 50%;

    background: #22c55e;

    box-shadow: 0 0 0 5px rgba(34, 197, 94, 0.10);
  }

  .status-title {
    font-size: 13px;
    font-weight: 700;
    color: #344054;
  }

  .status-subtitle {
    margin-top: 2px;

    font-size: 10px;
    color: #98a2b3;
  }


  /* =========================
     RESPONSIVE
  ========================= */

  @media (max-width: 991px) {

    .profile-header-card {
      grid-template-columns: 1fr;
      gap: 25px;
    }

    .profile-header-center {
      flex-direction: row;
      flex-wrap: wrap;
    }

    .profile-header-right {
      align-items: flex-start;
    }

  }

  @media (max-width: 576px) {

    .profile-header-card {
      padding: 22px 20px;
    }

    .profile-header-left {
      align-items: flex-start;
    }

    .profile-avatar {
      width: 90px;
      height: 90px;
    }

    .profile-meta h2 {
      font-size: 22px;
    }

    .profile-header-center {
      flex-direction: column;
    }

    .profile-action-group {
      width: 100%;
      flex-wrap: wrap;
    }

    .profile-header-right {
      width: 100%;
      align-items: flex-start;
    }

  }


  /* =========================
     COMPACT EDIT FORM
  ========================= */

  .compact-form .row.g-2 {
    --bs-gutter-x: .5rem;
    --bs-gutter-y: .5rem;
  }

  .compact-form .form-control,
  .compact-form .form-select,
  .compact-form textarea {
    padding: .375rem .5rem;
    font-size: .92rem;
  }

  .compact-form .profile-photo-compact {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 6px 18px rgba(2,6,23,.06);
  }

  .compact-form .btn-primary-save {
    padding: .45rem .8rem;
  }
</style>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

<div class="container-fluid px-3">
  @if($errors->any())
    <div class="alert alert-danger mt-3"><strong>Terdapat kesalahan:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
  @endif

  @if(!$user)
    <div class="alert alert-warning mt-3">Silakan login untuk melihat profil.</div>
  @else

  <!-- PROFILE HEADER -->
  <div class="profile-header-card">

    <!-- LEFT : AVATAR & IDENTITAS -->
    <div class="profile-header-left">

        <div class="avatar-wrapper">
            <img
                id="profilePreview"
                src="{{ $user->profile_photo_url }}"
                alt="user-image"
                class="profile-avatar"
            >

            <button
                type="button"
                class="avatar-camera"
                title="Ganti Foto"
                onclick="document.getElementById('profilePhotoInput').click()"
            >
                <i class="ti ti-camera"></i>
            </button>
        </div>

        <div class="profile-meta">

            <h2>{{ $user->name }}</h2>

            <span class="profile-role">
                {{ strtoupper($user->role ?? '') }}
            </span>

            <p class="profile-description">
                Administrator Sistem SIM-KOP<br>
                Bertanggung jawab penuh terhadap sistem.
            </p>

        </div>

    </div>


    <!-- CENTER : INFORMASI -->
    <div class="profile-header-center">

        <div class="profile-detail-item">

            <div class="profile-detail-icon">
                <i class="ti ti-mail"></i>
            </div>

            <div>
                <div class="profile-detail-label">
                    Email
                </div>

                <div class="profile-detail-value">
                    {{ $user->email }}
                </div>
            </div>

        </div>


        <div class="profile-detail-item">

            <div class="profile-detail-icon">
                <i class="ti ti-calendar-event"></i>
            </div>

            <div>
                <div class="profile-detail-label">
                    Bergabung Sejak
                </div>

                <div class="profile-detail-value">
                    {{ $user->created_at?->format('d F Y') ?? '-' }}
                </div>
            </div>

        </div>

    </div>


    <!-- RIGHT : ACTION & STATUS -->
    <div class="profile-header-right">

        <div class="profile-action-group">

            <button
                type="button"
                class="btn btn-outline-secondary"
                onclick="document.getElementById('profilePhotoInput').click()"
            >
                Ganti Foto
            </button>

            <a
                href="#edit-profile"
                class="btn btn-primary"
                onclick="document.getElementById('edit-tab').click();"
            >
                Edit Profile
            </a>

          <!-- Test loading button removed per request -->

        </div>


        <div class="profile-status">

            <div class="status-dot"></div>

            <div>

                <div class="status-title">
                    {{ ucfirst($user->status ?? 'aktif') }}
                </div>

                <div class="status-subtitle">
                    Status Akun
                </div>

            </div>

        </div>

    </div>

  </div>

  <!-- INFO CARDS -->
  <div class="row info-cards gy-3">
    <div class="col-lg-4 col-md-6">
      <div class="card p-3">
        <div class="d-flex align-items-center gap-3 mb-2">
          <div class="info-card-icon contact"><i class="ti ti-mail"></i></div>
          <div>
            <div class="text-muted small">Informasi Kontak</div>
            <div class="fw-semibold">Kontak & Alamat</div>
          </div>
        </div>
        <hr>
        <div class="info-row">
          <div class="small-icon"><i class="ti ti-mail"></i></div>
          <div>
            <div class="text-muted small">Email</div>
            <div class="mb-2">{{ $user->email }}</div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-phone"></i></div>
          <div>
            <div class="text-muted small">Telepon</div>
            <div class="mb-2">{{ $user->phone ?? '-' }}</div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-map-pin"></i></div>
          <div>
            <div class="text-muted small">Alamat</div>
            <div>{{ $user->address ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card p-3">
        <div class="d-flex align-items-center gap-3 mb-2">
          <div class="info-card-icon work"><i class="ti ti-briefcase"></i></div>
          <div>
            <div class="text-muted small">Informasi Pekerjaan</div>
            <div class="fw-semibold">Jabatan & Departemen</div>
          </div>
        </div>
        <hr>
        <div class="info-row">
          <div class="small-icon"><i class="ti ti-briefcase"></i></div>
          <div>
            <div class="text-muted small">Jabatan</div>
            <div class="mb-2">{{ $user->position ?? '-' }}</div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-building-store"></i></div>
          <div>
            <div class="text-muted small">Departemen</div>
            <div class="mb-2">{{ $user->department ?? '-' }}</div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-user"></i></div>
          <div>
            <div class="text-muted small">Manager</div>
            <div>-</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12">
      <div class="card p-3">
        <div class="d-flex align-items-center gap-3 mb-2">
          <div class="info-card-icon account"><i class="ti ti-shield-check"></i></div>
          <div>
            <div class="text-muted small">Informasi Akun</div>
            <div class="fw-semibold">Status & Role</div>
          </div>
        </div>
        <hr>
        <div class="info-row">
          <div class="small-icon"><i class="ti ti-shield-check"></i></div>
          <div>
            <div class="text-muted small">Status Akun</div>
            <div class="mb-2">
              <span class="status-pill {{ ($user->status ?? 'aktif') === 'aktif' ? 'active' : 'inactive' }}">{{ ucfirst($user->status ?? 'aktif') }}</span>
            </div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-id"></i></div>
          <div>
            <div class="text-muted small">Role</div>
            <div class="mb-2">{{ $user->role ?? '-' }}</div>
          </div>
        </div>

        <div class="info-row">
          <div class="small-icon"><i class="ti ti-calendar-event"></i></div>
          <div>
            <div class="text-muted small">Bergabung Sejak</div>
            <div>{{ $user->created_at?->format('d F Y') ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TABS -->
  <div class="card mt-4">
    <div class="card-body">
      <ul class="nav nav-tabs nav-profile-tabs" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"> <i class="ti ti-eye me-1"></i> Overview</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab"> <i class="ti ti-edit me-1"></i> Edit Profile</button>
        </li>
      </ul>
      <div class="tab-content mt-3">
        <!-- OVERVIEW -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
          <div class="profile-info-card mb-3">
            <div class="profile-info-header">
              <h5>Informasi Profil</h5>
              <p class="small">Informasi pribadi dan data akun Anda.</p>
            </div>

            <div class="profile-information-card">
              <div class="profile-info-grid">
                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-user"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Nama</div>
                    <div class="profile-info-value">{{ $user->name }}</div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-mail"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Email</div>
                    <div class="profile-info-value">{{ $user->email }}</div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-phone"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Telepon</div>
                    <div class="profile-info-value">{{ $user->phone ?? '-' }}</div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-briefcase"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Jabatan</div>
                    <div class="profile-info-value">{{ $user->position ?? '-' }}</div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-building-store"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Departemen</div>
                    <div class="profile-info-value">{{ $user->department ?? '-' }}</div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-icon"><i class="ti ti-map-pin"></i></div>
                  <div class="profile-info-meta">
                    <div class="profile-info-label">Alamat</div>
                    <div class="profile-info-value">{{ $user->address ?? '-' }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- EDIT PROFILE -->
        <div class="tab-pane fade" id="edit-profile" role="tabpanel">
          <div class="card" style="border-radius:12px;">
            <div class="card-body py-3">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <h5 class="mb-0">Edit Informasi Profil</h5>
                  <small class="text-muted">Perbarui informasi akun dan profil Anda.</small>
                </div>
              </div>

              <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="compact-form">
                @csrf
                <div class="row g-2 mt-3">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Nama</label>
                      <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Email</label>
                      <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Telepon</label>
                      <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Jabatan</label>
                      <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Departemen</label>
                      <input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label small">Status</label>
                      <select name="status" class="form-select">
                        <option value="aktif" {{ old('status', $user->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label class="form-label small">Alamat</label>
                      <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="text-center">
                      <img id="profilePreviewCard" src="{{ $user->profile_photo_url }}" class="profile-photo-compact mb-2">
                      <div>
                        <label class="btn btn-outline-secondary btn-sm" for="profilePhotoInput">Pilih Foto</label>
                        <input type="file" name="profile_photo" class="form-control d-none" accept="image/*" id="profilePhotoInput">
                        <div class="small text-muted mt-1">JPG, PNG maksimal 2MB</div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-white border" onclick="history.back()"><i class="ti ti-x"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-primary-save"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endif

</div>

@endsection

@push('scripts')
<script>
  // Keep original preview handler and mirror to card preview
  const photoInput = document.getElementById('profilePhotoInput');
  const preview = document.getElementById('profilePreview');
  const previewCard = document.getElementById('profilePreviewCard');

  if (photoInput) {
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
        if (preview) preview.src = e.target.result;
        if (previewCard) previewCard.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }
</script>
  <!-- SweetAlert2 JS + flash handler -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Sukses',
          text: {!! json_encode(session('success')) !!},
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          showCloseButton: true,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });
      @endif

      @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: {!! json_encode(session('error')) !!},
          showConfirmButton: true,
          confirmButtonText: 'Tutup'
        });
      @endif
    });
  </script>
  <!-- Test loading demo script removed per request -->
@endpush
