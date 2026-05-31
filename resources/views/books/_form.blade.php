@php
    $isEdit = isset($book) && $book !== null;
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method($method ?? 'POST')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $book?->title) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-300 @enderror">
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
            <input type="text" id="author" name="author"
                   value="{{ old('author', $book?->author) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('author') border-red-300 @enderror">
            @error('author')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
            <input type="text" id="isbn" name="isbn"
                   value="{{ old('isbn', $book?->isbn) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('isbn') border-red-300 @enderror">
            @error('isbn')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
            <input type="text" id="genre" name="genre"
                   value="{{ old('genre', $book?->genre) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('genre') border-red-300 @enderror">
            @error('genre')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
            <input type="text" id="publisher" name="publisher"
                   value="{{ old('publisher', $book?->publisher) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('publisher') border-red-300 @enderror">
            @error('publisher')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-1">Published Year</label>
            <input type="number" id="publication_year" name="publication_year"
                   value="{{ old('publication_year', $book?->publication_year) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('publication_year') border-red-300 @enderror">
            @error('publication_year')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Pages</label>
            <input type="number" id="pages" name="pages"
                   value="{{ old('pages', $book?->pages) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('pages') border-red-300 @enderror">
            @error('pages')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="shelf_location" class="block text-sm font-medium text-gray-700 mb-1">Shelf Location</label>
            <input type="text" id="shelf_location" name="shelf_location"
                   value="{{ old('shelf_location', $book?->shelf_location) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('shelf_location') border-red-300 @enderror">
            @error('shelf_location')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="available_copies" class="block text-sm font-medium text-gray-700 mb-1">Available Copies</label>
            <input type="number" id="available_copies" name="available_copies"
                   value="{{ old('available_copies', $book?->available_copies) }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('available_copies') border-red-300 @enderror">
            @error('available_copies')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="is_available" class="block text-sm font-medium text-gray-700 mb-1">Is Available</label>
            <select id="is_available" name="is_available" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="1" {{ old('is_available', $book?->is_available) == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_available', $book?->is_available) == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 @error('cover_image') border-red-300 @enderror">
            <p class="text-xs text-gray-500 mt-1">Optional. If no image provided, we'll try to fetch from OpenLibrary by ISBN. Max 2MB. JPEG, PNG, or WebP.</p>
            @error('cover_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @if($isEdit && $book->cover_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current cover" class="w-20 h-28 object-cover rounded-lg shadow-sm">
                    <p class="text-xs text-gray-400 mt-1">Current cover</p>
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            {{ $buttonText ?? 'Submit' }}
        </button>
        <a href="{{ url('/all/books') }}"
           class="px-6 py-2.5 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
            Cancel
        </a>
    </div>
</form>
