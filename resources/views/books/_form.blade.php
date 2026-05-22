<form action="{{ $action }}" method="POST" class="border p-4 rounded bg-light">
    @csrf
    @method($method ?? 'POST')

    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $book?->title) }}" required>
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Author:</label>
        <input type="text" id="author" name="author" class="form-control" value="{{ old('author', $book?->author) }}" required>
    </div>

    <div class="mb-3">
        <label for="isbn" class="form-label">ISBN:</label>
        <input type="text" id="isbn" name="isbn" class="form-control" value="{{ old('isbn', $book?->isbn) }}" required>
    </div>

    <div class="mb-3">
        <label for="publisher" class="form-label">Publisher:</label>
        <input type="text" id="publisher" name="publisher" class="form-control" value="{{ old('publisher', $book?->publisher) }}" required>
    </div>

    <div class="mb-3">
        <label for="publication_year" class="form-label">Published Year:</label>
        <input type="number" id="publication_year" name="publication_year" class="form-control" value="{{ old('publication_year', $book?->publication_year) }}" required>
    </div>

    <div class="mb-3">
        <label for="genre" class="form-label">Genre:</label>
        <input type="text" id="genre" name="genre" class="form-control" value="{{ old('genre', $book?->genre) }}" required>
    </div>

    <div class="mb-3">
        <label for="pages" class="form-label">Pages:</label>
        <input type="number" id="pages" name="pages" class="form-control" value="{{ old('pages', $book?->pages) }}" required>
    </div>

    <div class="mb-3">
        <label for="shelf_location" class="form-label">Shelf Location:</label>
        <input type="text" id="shelf_location" name="shelf_location" class="form-control" value="{{ old('shelf_location', $book?->shelf_location) }}" required>
    </div>

    <div class="mb-3">
        <label for="available_copies" class="form-label">Available Copies:</label>
        <input type="number" id="available_copies" name="available_copies" class="form-control" value="{{ old('available_copies', $book?->available_copies) }}" required>
    </div>

    <div class="mb-3">
        <label for="is_available" class="form-label">Is Available:</label>
        <select id="is_available" name="is_available" class="form-select" required>
            <option value="1" {{ old('is_available', $book?->is_available) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('is_available', $book?->is_available) == '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">{{ $buttonText ?? 'Submit' }}</button>
        <a href="{{ url('/all/books') }}" class="btn btn-secondary w-100">Cancel</a>
    </div>
</form>