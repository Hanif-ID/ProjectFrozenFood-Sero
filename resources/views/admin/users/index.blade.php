@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @include('layouts.flash')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar User</h5>
      <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bx bx-plus me-1"></i> Tambah User
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($users as $user)
            <tr>
              <td>{{ $users->firstItem() + $loop->index }}</td>
              <td><strong>{{ $user->name }}</strong></td>
              <td>{{ $user->email }}</td>
              <td>
                <span class="badge bg-label-{{ $user->isAdmin() ? 'primary' : 'info' }}">{{ ucfirst($user->role) }}</span>
              </td>
              <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                @if ($user->id !== auth()->id())
                  <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus user {{ e($user->name) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada user.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($users->hasPages())
      <div class="card-footer">{{ $users->links() }}</div>
    @endif
  </div>
</div>
@endsection
