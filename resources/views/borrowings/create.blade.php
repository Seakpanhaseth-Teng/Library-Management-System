@extends('layouts.app')

@section('title', 'New Borrowing')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('borrowings.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Borrowings
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-xl font-bold text-gray-900 mb-6">Create New Borrowing</h1>

        <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
            @csrf

            @can('manage-borrowings')
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Member</label>
                    <select name="user_id" id="user_id" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('user_id') border-red-300 @enderror">
                        <option value="">Select a member...</option>
                        @foreach(\App\Models\User::where('role', 'member')->get() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endcan

            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Book</label>
                <select name="book_id" id="book_id" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('book_id') border-red-300 @enderror">
                    <option value="">Select a book...</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id', $selectedBook?->id) == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} by {{ $book->author }} ({{ $book->available_copies }} copies)
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium">Loan Terms</p>
                        <ul class="mt-1 space-y-1 text-amber-700">
                            <li>• Loan period is 14 days</li>
                            <li>• Maximum 5 active borrowings per member</li>
                            <li>• Overdue fine: $0.50 per day</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    Create Borrowing
                </button>
                <a href="{{ route('borrowings.index') }}"
                   class="px-6 py-2.5 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
