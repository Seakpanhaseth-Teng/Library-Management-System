<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\LibraryBook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LibraryManagementTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helpers ──────────────────────────────────────────

    private function admin(): User
    {
        return User::factory()->admin()->create(['email_verified_at' => now()]);
    }

    private function librarian(): User
    {
        return User::factory()->librarian()->create(['email_verified_at' => now()]);
    }

    private function member(): User
    {
        return User::factory()->member()->create(['email_verified_at' => now()]);
    }

    private function book(array $overrides = []): LibraryBook
    {
        return LibraryBook::factory()->create($overrides);
    }

    // ─── Role-Based Access ───────────────────────────────

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_member_cannot_access_dashboard(): void
    {
        $response = $this->actingAs($this->member())->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard(): void
    {
        LibraryBook::factory()->count(3)->create();

        $response = $this->actingAs($this->admin())->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Books');
        $response->assertSee('3');
    }

    public function test_librarian_can_access_dashboard(): void
    {
        LibraryBook::factory()->count(2)->create();

        $response = $this->actingAs($this->librarian())->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_member_cannot_access_create_book(): void
    {
        $response = $this->actingAs($this->member())->get('/createbook');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_create_book(): void
    {
        $response = $this->actingAs($this->admin())->get('/createbook');

        $response->assertStatus(200);
        $response->assertSee('Add a New Book');
    }

    public function test_member_cannot_delete_book(): void
    {
        $book = $this->book();

        $response = $this->actingAs($this->member())
            ->delete("/books/{$book->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_book(): void
    {
        $book = $this->book();

        $response = $this->actingAs($this->admin())
            ->delete("/books/{$book->id}");

        $response->assertStatus(302);
        $this->assertModelMissing($book);
    }

    // ─── Borrowing Flow ──────────────────────────────────

    public function test_member_can_borrow_available_book(): void
    {
        $member = $this->member();
        $book = $this->book(['available_copies' => 3]);

        $response = $this->actingAs($member)->post('/borrowings', [
            'book_id' => $book->id,
        ]);

        $response->assertRedirect('/borrowings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('borrowings', [
            'user_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $this->assertDatabaseHas('library_books', [
            'id' => $book->id,
            'available_copies' => 2,
        ]);
    }

    public function test_member_cannot_borrow_unavailable_book(): void
    {
        $book = $this->book(['available_copies' => 0, 'is_available' => false]);

        $response = $this->actingAs($this->member())->post('/borrowings', [
            'book_id' => $book->id,
        ]);

        $response->assertSessionHasErrors('book_id');
        $this->assertDatabaseCount('borrowings', 0);
    }

    public function test_member_cannot_exceed_max_active_borrowings(): void
    {
        $member = $this->member();
        $books = LibraryBook::factory()->count(6)->create(['available_copies' => 5]);

        // Borrow 5 books (max allowed)
        foreach ($books->take(5) as $b) {
            Borrowing::factory()->forMember($member)->forBook($b)->create(['status' => 'borrowed']);
            $b->decrement('available_copies');
        }

        // Try to borrow a 6th
        $response = $this->actingAs($member)->post('/borrowings', [
            'book_id' => $books->last()->id,
        ]);

        $response->assertSessionHasErrors('book_id');
    }

    public function test_member_cannot_borrow_with_overdue_books(): void
    {
        $member = $this->member();
        $book1 = $this->book(['available_copies' => 5]);
        $book2 = $this->book(['available_copies' => 5]);

        // Create an overdue borrowing
        Borrowing::factory()->forMember($member)->forBook($book1)->create([
            'status' => 'borrowed',
            'borrowed_at' => now()->subDays(20),
            'due_at' => now()->subDays(6),
        ]);

        // Try to borrow another
        $response = $this->actingAs($member)->post('/borrowings', [
            'book_id' => $book2->id,
        ]);

        $response->assertSessionHasErrors('book_id');
    }

    public function test_staff_can_borrow_on_behalf_of_member(): void
    {
        $admin = $this->admin();
        $member = $this->member();
        $book = $this->book(['available_copies' => 3]);

        $response = $this->actingAs($admin)->post('/borrowings', [
            'book_id' => $book->id,
            'user_id' => $member->id,
        ]);

        $response->assertRedirect('/borrowings');

        $this->assertDatabaseHas('borrowings', [
            'user_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);
    }

    public function test_returning_book_increases_available_copies(): void
    {
        $member = $this->member();
        $book = $this->book(['available_copies' => 2]);
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'borrowed',
            'borrowed_at' => now()->subDays(5),
            'due_at' => now()->addDays(9),
        ]);
        $book->decrement('available_copies');

        $response = $this->actingAs($member)
            ->patch("/borrowings/{$borrowing->id}/return");

        $response->assertRedirect('/borrowings');

        $this->assertDatabaseHas('library_books', [
            'id' => $book->id,
            'available_copies' => 2,
        ]);

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'returned',
        ]);
    }

    public function test_returning_already_returned_book_fails(): void
    {
        $member = $this->member();
        $book = $this->book();
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $response = $this->actingAs($member)
            ->patch("/borrowings/{$borrowing->id}/return");

        $response->assertSessionHasErrors('borrowing');
    }

    // ─── Fine System ─────────────────────────────────────

    public function test_returning_overdue_book_creates_fine(): void
    {
        $member = $this->member();
        $book = $this->book(['available_copies' => 3]);
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'borrowed',
            'borrowed_at' => now()->subDays(20),
            'due_at' => now()->subDays(6),
        ]);
        $book->decrement('available_copies');

        $response = $this->actingAs($member)
            ->patch("/borrowings/{$borrowing->id}/return");

        $response->assertRedirect('/borrowings');
        $response->assertSessionHas('warning');

        $this->assertDatabaseHas('fines', [
            'borrowing_id' => $borrowing->id,
            'paid' => false,
        ]);

        // Fine should be $0.50 × 6 days = $3.00
        $fine = Fine::where('borrowing_id', $borrowing->id)->first();
        $this->assertEquals(3.00, $fine->amount);
    }

    public function test_fine_can_be_paid(): void
    {
        $member = $this->member();
        $book = $this->book();
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'returned',
            'returned_at' => now(),
        ]);
        $fine = Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'amount' => 3.00,
            'paid' => false,
        ]);

        $response = $this->actingAs($member)->post("/fines/{$fine->id}/pay");

        $response->assertRedirect('/fines');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('fines', [
            'id' => $fine->id,
            'paid' => true,
        ]);
    }

    public function test_member_cannot_pay_others_fine(): void
    {
        $member1 = $this->member();
        $member2 = $this->member();
        $book = $this->book();
        $borrowing = Borrowing::factory()->forMember($member2)->forBook($book)->create([
            'status' => 'returned',
            'returned_at' => now(),
        ]);
        $fine = Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'amount' => 3.00,
            'paid' => false,
        ]);

        $response = $this->actingAs($member1)->post("/fines/{$fine->id}/pay");

        $response->assertStatus(403);
    }

    public function test_staff_can_pay_any_fine(): void
    {
        $member = $this->member();
        $book = $this->book();
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'returned',
            'returned_at' => now(),
        ]);
        $fine = Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'amount' => 3.00,
            'paid' => false,
        ]);

        $response = $this->actingAs($this->admin())->post("/fines/{$fine->id}/pay");

        $response->assertRedirect('/fines');
        $this->assertDatabaseHas('fines', ['id' => $fine->id, 'paid' => true]);
    }

    public function test_paying_already_paid_fine_fails(): void
    {
        $member = $this->member();
        $book = $this->book();
        $borrowing = Borrowing::factory()->forMember($member)->forBook($book)->create([
            'status' => 'returned',
        ]);
        $fine = Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'amount' => 3.00,
            'paid' => true,
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($member)->post("/fines/{$fine->id}/pay");

        $response->assertSessionHasErrors('fine');
    }

    // ─── Book Management ─────────────────────────────────

    public function test_admin_can_create_book(): void
    {
        Http::fake();

        $response = $this->actingAs($this->admin())->post('/books/add', [
            'title' => 'New Test Book',
            'author' => 'Test Author',
            'genre' => 'Fiction',
            'isbn' => '978-0-123-45678-9',
            'publication_year' => 2023,
            'publisher' => 'Test Publisher',
            'pages' => 300,
            'shelf_location' => 'C1',
            'available_copies' => 5,
            'is_available' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('library_books', [
            'title' => 'New Test Book',
            'author' => 'Test Author',
        ]);
    }

    public function test_member_cannot_create_book(): void
    {
        $response = $this->actingAs($this->member())->post('/books/add', [
            'title' => 'Should Not Work',
            'author' => 'Hacker',
            'genre' => 'Fiction',
            'isbn' => '978-0-999-99999-9',
            'publication_year' => 2024,
            'publisher' => 'Fake',
            'pages' => 100,
            'shelf_location' => 'X1',
            'available_copies' => 1,
        ]);

        $response->assertStatus(403);
    }

    // ─── Welcome Page ────────────────────────────────────

    public function test_welcome_page_shows_live_stats(): void
    {
        Http::fake();

        LibraryBook::factory()->count(5)->fiction()->create(['available_copies' => 2]);
        LibraryBook::factory()->count(3)->nonFiction()->create(['available_copies' => 1]);

        $member = $this->member();
        Borrowing::factory()
            ->forMember($member)
            ->forBook(LibraryBook::first())
            ->create(['status' => 'borrowed']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Total Books:');
        $response->assertSee('Active Borrowings:');
        $response->assertSeeInOrder(['Total Books:', '8']);
        $response->assertSeeInOrder(['Active Borrowings:', '1']);
        $response->assertSee('Fiction');
        $response->assertSee('Non-Fiction');
    }

    public function test_welcome_page_handles_empty_database(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Total Books:');
        $response->assertSee('Active Borrowings:');
        $response->assertSee('0');
    }
}
