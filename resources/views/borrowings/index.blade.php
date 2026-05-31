@extends('layouts.app')

@section('title', 'Borrowings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Borrowings</h1>
        @can('manage-borrowings')
            <a href="{{ route('borrowings.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Borrowing
            </a>
        @endcan
    </div>

    @if($borrowings->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500">No borrowings found.</p>
            @can('manage-borrowings')
                <a href="{{ route('borrowings.create') }}" class="text-primary-600 hover:text-primary-700 font-medium mt-2 inline-block">
                    Create the first borrowing
                </a>
            @endcan
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                            @can('manage-borrowings')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrower</th>
                            @endcan
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-10 bg-primary-100 rounded flex items-center justify-center">
                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $borrowing->book?->title ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $borrowing->book?->author ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                @can('manage-borrowings')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900">{{ $borrowing->user?->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $borrowing->user?->email ?? '' }}</p>
                                    </td>
                                @endcan
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $borrowing->borrowed_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $borrowing->due_at?->format('M d, Y') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($borrowing->status === 'returned') bg-green-50 text-green-700
                                        @elseif($borrowing->isOverdue()) bg-red-50 text-red-700
                                        @else bg-blue-50 text-blue-700 @endif">
                                        {{ ucfirst($borrowing->status) }}
                                        @if($borrowing->isOverdue())
                                            ({{ $borrowing->daysOverdue() }}d overdue)
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($borrowing->fine)
                                        <span class="font-medium {{ $borrowing->fine->paid ? 'text-green-600' : 'text-red-600' }}">
                                            ${{ number_format($borrowing->fine->amount, 2) }}
                                            @if($borrowing->fine->paid)
                                                (paid)
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($borrowing->status === 'borrowed' && Auth::user()->isStaff())
                                        <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-primary-600 hover:text-primary-800"
                                                onclick="return confirm('Return this book?')">
                                                Return
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    @endif
</div>
@endsection
