@extends('layouts.template')

@section('title', 'Settings')

@section('main-content')
<style>
    .settings-page { --settings-ink:#152238; --settings-muted:#718198; --settings-line:#e5ebf2; --settings-blue:#2563eb; --settings-teal:#0f766e; }
    .settings-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:24px; margin-bottom:24px; }
    .settings-kicker { color:var(--settings-blue); font-size:11px; font-weight:800; letter-spacing:.13em; text-transform:uppercase; margin-bottom:8px; }
    .settings-title { color:var(--settings-ink); font-size:30px; font-weight:800; letter-spacing:-.03em; margin:0; }
    .settings-description { color:var(--settings-muted); font-size:14px; margin:8px 0 0; }
    .settings-page .card { border:1px solid var(--settings-line); border-radius:14px; box-shadow:0 8px 25px rgba(21,34,56,.055); overflow:hidden; }
    .settings-page .card-header { display:flex; align-items:center; gap:13px; padding:18px 22px; background:linear-gradient(105deg,#f5f9ff,#fff); border-bottom:1px solid var(--settings-line); }
    .settings-icon { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:11px; background:#dbeafe; color:var(--settings-blue); font-size:20px; }
    .settings-card-title { color:var(--settings-ink); font-size:15px; font-weight:800; margin:0; }
    .settings-card-caption { color:var(--settings-muted); font-size:12px; margin:3px 0 0; }
    .settings-page .card-body { padding:24px; }
    .settings-page .form-label { color:#52657c; font-size:12px; font-weight:800; margin-bottom:7px; }
    .settings-page .form-control { min-height:44px; border-color:#d9e3ee; border-radius:10px; }
    .settings-page textarea.form-control { min-height:108px; resize:vertical; }
    .settings-page .form-control:focus { border-color:#7aa2e8; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .settings-field { margin-bottom:18px; }
    .settings-field-hint { color:#91a0b3; font-size:11px; margin-top:6px; }
    .settings-save { min-height:43px; border:0; border-radius:9px; padding:9px 18px; font-weight:800; box-shadow:0 7px 15px rgba(37,99,235,.2); }
    .settings-shortcut { display:flex; align-items:center; justify-content:space-between; gap:18px; height:100%; padding:20px; background:linear-gradient(135deg,#f0fdfa,#fff); }
    .settings-shortcut-icon { display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; flex:0 0 44px; border-radius:12px; background:#ccfbf1; color:var(--settings-teal); font-size:22px; }
    .settings-shortcut-copy { flex:1; }
    .settings-shortcut-title { color:var(--settings-ink); font-size:15px; font-weight:800; margin:0 0 5px; }
    .settings-shortcut-text { color:var(--settings-muted); font-size:12px; margin:0; line-height:1.55; }
    .settings-shortcut .btn { flex:0 0 auto; border-radius:9px; font-weight:750; }
    .settings-system .card-body { padding:8px 22px 18px; }
    .settings-system-row { display:flex; align-items:center; justify-content:space-between; gap:15px; padding:14px 0; border-bottom:1px solid #edf1f6; }
    .settings-system-row:last-child { border-bottom:0; }
    .settings-system-label { color:var(--settings-muted); font-size:13px; }
    .settings-system-value { color:var(--settings-ink); font-size:13px; font-weight:800; text-align:right; }
    .settings-badge { display:inline-flex; padding:5px 9px; border-radius:999px; background:#eff6ff; color:#1d4ed8; font-size:11px; font-weight:800; }
    @media (max-width:767.98px) { .settings-hero { align-items:flex-start; flex-direction:column; } .settings-page .card-body { padding:18px; } .settings-shortcut { align-items:flex-start; flex-direction:column; } .settings-shortcut .btn { width:100%; } }
</style>

<div class="settings-page">
    <div class="page-header"><div class="page-block">@include('layouts.dashboard-breadcrumb', ['current' => 'Settings'])</div></div>
    <div class="settings-hero"><div><div class="settings-kicker">Workspace Control</div><h1 class="settings-title">Pengaturan Aplikasi</h1><p class="settings-description">Atur identitas dan pengalaman aplikasi SimKop dari satu tempat.</p></div></div>

    @if(session('success'))<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif
    @if($errors->any())<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert"><strong>Pengaturan belum tersimpan.</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card h-100"><div class="card-header"><span class="settings-icon"><i class="ti ti-adjustments-horizontal"></i></span><div><h5 class="settings-card-title">Pengaturan Umum</h5><p class="settings-card-caption">Informasi dasar yang digunakan di seluruh aplikasi.</p></div></div><div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">@csrf
                    <div class="row"><div class="col-md-6"><div class="settings-field"><label class="form-label" for="app-name">Nama Aplikasi <span class="text-danger">*</span></label><input type="text" id="app-name" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? 'SimKop') }}" required>@error('app_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div><div class="col-md-6"><div class="settings-field"><label class="form-label" for="app-email">Email Aplikasi <span class="text-danger">*</span></label><input type="email" id="app-email" class="form-control @error('app_email') is-invalid @enderror" name="app_email" value="{{ old('app_email', $settings['app_email'] ?? '') }}" required>@error('app_email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div></div>
                    <div class="row"><div class="col-md-6"><div class="settings-field"><label class="form-label" for="app-phone">Nomor Telepon Aplikasi</label><input type="text" id="app-phone" class="form-control @error('app_phone') is-invalid @enderror" name="app_phone" value="{{ old('app_phone', $settings['app_phone'] ?? '') }}">@error('app_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div></div>
                    <div class="settings-field"><label class="form-label" for="app-address">Alamat Aplikasi</label><textarea id="app-address" class="form-control @error('app_address') is-invalid @enderror" name="app_address" rows="3">{{ old('app_address', $settings['app_address'] ?? '') }}</textarea><div class="settings-field-hint">Alamat ini dapat digunakan sebagai identitas pada dokumen aplikasi.</div>@error('app_address')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary settings-save"><i class="ti ti-device-floppy me-1"></i> Simpan Pengaturan</button></div>
                </form>
            </div></div>
        </div>
        <div class="col-xl-4"><div class="card h-100"><div class="settings-shortcut"><span class="settings-shortcut-icon"><i class="ti ti-photo"></i></span><div class="settings-shortcut-copy"><h5 class="settings-shortcut-title">Tampilan Login</h5><p class="settings-shortcut-text">Kelola background login berupa gambar atau video.</p></div><a href="{{ route('settings.login_background.index') }}" class="btn btn-outline-success"><i class="ti ti-arrow-up-right me-1"></i> Kelola</a></div></div></div>
    </div>

    <div class="card settings-system mt-4"><div class="card-header"><span class="settings-icon"><i class="ti ti-activity"></i></span><div><h5 class="settings-card-title">Informasi Sistem</h5><p class="settings-card-caption">Ringkasan lingkungan aplikasi yang sedang berjalan.</p></div></div><div class="card-body"><div class="settings-system-row"><span class="settings-system-label">Versi Laravel</span><span class="settings-badge">{{ app()->version() }}</span></div><div class="settings-system-row"><span class="settings-system-label">Versi PHP</span><span class="settings-system-value">{{ phpversion() }}</span></div><div class="settings-system-row"><span class="settings-system-label">Total Users</span><span class="settings-system-value">{{ \App\Models\User::count() }}</span></div><div class="settings-system-row"><span class="settings-system-label">Total Super Admin</span><span class="settings-system-value">{{ \App\Models\User::where('role', 'SUPER_ADMIN')->count() }}</span></div><div class="settings-system-row"><span class="settings-system-label">Total Admin</span><span class="settings-system-value">{{ \App\Models\User::where('role', 'ADMIN')->count() }}</span></div></div></div>
</div>
@endsection
