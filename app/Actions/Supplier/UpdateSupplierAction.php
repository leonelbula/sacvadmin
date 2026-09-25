<?php

namespace App\Actions\Supplier;

use App\Interfaces\SupplierRepositoryInterface;
use App\DTOs\SupplierDTO;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateSupplierAction
{

    public function __construct(
        protected SupplierRepositoryInterface $supplier_repository
    ) {}

    public function execute(int $id, SupplierDTO $dto)
    {
        DB::beginTransaction();
        try {

            $data = $dto->toArray();

            $supplier = $this->supplier_repository->update($id, $data);

            DB::commit();

            return $supplier;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
