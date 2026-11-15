@php($editing = isset($user))

<div class="mb-3">
  <label class="form-label" for="name">Name</label>
  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
         value="{{ old('name', $user->name ?? '') }}" required />
  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label" for="email">Email</label>
  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
         value="{{ old('email', $user->email ?? '') }}" required />
  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label" for="role">Role</label>
  <select id="role" name="role" class="form-select @error('role') is-invalid @enderror"
          @disabled($editing && $user->id === auth()->id())>
    @foreach (['admin' => 'Admin', 'vendor' => 'Vendor'] as $value => $label)
      <option value="{{ $value }}" @selected(old('role', $user->role ?? 'vendor') === $value)>{{ $label }}</option>
    @endforeach
  </select>
  @if ($editing && $user->id === auth()->id())
    <div class="form-text">Anda tidak bisa mengubah role akun sendiri.</div>
  @endif
  @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label" for="password">Password @if($editing)<small class="text-muted">(kosongkan jika tidak diubah)</small>@endif</label>
  <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
         autocomplete="new-password" @required(! $editing) />
  @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
  <label class="form-label" for="password_confirmation">Confirm Password</label>
  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
         autocomplete="new-password" @required(! $editing) />
</div>
