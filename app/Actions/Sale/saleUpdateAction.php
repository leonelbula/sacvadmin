<?php

namespace App\Actions\Sale;

use App\DTOs\SaleDTO;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class SaleUpdateAction
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Actualiza una venta existente.
     */
    public function execute(int $id, SaleDTO $dto, array $products): Sale
    {

        /*
        |--------------------------------------------------------------------------
        | Validar productos
        |--------------------------------------------------------------------------
        */

        if (empty($products)) {
            throw new Exception(
                'No se pueden actualizar ventas sin productos.'
            );
        }

        return DB::transaction(function () use ($id, $dto, $products) {

            $userName = Auth::user()->name ?? 'Sistema';

            /*
            |--------------------------------------------------------------------------
            | 1. BUSCAR LA VENTA EXISTENTE
            |--------------------------------------------------------------------------
            */

            $sale = $this->saleRepository->findById($id);

            if (!$sale) {
                throw new Exception(
                    "La venta con ID {$id} no existe."
                );
            }
            $saleNumber = $sale->sale_number;
            /*
            |--------------------------------------------------------------------------
            | 2. OBTENER DETALLES ANTERIORES
            |--------------------------------------------------------------------------
            */

            $oldDetails = $sale->details()->get();

            /*
            |--------------------------------------------------------------------------
            | 3. DEVOLVER STOCK DE LA VENTA ANTERIOR
            |--------------------------------------------------------------------------
            */

            foreach ($oldDetails as $oldDetail) {

                $product = $this->productRepository
                    ->lockForUpdate($oldDetail->product_id);

                if (!$product) {
                    throw new Exception(
                        "El producto {$oldDetail->product_id} no existe."
                    );
                }

                $stockBefore = $product->stock;

                $product->stock += $oldDetail->quantity;

                $product->save();

                $stockAfter = $product->stock;

                /*
                |--------------------------------------------------------------------------
                | Kardex - Reversión
                |--------------------------------------------------------------------------
                */

                $this->kardexRepository->create([

                    'product_id' =>
                    $oldDetail->product_id,

                    'date' =>
                    now(),

                    'movement_type' =>
                    'REVERSION',

                    'origin' =>
                    "ACTUALIZACION VENTA NRO: {$saleNumber}",

                    'reference_id' =>
                    $sale->id,

                    'income' =>
                    $oldDetail->quantity,

                    'output' =>
                    0,

                    'stock_before' =>
                    $stockBefore,

                    'stock_after' =>
                    $stockAfter,

                    /*
                    | El Kardex debe registrar el costo
                    | y no el precio de venta.
                    */
                    'unit_cost' =>
                    $oldDetail->cost,

                    'user_name' =>
                    $userName,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. ELIMINAR DETALLES ANTERIORES
            |--------------------------------------------------------------------------
            */

            $sale->details()->delete();

            /*
            |--------------------------------------------------------------------------
            | 5. CALCULAR TOTALES NUEVOS
            |--------------------------------------------------------------------------
            */

            $totalCost = collect($products)->sum(
                fn($product) =>
                (float) $product['cost'] *
                    (int) $product['quantity']
            );

            $totalCalculated = collect($products)->sum(
                fn($product) =>
                (float) $product['price'] *
                    (int) $product['quantity']
            );

            $utility = $totalCalculated - $totalCost;

            /*
            |--------------------------------------------------------------------------
            | 6. DATOS DE LA VENTA
            |--------------------------------------------------------------------------
            */

            $data = $dto->toArray();

            /*
            |--------------------------------------------------------------------------
            | Forma de pago
            |--------------------------------------------------------------------------
            */

            if ($data['payment_form'] === 'counted') {

                $data['expiration_date'] =  $data['date_sale'];

                $data['term'] = 0;

                $data['balance'] = 0;

                /*
                | Ajusta este valor según tu BD.
                */
                $data['type_sale'] = 1;
            } else {

                $data['type_sale'] = 0;

                $days = (int) $data['term'];

                $data['expiration_date'] = Carbon::parse($data['date_sale'])->addDays($days)->format('Y-m-d');

                $data['balance'] = $totalCalculated;
            }

            /*
            |--------------------------------------------------------------------------
            | Totales
            |--------------------------------------------------------------------------
            */

            $data['cost'] = $totalCost;

            $data['utility'] = $utility;

            $data['total'] = $totalCalculated;

            $data['state'] = 'active';

            /*
            |--------------------------------------------------------------------------
            | 7. ACTUALIZAR LA VENTA EXISTENTE
            |--------------------------------------------------------------------------
            */

            $sale = $this->saleRepository->update($id, $data);

            /*
            |--------------------------------------------------------------------------
            | 8. BUSCAR IMPUESTOS
            |--------------------------------------------------------------------------
            */

            $taxValues = collect($products)
                ->pluck('tax')
                ->unique()
                ->values()
                ->toArray();

            $taxes = DB::table('taxes')
                ->whereIn('value', $taxValues)
                ->get()
                ->keyBy('value');

            /*
            |--------------------------------------------------------------------------
            | 9. CREAR NUEVOS DETALLES
            |--------------------------------------------------------------------------
            */

            $detailsData = [];

            foreach ($products as $prod) {

                $product = $this->productRepository
                    ->lockForUpdate($prod['id']);

                if (!$product) {
                    throw new Exception(
                        "El producto {$prod['id']} no existe."
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Verificar stock
                |--------------------------------------------------------------------------
                */

                if (
                    $product->stock <
                    $prod['quantity']
                ) {

                    throw new Exception(
                        "Stock insuficiente para el producto: "
                            . $product->name
                            . ". Disponible: "
                            . $product->stock
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Stock
                |--------------------------------------------------------------------------
                */

                $stockBefore = $product->stock;

                $product->stock -=  $prod['quantity'];

                $product->save();

                $stockAfter = $product->stock;

                /*
                |--------------------------------------------------------------------------
                | Impuesto
                |--------------------------------------------------------------------------
                */

                $taxRecord = $taxes->get($prod['tax']);

                if (!$taxRecord) {

                    throw new Exception(
                        "El impuesto del {$prod['tax']}% "
                            . "no está registrado."
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Subtotal
                |--------------------------------------------------------------------------
                */

                $subtotalItem = (float) $prod['price'] * (int) $prod['quantity'];

                /*
                |--------------------------------------------------------------------------
                | Utilidad
                |--------------------------------------------------------------------------
                */

                $utilityItem =  $subtotalItem - ((float) $prod['cost'] * (int) $prod['quantity']);

                /*
                |--------------------------------------------------------------------------
                | Detalle
                |--------------------------------------------------------------------------
                */

                $detailsData[] = [
                    'product_id' => $prod['id'],
                    'price' => $prod['price'],
                    'cost' => $prod['cost'],
                    'quantity' => $prod['quantity'],
                    'subtotal' => $subtotalItem,
                    'utility' => $utilityItem,
                    'tax_id' => $taxRecord->id,
                ];

                /*
                |--------------------------------------------------------------------------
                | Kardex - Salida
                |--------------------------------------------------------------------------
                */

                $this->kardexRepository->create([

                    'product_id' => $prod['id'],
                    'date' => now(),
                    'movement_type' => 'SALIDA',
                    'origin' => "ACTUALIZACION VENTA NRO: " . $sale->sale_number,
                    'reference_id' => $sale->id,
                    'income' => 0,
                    'output' => $prod['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,

                    /*
                    | Costo del producto
                    */
                    'unit_cost' => $prod['cost'],
                    'user_name' => $userName,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 10. CREAR NUEVOS DETALLES
            |--------------------------------------------------------------------------
            */

            $sale->details()->createMany(
                $detailsData
            );

            /*
            |--------------------------------------------------------------------------
            | 11. DEVOLVER VENTA ACTUALIZADA
            |--------------------------------------------------------------------------
            */

            return $sale->fresh('details');
        });
    }
}
