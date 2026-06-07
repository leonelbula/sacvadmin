<?php
namespace App\Actions\Customer;
use App\Interfaces\CustomerRepositoryInterface;
use App\DTOs\CustomerDTO;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateCustomerAction
{

    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function execute(int $id, CustomerDTO $dto)
    {
        DB::beginTransaction();
        try {

            $data = $dto->toArray();

            $customer = $this->customerRepository->update($id, $data);

            DB::commit();

            return $customer;
        } catch (Exception $e) {

            DB::rollBack();

            throw $e;

        }
    }
}