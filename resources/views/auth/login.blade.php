@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <h4 class="mb-2">Welcome to Sero! 👋</h4>
  <p class="mb-4">Please sign-in to your account and start the adventure</p>

  @include('layouts.flash')

  <form id="formAuthentication" class="mb-3" action="{{ route('login.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        class="form-control @error('email') is-invalid @enderror"
        id="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="Enter your email"
        autocomplete="email"
        required
        autofocus
      />
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3 form-password-toggle">
      <label class="form-label" for="password">Password</label>
      <div class="input-group input-group-merge @error('password') has-validation @enderror">
        <input
          type="password"
          id="password"
          class="form-control @error('password') is-invalid @enderror"
          name="password"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
          autocomplete="current-password"
          required
        />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
      </div>
      @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="remember-me" name="remember" value="1" @checked(old('remember')) />
        <label class="form-check-label" for="remember-me"> Remember Me </label>
      </div>
    </div>

    <div class="mb-3">
      <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
    </div>
  </form>

  <p class="text-center">
    <span>New on our platform?</span>
    <a href="{{ route('vendor.register') }}"><span>Create an account</span></a>
  </p>
@endsection
