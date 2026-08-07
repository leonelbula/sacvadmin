<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentityDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $documents = [
            ['code' => 1, 'name' => 'Cédula de Ciudadanía'],
            ['code' => 2, 'name' => 'Tarjeta de Identidad'],
            ['code' => 3, 'name' => 'Cédula de Extranjería'],
            ['code' => 4, 'name' => 'Pasaporte'],
            ['code' => 5, 'name' => 'NIT'],
            ['code' => 6, 'name' => 'Registro Civil'],
            ['code' => 7, 'name' => 'Permiso por Protección Temporal (PPT)'],
        ];

        DB::table('identity_documents')->insert($documents);
    }
}
