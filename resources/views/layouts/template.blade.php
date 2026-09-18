<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>@yield('title', 'Home') | Sim-Kop</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="{{ asset('assets/images/sim.png') }}" type="image/png"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" >
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}" id="sidebar-style-link" >
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" >
<!-- SIMKOP Loading CSS (global) -->
<!-- removed per request: loading.css not used -->
<style>
  .page-loading {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .page-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .data-loading {
    position: fixed;
    inset: 0;
    z-index: 2001;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .data-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .save-loading {
    position: fixed;
    inset: 0;
    z-index: 2002;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .save-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .update-loading {
    position: fixed;
    inset: 0;
    z-index: 2003;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .update-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .delete-loading {
    position: fixed;
    inset: 0;
    z-index: 2004;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .delete-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .upload-loading {
    position: fixed;
    inset: 0;
    z-index: 2005;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.42);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 180ms ease, visibility 180ms ease;
  }

  .upload-loading.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
  }

  .upload-progress {
    width: 100%;
    height: 8px;
    margin-top: 14px;
    overflow: hidden;
    border-radius: 999px;
    background: #dbeafe;
  }

  .upload-progress-fill {
    width: 35%;
    height: 100%;
    border-radius: inherit;
    background: #2563eb;
    animation: upload-progress-move 1.2s ease-in-out infinite;
  }

  .table-search-loading {
    position: relative;
  }

  .table-search-loading-indicator {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    width: 22px;
    height: 22px;
    border: 3px solid #dbeafe;
    border-right-color: transparent;
    border-bottom-color: #2563eb;
    border-radius: 50%;
    animation: table-search-spin 700ms linear infinite;
  }

  @keyframes table-search-spin {
    to { transform: rotate(360deg); }
  }

  @keyframes upload-progress-move {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(300%); }
  }

  .page-loading-panel {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 300px;
    padding: 22px 28px;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.2);
    color: #1f2937;
  }

  .page-loading-panel strong,
  .page-loading-panel span {
    display: block;
  }

  .page-loading-panel strong {
    font-size: 16px;
  }

  .page-loading-panel div span {
    margin-top: 4px;
    color: #6b7280;
    font-size: 14px;
  }

  .header-search-results {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    z-index: 2100;
    display: none;
    overflow: hidden;
    max-height: 360px;
    overflow-y: auto;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.14);
  }

  .header-search-results.is-visible { display: block; }

  .header-search-result {
    display: block;
    padding: 10px 14px;
    color: #1f2937;
    text-decoration: none;
    border-bottom: 1px solid #f1f5f9;
  }

  .header-search-result:last-child { border-bottom: 0; }
  .header-search-result:hover { background: #eff6ff; }
  .header-search-result strong { display: block; font-size: 13px; }
  .header-search-result small { display: block; margin-top: 3px; color: #64748b; font-size: 11px; }
  .header-search-result em { display: block; padding: 12px 14px; color: #64748b; font-size: 13px; font-style: normal; }

  .page-loading-spinner {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    border: 4px solid #dbeafe;
    border-right-color: transparent;
    border-bottom-color: #2563eb;
    border-radius: 50%;
    animation: page-loading-spin 800ms linear infinite;
  }

  @keyframes page-loading-spin {
    to { transform: rotate(360deg); }
  }

  @media (max-width: 420px) {
    .page-loading-panel {
      min-width: 0;
      width: calc(100% - 32px);
    }
  }
</style>
@stack('styles')
<!-- profile.css removed to restore original layout (custom styles kept in repo if needed) -->
 

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr">
  <div class="page-loading" id="pageLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Mohon Tunggu...</strong>
        <span>Sedang memuat halaman</span>
      </div>
    </div>
  </div>
  <div class="data-loading" id="dataLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Memuat Data...</strong>
        <span>Sedang mengambil data terbaru</span>
      </div>
    </div>
  </div>
  <div class="save-loading" id="saveLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Menyimpan Data...</strong>
        <span>Mohon tunggu sebentar</span>
      </div>
    </div>
  </div>
  <div class="update-loading" id="updateLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Memperbarui Data...</strong>
        <span>Perubahan sedang disimpan</span>
      </div>
    </div>
  </div>
  <div class="delete-loading" id="deleteLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Menghapus Data...</strong>
        <span>Mohon tunggu...</span>
      </div>
    </div>
  </div>
  <div class="upload-loading" id="uploadLoading" aria-hidden="true">
    <div class="page-loading-panel" role="status" aria-live="polite">
      <span class="page-loading-spinner" aria-hidden="true"></span>
      <div>
        <strong>Mengupload File...</strong>
        <span>File sedang diproses</span>
        <div class="upload-progress" aria-hidden="true">
          <div class="upload-progress-fill" id="uploadProgressFill"></div>
        </div>
      </div>
    </div>
  </div>
 <!-- [ Sidebar Menu ] start -->
    @include('layouts.sidebar')
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  
  <!-- Header Left -->
  <div class="header-left">
    <a href="#" class="sidebar-toggle" id="sidebar-hide" aria-label="Toggle sidebar">
      <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <rect x="0" y="1" width="18" height="2" rx="1" fill="#0f172a" opacity="0.9" />
        <rect x="0" y="6" width="18" height="2" rx="1" fill="#0f172a" opacity="0.9" />
        <rect x="0" y="11" width="18" height="2" rx="1" fill="#0f172a" opacity="0.9" />
      </svg>
    </a>
    <div class="header-title">
      <h5>
        <span class="dashboard-icon" aria-hidden="true">
          <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <linearGradient id="g1" x1="0" x2="1" y1="0" y2="1">
                <stop offset="0%" stop-color="#2563EB" />
                <stop offset="100%" stop-color="#0EA5E9" />
              </linearGradient>
            </defs>
            <rect x="0.5" y="0.5" width="27" height="27" rx="6" fill="#E8F4FF" />
            <rect x="6" y="6" width="6" height="6" rx="2" fill="url(#g1)" />
            <rect x="16" y="6" width="6" height="6" rx="2" fill="url(#g1)" />
            <rect x="6" y="16" width="6" height="6" rx="2" fill="url(#g1)" />
            <rect x="16" y="16" width="6" height="6" rx="2" fill="url(#g1)" />
          </svg>
        </span>
        Dashboard
      </h5>
      <span>Welcome back, {{ auth()->user()?->name ?? 'User' }}</span>
    </div>
  </div>

  <!-- Header Center -->
  <div class="header-center">
    <form action="{{ route('invoices.index') }}" method="GET" class="header-search-form" id="headerSearchForm">
      <i class="ti ti-search header-search-icon"></i>
      <input 
        type="search" 
        name="search" 
        class="form-control form-control-sm header-search-input" 
        placeholder="Cari Invoice, PO, atau SO..."
      />
      <div class="search-shortcut">Ctrl + K</div>
      <div class="header-search-results" id="headerSearchResults" aria-hidden="true"></div>
    </form>
  </div>

  <!-- Header Right -->
  <div class="header-right">
    <ul class="list-unstyled">
      @php
        $reminderItems = \App\Models\InvoiceReminder::pendingForDisplay();
        $reminderCount = count($reminderItems);
      @endphp
      <li class="nav-item header-notification reminder-notification-wrap">
        <a href="#" class="notification-link reminder-trigger" aria-label="Pengingat Tagihan">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M15 17h5l-1.405-1.405C18.403 14.79 18 13.92 18 13V9c0-3.07-1.64-5.64-4.5-6.32V2a1.5 1.5 0 0 0-3 0v.68C7.64 3.36 6 5.92 6 9v4c0 .92-.403 1.79-1.595 2.595L3 17h5m4 0v1a2 2 0 1 0 4 0v-1" stroke="#172b4d" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          @if($reminderCount > 0)
            <span class="notification-badge">{{ $reminderCount }}</span>
          @endif
        </a>

        <div class="reminder-dropdown" aria-hidden="true">
          <div class="reminder-dropdown-header">Pengingat Tagihan</div>

          @if($reminderCount > 0)
            @foreach($reminderItems as $reminder)
              <div class="reminder-item">
                <div class="reminder-item-title">🔔 {{ $reminder['label'] }}</div>
                <div class="reminder-item-code">{{ $reminder['kode'] }}</div>
                <div class="reminder-item-amount">Rp {{ number_format((float) $reminder['amount'], 0, ',', '.') }}</div>
              </div>
            @endforeach
          @else
            <div class="reminder-empty">Tidak ada reminder saat ini.</div>
          @endif

          <button type="button" class="reminder-desktop-toggle" id="reminder-desktop-toggle">
            Aktifkan notifikasi desktop
          </button>
          <a href="{{ route('reminders.index') }}" class="reminder-footer-link">Lihat Semua Tagihan</a>
        </div>
      </li>
      <li class="nav-item header-notification">
        <a href="#" class="notification-link" aria-label="Messages">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect x="2" y="4" width="20" height="14" rx="2" stroke="#172b4d" stroke-width="1.4" fill="none"/>
            <path d="M22 6l-10 7L2 6" stroke="#172b4d" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="notification-badge">5</span>
        </a>
      </li>
      @include('layouts.profile')
    </ul>
  </div>

</header>
<!-- [ Header ] end -->
  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
        @yield('main-content')
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">Copyright @ Asep Obay Badilah</p>
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="{{ url('/') }}">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- [Page Specific JS] start -->
  <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('assets/js/pcoded.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <script>change_box_container('false');</script>



  <script>layout_rtl_change('false');</script>


  <script>font_change("Public-Sans");</script>

  <!-- SIMKOP Loading JS (global) -->
  <!-- removed per request: loading.js not used -->
  <!-- Custom Page Scripts -->
  <script>
    (function(){
      var headerSearchForm = document.getElementById('headerSearchForm');
      var headerSearchInput = headerSearchForm ? headerSearchForm.querySelector('.header-search-input') : null;
      var headerSearchResults = document.getElementById('headerSearchResults');
      var headerSearchTimer;
      var headerSearchRequest;

      function escapeSearchHtml(value) {
        return String(value).replace(/[&<>'"]/g, function(character) {
          return {'&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'}[character];
        });
      }

      function closeHeaderSearch() {
        if (!headerSearchResults) return;
        headerSearchResults.classList.remove('is-visible');
        headerSearchResults.setAttribute('aria-hidden', 'true');
      }

      function renderHeaderSearch(results) {
        if (!headerSearchResults) return;
        if (!results.length) {
          headerSearchResults.innerHTML = '<em>Tidak ada data yang cocok.</em>';
        } else {
          headerSearchResults.innerHTML = results.map(function(result) {
            return '<a class="header-search-result" href="' + escapeSearchHtml(result.url) + '">' +
              '<strong>' + escapeSearchHtml(result.type) + ': ' + escapeSearchHtml(result.label) + '</strong>' +
              '<small>' + escapeSearchHtml(result.detail) + '</small></a>';
          }).join('');
        }
        headerSearchResults.classList.add('is-visible');
        headerSearchResults.setAttribute('aria-hidden', 'false');
      }

      if (headerSearchForm && headerSearchInput && headerSearchResults) {
        headerSearchForm.addEventListener('submit', function(event) {
          if (headerSearchInput.value.trim().length >= 2) event.preventDefault();
        });

        headerSearchInput.addEventListener('input', function() {
          var query = headerSearchInput.value.trim();
          window.clearTimeout(headerSearchTimer);
          if (headerSearchRequest) headerSearchRequest.abort();
          if (query.length < 2) {
            closeHeaderSearch();
            return;
          }

          headerSearchResults.innerHTML = '<em>Mencari Data...</em>';
          headerSearchResults.classList.add('is-visible');
          headerSearchResults.setAttribute('aria-hidden', 'false');
          headerSearchTimer = window.setTimeout(function() {
            headerSearchRequest = new AbortController();
            fetch('{{ route('header-search') }}?q=' + encodeURIComponent(query), { signal: headerSearchRequest.signal })
              .then(function(response) { return response.json(); })
              .then(function(payload) { renderHeaderSearch(payload.results || []); })
              .catch(function(error) { if (error.name !== 'AbortError') closeHeaderSearch(); });
          }, 250);
        });

        document.addEventListener('click', function(event) {
          if (!headerSearchForm.contains(event.target)) closeHeaderSearch();
        });
      }

      var pageLoading = document.getElementById('pageLoading');
      var dataLoading = document.getElementById('dataLoading');
      var saveLoading = document.getElementById('saveLoading');
      var updateLoading = document.getElementById('updateLoading');
      var deleteLoading = document.getElementById('deleteLoading');
      var uploadLoading = document.getElementById('uploadLoading');
      var uploadProgressFill = document.getElementById('uploadProgressFill');
      var activeDataRequests = 0;
      var downloadLoadingTimer;

      function showPageLoading() {
        if (!pageLoading) return;
        pageLoading.classList.add('is-visible');
        pageLoading.setAttribute('aria-hidden', 'false');
      }

      function showDataLoading() {
        if (!dataLoading) return;
        dataLoading.classList.add('is-visible');
        dataLoading.setAttribute('aria-hidden', 'false');
      }

      function hideDataLoading() {
        if (!dataLoading || activeDataRequests > 0) return;
        dataLoading.classList.remove('is-visible');
        dataLoading.setAttribute('aria-hidden', 'true');
      }

      function showSaveLoading() {
        if (!saveLoading) return;
        saveLoading.classList.add('is-visible');
        saveLoading.setAttribute('aria-hidden', 'false');
      }

      function showUpdateLoading() {
        if (!updateLoading) return;
        updateLoading.classList.add('is-visible');
        updateLoading.setAttribute('aria-hidden', 'false');
      }

      function showDeleteLoading() {
        if (!deleteLoading) return;
        deleteLoading.classList.add('is-visible');
        deleteLoading.setAttribute('aria-hidden', 'false');
      }

      function showUploadLoading() {
        if (!uploadLoading) return;
        uploadLoading.classList.add('is-visible');
        uploadLoading.setAttribute('aria-hidden', 'false');
        if (uploadProgressFill) uploadProgressFill.style.width = '35%';
      }

      function showDownloadLoading() {
        showDataLoading();
        window.clearTimeout(downloadLoadingTimer);
        downloadLoadingTimer = window.setTimeout(hideDataLoading, 1400);
      }

      function isUpdateForm(form) {
        var methodField = form.querySelector('input[name="_method"]');
        var submitter = form.querySelector('button[type="submit"], input[type="submit"]');
        var submitLabel = submitter ? (submitter.textContent || submitter.value || '') : '';
        return (methodField && /^(PUT|PATCH)$/i.test(methodField.value)) || /update|perbarui/i.test(submitLabel);
      }

      function isDeleteForm(form) {
        var methodField = form.querySelector('input[name="_method"]');
        var submitter = form.querySelector('button[type="submit"], input[type="submit"]');
        var submitLabel = submitter ? (submitter.textContent || submitter.value || '') : '';
        return (methodField && methodField.value.toUpperCase() === 'DELETE') || /ya,?\s*hapus|hapus/i.test(submitLabel);
      }

      function isUploadForm(form) {
        return Array.from(form.querySelectorAll('input[type="file"]')).some(function(input) {
          return input.files && input.files.length > 0;
        });
      }

      function isDownloadLink(link) {
        var url = new URL(link.href, window.location.href);
        return /download|export/i.test(url.pathname) || url.searchParams.has('export') || link.id === 'download-selected-invoices';
      }

      function isDownloadForm(form) {
        return /download|export/i.test(form.action) || form.id === 'invoice-export-form';
      }

      function isSearchForm(form) {
        return form.method.toLowerCase() === 'get' && (
          /search|filter|q|bulan|tanggal|month_year/i.test(form.className + ' ' + form.action) ||
          !!form.querySelector('input[name="search"], input[name="q"], input[name="month_year"], input[name="bulan"], input[name="tanggal_mulai"], input[name="tanggal_selesai"], select[name="per_page"]')
        );
      }

      function showTableSearchLoading(form) {
        var table = document.querySelector('.invoice-index-table-wrap, .po-table-body, .table-responsive');
        if (!table) return;
        table.classList.add('table-search-loading');
        if (!table.querySelector('.table-search-loading-indicator')) {
          var indicator = document.createElement('span');
          indicator.className = 'table-search-loading-indicator';
          indicator.setAttribute('aria-label', 'Mencari Data...');
          table.appendChild(indicator);
        }
      }

      function resetLoaders() {
        [pageLoading, dataLoading, saveLoading, updateLoading, deleteLoading, uploadLoading].forEach(function(loader) {
          if (!loader) return;
          loader.classList.remove('is-visible');
          loader.setAttribute('aria-hidden', 'true');
        });
        activeDataRequests = 0;
        if (uploadProgressFill) uploadProgressFill.style.width = '35%';
      }

      var nativeFormSubmit = HTMLFormElement.prototype.submit;
      HTMLFormElement.prototype.submit = function() {
        if (isDeleteForm(this)) showDeleteLoading();
        if (isDownloadForm(this)) showDownloadLoading();
        return nativeFormSubmit.call(this);
      };

      function isDataListUrl(url) {
        return /\/(purchase-orders|invoices|users|vendors|reminders|laporan(?:\/|$))(?:\/)?(?:\?|$)/i.test(url.pathname + url.search);
      }

      function isNavigableLink(link, event) {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return false;
        if (!link.href || link.target === '_blank' || link.hasAttribute('download')) return false;
        if (link.getAttribute('href') === '#' || link.href === window.location.href + '#') return false;
        if (link.dataset.bsToggle || link.dataset.bsDismiss) return false;
        return link.origin === window.location.origin;
      }

      document.addEventListener('click', function(event) {
        var link = event.target.closest('a');
        if (link && isNavigableLink(link, event)) {
          if (isDownloadLink(link)) {
            showDownloadLoading();
            return;
          }
          var targetUrl = new URL(link.href, window.location.href);
          if (isDataListUrl(targetUrl)) showDataLoading(); else showPageLoading();
        }
      });

      document.addEventListener('submit', function(event) {
        if (event.defaultPrevented || event.target.method.toLowerCase() === 'dialog') return;
        if (isDownloadForm(event.target)) {
          showDownloadLoading();
          return;
        }
        if (event.target.method.toLowerCase() === 'get') {
          if (isSearchForm(event.target)) showTableSearchLoading(event.target);
          else showPageLoading();
        }
        else {
          if (isUploadForm(event.target)) showUploadLoading();
          else if (isDeleteForm(event.target)) showDeleteLoading();
          else if (isUpdateForm(event.target)) showUpdateLoading();
          else showSaveLoading();
          event.target.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function(button) {
            button.disabled = true;
          });
        }
      });

      window.addEventListener('pageshow', function() {
        resetLoaders();
      });

      window.addEventListener('DOMContentLoaded', resetLoaders);
      window.addEventListener('load', resetLoaders);

      if (window.fetch) {
        var originalFetch = window.fetch;
        window.fetch = function() {
          var requestUrl = arguments[0] && arguments[0].url ? arguments[0].url : String(arguments[0] || '');
          var isHeaderSearchRequest = requestUrl.indexOf('header-search') !== -1;
          if (isHeaderSearchRequest) return originalFetch.apply(this, arguments);
          activeDataRequests++;
          showDataLoading();
          return originalFetch.apply(this, arguments).finally(function() {
            activeDataRequests--;
            hideDataLoading();
          });
        };
      }

      var originalXhrSend = XMLHttpRequest.prototype.send;
      XMLHttpRequest.prototype.send = function() {
        activeDataRequests++;
        showDataLoading();
        if (this.upload && uploadProgressFill) {
          this.upload.addEventListener('progress', function(event) {
            if (!event.lengthComputable) return;
            uploadProgressFill.style.width = Math.round((event.loaded / event.total) * 100) + '%';
          });
        }
        this.addEventListener('loadend', function() {
          activeDataRequests--;
          hideDataLoading();
        }, { once: true });
        return originalXhrSend.apply(this, arguments);
      };

      function initReminderDropdown(){
        document.querySelectorAll('.reminder-notification-wrap').forEach(function(wrap){
          var trigger = wrap.querySelector('.reminder-trigger');
          var dropdown = wrap.querySelector('.reminder-dropdown');
          if(!trigger || !dropdown) return;

          function openDrop(){ wrap.classList.add('open'); dropdown.setAttribute('aria-hidden','false'); }
          function closeDrop(){ wrap.classList.remove('open'); dropdown.setAttribute('aria-hidden','true'); }

          trigger.addEventListener('click', function(e){
            e.preventDefault(); e.stopPropagation();
            if(wrap.classList.contains('open')) closeDrop(); else openDrop();
          });

          // close when clicking outside
          document.addEventListener('click', function(e){ if(!wrap.contains(e.target)) closeDrop(); });
          // close on Escape
          document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeDrop(); });
        });
      }

      if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initReminderDropdown); else initReminderDropdown();
    })();
  </script>
  <script>
    (function(){
      var reminders = @json($reminderItems);
      var toggle = document.getElementById('reminder-desktop-toggle');
      var storageKey = 'simkop.desktop-reminders.v1';
      var remindersUrl = @json(route('reminders.index'));
      var iconUrl = @json(asset('assets/images/sim.png'));

      if (!toggle || !('Notification' in window)) {
        if (toggle) toggle.hidden = true;
        return;
      }

      function reminderKey(reminder) {
        return [reminder.jenis, reminder.kode, reminder.sort_key].join(':');
      }

      function readSeen() {
        try {
          return JSON.parse(localStorage.getItem(storageKey) || '[]');
        } catch (error) {
          return [];
        }
      }

      function notifyReminders() {
        if (Notification.permission !== 'granted') return;

        var seen = readSeen();
        var fresh = reminders.filter(function(reminder){
          return !seen.includes(reminderKey(reminder));
        });

        fresh.forEach(function(reminder){
          var notification = new Notification('Pengingat Tagihan', {
            body: reminder.label + ': ' + reminder.kode,
            icon: iconUrl,
            tag: reminderKey(reminder)
          });
          notification.onclick = function(){
            window.focus();
            window.location.href = remindersUrl;
          };
          seen.push(reminderKey(reminder));
        });

        localStorage.setItem(storageKey, JSON.stringify(seen.slice(-100)));
      }

      function updateToggleLabel() {
        if (Notification.permission === 'granted') {
          toggle.textContent = 'Notifikasi desktop aktif';
        } else if (Notification.permission === 'denied') {
          toggle.textContent = 'Notifikasi diblokir browser';
          toggle.disabled = true;
        }
      }

      toggle.addEventListener('click', function(){
        if (Notification.permission === 'default') {
          Notification.requestPermission().then(function(){
            updateToggleLabel();
            notifyReminders();
          });
        } else {
          notifyReminders();
        }
      });

      updateToggleLabel();
      notifyReminders();
    })();
  </script>
  @stack('scripts')

  <!-- breadcrumb injection removed -->
</body>
<!-- [Body] end -->

</html>

