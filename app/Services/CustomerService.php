<?php
namespace App\Services;

use App\Actions\Customer\CreateCustomerAction;
use App\Actions\Customer\DeleteCustomerAction;  
use App\Actions\Customer\UpdateCustomerAction;
use App\Interfaces\CustomerRepositoryInterface;
use App\DTOs\CustomerDTO;

class CustomerService
{
    public function __construct(
        protected CreateCustomerAction $createCustomerAction,
        protected UpdateCustomerAction $updateCustomerAction,
        protected DeleteCustomerAction $deleteCustomerAction,
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function create(CustomerDTO $data)
    {
        return $this->createCustomerAction->execute($data);
    }

    public function update(int $id, CustomerDTO $data)
    {
        return $this->updateCustomerAction->execute($id, $data);
    }

    public function delete(int $id)
    {
        return $this->deleteCustomerAction->execute($id);
    }

    public function find(int $id)
    {
        return $this->customerRepository->find($id);
    }

    public function all()
    {
        return $this->customerRepository->all();
    }
    public function search(string $query)
    {
        return $this->customerRepository->search($query);
    }
}