<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizationTypes = [
            ['code' => 1, 'name' => 'Persona Natural'],
            ['code' => 2, 'name' => 'Sociedad Anónima (S.A.)'],
            ['code' => 3, 'name' => 'Sociedad por Acciones Simplificada (S.A.S.)'],
            ['code' => 4, 'name' => 'Sociedad Limitada (Ltda.)'],
            ['code' => 5, 'name' => 'Empresa Unipersonal (E.U.)'],
            ['code' => 6, 'name' => 'Cooperativa'],
            ['code' => 7, 'name' => 'Fundación'],
            ['code' => 8, 'name' => 'Asociación'],
        ];

        DB::table('organization_types')->insert($organizationTypes);
    }
}
