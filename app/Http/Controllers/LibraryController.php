<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\LibraryBook;
use App\Services\OpenLibraryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function show(int $id): View
    {
        $book = LibraryBook::findOrFail($id);

        return view('books.show', ['book' => $book]);
    }

    public function editBook(int $id): View
    {
        $book = LibraryBook::findOrFail($id);

        return view('books.edit', ['book' => $book]);
    }

    public function updateBook(StoreBookRequest $request, int $id): RedirectResponse
    {
        $book = LibraryBook::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect('/all/books')->with('success', 'Book updated successfully!');
    }

    public function deleteBook(int $id): RedirectResponse
    {
        $book = LibraryBook::findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect('/all/books')->with('success', 'Book deleted successfully!');
    }

    public function addBook(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } else {
            $openLibrary = app(OpenLibraryService::class);
            $coverPath = $openLibrary->fetchCoverByIsbn($data['isbn']);
            if ($coverPath) {
                $data['cover_image'] = $coverPath;
            }
        }

        LibraryBook::create($data);

        return redirect('/all/books')->with('success', 'Book added successfully!');
    }
}
