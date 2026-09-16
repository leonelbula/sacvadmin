<?php

namespace App\Actions\Product;

use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class DeleteProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected KardexRepositoryInterface $kardexRepository
    ) {}

    public function execute(Product $product): bool
    {

        DB::beginTransaction();

        try {

            $this->repository->delete($product->id);
            DB::commit();
            return true;
        } catch (Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
