@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Verify Your Email</h1>

            <div class="alert alert-info text-center">
                <p class="mb-0">
                    A verification link has been sent to <strong>{{ Auth::user()->email }}</strong>.
                </p>
            </div>

            <p class="text-center">Please check your inbox and click the verification link to activate your account.</p>

            <form action="{{ route('verification.send') }}" method="POST" class="text-center mt-4">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>

            @if(session('message'))
                <div class="alert alert-success text-center mt-3">{{ session('message') }}</div>
            @endif

            <p class="text-center mt-3">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            </p>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endsection