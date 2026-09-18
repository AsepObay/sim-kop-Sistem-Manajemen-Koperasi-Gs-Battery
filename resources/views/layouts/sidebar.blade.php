@php
    $currentUser = auth()->user();
    $currentUserName = $currentUser?->name ?? 'User';
    $currentUserRole = $currentUser?->role ?? '';
    $currentUserInitial = strtoupper(substr($currentUserName, 0, 1));
@endphp

<nav class="pc-sidebar simkop-sidebar">
  <style>
    .simkop-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 260px;
      min-width: 260px;
      height: 100vh;
      min-height: 100vh;
      background-color: #0F172A;
      background-image: linear-gradient(rgba(8, 19, 34, 0.62), rgba(8, 19, 34, 0.72)), url("{{ asset('assets/images/Sidebar.png') }}");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: #E2E8F0;
      border-right: 1px solid rgba(148, 163, 184, 0.18);
      padding-top: 18px;
      overflow: hidden;
      z-index: 1026;
      box-sizing: border-box;
      transition: width 0.25s ease, min-width 0.25s ease, box-shadow 0.25s ease;
    }

    .simkop-sidebar::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(15, 23, 42, 0.08);
      pointer-events: none;
    }

    .simkop-sidebar > * {
      position: relative;
      z-index: 1;
    }

    .simkop-sidebar .navbar-wrapper {
      width: 260px;
      height: 100%;
      background: transparent;
      transition: width 0.25s ease, opacity 0.18s ease;
    }

    .simkop-sidebar .m-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 14px;
      padding: 12px 14px 18px;
      margin: 0 0 12px;
      border-bottom: 1px solid rgba(148, 163, 184, 0.12);
    }

    .simkop-sidebar .b-brand {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.96);
      border-radius: 12px;
      width: 48px;
      height: 48px;
      padding: 10px;
      box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      flex-shrink: 0;
    }

    .simkop-sidebar .b-brand:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 22px rgba(15, 23, 42, 0.18);
    }

    .simkop-sidebar .b-brand img {
      width: 28px;
      height: 28px;
      object-fit: contain;
      display: block;
    }

    .simkop-sidebar .brand-text {
      text-align: left;
      color: #E2E8F0;
      min-width: 0;
    }

    .simkop-sidebar .brand-name {
      display: block;
      font-size: 0.96rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      line-height: 1.2;
      color: #F8FAFC;
    }

    .simkop-sidebar .brand-subtitle {
      display: block;
      font-size: 12px;
      color: #94A3B8;
      line-height: 1.35;
      margin-top: 2px;
      white-space: nowrap;
    }

    .simkop-sidebar .navbar-content {
      padding: 0 8px 16px;
    }

    .simkop-sidebar .pc-navbar {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .simkop-sidebar .pc-item {
      margin: 4px 0;
      padding: 0 8px;
    }

    .simkop-sidebar .pc-link {
      display: flex;
      align-items: center;
      gap: 10px;
      height: 42px;
      padding: 0 12px;
      color: #E2E8F0;
      border-radius: 10px;
      text-decoration: none;
      border: 1px solid transparent;
      transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
      position: relative;
    }

    .simkop-sidebar .pc-link:hover {
      background: rgba(148, 163, 184, 0.08);
      color: #FFFFFF;
      border-color: rgba(148, 163, 184, 0.10);
      transform: translateX(1px);
    }

    .simkop-sidebar .pc-item.active > .pc-link,
    .simkop-sidebar .pc-link.active {
      background: #2563EB;
      color: #FFFFFF !important;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
      border-color: rgba(255, 255, 255, 0.08);
    }

    .simkop-sidebar .pc-item.active > .pc-link::before,
    .simkop-sidebar .pc-link.active::before {
      content: "";
      position: absolute;
      left: -6px;
      top: 10px;
      width: 3px;
      height: 22px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.85);
    }

    .simkop-sidebar .pc-link .pc-micon {
      width: 18px;
      height: 18px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #BFDBFE;
      flex-shrink: 0;
    }

    .simkop-sidebar .pc-link .pc-micon i,
    .simkop-sidebar .pc-link .pc-micon svg {
      font-size: 18px;
      line-height: 1;
    }

    .simkop-sidebar .pc-link:hover .pc-micon,
    .simkop-sidebar .pc-item.active > .pc-link .pc-micon,
    .simkop-sidebar .pc-link.active .pc-micon {
      color: #FFFFFF;
    }

    .simkop-sidebar .pc-mtext {
      font-size: 14px;
      line-height: 1.2;
      font-weight: 500;
      letter-spacing: 0.01em;
    }

    .simkop-sidebar .pc-submenu {
      list-style: none;
      padding: 4px 0 6px 0;
      margin: 0;
    }

    .simkop-sidebar .pc-submenu .pc-item {
      margin: 2px 0;
      padding: 0 12px 0 20px;
    }

    .simkop-sidebar .pc-submenu .pc-link {
      height: 36px;
      padding: 0 12px 0 14px;
      border-radius: 8px;
      color: #CBD5E1;
      background: transparent;
    }

    .simkop-sidebar .pc-submenu .pc-link:hover {
      background: rgba(148, 163, 184, 0.08);
      color: #FFFFFF;
    }

    .simkop-sidebar .pc-heading {
      margin: 10px 0 8px;
      padding: 0 16px;
      color: #64748B;
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .simkop-sidebar .sidebar-divider {
      margin: 12px 12px 10px;
      border-top: 1px solid #1E293B;
      opacity: 0.7;
    }

    .simkop-sidebar .user-card {
      margin: 14px 8px 0;
      padding: 14px 12px 12px;
      border: 1px solid #1E293B;
      border-radius: 12px;
      background: rgba(15, 23, 42, 0.72);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
    }

    .simkop-sidebar .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2563EB, #60A5FA);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FFFFFF;
      font-weight: 700;
      font-size: 14px;
      box-shadow: 0 8px 18px rgba(37, 99, 235, 0.24);
      flex-shrink: 0;
    }

    .simkop-sidebar .user-name {
      font-size: 14px;
      font-weight: 700;
      color: #F8FAFC;
      line-height: 1.25;
    }

    .simkop-sidebar .user-role {
      font-size: 11px;
      color: #94A3B8;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-top: 2px;
    }

    .simkop-sidebar .user-status {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
      color: #E2E8F0;
      font-size: 12px;
    }

    .simkop-sidebar .status-indicator {
      display: inline-block;
      width: 8px;
      height: 8px;
      background: #22C55E;
      border-radius: 50%;
      box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.18);
    }

    .simkop-sidebar .badge-sidebar {
      font-size: 12px;
      color: #E2E8F0;
      background: transparent;
      padding: 0;
    }

    .simkop-sidebar .user-meta-text {
      color: #94A3B8;
      font-size: 11px;
      margin-left: 2px;
    }

    .simkop-sidebar .pc-arrow i {
      color: #94A3B8;
      font-size: 12px;
    }

    .simkop-sidebar .pc-link .pc-arrow {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 18px;
      height: 18px;
      margin-left: auto;
      flex: 0 0 18px;
      line-height: 1;
    }

    .simkop-sidebar .pc-link .pc-arrow svg {
      width: 15px;
      height: 15px;
      stroke-width: 2;
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .simkop-sidebar .pc-hasmenu.pc-trigger > .pc-link .pc-arrow svg {
      transform: rotate(90deg);
      color: #FFFFFF;
    }

    .simkop-sidebar .pc-sidebar-collapse .pc-head-link {
      color: #E2E8F0;
    }

    @media (min-width: 1025px) {
      .simkop-sidebar.pc-sidebar-hide {
        width: 0;
        min-width: 0;
      }

      .simkop-sidebar.pc-sidebar-hide .navbar-wrapper {
        width: 0;
        opacity: 0;
        pointer-events: none;
      }
    }

    @media (max-width: 1024px) {
      .simkop-sidebar {
        width: 280px;
      }
    }
  </style>

  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ url('dashboard') }}" class="b-brand" aria-label="SIM-KOP dashboard home">
        <img src="{{ asset('assets/images/sim.png') }}" alt="Sim-Kop Logo">
      </a>
      <div class="brand-text">
        <span class="brand-name">SIM-KOP</span>
        <span class="brand-subtitle">Purchase Management</span>
      </div>
    </div>

    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-heading">General</li>

        <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
          <a href="{{ url('dashboard') }}" class="pc-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="sidebar-divider"></li>
        <li class="pc-heading">Main</li>

        <li class="pc-item pc-hasmenu {{ request()->routeIs('checksheet-masters.*') ? 'pc-trigger active' : '' }}">
          <a href="#!" class="pc-link {{ request()->routeIs('checksheet-masters.*') ? 'active' : '' }}">
            <span class="pc-micon"><i class="ti ti-clipboard-check"></i></span>
            <span class="pc-mtext">Checksheet</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item {{ request()->routeIs('checksheet-masters.index') && request('category') === 'pallet' ? 'active' : '' }}"><a class="pc-link {{ request()->routeIs('checksheet-masters.index') && request('category') === 'pallet' ? 'active' : '' }}" href="{{ route('checksheet-masters.index', ['category' => 'pallet']) }}">Pallet</a></li>
            <li class="pc-item {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Ultra Milk' ? 'active' : '' }}"><a class="pc-link {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Ultra Milk' ? 'active' : '' }}" href="{{ route('checksheet-masters.index', ['category' => 'produk', 'item' => 'Ultra Milk']) }}">Ultra Milk</a></li>
            <li class="pc-item {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Susu Shift' ? 'active' : '' }}"><a class="pc-link {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Susu Shift' ? 'active' : '' }}" href="{{ route('checksheet-masters.index', ['category' => 'produk', 'item' => 'Susu Shift']) }}">Susu Shift</a></li>
            <li class="pc-item {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Galon Ron 88' ? 'active' : '' }}"><a class="pc-link {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Galon Ron 88' ? 'active' : '' }}" href="{{ route('checksheet-masters.index', ['category' => 'produk', 'item' => 'Galon Ron 88']) }}">Galon Ron 88</a></li>
            <li class="pc-item {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Snack' ? 'active' : '' }}"><a class="pc-link {{ request()->routeIs('checksheet-masters.index') && request('item') === 'Snack' ? 'active' : '' }}" href="{{ route('checksheet-masters.index', ['category' => 'produk', 'item' => 'Snack']) }}">Snack</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-box"></i></span>
            <span class="pc-mtext">Kelola PO</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('purchase-orders.create') }}">Tambah PO</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('purchase-orders.index') }}">Daftar PO</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-notes"></i></span>
            <span class="pc-mtext">Kelola Tagihan</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-po') }}">Tagihan PO</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-non-po') }}">Tagihan Non PO</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-sementara') }}">Tagihan Sementara</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-pascabayar') }}">Tagihan Pascabayar</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-vending') }}">Tagihan Vending</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.create-pulsa-modem') }}">Tagihan Pulsa Modem</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ \Illuminate\Support\Facades\Route::has('invoices.create-voucher') ? route('invoices.create-voucher') : url('invoices/create-voucher') }}">Invoice Voucher</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('invoices.index') }}">Daftar Invoice</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-file-text"></i></span>
            <span class="pc-mtext">Laporan</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ url('laporan/rekap-po') }}">Rekap PO</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('laporan.non-po') }}">Rekap Non PO</a></li>
          </ul>
        </li>

        @if(($currentUser?->role ?? null) === 'SUPER_ADMIN')
        <li class="sidebar-divider"></li>
        <li class="pc-heading">User Management</li>
        <li class="pc-item">
          <a href="{{ route('users.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Kelola Users</span>
          </a>
        </li>

        <li class="pc-item">
          <a href="{{ route('settings.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-settings"></i></span>
            <span class="pc-mtext">Settings</span>
          </a>
        </li>
        @endif
      </ul>

      <div class="user-card">
        <div class="d-flex align-items-center">
          <div class="user-avatar">{{ $currentUserInitial }}</div>
          <div class="ms-3" style="min-width:0;">
            <div class="user-name">{{ $currentUserName }}</div>
            <div class="user-role">{{ $currentUserRole }}</div>
          </div>
        </div>
        <div class="user-status">
          <span class="status-indicator"></span>
          <span class="badge-sidebar">Aktif</span>
          <span class="user-meta-text">Status akun</span>
        </div>
      </div>
    </div>
  </div>
</nav>
