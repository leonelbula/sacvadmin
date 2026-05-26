<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['code' => 'PT001', 'name' => 'Producto'],
            ['code' => 'PT003', 'name' => 'Servicio'],
          
        ];

        foreach ($types as $type) {
            ProductType::updateOrCreate(['code' => $type['code']], $type);
        }
    }
}
