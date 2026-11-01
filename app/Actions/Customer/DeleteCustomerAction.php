<?php

namespace App\Actions\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class DeleteCustomerAction
{

    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function execute(int $id)
    {
        DB::beginTransaction();
        try {

            $result = $this->customerRepository->delete($id);

            DB::commit();

            return $result;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;

        }
    }
}
