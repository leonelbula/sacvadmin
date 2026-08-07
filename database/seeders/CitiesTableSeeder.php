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
            //AMAZONAS
            ['code' => 91001, 'name' => 'Leticia', 'departament_id' => 1],
            ['code' => 91263, 'name' => 'El Encanto', 'departament_id' => 1],
            ['code' => 91405, 'name' => 'La Chorrera', 'departament_id' => 1],
            ['code' => 91407, 'name' => 'La Pedrera', 'departament_id' => 1],
            ['code' => 91430, 'name' => 'La Victoria', 'departament_id' => 1],
            ['code' => 91460, 'name' => 'Mirití - Paraná', 'departament_id' => 1],
            ['code' => 91530, 'name' => 'Puerto Alegría', 'departament_id' => 1],
            ['code' => 91536, 'name' => 'Puerto Arica', 'departament_id' => 1],
            ['code' => 91540, 'name' => 'Puerto Nariño', 'departament_id' => 1],
            ['code' => 91669, 'name' => 'Puerto Santander', 'departament_id' => 1],
            ['code' => 91798, 'name' => 'Tarapacá', 'departament_id' => 1],

            // Antioquia

            ['code' => 05001, 'name' => 'Medellín', 'departament_id' => 2],
            ['code' => 05002, 'name' => 'Abejorral', 'departament_id' => 2],
            ['code' => 05004, 'name' => 'Abriaquí', 'departament_id' => 2],
            ['code' => 05021, 'name' => 'Alejandría', 'departament_id' => 2],
            ['code' => 05030, 'name' => 'Amagá', 'departament_id' => 2],
            ['code' => 05031, 'name' => 'Amalfi', 'departament_id' => 2],
            ['code' => 05034, 'name' => 'Andes', 'departament_id' => 2],
            ['code' => 05036, 'name' => 'Angelópolis', 'departament_id' => 2],
            ['code' => 05037, 'name' => 'Angostura', 'departament_id' => 2],
            ['code' => 05040, 'name' => 'Anorí', 'departament_id' => 2],
            ['code' => 05042, 'name' => 'Santafé de Antioquia', 'departament_id' => 2],
            ['code' => 05044, 'name' => 'Anza', 'departament_id' => 2],
            ['code' => 05045, 'name' => 'Apartadó', 'departament_id' => 2],
            ['code' => 05051, 'name' => 'Arboletes', 'departament_id' => 2],
            ['code' => 05055, 'name' => 'Argelia', 'departament_id' => 2],
            ['code' => 05056, 'name' => 'Armenia', 'departament_id' => 2],
            ['code' => 05057, 'name' => 'Barbosa', 'departament_id' => 2],
          
            //

            // Cundinamarca (id: 25, code: 25)
            ['code' => 25001, 'name' => 'Soacha', 'departament_id' => 25],
            ['code' => 25035, 'name' => 'Facatativá', 'departament_id' => 25],

            // Valle del Cauca (id: 30, code: 76)
            ['code' => 76001, 'name' => 'Cali', 'departament_id' => 30],
            ['code' => 76036, 'name' => 'Palmira', 'departament_id' => 30],

            // Atlántico (id: 4, code: 8)
            ['code' => 8001, 'name' => 'Barranquilla', 'departament_id' => 4],
            ['code' => 8078, 'name' => 'Soledad', 'departament_id' => 4],

            // Bolívar (id: 5, code: 13)
            ['code' => 13001, 'name' => 'Cartagena', 'departament_id' => 5],

            // Santander (id: 27, code: 68)
            ['code' => 68001, 'name' => 'Bucaramanga', 'departament_id' => 27],

            // Bogotá D.C. (id: 33, code: 11)
            ['code' => 11001, 'name' => 'Bogotá D.C.', 'departament_id' => 33],

            //cordoba
            ['code' => 23001, 'name' => 'Montería', 'departament_id' => 13],
            ['code' => 23068, 'name' => 'Ayapel', 'departament_id' => 13],
            ['code' => 23079, 'name' => 'Buenavista', 'departament_id' => 13],
            ['code' => 23090, 'name' => 'Canalete', 'departament_id' => 13],
            ['code' => 23162, 'name' => 'Cereté', 'departament_id' => 13],
            ['code' => 23168, 'name' => 'Chimá', 'departament_id' => 13],
            ['code' => 23182, 'name' => 'Chinú', 'departament_id' => 13],
            ['code' => 23189, 'name' => 'Ciénaga de Oro', 'departament_id' => 13],
            ['code' => 23300, 'name' => 'Cotorra', 'departament_id' => 13],
            ['code' => 23350, 'name' => 'La Apartada', 'departament_id' => 13],
            ['code' => 23417, 'name' => 'Lorica', 'departament_id' => 13],
            ['code' => 23419, 'name' => 'Los Córdobas', 'departament_id' => 13],
            ['code' => 23464, 'name' => 'Momil', 'departament_id' => 13],
            ['code' => 23466, 'name' => 'Montelíbano', 'departament_id' => 13],
            ['code' => 23500, 'name' => 'Moñitos', 'departament_id' => 13],
            ['code' => 23555, 'name' => 'Planeta Rica', 'departament_id' => 13],
            ['code' => 23570, 'name' => 'Pueblo Nuevo', 'departament_id' => 13],
            ['code' => 23574, 'name' => 'Puerto Escondido', 'departament_id' => 13],
            ['code' => 23580, 'name' => 'Puerto Libertador', 'departament_id' => 13],
            ['code' => 23586, 'name' => 'Purísima', 'departament_id' => 13],
            ['code' => 23660, 'name' => 'Sahagún', 'departament_id' => 13],
            ['code' => 23670, 'name' => 'San Andrés de Sotavento', 'departament_id' => 13],
            ['code' => 23672, 'name' => 'San Antero', 'departament_id' => 13],
            ['code' => 23675, 'name' => 'San Bernardo del Viento', 'departament_id' => 13],
            ['code' => 23678, 'name' => 'San Carlos', 'departament_id' => 13],
            ['code' => 23682, 'name' => 'San José de Uré', 'departament_id' => 13],
            ['code' => 23686, 'name' => 'San Pelayo', 'departament_id' => 13],
            ['code' => 23807, 'name' => 'Tierralta', 'departament_id' => 13],
            ['code' => 23815, 'name' => 'Tuchín', 'departament_id' => 13],
            ['code' => 23855, 'name' => 'Valencia', 'departament_id' => 13],

            //SINCELEJO
            ['code' => 70001, 'name' => 'Sincelejo', 'departament_id' => 28],
            ['code' => 70110, 'name' => 'Buenavista', 'departament_id' => 28],
            ['code' => 70124, 'name' => 'Caimito', 'departament_id' => 28],
            ['code' => 70204, 'name' => 'Colosó', 'departament_id' => 28],
            ['code' => 70215, 'name' => 'Corozal', 'departament_id' => 28],
            ['code' => 70221, 'name' => 'Coveñas', 'departament_id' => 28],
            ['code' => 70230, 'name' => 'Chalán', 'departament_id' => 28],
            ['code' => 70233, 'name' => 'El Roble', 'departament_id' => 28],
            ['code' => 70235, 'name' => 'Galeras', 'departament_id' => 28],
            ['code' => 70265, 'name' => 'Guaranda', 'departament_id' => 28],
            ['code' => 70400, 'name' => 'La Unión', 'departament_id' => 28],
            ['code' => 70418, 'name' => 'Los Palmitos', 'departament_id' => 28],
            ['code' => 70429, 'name' => 'Majagual', 'departament_id' => 28],
            ['code' => 70473, 'name' => 'Morroa', 'departament_id' => 28],
            ['code' => 70508, 'name' => 'Ovejas', 'departament_id' => 28],
            ['code' => 70523, 'name' => 'Palmito', 'departament_id' => 28],
            ['code' => 70670, 'name' => 'Sampués', 'departament_id' => 28],
            ['code' => 70678, 'name' => 'San Benito Abad', 'departament_id' => 28],
            ['code' => 70702, 'name' => 'San Juan de Betulia', 'departament_id' => 28],
            ['code' => 70708, 'name' => 'San Marcos', 'departament_id' => 28],
            ['code' => 70713, 'name' => 'San Onofre', 'departament_id' => 28],
            ['code' => 70717, 'name' => 'San Pedro', 'departament_id' => 28],
            ['code' => 70742, 'name' => 'San Luis de Sincé', 'departament_id' => 28],
            ['code' => 70771, 'name' => 'Sucre', 'departament_id' => 28],
            ['code' => 70820, 'name' => 'Tolú', 'departament_id' => 28],
            ['code' => 70823, 'name' => 'San José de Toluviejo', 'departament_id' => 28],

        ];

        DB::table('cities')->insert($cities);
    }
}
