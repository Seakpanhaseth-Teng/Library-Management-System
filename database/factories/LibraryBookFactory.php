<?php

namespace Database\Factories;

use App\Models\LibraryBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LibraryBook>
 */
class LibraryBookFactory extends Factory
{
    protected $model = LibraryBook::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'genre' => fake()->randomElement(['Fiction', 'Non-Fiction']),
            'isbn' => fake()->unique()->isbn13(),
            'publication_year' => fake()->numberBetween(1900, 2024),
            'publisher' => fake()->company(),
            'pages' => fake()->numberBetween(100, 1000),
            'shelf_location' => strtoupper(fake()->randomLetter()) . fake()->numberBetween(1, 20),
            'available_copies' => fake()->numberBetween(1, 5),
            'is_available' => true,
        ];
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_copies' => 0,
            'is_available' => false,
        ]);
    }

    public function fiction(): static
    {
        return $this->state(fn (array $attributes) => [
            'genre' => 'Fiction',
        ]);
    }

    public function nonFiction(): static
    {
        return $this->state(fn (array $attributes) => [
            'genre' => 'Non-Fiction',
        ]);
    }
}
