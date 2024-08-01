@extends('layouts.auth')

@section('content')
<div class="background">
    <div class="login-box">
        <h2 class="text-center fw-bolder">LOGIN</h2>
        <div class="card-body">
            <form method="POST" action="{{ route('login.handle') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="col-md-4 col-form-label text-light">Email</label>
                    <input id="email" type="email" class="form-control rounded-pill border border-2" name="email" placeholder="Enter email" autocomplete="email" autofocus value="{{ old('email') }}">
                    <div class="error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label text-light">Password</label>
                    <input id="password" type="password" class="form-control rounded-pill border border-2 " name="password" placeholder="Password" autocomplete="current-password" value="{{ old('password') }}">
                    <div class="error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="mt-3 ms-2 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') === 'on' ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-secondary btn-block mt-3 rounded-pill p-2 flex-fill">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary btn-block mt-3 rounded-pill p-2 flex-fill">
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </div>
                <p class="text-center mt-3">
                    <span class="text-light">Don't have an account?</span>
                    <a href="{{ route('register.form') }}" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Register</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection