@extends('layouts.app')

@section('title', 'Dashboard Vendor')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @include('layouts.flash')
  <div class="card">
    <div class="card-body">
      <h5 class="card-title text-primary">Halo, {{ auth()->user()->name }}! 👋</h5>
      <p class="mb-0">Selamat datang di dashboard vendor Sero. Fitur pengelolaan produk akan ditambahkan di sini.</p>
    </div>
  </div>
</div>
@endsection
