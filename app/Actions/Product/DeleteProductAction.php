<?php

namespace App\Actions\Product;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;
use App\Repositories\KardexRepository;

class DeleteProductAction
{
    public function __construct(
        protected ProductRepository $repository,
        protected KardexRepository $kardexRepository
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
