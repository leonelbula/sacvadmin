<?php

namespace App\Actions\Shopping;

use App\DTOs\ShoppingDTO;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ShoppingRepositoryInterface;
use App\Models\Shopping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class ShoppingCreateAction
{
    public function __construct(
        protected ShoppingRepositoryInterface $shopping_repository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Ejecuta la creación de la venta
     *
     * @param ShoppingDTO $dto
     * @param array $products Estructura esperada: [['id' => 1, 'quantity' => 2, 'price' => 100, 'cost' => 70, 'tax' => 19], ...]
     * @return Shopping
     */
    public function execute(ShoppingDTO $dto, array $products): Shopping
    {
        if (empty($products)) {
            throw new Exception("No se pueden registrar ventas sin productos.");
        }

        return DB::transaction(function () use ($dto, $products) {
            $data = $dto->toArray();



            $totalCalculated = collect($products)->sum(fn($prod) => $prod['cost'] * $prod['quantity']);

            $balance = $data['purchase_type'] === 'counted' ? 0 : $totalCalculated;

            if ($data['purchase_type'] === 'counted') {
                $data['due_date'] = $data['shopping_date'];
                $data['term']            = '0';
            } else {
                $days                    = (int)$data['term'];
                $data['due_date'] = date('Y-m-d', strtotime($data['shopping_date'] . " + $days days"));
            }


            $data['total']       = $totalCalculated;
            $data['balance']     = $balance;



            $shopping = $this->shopping_repository->create($data);
            $detailsData = [];


            $userName = Auth::user()->name ?? 'Sistema';


            foreach ($products as $prod) {
                $product = $this->productRepository->lockForUpdate($prod['id']);

                if ($prod['quantity'] <= 0) {
                    throw new Exception("La candida no debe ser cero o menor a cero: {$product->name}");
                }

                $stockBefore = $product->stock;
                $product->stock += $prod['quantity'];
                $product->save();
                $stockAfter = $product->stock;

                // Buscar el impuesto en la base de datos
                $taxRecord = DB::table('taxes')->where('value', $prod['tax'])->first();
                if (!$taxRecord) {
                    throw new Exception("El impuesto del {$prod['tax']}% no está registrado.");
                }


                $costTotalItem = $prod['cost'] * $prod['quantity'];
                $precio_base = $costTotalItem / (1 + ($prod['tax'] / 100));


                $subtotalItem = ($costTotalItem  - $precio_base);

                $detailsData[] = [
                    'product_id' => $prod['id'],
                    'quantity'      => $prod['quantity'],
                    'price'       => $prod['cost'],
                    'subtotal'   => $subtotalItem,
                    'has_iva' => 1,
                    'iva'     => $taxRecord->value,
                    'total'   => $prod['quantity'],
                ];


                $this->kardexRepository->create([
                    'product_id'    => $prod['id'],
                    'date'          => now(),
                    'movement_type' => 'INGRESO',
                    'origin'        => "cOMPRA NRO: {$shopping->invoice_number}",
                    'reference_id'  => $shopping->id,
                    'income'        => 0,
                    'output'        => $prod['quantity'],
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     => $prod['price'],
                    'user_name'     => $userName, // CORREGIDO: Variable segura de Laravel Auth
                ]);
            }

            // 5. Inserción masiva mediante la relación HasMany del modelo
            $shopping->details()->createMany($detailsData);

            return $shopping;
        });
    }
}
