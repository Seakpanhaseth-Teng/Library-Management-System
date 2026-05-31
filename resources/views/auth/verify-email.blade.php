@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
        <div class="w-16 h-16 bg-accent-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-900 mb-2">Verify Your Email</h1>
        <p class="text-sm text-gray-500 mb-2">
            A verification link has been sent to
        </p>
        <p class="text-sm font-medium text-gray-900 mb-4">{{ Auth::user()->email }}</p>
        <p class="text-sm text-gray-500 mb-6">Please check your inbox and click the verification link to activate your account.</p>

        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit"
                    class="px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                Resend Verification Email
            </button>
        </form>

        @if(session('message'))
            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('message') }}
            </div>
        @endif

        <div class="mt-6 pt-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Log Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
