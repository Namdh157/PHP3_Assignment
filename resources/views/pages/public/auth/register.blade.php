@extends('layouts.auth')

@section('content')
    <div class="background">
        <div class="login-container">
            <div class="login-box">
                <h2 class="text-center">Register</h2>
                <div class="card-body">
                    <form method="POST" action="{{ route('register.handle') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email Address</label>
                            <input id="email" type="email" class="form-control rounded-pill border border-2"
                                name="email" placeholder="Enter your email" required autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password</label>
                            <input id="password" type="password" class="form-control rounded-pill border border-2"
                                name="password" placeholder="Password" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control rounded-pill border border-2"
                                name="password_confirmation" placeholder="Confirm Password" required
                                autocomplete="new-password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-light btn-block mt-3 rounded-pill">
                                Register
                            </button>
                        </div>
                        <p class="text-center mt-3">If you already have an account? <a href="{{ route('login.form') }}">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
