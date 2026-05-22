@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center mb-4">Forgot Password</h1>

            <p class="text-center text-muted mb-4">Enter your email and we'll send you a password reset link.</p>

            @if(session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="border p-4 rounded bg-light">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>

            <p class="text-center mt-3">
                <a href="{{ route('login') }}">Back to Login</a>
            </p>
        </div>
    </div>
@endsection