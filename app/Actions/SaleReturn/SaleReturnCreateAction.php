<?php

namespace App\Actions\SaleReturn;

use App\DTOs\SaleReturnDTO;
use App\Interfaces\SaleReturnRepositoryInterface;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\SaleReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnCreateAction
{
    public function __construct(
        protected SaleReturnRepositoryInterface $returnSaleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(
        SaleReturnDTO $dto,
        array $products
    ): SaleReturn {

        return DB::transaction(function () use ($dto, $products) {

            $data = $dto->toArray();

            /*
             * Cliente
             */
            $customerId = !empty($data['customer_id'])
                ? (int) $data['customer_id']
                : 1;

            $data['customer_id'] = $customerId;

            /*
             * Número de devolución
             */
            $lastReturn = $this->returnSaleRepository->lastReturnNumber();

            $data['return_number'] = $lastReturn
                ? $lastReturn + 1
                : 1;

            /*
             * Costo total
             */
            $totalCost = collect($products)->sum(
                fn($prod) => $prod['cost'] * $prod['quantity']
            );

            $data['cost'] = $totalCost;

            /*
             * Crear devolución
             */
            $saleReturn = $this->returnSaleRepository
                ->createReturn($data);

            $detailsData = [];

            $userName = Auth::user()->name ?? 'Sistema';

            /*
             * Procesar productos
             */
            foreach ($products as $prod) {

                $product = $this->productRepository
                    ->lockForUpdate($prod['id']);

                $stockBefore = $product->stock;

                /*
                 * IMPORTANTE:
                 * Una devolución de venta normalmente
                 * debe volver a ingresar mercancía al inventario.
                 */
                $product->stock += $prod['quantity'];

                $product->save();

                $stockAfter = $product->stock;

                $subtotal = $prod['price'] * $prod['quantity'];

                $cost = $prod['cost'] * $prod['quantity'];

                $detailsData[] = [
                    'product_id' => $prod['id'],
                    'quantity'   => $prod['quantity'],
                    'price'      => $prod['price'],
                    'cost'       => $cost,
                    'subtotal'   => $subtotal,
                ];

                /*
                 * Kardex
                 */
                $this->kardexRepository->create([
                    'product_id'    => $prod['id'],
                    'date'          => now(),
                    'movement_type' => 'ENTRADA',
                    'origin'        => "DEVOLUCION NRO: {$saleReturn->return_number}",
                    'reference_id'  => $saleReturn->id,
                    'income'        => $prod['quantity'],
                    'output'        => 0,
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     => $prod['cost'],
                    'user_name'     => $userName,
                ]);
            }

            /*
             * Detalles de la devolución
             */
            $saleReturn->details()->createMany($detailsData);

            return $saleReturn;
        });
    }
}
