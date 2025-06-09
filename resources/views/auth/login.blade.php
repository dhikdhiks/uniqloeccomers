@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded">
                <div class="card-header text-center bg-primary text-white">
                    <h4><i class="bi bi-person-circle"></i> Login to Your Account</h4>
                </div>

                <div class="card-body">
                    {{-- Regular Login Form --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required>

                            @error('password')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="text-center mt-2">
                            <a class="text-decoration-none" href="{{ route('register') }}">
                               Don't have an account? Register here
                            </a>
                        </div

                        @if (Route::has('password.request'))
                            <div class="text-center mt-2">
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        @endif
                    </form>

                    <hr>

                    {{-- Google Login --}}
                    <div class="text-center">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger w-100">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" class="me-2">
                            Login with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
