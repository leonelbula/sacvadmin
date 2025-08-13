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

      /*  $this->call([
            DepartamentsTableSeeder::class,
            CitiesTableSeeder::class,
            TaxesTableSeeder::class,
            OrganizationTypesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            IdentityDocumentsTableSeeder::class,
            CustomerTributesTableSeeder::class,
            ProductTypeSeeder::class,
        ]);*/
        //User::factory()->count(5)->create();
        //Company::factory()->count(5)->create();
       // Category::factory()->count(100)->create();
        Product::factory()->count(1000)->create();
        Customer::factory()->count(100)->create();
    }
}
