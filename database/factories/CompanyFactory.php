<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Company::class;
    
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->company,
            'identification_card' => $this->faker->unique()->numerify('##########'), // 10 dígitos
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->companyEmail,
            'address' => $this->faker->streetAddress,
            'department' => $this->faker->state,
            'city' => $this->faker->city,
            'logo' => null, // Puedes generar imagen si quieres usando $this->faker->imageUrl()
            'user_id' => User::factory(), // Crea un usuario asociado automáticamente
        ];
    }
}
