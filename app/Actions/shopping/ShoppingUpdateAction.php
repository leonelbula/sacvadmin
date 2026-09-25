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

class ShoppingUpdateAction
{
    public function __construct(
        protected ShoppingRepositoryInterface $shopping_repository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Actualiza una venta existente.
     */
    public function execute(int $id, ShoppingDTO $dto, array $products): Shopping
    {

        if (empty($products)) {
            throw new Exception(
                'No se pueden actualizar compra sin productos.'
            );
        }

        return DB::transaction(function () use ($id, $dto, $products) {

            $userName = Auth::user()->name ?? 'Sistema';


            $shopping = $this->shopping_repository->findById($id);

            if (!$shopping) {
                throw new Exception(
                    "La comnpra con ID {$id} no existe."
                );
            }
            $shoppingNumber = $shopping->invoice_number;

            $oldDetails = $shopping->details()->get();


            foreach ($oldDetails as $oldDetail) {

                $product = $this->productRepository
                    ->lockForUpdate($oldDetail->product_id);

                if (!$product) {
                    throw new Exception(
                        "El producto {$oldDetail->product_id} no existe."
                    );
                }

                $stockBefore = $product->stock;

                $product->stock -= $oldDetail->quantity;

                $product->save();

                $stockAfter = $product->stock;


                $this->kardexRepository->create([

                    'product_id' => $oldDetail->product_id,

                    'date' => now(),
                    'movement_type' => 'REVERSION',
                    'origin' =>  "ACTUALIZACION COMPRA NRO: {$shoppingNumber}",
                    'reference_id' => $shopping->id,
                    'income' => $oldDetail->quantity,
                    'output' => 0,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'unit_cost' => $oldDetail->price,
                    'user_name' => $userName,
                ]);
            }

            $shopping->details()->delete();



            $totalCalculated = collect($products)->sum(
                fn($product) =>
                (float) $product['cost'] *
                    (int) $product['quantity']
            );


            $data = $dto->toArray();

            $balance = $data['purchase_type'] === 'counted' ? 0 : $totalCalculated;

            if ($data['purchase_type'] === 'counted') {
                $data['due_date'] = $data['shopping_date'];
                $data['term']            = '0';
            } else {
                $data['type_sale']       = 0;
                $days                    = (int)$data['term'];
                $data['due_date'] = date('Y-m-d', strtotime($data['due_date'] . " + $days days"));
            }


            $data['total']       = $totalCalculated;
            $data['balance']     = $balance;



            $sale = $this->shopping_repository->update($id, $data);

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
                    'origin'        => "COMPRA NRO: {$shopping->invoice_number}",
                    'reference_id'  => $shopping->id,
                    'income'        => 0,
                    'output'        => $prod['quantity'],
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     => $prod['price'],
                    'user_name'     => $userName, // CORREGIDO: Variable segura de Laravel Auth
                ]);
            }


            $sale->details()->createMany(
                $detailsData
            );


            return $sale->fresh('details');
        });
    }
}
