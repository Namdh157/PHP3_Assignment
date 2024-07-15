@extends('layouts.auth')

@section('content')
    <div class="background">
        <div class="login-container ">
            <div class="login-box">
                <h2 class="text-center">Login</h2>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.handle') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label">Email</label>
                            <input id="email" type="email" class="form-control rounded-pill border border-2"
                                name="email" placeholder="Enter email" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password</label>
                            <input id="password" type="password" class="form-control rounded-pill border border-2 "
                                name="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-light btn-block mt-3 rounded-pill">
                                Login
                            </button>
                        </div>
                        <p class="text-center mt-3">Don't have an account? <a href="{{ route('register.form') }}">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
