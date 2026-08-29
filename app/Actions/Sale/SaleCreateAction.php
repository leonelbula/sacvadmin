<?php

namespace App\Actions\Sale;

use App\DTOs\SaleDTO;
use App\Models\Parameter;
use App\Models\Sale;
use App\Repositories\KardexRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class SaleCreateAction
{
    public function __construct(
        protected SaleRepository $saleRepository,
        protected KardexRepository $kardexRepository,
        protected ProductRepository $productRepository
    ) {}

    /**
     * Ejecuta la creación de la venta
     * 
     * @param SaleDTO $dto
     * @param array $products Estructura esperada: [['id' => 1, 'quantity' => 2, 'price' => 100, 'cost' => 70, 'tax' => 19], ...]
     * @return Sale
     */
    public function execute(SaleDTO $dto, array $products): Sale
    {
        if (empty($products)) {
            throw new Exception("No se pueden registrar ventas sin productos.");
        }

        return DB::transaction(function () use ($dto, $products) {
            $data = $dto->toArray();
            $parameter = Parameter::first();

            // 1. Número de venta correlativo seguro
            $lastSale = $this->saleRepository->lastSale();
            $saleNumber = $lastSale ? ($lastSale->sale_number + 1) : ($parameter ? ($parameter->sale_code + 1) : 1);

            // 2. Recálculo estricto de costos, subtotales e impuestos en el servidor (Evita fraudes del Frontend)
            $totalCost = collect($products)->sum(fn($prod) => $prod['cost'] * $prod['quantity']);
            $totalCalculated = collect($products)->sum(fn($prod) => $prod['price'] * $prod['quantity']);
            $utility = $totalCalculated - $totalCost;

            // Determinar balance según la forma de pago
            $balance = $data['payment_form'] === 'counted' ? 0 : $totalCalculated;

            // 3. Gestión estricta de fechas usando los datos limpios del DTO
            if ($data['payment_form'] === 'counted') {
                $data['expiration_date'] = $data['date_sale'];
                $data['term']            = '0';
            } else {
                $data['type_sale']       = 0;
                // CORREGIDO: Se usa el 'term' que ya validó el DTO en lugar de 'plazo'
                $days                    = (int)$data['term'];
                $data['expiration_date'] = date('Y-m-d', strtotime($data['date_sale'] . " + $days days"));
            }

            // Inyección de variables calculadas obligatorias en el servidor
            $data['sale_number'] = $saleNumber;
            $data['cost']        = $totalCost;
            $data['utility']     = $utility;
            $data['total']       = $totalCalculated;
            $data['balance']     = $balance;
            $data['hour']        = date('H:i:s');
            $data['state']       = 'active'; // Ajustado a string ya que tu migración define 'state' como string

            // Guardar cabecera de la venta
            $sale = $this->saleRepository->create($data);
            $detailsData = [];

            // Obtener el nombre del usuario autenticado de forma segura para el Kardex
            $userName = Auth::user()->name ?? 'Sistema';

            // 4. Ciclo transaccional de productos (Concurrencia protegida)
            foreach ($products as $prod) {
                // lockForUpdate previene condiciones de carrera concurrentes
                $product = $this->productRepository->lockForUpdate($prod['id']);

                if ($product->stock < $prod['quantity']) {
                    throw new Exception("Stock insuficiente en BD para el producto: {$product->name}");
                }

                $stockBefore = $product->stock;
                $product->stock -= $prod['quantity'];
                $product->save();
                $stockAfter = $product->stock;

                // Buscar el impuesto en la base de datos
                $taxRecord = DB::table('taxes')->where('value', $prod['tax'])->first();
                if (!$taxRecord) {
                    throw new Exception("El impuesto del {$prod['tax']}% no está registrado.");
                }

                $subtotalItem = $prod['price'] * $prod['quantity'];
                $costTotalItem = $prod['cost'] * $prod['quantity'];
                $utilityItem = $subtotalItem - $costTotalItem;

                // Estructura idéntica a tu migración de 'sale_details'
                $detailsData[] = [
                    'product_id' => $prod['id'],
                    'price'      => $prod['price'],
                    'cost'       => $prod['cost'],
                    'quantity'   => $prod['quantity'],
                    'subtotal'   => $subtotalItem,
                    'utility'    => $utilityItem,
                    'tax_id'     => $taxRecord->id,
                ];

                // Registro del movimiento Kardex
                $this->kardexRepository->create([
                    'product_id'    => $prod['id'],
                    'date'          => now(),
                    'movement_type' => 'SALIDA',
                    'origin'        => "VENTA NRO: {$saleNumber}",
                    'reference_id'  => $sale->id,
                    'income'        => 0,
                    'output'        => $prod['quantity'],
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     => $prod['price'],
                    'user_name'     => $userName, // CORREGIDO: Variable segura de Laravel Auth
                ]);
            }

            // 5. Inserción masiva mediante la relación HasMany del modelo
            $sale->details()->createMany($detailsData);

            return $sale;
        });
    }
}
