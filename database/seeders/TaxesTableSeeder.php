<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxes = [
            [
                'code' => 'IVA05',
                'name' => 'IVA 5%',
                'description' => 'Impuesto al valor agregado del 5%',
                'value' => 5.0,
            ],
            [
                'code' => 'IVA19',
                'name' => 'IVA 19%',
                'description' => 'Impuesto al valor agregado del 19%',
                'value' => 19.0,
            ],
            [
                'code' => 'RET10',
                'name' => 'Retefuente 10%',
                'description' => 'Retención en la fuente del 10%',
                'value' => 10.0,
            ],
            [
                'code' => 'RET11',
                'name' => 'Retefuente 11%',
                'description' => 'Retención en la fuente del 11%',
                'value' => 11.0,
            ],
            [
                'code' => 'EXENTO',
                'name' => 'Exento',
                'description' => 'Producto exento de impuestos',
                'value' => 0.0,
            ],
        ];

        DB::table('taxes')->insert($taxes);
    }
}
