@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <h5 class="card-header">Tambah User</h5>
    <div class="card-body">
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users._form')
        <button type="submit" class="btn btn-primary me-2">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
