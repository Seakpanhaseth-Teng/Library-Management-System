<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryBook extends Model
{
    /** @use HasFactory<\Database\Factories\LibraryBookFactory> */
    use HasFactory;
    protected $table = 'library_books';

    protected $fillable = [
        'title', 'author', 'genre', 'isbn', 'publication_year',
        'publisher', 'pages', 'shelf_location', 'available_copies',
        'is_available', 'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'publication_year' => 'integer',
            'pages' => 'integer',
            'available_copies' => 'integer',
        ];
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'book_id');
    }
}
