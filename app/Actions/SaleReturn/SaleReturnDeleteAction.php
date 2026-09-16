<?php

namespace App\Actions\SaleReturn;


use App\Interfaces\SaleReturnRepositoryInterface;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnDeleteAction
{
    public function __construct(
        protected SaleReturnRepositoryInterface $returnSaleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(
        int $id
    ): bool {

        return DB::transaction(function () use ($id) {


            $saleReturn = $this->returnSaleRepository->getReturnById($id);

            $products = $saleReturn->details;

            $userName = Auth::user()->name ?? 'Sistema';



            /*
             * Procesar productos
             */
            foreach ($products as $prod) {

                $product = $this->productRepository
                    ->lockForUpdate($prod['product_id']);

                $stockBefore = $product->stock;

                $product->stock -= $prod['quantity'];

                $product->save();

                $stockAfter = $product->stock;

                /*
                 * Kardex
                 */
                $this->kardexRepository->create([
                    'product_id'    => $prod['id'],
                    'date'          => now(),
                    'movement_type' => 'SALIDA',
                    'origin'        => "DEVOLUCION NRO: {$saleReturn->return_number}",
                    'reference_id'  => $saleReturn->id,
                    'income'        => 0,
                    'output'        => $prod['quantity'],
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     =>  $product->cost,
                    'user_name'     => $userName,
                ]);
            }
            /*
             * Detalles de la devolución
             */
            $saleReturn->details()->delete();
            $resulk = $this->returnSaleRepository->deleteReturn($id);
            return $resulk;
        });
    }
}
