<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\LibraryBook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    const DAILY_FINE_RATE = 0.50;
    const LOAN_DURATION_DAYS = 14;
    const MAX_ACTIVE_BORROWINGS = 5;

    public function index(): View
    {
        $user = Auth::user();

        if ($user->isStaff()) {
            $borrowings = Borrowing::with(['user', 'book'])
                ->latest()
                ->paginate(15);
        } else {
            $borrowings = Borrowing::with(['book', 'fine'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('borrowings.index', ['borrowings' => $borrowings]);
    }

    public function create(Request $request): View
    {
        $book = null;
        if ($request->has('book_id')) {
            $book = LibraryBook::findOrFail($request->book_id);
        }

        $books = LibraryBook::where('is_available', true)
            ->where('available_copies', '>', 0)
            ->orderBy('title')
            ->get();

        return view('borrowings.create', [
            'books' => $books,
            'selectedBook' => $book,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:library_books,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $userId = Auth::user()->isStaff()
            ? ($validated['user_id'] ?? Auth::id())
            : Auth::id();

        $book = LibraryBook::findOrFail($validated['book_id']);

        if (!$book->is_available || $book->available_copies < 1) {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        $activeCount = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();

        if ($activeCount >= self::MAX_ACTIVE_BORROWINGS) {
            return back()->withErrors(['book_id' => 'User has reached the maximum number of active borrowings.']);
        }

        $hasOverdue = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->where('due_at', '<', now())
            ->exists();

        if ($hasOverdue) {
            return back()->withErrors(['book_id' => 'User has overdue books. Please return them before borrowing new ones.']);
        }

        $borrowing = Borrowing::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(self::LOAN_DURATION_DAYS),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_copies');

        if ($book->available_copies <= 0) {
            $book->update(['is_available' => false]);
        }

        return redirect('/borrowings')
            ->with('success', 'Book borrowed successfully! Due date: ' . $borrowing->due_at->format('M d, Y'));
    }

    public function returnBorrowing(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status === 'returned') {
            return back()->withErrors(['borrowing' => 'This book has already been returned.']);
        }

        $borrowing->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        $book = $borrowing->book;
        $book->increment('available_copies');

        if ($book->available_copies > 0 && !$book->is_available) {
            $book->update(['is_available' => true]);
        }

        if ($borrowing->due_at && now()->gt($borrowing->due_at)) {
            $daysOverdue = (int) $borrowing->due_at->diffInDays(now());
            $fineAmount = round($daysOverdue * self::DAILY_FINE_RATE, 2);

            if ($fineAmount > 0) {
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'amount' => $fineAmount,
                    'paid' => false,
                ]);

                return redirect('/borrowings')
                    ->with('warning', "Book returned successfully! A fine of \${$fineAmount} has been applied for {$daysOverdue} day(s) overdue.");
            }
        }

        return redirect('/borrowings')
            ->with('success', 'Book returned successfully!');
    }
}
