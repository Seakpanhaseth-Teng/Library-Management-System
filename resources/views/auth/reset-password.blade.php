@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Reset Password</h1>
<p class="text-sm text-gray-500 text-center mb-8">Choose a new password for your account</p>

<form action="{{ route('password.update') }}" method="POST" class="space-y-5">
    @csrf

    <input type="hidden" name="token" value="{{ request()->route('token') }}">

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', request()->email) }}" required autofocus
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-300 @enderror"
               placeholder="you@example.com">
        @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
        <input type="password" id="password" name="password" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-300 @enderror"
               placeholder="••••••••">
        @error('password')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
               placeholder="••••••••">
    </div>

    <button type="submit"
            class="w-full px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        Reset Password
    </button>
</form>
@endsection