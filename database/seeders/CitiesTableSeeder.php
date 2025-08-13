<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Antioquia (id: 2, code: 5)
            ['code' => 5001, 'name' => 'Medellín', 'Departament_id' => 2],
            ['code' => 5002, 'name' => 'Bello', 'Departament_id' => 2],
            ['code' => 5003, 'name' => 'Itagüí', 'Departament_id' => 2],

            // Cundinamarca (id: 25, code: 25)
            ['code' => 25001, 'name' => 'Soacha', 'Departament_id' => 25],
            ['code' => 25035, 'name' => 'Facatativá', 'Departament_id' => 25],

            // Valle del Cauca (id: 30, code: 76)
            ['code' => 76001, 'name' => 'Cali', 'Departament_id' => 30],
            ['code' => 76036, 'name' => 'Palmira', 'Departament_id' => 30],

            // Atlántico (id: 4, code: 8)
            ['code' => 8001, 'name' => 'Barranquilla', 'Departament_id' => 4],
            ['code' => 8078, 'name' => 'Soledad', 'Departament_id' => 4],

            // Bolívar (id: 5, code: 13)
            ['code' => 13001, 'name' => 'Cartagena', 'Departament_id' => 5],

            // Santander (id: 27, code: 68)
            ['code' => 68001, 'name' => 'Bucaramanga', 'Departament_id' => 27],

            // Bogotá D.C. (id: 33, code: 11)
            ['code' => 11001, 'name' => 'Bogotá D.C.', 'Departament_id' => 33],
        ];

        DB::table('cities')->insert($cities);
    }
}
