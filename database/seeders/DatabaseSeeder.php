<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IdentityDocumentsTableSeeder::class,
            CustomerTributesTableSeeder::class,
            OrganizationTypesTableSeeder::class,
            TaxesTableSeeder::class,
            DepartamentsTableSeeder::class,
            CitiesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
        ]);

        User::factory()->count(5)->create();
        Category::factory()->count(20)->create();
        Product::factory()->count(100)->create();
        Customer::factory()->count(20)->create();
        Supplier::factory()->count(10)->create();
    }
}
