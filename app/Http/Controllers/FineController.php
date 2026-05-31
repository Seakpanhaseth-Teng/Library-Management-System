<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if ($user->isStaff()) {
            $fines = Fine::with(['borrowing.user', 'borrowing.book'])
                ->latest()
                ->paginate(15);
        } else {
            $fines = Fine::whereHas('borrowing', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['borrowing.book'])
                ->latest()
                ->paginate(15);
        }

        $totalUnpaid = $user->isStaff()
            ? Fine::where('paid', false)->sum('amount')
            : Fine::whereHas('borrowing', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('paid', false)->sum('amount');

        return view('fines.index', [
            'fines' => $fines,
            'totalUnpaid' => $totalUnpaid,
        ]);
    }

    public function pay(Fine $fine): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->isStaff() && $fine->borrowing->user_id !== $user->id) {
            abort(403);
        }

        if ($fine->paid) {
            return back()->withErrors(['fine' => 'This fine has already been paid.']);
        }

        $fine->update([
            'paid' => true,
            'paid_at' => now(),
        ]);

        return redirect('/fines')->with('success', 'Fine paid successfully!');
    }
}
