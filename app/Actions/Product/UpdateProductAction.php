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

            if ($product->stock != $data['stock']) {
                if ($product->stock < $data['stock']) {
                    $income =  $data['stock'] - $product->stock;
                    $output = 0;
                } else {
                    $output =  $data['stock'] - $product->stock;
                    $income = 0;
                }

                $kardexData = [
                    'product_id' => $product->id,
                    'date' => now(),
                    'movement_type' => 'Actilizado',
                    'origin' => 'INVENTARIO',
                    'reference_id' => 0,
                    'income' => $income,
                    'output' => $output,
                    'stock_before' => $product->getOriginal('stock'),
                    'stock_after' => $data['stock'],
                    'unit_cost' => $product->price,
                    'user_name' => Auth::user()->name,
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
