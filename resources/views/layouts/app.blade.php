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
<body class="bg-gray-50 text-gray-600 antialiased">

@auth
    <div class="flex h-screen overflow-hidden">
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-gray-900/50 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-200 ease-in-out flex flex-col">
            <div class="h-16 flex items-center gap-2 px-6 border-b border-gray-100 shrink-0">
                <span class="text-2xl">📚</span>
                <span class="text-xl font-bold text-primary-700">LibraryOS</span>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
                <div>
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ url('/all/books') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('all/books*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                            </svg>
                            All Books
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Catalog</p>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/books/available') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('books/available*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Available
                        </a>
                        <a href="{{ url('/books/fiction') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('books/fiction*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                            Fiction
                        </a>
                        <a href="{{ url('/books/nonfiction') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('books/nonfiction*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                            Non-Fiction
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Services</p>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/borrowings') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('borrowings*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                            </svg>
                            Borrowings
                        </a>
                        <a href="{{ url('/fines') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('fines*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Fines
                        </a>
                    </div>
                </div>

                @auth
                    <div>
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ url('/createbook') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('createbook*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                Add Book
                            </a>
                        </div>
                    </div>
                @endauth
            </nav>

            <div class="border-t border-gray-100 p-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-semibold text-sm shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-accent-100 text-accent-700">Member</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 hover:underline transition-colors">Sign out</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen w-0 lg:w-auto">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 shrink-0">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors" aria-label="Toggle sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <span class="hidden sm:inline">{{ date('M d, Y') }}</span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @if(!Auth::user()->hasVerifiedEmail())
                    <div class="flex items-center gap-3 p-4 mb-4 text-sm rounded-lg bg-accent-50 border border-accent-200 text-accent-800" role="alert">
                        <svg class="w-5 h-5 shrink-0 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                        </svg>
                        <div class="flex-1">
                            <span class="font-medium">Email not verified.</span>
                            <a href="{{ route('verification.notice') }}" class="font-medium underline hover:no-underline">Resend verification link</a>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 mb-4 text-sm rounded-lg bg-green-50 border border-green-200 text-green-800" role="alert">
                        <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800" aria-label="Dismiss">&times;</button>
                    </div>
                @endif

                @if(session('status'))
                    <div class="flex items-center gap-3 p-4 mb-4 text-sm rounded-lg bg-blue-50 border border-blue-200 text-blue-800" role="alert">
                        <svg class="w-5 h-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-blue-600 hover:text-blue-800" aria-label="Dismiss">&times;</button>
                    </div>
                @endif

                @if(session('message'))
                    <div class="flex items-center gap-3 p-4 mb-4 text-sm rounded-lg bg-blue-50 border border-blue-200 text-blue-800" role="alert">
                        <svg class="w-5 h-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <span>{{ session('message') }}</span>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-blue-600 hover:text-blue-800" aria-label="Dismiss">&times;</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 mb-4 text-sm rounded-lg bg-red-50 border border-red-200 text-red-800" role="alert">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                            <span class="font-medium">Please fix the following errors:</span>
                            <button onclick="this.closest('[role=alert]').remove()" class="ml-auto text-red-600 hover:text-red-800" aria-label="Dismiss">&times;</button>
                        </div>
                        <ul class="mt-2 list-disc list-inside pl-7 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
@else
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <span class="text-xl">📚</span>
                        <span class="text-lg font-bold text-primary-700">LibraryOS</span>
                    </a>
                    <div class="flex items-center gap-4 text-sm">
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-900 transition-colors">Log in</a>
                        @endif
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="font-medium text-gray-600 hover:text-gray-900 transition-colors">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <main class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                @if(session('status'))
                    <div class="flex items-center gap-3 p-4 mb-4 text-sm rounded-lg bg-blue-50 border border-blue-200 text-blue-800" role="alert">
                        <span>{{ session('status') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="p-4 mb-4 text-sm rounded-lg bg-red-50 border border-red-200 text-red-800" role="alert">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
@endauth

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        sidebar.classList.toggle('-translate-x-full', isOpen);
        sidebar.classList.toggle('translate-x-0', !isOpen);
        overlay.classList.toggle('hidden', isOpen);
        document.body.classList.toggle('overflow-hidden', !isOpen);
    }
</script>

@stack('scripts')
</body>
</html>
