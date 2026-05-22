<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\LibraryBook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function allBooks(): View
    {
        $books = LibraryBook::paginate(10);

        return view('books.all_books', ['books' => $books]);
    }

    public function availableBooks(): View
    {
        $books = LibraryBook::where('is_available', true)->paginate(10);

        return view('books.available', ['books' => $books]);
    }

    public function fictionBooks(): View
    {
        $books = LibraryBook::where('genre', 'Fiction')->paginate(10);

        return view('books.genre', ['books' => $books, 'genre' => 'Fiction']);
    }

    public function nonFictionBooks(): View
    {
        $books = LibraryBook::where('genre', 'Non-Fiction')->paginate(10);

        return view('books.genre', ['books' => $books, 'genre' => 'Non-Fiction']);
    }

    public function search(Request $request): View
    {
        $q = str_replace(['%', '_'], ['\\%', '\\_'], $request->input('q', ''));

        $books = LibraryBook::where('title', 'like', "%{$q}%")
            ->orWhere('author', 'like', "%{$q}%")
            ->orWhere('isbn', 'like', "%{$q}%")
            ->paginate(10)
            ->appends(['q' => $q]);

        return view('books.all_books', ['books' => $books]);
    }

    public function editBook(int $id): View
    {
        $book = LibraryBook::findOrFail($id);

        return view('books.edit', ['book' => $book]);
    }

    public function updateBook(StoreBookRequest $request, int $id): RedirectResponse
    {
        $book = LibraryBook::findOrFail($id);
        $book->update($request->validated());

        return redirect('/all/books')->with('success', 'Book updated successfully!');
    }

    public function deleteBook(int $id): RedirectResponse
    {
        $book = LibraryBook::findOrFail($id);
        $book->delete();

        return redirect('/all/books')->with('success', 'Book deleted successfully!');
    }

    public function addBook(StoreBookRequest $request): RedirectResponse
    {
        LibraryBook::create($request->validated());

        return redirect('/all/books')->with('success', 'Book added successfully!');
    }
}