<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FineController;
use App\Models\Borrowing;
use App\Models\LibraryBook;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    $totalBooks = LibraryBook::count();
    $activeBorrowings = Borrowing::where('status', 'borrowed')->count();
    $totalCopies = LibraryBook::sum('available_copies');
    $fictionCount = LibraryBook::where('genre', 'Fiction')->count();
    $nonFictionCount = LibraryBook::where('genre', 'Non-Fiction')->count();

    return view('welcome', compact(
        'totalBooks', 'activeBorrowings', 'totalCopies',
        'fictionCount', 'nonFictionCount'
    ));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');

    /***** Book Routes *****/
    Route::get('/all/books', [LibraryController::class, 'allBooks']);
    Route::get('/books/available', [LibraryController::class, 'availableBooks']);
    Route::get('/books/fiction', [LibraryController::class, 'fictionBooks']);
    Route::get('/books/nonfiction', [LibraryController::class, 'nonFictionBooks']);
    Route::get('/books/search', [LibraryController::class, 'search']);
    Route::get('/books/{id}', [LibraryController::class, 'show']);

    /***** Borrowing Routes *****/
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBorrowing'])->name('borrowings.return');

    /***** Fine Routes *****/
    Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
    Route::post('/fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');

    /***** Staff-only (admin/librarian) Routes *****/
    Route::middleware('role:admin,librarian')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/createbook', function () {
            return view('books.create_book');
        });
        Route::get('/books/{id}/edit', [LibraryController::class, 'editBook']);
        Route::put('/books/{id}', [LibraryController::class, 'updateBook']);
        Route::delete('/books/{id}', [LibraryController::class, 'deleteBook']);
        Route::post('/books/add', [LibraryController::class, 'addBook']);
    });

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});
