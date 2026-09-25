<?php

namespace App\Actions\Shopping;

use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ShoppingRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class ShoppingDeleteAction
{
    public function __construct(
        protected ShoppingRepositoryInterface $shopping_repository,
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

            $shopping = $this->shopping_repository->findById($id);

            if (!$shopping) {
                throw new Exception(
                    "La compra con ID {$id} no existe."
                );
            }
            $Number = $shopping->invoice_number;

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
                    'movement_type' => 'ELIMINAR',
                    'origin' => "ELIMINACION COMPRA NRO: {$Number}",
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
            return $this->shopping_repository->delete($id);
        });
    }
}
