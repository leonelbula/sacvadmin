<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $methods = [
            ['code' => 1, 'name' => 'Efectivo'],
            ['code' => 2, 'name' => 'Transferencia Bancaria'],
            ['code' => 3, 'name' => 'Tarjeta de Crédito'],
            ['code' => 4, 'name' => 'Tarjeta Débito'],
            ['code' => 5, 'name' => 'Cheque'],
            ['code' => 6, 'name' => 'Consignación'],
            ['code' => 7, 'name' => 'Pago en Línea'],
            ['code' => 8, 'name' => 'Giro'],
            ['code' => 9, 'name' => 'Billetera Digital'],
        ];

        DB::table('payment_methods')->insert($methods);
    }
}
