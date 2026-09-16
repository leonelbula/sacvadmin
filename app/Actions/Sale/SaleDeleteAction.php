<?php

namespace App\Actions\Sale;

use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class SaleDeleteAction
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}
    public function execute(int $id): bool
    {
        if ($id == null) {
            throw new Exception('No se especificó el ID de la venta a eliminar.');
        }
        return DB::transaction(function () use ($id) {
            $userName = Auth::user()->name ?? 'Sistema';

            $sale = $this->saleRepository->findById($id);

            if (!$sale) {
                throw new Exception(
                    "La venta con ID {$id} no existe."
                );
            }
            $saleNumber = $sale->sale_number;

            $oldDetails = $sale->details()->get();

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

                    'product_id' => $oldDetail->product_id,

                    'date' => now(),

                    'movement_type' => 'ELIMINAR',

                    'origin' => "ELIMINACION VENTA NRO: {$saleNumber}",

                    'reference_id' => $sale->id,

                    'income' => $oldDetail->quantity,

                    'output' => 0,

                    'stock_before' => $stockBefore,

                    'stock_after' => $stockAfter,

                    /*
                    | El Kardex debe registrar el costo
                    | y no el precio de venta.
                    */
                    'unit_cost' => $oldDetail->cost,

                    'user_name' => $userName,
                ]);
            }
            $sale->details()->delete();
            return $this->saleRepository->delete($id);
        });
    }
}
