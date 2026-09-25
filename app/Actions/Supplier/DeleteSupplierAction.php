<?php

namespace App\Actions\Supplier;

use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class DeleteSupplierAction
{

    public function __construct(
        protected SupplierRepositoryInterface $supplier_repository
    ) {}

    public function execute(int $id)
    {
        DB::beginTransaction();
        try {

            $result = $this->supplier_repository->delete($id);

            DB::commit();

            return $result;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
