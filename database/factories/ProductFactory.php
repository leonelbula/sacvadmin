<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
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
        $cost = $this->faker->randomFloat(2, 10, 100);
        $utility = $this->faker->randomFloat(2, 10, 50); // utilidad en valor
        $price = $cost + $utility;

        return [
            'code' => $this->faker->unique()->ean13,
            'name' => $this->faker->words(3, true), // Ej: "Cámara de seguridad HD"
            'cost' => $cost,
            'price' => $price,
            'utility' => $utility,
            'minimum_amount' => $this->faker->randomFloat(2, 1, 5),
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'state' => $this->faker->boolean(90),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'company_id' => Company::inRandomOrder()->first()->id ?? Company::factory(),
        ];
    }
}
