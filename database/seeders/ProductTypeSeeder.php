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
            ['code' => 'PT001', 'name' => 'Producto terminado'],
            ['code' => 'PT002', 'name' => 'Materia prima'],
            ['code' => 'PT003', 'name' => 'Servicio'],
            ['code' => 'PT004', 'name' => 'Consumo interno'],
            ['code' => 'PT005', 'name' => 'Bien de uso'],
        ];

        foreach ($types as $type) {
            ProductType::updateOrCreate(['code' => $type['code']], $type);
        }
    }
}
