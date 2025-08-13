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
       $cost = $this->faker->randomFloat(2, 1000, 100000);
        $utility = $this->faker->randomFloat(2, 5, 50); // Porcentaje
        $price = $cost + ($cost * ($utility / 100));
        $taxIncluded = $this->faker->boolean();

        return [
            'code' => strtoupper($this->faker->bothify('PRD-###??')),
            'name' => $this->faker->words(3, true),
            'cost' => $cost,
            'price' => $price,
            'utility' => $utility,
            'minimum_amount' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->numberBetween(10, 500),
            'tax' => $taxIncluded,
            'tax_value' => $taxIncluded ? $this->faker->randomElement([0, 5, 19]) : 0,
            'state' => $this->faker->boolean(90),

            // Relaciones
            'product_type_id' => ProductType::inRandomOrder()->first()->id ?? 1,
            'taxes_id' => Tax::inRandomOrder()->first()->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'company_id' => Company::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
