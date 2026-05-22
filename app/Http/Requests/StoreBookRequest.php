<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'isbn' => 'required|string|max:20',
            'publication_year' => 'required|integer|min:1000|max:' . date('Y'),
            'publisher' => 'required|string|max:255',
            'pages' => 'required|integer|min:1',
            'shelf_location' => 'required|string|max:50',
            'available_copies' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
        ];
    }
}