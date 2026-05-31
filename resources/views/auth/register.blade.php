@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 text-center mb-6">Create Account</h1>
<p class="text-sm text-gray-500 text-center mb-8">Join the Library Management System</p>

<form action="{{ route('register') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}" required autofocus
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 @enderror"
               placeholder="John Doe">
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-300 @enderror"
               placeholder="you@example.com">
        @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-300 @enderror"
               placeholder="••••••••">
        @error('password')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required
               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
               placeholder="••••••••">
    </div>

    <button type="submit"
            class="w-full px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        Create Account
    </button>
</form>

<p class="text-center text-sm text-gray-500 mt-6">
    Already have an account?
    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-800 font-medium">Sign In</a>
</p>
@endsection
