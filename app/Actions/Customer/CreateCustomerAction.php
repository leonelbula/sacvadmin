<?php

namespace App\Actions\Customer;


use Exception;
use App\DTOs\CustomerDTO;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateCustomerAction
{

    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function execute(CustomerDTO $dto)
    {
        DB::beginTransaction();
        try {

            $data = $dto->toArray();

            $customer = $this->customerRepository->create($data);

            DB::commit();

            return $customer;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;

        }
    }
}
