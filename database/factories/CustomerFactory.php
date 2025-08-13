<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerTributes;
use App\Models\Departament;
use App\Models\IdentityDocument;
use App\Models\OrganizationType;
use App\Models\Tax;
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
            'identification_card' => $this->faker->unique()->numberBetween(10000000, 999999999),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'credit_amount' => $this->faker->random_int(100000,1000000),

            // Relaciones (asegúrate de tener datos en estas tablas)
            'Departament_id' => Departament::inRandomOrder()->first()->id ?? 1,
            'city_id' => City::inRandomOrder()->first()->id ?? 1,
            'tax_id' => Tax::inRandomOrder()->first()->id ?? 1,
            'type_organice_id' => OrganizationType::inRandomOrder()->first()->id ?? 1,
            'identity_document_id' => IdentityDocument::inRandomOrder()->first()->id ?? 1,
            'customer_tribute_id' => CustomerTributes::inRandomOrder()->first()->id ?? 1,
            'company_id' => Company::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
