<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Library Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-600 antialiased min-h-screen flex flex-col items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <span class="text-3xl">📚</span>
                <span class="text-2xl font-bold text-primary-700">LibraryOS</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            @yield('content')
        </div>

        <p class="text-center mt-6 text-xs text-gray-400">
            &copy; {{ date('Y') }} Library Management System. All rights reserved.
        </p>
    </div>

    @stack('scripts')
</body>
</html>
