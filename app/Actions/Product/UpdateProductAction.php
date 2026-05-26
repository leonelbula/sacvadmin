<?php

namespace App\Actions\Product;

use Exception;
use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\KardexRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProductAction
{
    public function __construct(
        protected ProductRepository $repository,
        protected KardexRepository $kardexRepository
    ) {}

    public function execute(Product $product, ProductDTO $dto): Product
    {

        DB::beginTransaction();

        try {

            $data = $dto->toArray();

            if (empty($data['code'])) {
                $data['code'] = $product->code;
            }

            $this->repository->update($product->id, $data);

            if ($product->amount != $data['amount']) {
                if ($product->amount < $data['amount']) {
                    $quantity =  $data['amount'] - $product->amount;
                } else {
                    $quantity =  $data['amount'] - $product->amount;
                }

                $kardexData = [
                    'product_id' => $product->id,
                    'date' => now(),
                    'movement_type' => 'ACTUALIZACION ' . Auth::user()->name,
                    'origin' => 'INVENTARIO',
                    'reference_id' => 0,
                    'quantity' => $quantity,
                    'stock_before' => $product->getOriginal('amount'),
                    'stock_after' => $data['amount'],
                    'unit_cost' => $product->price,
                ];

                $this->kardexRepository->create($kardexData);
            }

            DB::commit();

            return $product;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
