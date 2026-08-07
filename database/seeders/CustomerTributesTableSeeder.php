<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tributes = [
            ['code' => 1, 'name' => 'Régimen Común'],
            ['code' => 2, 'name' => 'Régimen Simplificado'],
            ['code' => 3, 'name' => 'Gran Contribuyente'],
            ['code' => 4, 'name' => 'Autorretenedor'],
            ['code' => 5, 'name' => 'No Responsable'],
            ['code' => 6, 'name' => 'Entidad sin Ánimo de Lucro'],
        ];

        DB::table('customer_tributes')->insert($tributes);
    }
}
