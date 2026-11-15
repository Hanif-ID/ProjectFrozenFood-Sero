<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('layouts.logo')
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Sero</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    {{-- Dashboard: sudah punya halaman --}}
    <li class="menu-item {{ request()->routeIs('admin.dashboard', 'vendor.dashboard') ? 'active' : '' }}">
      <a href="{{ route(auth()->user()->homeRoute()) }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    {{-- Orders: belum ada halaman --}}
    {{-- Nanti: href="{{ route('orders.index') }}" dan class active: request()->routeIs('orders.*') --}}
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
        <div>Orders</div>
      </a>
    </li>

    {{-- Chat: belum ada halaman --}}
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-chat"></i>
        <div>Chat</div>
      </a>
    </li>

    {{-- Form: belum ada halaman --}}
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-food-menu"></i>
        <div>Form</div>
      </a>
    </li>

    @if (auth()->user()->isAdmin())
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Admin</span></li>
      <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div>Kelola User</div>
        </a>
      </li>
    @endif
  </ul>
</aside>