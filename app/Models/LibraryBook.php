<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    protected $table = 'library_books';

    protected $fillable = [
        'title', 'author', 'genre', 'isbn', 'publication_year',
        'publisher', 'pages', 'shelf_location', 'available_copies', 'is_available',
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
}
