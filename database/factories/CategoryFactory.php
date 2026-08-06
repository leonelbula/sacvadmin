<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true), // genera nombres como "Ropa Deportiva"
            'state' => $this->faker->boolean(90),   // 90% probabilidad de que sea true
        ];
    }
}
