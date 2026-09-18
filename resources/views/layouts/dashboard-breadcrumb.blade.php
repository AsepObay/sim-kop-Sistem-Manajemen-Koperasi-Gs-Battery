@php
    $current = $current ?? 'Dashboard';
    $homeLabel = $homeLabel ?? 'Home';
    $homeUrl = $homeUrl ?? url('dashboard');
    $currentUrl = $currentUrl ?? null;
@endphp

<div class="dashboard-breadcrumb-wrapper">
  <div class="breadcrumb-left">
    <span class="breadcrumb-home-icon"><i class="ti ti-home"></i></span>
    <span class="breadcrumb-home"><a href="{{ $homeUrl }}">{{ $homeLabel }}</a></span>
    <span class="breadcrumb-separator">›</span>
    @if($currentUrl)
      <span class="breadcrumb-current"><a href="{{ $currentUrl }}">{{ $current }}</a></span>
    @else
      <span class="breadcrumb-current">{{ $current }}</span>
    @endif
  </div>

  <div class="breadcrumb-meta">
    <div class="breadcrumb-date">
      <div class="breadcrumb-calendar"><i class="ti ti-calendar"></i></div>
      <div class="breadcrumb-date-text">
        <strong>{{ \Carbon\Carbon::now()->format('j F Y') }}</strong>
        <small>{{ \Carbon\Carbon::now()->format('l, H:i') }} WIB</small>
      </div>
    </div>

    <div class="breadcrumb-divider"></div>

    <div class="breadcrumb-online">
      <span class="online-dot"></span>
      <span>Online</span>
    </div>

    <div class="breadcrumb-divider"></div>

    <button class="breadcrumb-theme" type="button" aria-label="Toggle theme">
      <i class="ti ti-sun"></i>
    </button>
  </div>
</div>
