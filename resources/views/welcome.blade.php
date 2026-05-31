<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    {{-- Navigation --}}
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">📚</span>
                    <span class="text-lg font-bold text-gray-900">LibraryOS</span>
                </div>
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/all/books') }}"
                           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <main>
        <section class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-50 text-primary-700 mb-6">
                            Modern Library Management
                        </span>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Organize.
                            <span class="text-primary-600">Discover.</span>
                            <span class="text-accent-500">Borrow.</span>
                        </h1>
                        <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-lg">
                            A comprehensive library management system designed for modern librarians and readers.
                            Manage your collection, track borrowings, and keep your library organized effortlessly.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            @auth
                                <a href="{{ url('/all/books') }}"
                                   class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                                    Browse Collection
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                                    Get Started Free
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="mt-12 lg:mt-0">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-r from-primary-100 to-accent-100 rounded-3xl blur-2xl opacity-50"></div>
                            <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                        <span class="text-xs text-gray-400 ml-2">libraryos --dashboard</span>
                                    </div>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary-600 font-medium">$</span>
                                            <span class="text-gray-800">Total Books: <strong class="text-primary-600">{{ $totalBooks }}</strong></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary-600 font-medium">$</span>
                                            <span class="text-gray-800">Active Borrowings: <strong class="text-accent-600">{{ $activeBorrowings }}</strong></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary-600 font-medium">$</span>
                                            <span class="text-gray-800">Available Copies: <strong class="text-green-600">{{ $totalCopies }}</strong></span>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="grid grid-cols-3 gap-2">
                                                <div class="bg-primary-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Fiction</p>
                                                    <p class="text-sm font-bold text-primary-600">{{ $fictionCount }}</p>
                                                </div>
                                                <div class="bg-accent-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Non-Fiction</p>
                                                    <p class="text-sm font-bold text-accent-600">{{ $nonFictionCount }}</p>
                                                </div>
                                                <div class="bg-green-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Available</p>
                                                    <p class="text-sm font-bold text-green-600">{{ $totalCopies }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex items-center gap-1 text-xs text-gray-400">
                                            <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                                            System ready · SQLite · Last sync: just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Everything you need to manage your library</h2>
                    <p class="mt-4 text-gray-500 max-w-2xl mx-auto">From cataloging to checkouts, fines to dashboards — all in one place.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-primary-50 transition-colors">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Catalog Management</h3>
                        <p class="text-sm text-gray-500">Add, edit, and organize your book collection with detailed metadata and cover images.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-accent-50 transition-colors">
                        <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Borrowing System</h3>
                        <p class="text-sm text-gray-500">Track checkouts, manage due dates, and handle returns with ease.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-red-50 transition-colors">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Fine Management</h3>
                        <p class="text-sm text-gray-500">Auto-calculate overdue fines and track payments effortlessly.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-purple-50 transition-colors">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics Dashboard</h3>
                        <p class="text-sm text-gray-500">Real-time insights with genre distribution, borrowing trends, and popular titles.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-green-50 transition-colors">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Role-Based Access</h3>
                        <p class="text-sm text-gray-500">Admin, librarian, and member roles with appropriate permissions for each.</p>
                    </div>
                    <div class="p-6 rounded-xl bg-gray-50 hover:bg-primary-50 transition-colors">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Search & Filter</h3>
                        <p class="text-sm text-gray-500">Find books instantly by title, author, or ISBN. Filter by genre and availability.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-gray-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📚</span>
                        <span class="text-sm font-semibold text-gray-700">LibraryOS</span>
                    </div>
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Library Management System. Built with Laravel & TailwindCSS.</p>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
