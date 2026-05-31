<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\LibraryBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $totalBooks = LibraryBook::count();
        $totalCopies = LibraryBook::sum('available_copies');
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();
        $overdueBorrowings = Borrowing::whereNull('returned_at')
            ->where('due_at', '<', now())
            ->where('status', '!=', 'returned')
            ->count();

        $totalFinesCollected = Fine::where('paid', true)->sum('amount');
        $outstandingFines = Fine::where('paid', false)->sum('amount');

        $popularBooks = LibraryBook::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        $recentActivity = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(10)
            ->get();

        $genreDistribution = LibraryBook::selectRaw('genre, count(*) as total')
            ->groupBy('genre')
            ->get();

        $borrowedVsAvailable = [
            'borrowed' => Borrowing::where('status', 'borrowed')->count(),
            'available' => LibraryBook::where('is_available', true)->sum('available_copies'),
        ];

        return view('dashboard.index', compact(
            'totalBooks',
            'totalCopies',
            'activeBorrowings',
            'overdueBorrowings',
            'totalFinesCollected',
            'outstandingFines',
            'popularBooks',
            'recentActivity',
            'genreDistribution',
            'borrowedVsAvailable'
        ));
    }
}
