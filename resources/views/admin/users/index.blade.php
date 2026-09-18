@extends('layouts.template')

@section('title', 'Kelola Users')

@section('main-content')
<style>
    .users-page { --users-ink:#152238; --users-muted:#718198; --users-line:#e5ebf2; --users-blue:#2563eb; }
    .users-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin-bottom:24px; }
    .users-kicker { color:var(--users-blue); font-size:11px; font-weight:800; letter-spacing:.13em; text-transform:uppercase; margin-bottom:8px; }
    .users-title { color:var(--users-ink); font-size:30px; font-weight:800; letter-spacing:-.03em; margin:0; }
    .users-description { color:var(--users-muted); font-size:14px; margin:8px 0 0; }
    .users-add { display:inline-flex; align-items:center; gap:9px; min-height:44px; border:0; border-radius:10px; padding:8px 16px 8px 11px; background:var(--users-blue); color:#fff; font-weight:800; box-shadow:0 8px 17px rgba(37,99,235,.2); transition:transform .2s ease, box-shadow .2s ease; }
    .users-add i { display:inline-flex; align-items:center; justify-content:center; width:27px; height:27px; border-radius:8px; background:rgba(255,255,255,.18); font-size:17px; }
    .users-add:hover { color:#fff; transform:translateY(-2px); box-shadow:0 11px 22px rgba(37,99,235,.28); }
    .users-page .card { border:1px solid var(--users-line); border-radius:14px; box-shadow:0 8px 25px rgba(21,34,56,.055); overflow:hidden; }
    .users-card-head { display:flex; align-items:center; justify-content:space-between; gap:18px; padding:18px 22px; background:linear-gradient(105deg,#f5f9ff,#fff); border-bottom:1px solid var(--users-line); }
    .users-card-heading { display:flex; align-items:center; gap:12px; }
    .users-icon { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:11px; background:#dbeafe; color:var(--users-blue); font-size:20px; }
    .users-card-title { color:var(--users-ink); font-size:15px; font-weight:800; margin:0; }
    .users-card-caption { color:var(--users-muted); font-size:12px; margin:3px 0 0; }
    .users-total { display:inline-flex; align-items:center; gap:7px; padding:7px 10px; border-radius:999px; background:#eff6ff; color:#1d4ed8; font-size:11px; font-weight:800; }
    .users-page .card-body { padding:0; }
    .users-table { margin:0; }
    .users-table th { padding:14px 16px; color:#52657c; background:#f8fafc; border-bottom:1px solid #dce5ef; font-size:11px; letter-spacing:.04em; text-transform:uppercase; white-space:nowrap; }
    .users-table td { padding:15px 16px; color:#27384e; vertical-align:middle; }
    .users-table tbody tr { transition:background .18s ease; }
    .users-table tbody tr:hover { background:#f8fbff; }
    .users-avatar { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; margin-right:10px; border-radius:11px; background:linear-gradient(135deg,#2563eb,#0f766e); color:#fff; font-size:13px; font-weight:800; vertical-align:middle; }
    .users-name { color:var(--users-ink); font-weight:800; }
    .users-email { color:var(--users-muted); font-size:12px; }
    .users-role, .users-status { display:inline-flex; align-items:center; gap:5px; padding:6px 9px; border-radius:999px; font-size:11px; font-weight:800; white-space:nowrap; }
    .users-role.admin { background:#eff6ff; color:#1d4ed8; }
    .users-role.super { background:#fff7ed; color:#c2410c; }
    .users-status.active { background:#ecfdf5; color:#047857; }
    .users-status.inactive { background:#fef2f2; color:#b91c1c; }
    .users-actions { display:flex; justify-content:flex-end; gap:6px; }
    .users-actions .btn { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; padding:0; border-radius:8px; }
    .users-empty { padding:55px 20px !important; color:var(--users-muted) !important; text-align:center; }
    .users-empty i { display:block; margin-bottom:9px; color:#a9b8ca; font-size:38px; }
    .users-pagination { display:flex; align-items:center; justify-content:space-between; gap:18px; padding:17px 22px; border-top:1px solid var(--users-line); }
    .users-pagination-text { color:var(--users-muted); font-size:12px; }
    .users-pagination-text strong { color:var(--users-ink); }
    .users-pagination .pagination { margin:0; }
    .users-modal .modal-content { border:0; border-radius:15px; box-shadow:0 20px 55px rgba(21,34,56,.2); overflow:hidden; }
    .users-modal .modal-header { padding:21px 24px 18px; border-bottom:1px solid var(--users-line); background:linear-gradient(105deg,#f5f9ff,#fff); }
    .users-modal .modal-title { color:var(--users-ink); font-size:17px; font-weight:800; }
    .users-modal .modal-title i { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; margin-right:8px; border-radius:10px; background:#dbeafe; color:var(--users-blue); vertical-align:middle; }
    .users-modal .modal-subtitle { margin:7px 0 0 43px; color:var(--users-muted); font-size:12px; }
    .users-modal-close { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; padding:0; border:1px solid #d9e3ee; border-radius:10px; background:#fff; color:#718198; font-size:19px; line-height:1; transition:all .2s ease; }
    .users-modal-close:hover { border-color:#bfdbfe; background:#eff6ff; color:var(--users-blue); transform:rotate(90deg); }
    .users-modal-close:focus-visible { outline:0; border-color:#93b4ee; box-shadow:0 0 0 3px rgba(37,99,235,.14); }
    .users-modal .modal-body { padding:22px 24px; }
    .users-modal .form-label { color:#52657c; font-size:12px; font-weight:800; margin-bottom:7px; }
    .users-modal .form-control, .users-modal .form-select { min-height:43px; border-color:#d9e3ee; border-radius:9px; }
    .users-modal .form-control:focus, .users-modal .form-select:focus { border-color:#7aa2e8; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .users-modal textarea.form-control { min-height:85px; resize:vertical; }
    .users-modal .modal-footer { padding:15px 24px; border-top:1px solid var(--users-line); background:#fbfcfe; }
    .users-modal .modal-footer .btn { min-height:40px; border-radius:9px; padding-inline:16px; font-weight:750; }
    @media (max-width:767.98px) { .users-hero { align-items:flex-start; flex-direction:column; } .users-add { width:100%; justify-content:center; } .users-card-head { align-items:flex-start; flex-direction:column; } .users-pagination { align-items:flex-start; flex-direction:column; } .users-table { min-width:780px; } }
</style>

<div class="users-page">
    <div class="page-header"><div class="page-block">@include('layouts.dashboard-breadcrumb', ['current' => 'Kelola Users'])</div></div>
    <div class="users-hero"><div><div class="users-kicker">Access Directory</div><h1 class="users-title">Kelola User</h1><p class="users-description">Atur akun, peran, dan informasi pengguna aplikasi SimKop.</p></div><button type="button" class="users-add" data-bs-toggle="modal" data-bs-target="#userCreateModal"><i class="ti ti-plus"></i><span>Tambah User</span></button></div>

    @if(session('success'))<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif

    <div class="card"><div class="users-card-head"><div class="users-card-heading"><span class="users-icon"><i class="ti ti-users"></i></span><div><h5 class="users-card-title">Daftar Pengguna</h5><p class="users-card-caption">Kelola akses dan detail akun yang terdaftar.</p></div></div><span class="users-total"><i class="ti ti-users"></i> {{ $users->total() }} User</span></div><div class="table-responsive"><table class="table users-table"><thead><tr><th class="ps-4">No</th><th>Pengguna</th><th>Role</th><th>Status</th><th>Posisi</th><th class="text-end pe-4">Aksi</th></tr></thead><tbody>
        @forelse($users as $user)<tr><td class="ps-4">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td><td><span class="users-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span><span class="users-name">{{ $user->name }}</span><br><span class="users-email ms-5">{{ $user->email }}</span></td><td><span class="users-role {{ $user->role === 'SUPER_ADMIN' ? 'super' : 'admin' }}"><i class="ti {{ $user->role === 'SUPER_ADMIN' ? 'ti-shield-star' : 'ti-user-check' }}"></i>{{ $user->role === 'SUPER_ADMIN' ? 'Super Admin' : 'Admin' }}</span></td><td><span class="users-status {{ $user->status === 'aktif' ? 'active' : 'inactive' }}"><i class="ti ti-point-filled"></i>{{ ucfirst($user->status) }}</span></td><td>{{ $user->position ?? '-' }}</td><td class="text-end pe-4"><div class="users-actions"><button type="button" class="btn btn-outline-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#userEditModal{{ $user->id }}"><i class="ti ti-edit"></i></button><form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')"><i class="ti ti-trash"></i></button></form></div></td></tr>@empty<tr><td colspan="6" class="users-empty"><i class="ti ti-users-off"></i>Belum ada data user.</td></tr>@endforelse
    </tbody></table></div><div class="users-pagination"><div class="users-pagination-text">Menampilkan <strong>{{ $users->firstItem() ?? 0 }}</strong> sampai <strong>{{ $users->lastItem() ?? 0 }}</strong> dari <strong>{{ $users->total() }}</strong> user</div>{{ $users->links('pagination::bootstrap-5') }}</div></div>
</div>

@foreach($users as $user)
<div class="modal fade users-modal" id="userEditModal{{ $user->id }}" tabindex="-1" aria-labelledby="userEditModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"><div><h5 class="modal-title" id="userEditModalLabel{{ $user->id }}"><i class="ti ti-edit"></i>Edit User</h5><p class="modal-subtitle">Perbarui informasi akun <strong>{{ $user->name }}</strong> tanpa meninggalkan halaman ini.</p></div><button type="button" class="users-modal-close" data-bs-dismiss="modal" aria-label="Tutup"><i class="ti ti-x"></i></button></div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">@csrf @method('PUT')
                <div class="modal-body"><div class="row g-3">
                    <div class="col-md-6"><label class="form-label" for="user-name-{{ $user->id }}">Nama Lengkap <span class="text-danger">*</span></label><input type="text" id="user-name-{{ $user->id }}" name="name" value="{{ $user->name }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="user-email-{{ $user->id }}">Email <span class="text-danger">*</span></label><input type="email" id="user-email-{{ $user->id }}" name="email" value="{{ $user->email }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="user-password-{{ $user->id }}">Password Baru</label><input type="password" id="user-password-{{ $user->id }}" name="password" class="form-control" minlength="8"><small class="text-muted">Kosongkan jika tidak ingin mengubah.</small></div>
                    <div class="col-md-6"><label class="form-label" for="user-password-confirmation-{{ $user->id }}">Konfirmasi Password</label><input type="password" id="user-password-confirmation-{{ $user->id }}" name="password_confirmation" class="form-control" minlength="8"></div>
                    <div class="col-md-6"><label class="form-label" for="user-role-{{ $user->id }}">Role <span class="text-danger">*</span></label><select id="user-role-{{ $user->id }}" name="role" class="form-select" required><option value="ADMIN" @selected($user->role === 'ADMIN')>Admin</option><option value="SUPER_ADMIN" @selected($user->role === 'SUPER_ADMIN')>Super Admin</option></select></div>
                    <div class="col-md-6"><label class="form-label" for="user-phone-{{ $user->id }}">Nomor Telepon</label><input type="text" id="user-phone-{{ $user->id }}" name="phone" value="{{ $user->phone }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label" for="user-position-{{ $user->id }}">Posisi</label><input type="text" id="user-position-{{ $user->id }}" name="position" value="{{ $user->position }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label" for="user-department-{{ $user->id }}">Departemen</label><input type="text" id="user-department-{{ $user->id }}" name="department" value="{{ $user->department }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label" for="user-address-{{ $user->id }}">Alamat</label><textarea id="user-address-{{ $user->id }}" name="address" class="form-control" rows="3">{{ $user->address }}</textarea></div>
                </div></div>
                <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal"><i class="ti ti-x me-1"></i> Batal</button><button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button></div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade users-modal" id="userCreateModal" tabindex="-1" aria-labelledby="userCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"><div><h5 class="modal-title" id="userCreateModalLabel"><i class="ti ti-user-plus"></i>Tambah User</h5><p class="modal-subtitle">Buat akun pengguna baru untuk mengakses aplikasi SimKop.</p></div><button type="button" class="users-modal-close" data-bs-dismiss="modal" aria-label="Tutup"><i class="ti ti-x"></i></button></div>
            <form action="{{ route('users.store') }}" method="POST">@csrf
                <div class="modal-body"><div class="row g-3">
                    <div class="col-md-6"><label class="form-label" for="create-user-name">Nama Lengkap <span class="text-danger">*</span></label><input type="text" id="create-user-name" name="name" value="{{ old('name') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-email">Email <span class="text-danger">*</span></label><input type="email" id="create-user-email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-password">Password <span class="text-danger">*</span></label><input type="password" id="create-user-password" name="password" class="form-control" minlength="8" required></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-password-confirmation">Konfirmasi Password <span class="text-danger">*</span></label><input type="password" id="create-user-password-confirmation" name="password_confirmation" class="form-control" minlength="8" required></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-role">Role <span class="text-danger">*</span></label><select id="create-user-role" name="role" class="form-select" required><option value="">Pilih Role</option><option value="ADMIN" @selected(old('role') === 'ADMIN')>Admin</option><option value="SUPER_ADMIN" @selected(old('role') === 'SUPER_ADMIN')>Super Admin</option></select></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-phone">Nomor Telepon</label><input type="text" id="create-user-phone" name="phone" value="{{ old('phone') }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-position">Posisi</label><input type="text" id="create-user-position" name="position" value="{{ old('position') }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label" for="create-user-department">Departemen</label><input type="text" id="create-user-department" name="department" value="{{ old('department') }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label" for="create-user-address">Alamat</label><textarea id="create-user-address" name="address" class="form-control" rows="3">{{ old('address') }}</textarea></div>
                </div></div>
                <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal"><i class="ti ti-x me-1"></i> Batal</button><button type="submit" class="btn btn-primary"><i class="ti ti-user-plus me-1"></i> Buat User</button></div>
            </form>
        </div>
    </div>
</div>

@endsection
