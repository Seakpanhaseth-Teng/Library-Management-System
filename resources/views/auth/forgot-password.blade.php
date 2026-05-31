@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Forgot Password</h1>
<p class="text-sm text-gray-500 text-center mb-8">Enter your email and we'll send you a reset link</p>

<form action="{{ route('password.email') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}" required autofocus
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-300 @enderror"
               placeholder="you@example.com">
        @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="w-full px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        Send Reset Link
    </button>
</form>

<p class="text-center text-sm text-gray-500 mt-6">
    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-800 font-medium">&larr; Back to Login</a>
</p>
@endsection