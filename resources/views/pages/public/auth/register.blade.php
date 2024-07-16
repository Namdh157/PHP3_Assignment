@extends('layouts.auth')

@section('content')
<div class="background">
    <div class="login-box">
        <h2 class="text-center text-primary fw-bold">REGISTER</h2>
        <div class="card-body">
            <form method="POST" action="{{ route('register.handle') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="col-form-label text-light">Email Address</label>
                    <input id="email" type="email" class="form-control rounded-pill border border-2" name="email" placeholder="Enter your email" autocomplete="email" autofocus>
                    <div class="error"></div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label text-light">Password</label>
                    <input id="password" type="password" class="form-control rounded-pill border border-2" name="password" placeholder="Password" autocomplete="new-password">
                    <div class="error"></div>
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="col-form-label text-light">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control rounded-pill border border-2" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                    <div class="error"></div>
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
<!-- <script>
    (()=>{
        const emailElement = document.getElementById('email');
        const passwordElement = document.getElementById('password');
        const passwordConfirmElement = document.getElementById('password-confirm');
        const submitBtn = document.querySelector('#submit-btn');

        function checkPassword() {
            return passwordElement.value === passwordConfirmElement.value;
        }
        function validatePassword(target) {
            return target.value.length >= 6;
        }
        function validateEmail(target) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(target.value);
        }
        
        passwordElement.addEventListener('input', (e)=>{
            const errorElement = e.target.closest('.form-group').querySelector('.error');
            errorElement.innerHTML = '';
            submitBtn.type = 'button';
            submitBtn.classList.contains('disabled') ? null : submitBtn.classList.add('disabled');
            if(!validatePassword(e.target)) {
                errorElement.innerHTML = 'Password must be at least 6 characters long';
            }
            if(isValid){
                submitBtn.type = 'submit';
                submitBtn.classList.contains('disabled') ? submitBtn.classList.remove('disabled') : null;
            }
        });

        passwordConfirmElement.addEventListener('input', (e)=>{
            const errorElement = e.target.closest('.form-group').querySelector('.error');
            errorElement.innerHTML = '';
            submitBtn.type = 'button';
            submitBtn.classList.contains('disabled') ? null : submitBtn.classList.add('disabled');
            if(!validatePassword(e.target)) {
                errorElement.innerHTML = 'Password must be at least 6 characters long';
            }
            else if(!checkPassword()) {
                errorElement.innerHTML = 'Password does not match';
            }
            if(isValid){
                submitBtn.type = 'submit';
                submitBtn.classList.contains('disabled') ? submitBtn.classList.remove('disabled') : null;
            }
        });

        emailElement.addEventListener('input', (e)=>{
            const errorElement = e.target.closest('.form-group').querySelector('.error');
            errorElement.innerHTML = '';
            submitBtn.type = 'button';
            submitBtn.classList.contains('disabled') ? null : submitBtn.classList.add('disabled');
            if(!validateEmail(e.target)) {
                isValid = false;
                errorElement.innerHTML = 'Invalid email address';
            }else isValid = true;

            if(isValid){
                submitBtn.type = 'submit';
                submitBtn.classList.contains('disabled') ? submitBtn.classList.remove('disabled') : null;
            }
        });
    })();
</script> -->
@endsection