@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center mb-4">Reset Password</h1>

            <form action="{{ route('password.update') }}" method="POST" class="border p-4 rounded bg-light">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', request()->email) }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>

            <p class="text-center mt-3">
                <a href="{{ route('login') }}">Back to Login</a>
            </p>
        </div>
    </div>
@endsection