@extends('layouts.auth')

@section('content')

<div class="background">
    <div class="login-box">
        <h2 class="text-center fw-bold">REGISTER</h2>
        <div class="card-body">
            <form method="POST" action="{{ route('register.handle') }}">
                @csrf
                <div class="form-group">
                    <input id="name" type="text" class="form-control rounded-pill border border-2" name="name" placeholder="Full name" autocomplete="name" autofocus value="{{ old('name') }}">
                    <div class="error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input id="email" type="email" class="form-control rounded-pill border border-2" name="email" placeholder="Email address" autocomplete="email" autofocus value="{{ old('email') }}">
                    <div class="error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input id="password" type="password" class="form-control rounded-pill border border-2" name="password" placeholder="Password" autocomplete="new-password" value="{{ old('password') }}">
                    <div class="error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input id="password-confirm" type="password" class="form-control rounded-pill border border-2" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" value="{{ old('password_confirmation') }}">
                    <div class="error">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-secondary btn-block mt-3 rounded-pill p-2 flex-fill">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary btn-block mt-3 rounded-pill p-2 flex-fill" id="submit-btn">
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </div>
                <p class="text-center mt-3">
                    <span class="text-light">If you already have an account?</span>
                    <a href="{{ route('login.form') }}">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection