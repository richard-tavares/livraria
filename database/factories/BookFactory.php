<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'publisher' => $this->faker->company(),
            'edition' => $this->faker->numberBetween(1, 10),
            'publication_year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
