<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Customer::class;


    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'identification_card' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'department' => $this->faker->state(),
            'credit_amount' => $this->faker->randomFloat(2, 0, 100000), // crédito disponible
            'company_id' => Company::inRandomOrder()->first()->id ?? Company::factory(),
        ];
    }
}
