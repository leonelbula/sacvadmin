<?php

namespace App\Actions\Product;

use Exception;
use App\DTOs\ProductDTO;
use App\Repositories\ProductRepository;
use App\Repositories\KardexRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProductAction
{
    public function __construct(
        protected ProductRepository $repository,
        protected KardexRepository $kardexRepository
    ) {}

    public function execute(ProductDTO $dto)
    {

        DB::beginTransaction();

        try {

            $data = $dto->toArray();

            if (empty($data['code'])) {

                $data['code'] = $this->repository->getNextCode();
            }

            $product = $this->repository->create($data);
            

            $kardexData = [
                'product_id' => $product->id,
                'date' => now(),
                'movement_type' => 'INGRESO-NUEVO ' . Auth::user()->name,
                'origin' => 'INVENTARIO',
                'reference_id' => 0,
                'quantity' => $product->amount,
                'stock_before' => 0,
                'stock_after' => $product->amount,
                'unit_cost' => $product->price,
            ];

            $this->kardexRepository->create($kardexData);

            DB::commit();

            return $product;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
