<?php

namespace App\Actions\Supplier;


use Exception;
use App\DTOs\SupplierDTO;
use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateSupplierAction
{

    public function __construct(
        protected SupplierRepositoryInterface $supplier_repository
    ) {}

    public function execute(SupplierDTO $dto)
    {
        DB::beginTransaction();
        try {

            $data = $dto->toArray();

            $supplier = $this->supplier_repository->create($data);

            DB::commit();

            return $supplier;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
