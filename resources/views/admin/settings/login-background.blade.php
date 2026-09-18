@extends('layouts.template')

@section('title', 'Tampilan Login')

@section('main-content')
<style>
    .login-bg-page { --login-ink:#152238; --login-muted:#718198; --login-line:#e5ebf2; --login-blue:#2563eb; --login-teal:#0f766e; }
    .login-bg-hero { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin-bottom:24px; }
    .login-bg-kicker { color:var(--login-blue); font-size:11px; font-weight:800; letter-spacing:.13em; text-transform:uppercase; margin-bottom:8px; }
    .login-bg-title { color:var(--login-ink); font-size:30px; font-weight:800; letter-spacing:-.03em; margin:0; }
    .login-bg-description { color:var(--login-muted); font-size:14px; margin:8px 0 0; }
    .login-bg-page .card { border:1px solid var(--login-line); border-radius:14px; box-shadow:0 8px 25px rgba(21,34,56,.055); overflow:hidden; }
    .login-bg-page .card-header { display:flex; align-items:center; gap:13px; padding:18px 22px; background:linear-gradient(105deg,#f5f9ff,#fff); border-bottom:1px solid var(--login-line); }
    .login-bg-icon { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:11px; background:#dbeafe; color:var(--login-blue); font-size:20px; }
    .login-bg-card-title { color:var(--login-ink); font-size:15px; font-weight:800; margin:0; }
    .login-bg-card-caption { color:var(--login-muted); font-size:12px; margin:3px 0 0; }
    .login-bg-page .card-body { padding:22px; }
    .login-bg-preview { position:relative; min-height:280px; border-radius:12px; overflow:hidden; background:linear-gradient(135deg,#172554,#0f766e); }
    .login-bg-preview:after { position:absolute; inset:0; content:""; background:linear-gradient(120deg,rgba(15,23,42,.12),rgba(15,23,42,.58)); pointer-events:none; }
    .login-bg-preview img, .login-bg-preview video { display:block; width:100%; height:280px; object-fit:cover; }
    .login-bg-preview-empty { display:flex; align-items:center; justify-content:center; min-height:280px; color:#dbeafe; text-align:center; }
    .login-bg-preview-empty i { display:block; font-size:40px; margin-bottom:8px; }
    .login-bg-preview-label { position:absolute; z-index:1; right:14px; bottom:14px; left:14px; display:flex; align-items:center; justify-content:space-between; gap:12px; color:#fff; font-size:12px; }
    .login-bg-status { display:inline-flex; align-items:center; gap:6px; padding:6px 9px; border-radius:999px; background:#dcfce7; color:#166534; font-size:11px; font-weight:800; }
    .login-bg-status i { font-size:13px; }
    .login-bg-page .form-label { color:#52657c; font-size:12px; font-weight:800; margin-bottom:7px; }
    .login-bg-page .form-select, .login-bg-page .form-control { min-height:44px; border-color:#d9e3ee; border-radius:10px; }
    .login-bg-page .form-select:focus, .login-bg-page .form-control:focus { border-color:#7aa2e8; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .login-bg-upload { padding:16px; border:1px dashed #b8c9df; border-radius:12px; background:#f8fbff; }
    .login-bg-upload .form-text { color:var(--login-muted); font-size:11px; line-height:1.5; }
    .login-bg-page .form-check { padding:12px 14px 12px 36px; border:1px solid #e7edf5; border-radius:10px; background:#fbfcfe; }
    .login-bg-page .form-check-input { cursor:pointer; }
    .login-bg-save { min-height:43px; border:0; border-radius:9px; padding:9px 18px; font-weight:800; box-shadow:0 7px 15px rgba(37,99,235,.2); }
    .login-bg-table { margin:0; }
    .login-bg-table th { color:#52657c; background:#f4f7fb; border-bottom:1px solid #dce5ef; font-size:11px; letter-spacing:.04em; text-transform:uppercase; }
    .login-bg-table td { color:#27384e; vertical-align:middle; }
    .login-bg-thumb { width:116px; height:66px; object-fit:cover; border-radius:9px; border:1px solid var(--login-line); }
    .login-bg-type { display:inline-flex; padding:5px 9px; border-radius:999px; background:#eff6ff; color:#1d4ed8; font-size:11px; font-weight:800; }
    .login-bg-table .btn { border-radius:8px; font-weight:700; }
    .login-bg-info { height:100%; padding:20px; background:linear-gradient(135deg,#f0fdfa,#fff); }
    .login-bg-info-list { padding:0; margin:18px 0 0; list-style:none; }
    .login-bg-info-list li { display:flex; align-items:flex-start; gap:9px; padding:10px 0; border-bottom:1px solid rgba(15,118,110,.12); color:#52657c; font-size:12px; }
    .login-bg-info-list li:last-child { border-bottom:0; }
    .login-bg-info-list i { color:var(--login-teal); font-size:16px; }
    @media (max-width:767.98px) { .login-bg-hero { align-items:flex-start; flex-direction:column; } .login-bg-page .card-body { padding:17px; } .login-bg-table { min-width:650px; } }
</style>

<div class="login-bg-page">
    <div class="page-header"><div class="page-block">@include('layouts.dashboard-breadcrumb', ['current' => 'Tampilan Login'])</div></div>
    <div class="login-bg-hero"><div><div class="login-bg-kicker">Workspace Appearance</div><h1 class="login-bg-title">Tampilan Login</h1><p class="login-bg-description">Atur latar belakang yang menyambut pengguna saat masuk ke SimKop.</p></div></div>

    @if(session('success'))<div class="alert alert-success border-0 shadow-sm"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger border-0 shadow-sm"><strong>Background belum tersimpan.</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>@endif

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card"><div class="card-header"><span class="login-bg-icon"><i class="ti ti-photo"></i></span><div><h5 class="login-bg-card-title">Background Login</h5><p class="login-bg-card-caption">Pilih media yang akan tampil pada halaman masuk.</p></div></div><div class="card-body">
                    <div class="login-bg-preview mb-4">
                    @if($active && $active->type === 'video' && $active->file_path)<video autoplay muted loop playsinline><source src="{{ Storage::url($active->file_path) }}"></video><div class="login-bg-preview-label"><span>{{ basename($active->file_path) }}</span><span class="login-bg-status"><i class="ti ti-circle-check"></i> Aktif</span></div>
                    @elseif($active && $active->type === 'image' && $active->file_path)<img src="{{ Storage::url($active->file_path) }}" alt="Preview background aktif"><div class="login-bg-preview-label"><span>{{ basename($active->file_path) }}</span><span class="login-bg-status"><i class="ti ti-circle-check"></i> Aktif</span></div>
                    @else<div class="login-bg-preview-empty"><div><i class="ti ti-photo-off"></i><div>Background default sedang digunakan</div></div></div>@endif
                    </div>
                    <form action="{{ route('settings.login_background.store') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row g-3"><div class="col-md-6"><label class="form-label" for="background-type">Gunakan</label><select id="background-type" name="type" class="form-select"><option value="video">Video</option><option value="image">Gambar</option><option value="default">Default</option></select></div><div class="col-md-6"><label class="form-label" for="background-file">Upload File</label><div class="login-bg-upload"><input id="background-file" type="file" name="background" class="form-control"><div class="form-text">Video MP4/WebM maksimal 50MB. Gambar JPG/PNG/WebP maksimal 10MB.</div></div></div></div>
                        <div class="file-preview mt-3"></div>
                        <div class="form-check mt-3 mb-3"><input class="form-check-input" type="checkbox" name="activate" id="activateCheck" value="1"><label class="form-check-label" for="activateCheck"><strong>Aktifkan setelah upload</strong><small class="d-block text-muted">Background baru langsung digunakan setelah disimpan.</small></label></div>
                        <div class="d-flex justify-content-end"><button class="btn btn-primary login-bg-save" type="submit"><i class="ti ti-upload me-1"></i> Unggah / Simpan</button></div>
                    </form>
                </div></div>

            <div class="card mt-4"><div class="card-header"><span class="login-bg-icon"><i class="ti ti-library-photo"></i></span><div><h5 class="login-bg-card-title">Koleksi Background</h5><p class="login-bg-card-caption">Kelola media yang pernah diunggah.</p></div></div><div class="table-responsive"><table class="table login-bg-table"><thead><tr><th class="ps-4">Preview</th><th>Nama File</th><th>Tipe</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr></thead><tbody>
                    @forelse($backgrounds as $bg)<tr><td class="ps-4">@if($bg->type === 'video' && $bg->file_path)<video class="login-bg-thumb" muted loop playsinline><source src="{{ Storage::url($bg->file_path) }}"></video>@elseif($bg->type === 'image' && $bg->file_path)<img class="login-bg-thumb" src="{{ Storage::url($bg->file_path) }}" alt="Preview background">@else<span class="text-muted">Default</span>@endif</td><td><strong>{{ $bg->file_path ? basename($bg->file_path) : 'Background Default' }}</strong></td><td><span class="login-bg-type">{{ ucfirst($bg->type) }}</span></td><td>{!! $bg->is_active ? '<span class="login-bg-status"><i class="ti ti-circle-check"></i> Aktif</span>' : '<span class="text-muted small">Tidak aktif</span>' !!}</td><td class="text-end pe-4"><div class="d-flex justify-content-end gap-2">@if(!$bg->is_active)<form action="{{ route('settings.login_background.activate', $bg->id) }}" method="POST">@csrf<button class="btn btn-sm btn-outline-primary" title="Aktifkan"><i class="ti ti-player-play me-1"></i> Aktifkan</button></form>@endif @if($bg->file_path)<form action="{{ route('settings.login_background.destroy', $bg->id) }}" method="POST" onsubmit="return confirm('Hapus background ini?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button></form>@endif</div></td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-5"><i class="ti ti-photo-off d-block fs-3 mb-2"></i>Belum ada background yang diunggah.</td></tr>@endforelse
                </tbody></table></div></div>
        </div>
        <div class="col-xl-4"><div class="card h-100"><div class="login-bg-info"><span class="login-bg-icon" style="background:#ccfbf1;color:#0f766e;"><i class="ti ti-info-circle"></i></span><h5 class="login-bg-card-title mt-3">Panduan Media</h5><p class="login-bg-card-caption">Gunakan media yang ringan dan tajam agar halaman login tetap cepat dibuka.</p><ul class="login-bg-info-list"><li><i class="ti ti-movie"></i><span><strong>Video</strong><br>MP4 atau WebM, maksimal 50MB.</span></li><li><i class="ti ti-photo"></i><span><strong>Gambar</strong><br>JPG, PNG, GIF, atau WebP, maksimal 10MB.</span></li><li><i class="ti ti-shield-check"></i><span><strong>Akses</strong><br>Pengelolaan media hanya untuk SUPER_ADMIN.</span></li></ul></div></div></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="{{ route('settings.login_background.store') }}"]');
    const fileInput = form ? form.querySelector('input[name="background"]') : null;
    const typeSelect = form ? form.querySelector('select[name="type"]') : null;

    function showError(msg) {
        Swal.fire({ icon: 'error', title: 'Error', text: msg });
    }

    function showSuccess(msg) {
        Swal.fire({ icon: 'success', title: 'Sukses', text: msg, timer: 1600, showConfirmButton: false });
    }

    @if(session('success'))
        showSuccess("{{ session('success') }}");
    @endif

    @if(session('error'))
        showError("{{ session('error') }}");
    @endif

    if (!form) return;

    // preview element insertion
    const previewContainer = document.createElement('div');
    previewContainer.className = 'mb-3 file-preview';
    form.insertBefore(previewContainer, form.querySelector('.d-flex'));

    fileInput?.addEventListener('change', function (e) {
        previewContainer.innerHTML = '';
        const f = e.target.files && e.target.files[0];
        if (!f) return;
        const t = (typeSelect && typeSelect.value) || '';

        // client-side validation
        const maxVideo = 50 * 1024 * 1024; // 50MB
        const maxImage = 10 * 1024 * 1024; // 10MB
        const allowedVideo = ['video/mp4','video/webm'];
        const allowedImage = ['image/jpeg','image/png','image/webp','image/gif'];

        if (t === 'video') {
            if (!allowedVideo.includes(f.type)) {
                showError('Tipe file tidak diizinkan untuk video. Gunakan MP4 atau WebM.');
                fileInput.value = '';
                return;
            }
            if (f.size > maxVideo) {
                showError('Ukuran file video terlalu besar (maks 50MB).');
                fileInput.value = '';
                return;
            }
            // preview small video
            const vid = document.createElement('video');
            vid.style.width = '100%';
            vid.style.maxHeight = '200px';
            vid.style.objectFit = 'cover';
            vid.muted = true; vid.loop = true; vid.playsInline = true; vid.autoplay = true;
            vid.src = URL.createObjectURL(f);
            previewContainer.appendChild(vid);
        } else if (t === 'image') {
            if (!allowedImage.includes(f.type)) {
                showError('Tipe file tidak diizinkan untuk gambar. Gunakan JPG/PNG/WebP.');
                fileInput.value = '';
                return;
            }
            if (f.size > maxImage) {
                showError('Ukuran file gambar terlalu besar (maks 10MB).');
                fileInput.value = '';
                return;
            }
            const img = document.createElement('img');
            img.style.width = '100%'; img.style.maxHeight = '200px'; img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(f);
            previewContainer.appendChild(img);
        } else {
            showError('Pilih tipe terlebih dahulu (Video atau Gambar).');
            fileInput.value = '';
            return;
        }
    });

    form.addEventListener('submit', function (e) {
        const f = fileInput && fileInput.files && fileInput.files[0];
        const t = (typeSelect && typeSelect.value) || '';
        if (!f) {
            // allow submit if type default (no file)
            if (t === 'default') return true;
            // else warn user
            e.preventDefault();
            showError('Silakan pilih file untuk diunggah terlebih dahulu.');
            return false;
        }
        // further client checks already done on change
        return true;
    });
});
</script>
@endpush
