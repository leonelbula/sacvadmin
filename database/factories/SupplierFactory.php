<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Supplier::class;


    public function definition(): array
    {
        return [
            'full_name' => $this->faker->company(),
            'identification_card' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'department' => $this->faker->state(),
            'credit_amount' => $this->faker->randomFloat(2, 0, 200000), // crédito asignado
            'description' => $this->faker->catchPhrase(), // algo como "Proveedor confiable de repuestos"
            'company_id' => Company::inRandomOrder()->first()->id ?? Company::factory(),
        ];
    }
}
