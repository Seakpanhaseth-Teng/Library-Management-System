@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Books</p>
                    <p class="text-3xl font-bold text-primary-600 mt-1">{{ $totalBooks }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-2">{{ $totalCopies }} total copies available</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Borrowings</p>
                    <p class="text-3xl font-bold text-accent-600 mt-1">{{ $activeBorrowings }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-2">{{ $overdueBorrowings }} overdue</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Fines</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">${{ number_format($outstandingFines, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-2">${{ number_format($totalFinesCollected, 2) }} collected</p>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Genre Distribution --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Genre Distribution</h2>
            <div class="space-y-3">
                @foreach($genreDistribution as $genre)
                    @php
                        $percentage = $totalBooks > 0 ? round(($genre->total / $totalBooks) * 100) : 0;
                        $colors = ['bg-primary-500', 'bg-accent-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 font-medium">{{ $genre->genre }}</span>
                            <span class="text-gray-500">{{ $genre->total }} books ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Borrowed vs Available --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Borrowed vs Available</h2>
            <div class="flex items-center justify-center h-48">
                <div class="relative w-48 h-48">
                    <svg class="w-48 h-48 -rotate-90" viewBox="0 0 36 36">
                        @php
                            $total = $borrowedVsAvailable['borrowed'] + $borrowedVsAvailable['available'];
                            $borrowedPct = $total > 0 ? ($borrowedVsAvailable['borrowed'] / $total) * 100 : 0;
                            $availablePct = $total > 0 ? ($borrowedVsAvailable['available'] / $total) * 100 : 0;
                            $borrowedDash = ($borrowedPct / 100) * 100;
                            $availableDash = ($availablePct / 100) * 100;
                        @endphp
                        <circle class="text-gray-100" stroke="currentColor" stroke-width="3" fill="none" cx="18" cy="18" r="15.9"/>
                        <circle class="text-accent-500" stroke="currentColor" stroke-width="3" fill="none" cx="18" cy="18" r="15.9"
                            stroke-dasharray="{{ $borrowedDash }} {{ 100 - $borrowedDash }}"
                            stroke-dashoffset="0"/>
                        <circle class="text-primary-500" stroke="currentColor" stroke-width="3" fill="none" cx="18" cy="18" r="15.9"
                            stroke-dasharray="{{ $availableDash }} {{ 100 - $availableDash }}"
                            stroke-dashoffset="{{ -$borrowedDash }}"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
                            <p class="text-xs text-gray-500">Total Copies</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center gap-6 text-sm mt-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-accent-500"></span>
                    <span class="text-gray-600">Borrowed: {{ $borrowedVsAvailable['borrowed'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-primary-500"></span>
                    <span class="text-gray-600">Available: {{ $borrowedVsAvailable['available'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Popular Books --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Most Popular Books</h2>
            <div class="space-y-3">
                @forelse($popularBooks as $book)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</p>
                            <p class="text-xs text-gray-500">{{ $book->author }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                            {{ $book->borrowings_count }} borrows
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">No borrowing data yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
            <div class="space-y-3">
                @forelse($recentActivity as $activity)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->book?->title ?? 'Unknown Book' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $activity->user?->name ?? 'Unknown User' }}
                                @if($activity->status === 'returned')
                                    · Returned {{ $activity->returned_at?->diffForHumans() }}
                                @else
                                    · Borrowed {{ $activity->borrowed_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($activity->status === 'returned') bg-green-50 text-green-700
                            @elseif($activity->isOverdue()) bg-red-50 text-red-700
                            @else bg-blue-50 text-blue-700 @endif">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">No activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
