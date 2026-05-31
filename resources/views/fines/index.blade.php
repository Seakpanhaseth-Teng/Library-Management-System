@extends('layouts.app')

@section('title', 'Fines')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Fines</h1>
        <div class="text-right">
            <p class="text-sm text-gray-500">Total Outstanding</p>
            <p class="text-2xl font-bold text-red-600">${{ number_format($totalUnpaid, 2) }}</p>
        </div>
    </div>

    @if($fines->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">No fines recorded.</p>
            <p class="text-sm text-gray-400 mt-1">All borrowings have been returned on time!</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                            @can('manage-fines')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            @endcan
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($fines as $fine)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">{{ $fine->borrowing?->book?->title ?? 'Unknown' }}</p>
                                </td>
                                @can('manage-fines')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900">{{ $fine->borrowing?->user?->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $fine->borrowing?->user?->email ?? '' }}</p>
                                    </td>
                                @endcan
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Overdue {{ optional($fine->borrowing?->due_at)->diffInDays($fine->borrowing?->returned_at ?? now()) ?? 0 }} days
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($fine->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $fine->paid ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $fine->paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(!$fine->paid)
                                        <form action="{{ route('fines.pay', $fine) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-primary-600 hover:text-primary-800"
                                                onclick="return confirm('Pay this fine of ${{ number_format($fine->amount, 2) }}?')">
                                                Pay Now
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Paid {{ $fine->paid_at?->format('M d, Y') ?? '' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $fines->links() }}
        </div>
    @endif
</div>
@endsection
