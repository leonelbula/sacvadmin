<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function find(int $id)
    {
        return Customer::find($id);
    }

    public function all()
    {
        return Customer::orderBy('full_name', 'asc')->paginate(10);
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function update(int $id, array $data)
    {
        $customer = Customer::findOrFail($id);

        $customer->update($data);

        return $customer;
    }

    public function delete(int $id)
    {
        $customer = Customer::findOrFail($id);

        return $customer->delete();
    }

    public function search(string $query)
    {
        $clientes = Customer::with('city')
            ->where('full_name', 'LIKE', "%{$query}%")
            ->orWhere('identification_card', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        return $clientes;
    }
}
