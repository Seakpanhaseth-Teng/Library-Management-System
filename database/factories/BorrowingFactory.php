<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\LibraryBook;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => LibraryBook::factory(),
            'borrowed_at' => now()->subDays(7),
            'due_at' => now()->addDays(7),
            'status' => 'borrowed',
        ];
    }

    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'returned',
            'returned_at' => now(),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_at' => now()->subDays(5),
        ]);
    }

    public function forMember(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    public function forBook(LibraryBook $book): static
    {
        return $this->state(fn (array $attributes) => [
            'book_id' => $book->id,
        ]);
    }
}
