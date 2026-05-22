@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center mb-4">Login</h1>

            <form action="{{ route('login') }}" method="POST" class="border p-4 rounded bg-light">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-end">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100" onclick="this.disabled=true; this.form.submit();">Login</button>
            </form>

            <p class="text-center mt-3">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </div>
@endsection
