<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fine>
 */
class FineFactory extends Factory
{
    protected $model = Fine::class;

    public function definition(): array
    {
        return [
            'borrowing_id' => Borrowing::factory(),
            'amount' => fake()->randomFloat(2, 1, 20),
            'paid' => false,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'paid' => true,
            'paid_at' => now(),
        ]);
    }
}
