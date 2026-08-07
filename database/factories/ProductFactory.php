<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Product::class;

    public function definition(): array
    {
       $cost = $this->faker->numberBetween(1000, 100000);
        $utility = $this->faker->numberBetween(5, 50); // Porcentaje
        $price = $cost + ($cost * ($utility / 100));
        $taxIncluded = $this->faker->boolean();

        return [
            'code' => strtoupper($this->faker->bothify('PRD-###??')),
            'name' => $this->faker->words(3, true),
            'cost' => $cost,
            'price' => $price,
            'utility' => $utility,
            'stock_min' => $this->faker->numberBetween(1, 10),
            'stock' => $this->faker->numberBetween(10, 50),
            'state' => $this->faker->boolean(),
            // Relaciones
            'tax_id' => Tax::inRandomOrder()->first()->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
