<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Parameter;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function searchProducts(?string $search = null, int $perPage = 5)
    {
        return Product::query()
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->get(['id', 'code', 'name','cost', 'price', 'stock', 'stock_min', 'state']);
    }
    public function getAllProducts()
    {
        return Product::paginate($perPage = 10);
    }

    public function findOrFail(int $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);

        $product->update($data);

        return $product;
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);

        return $product->delete();
    }

    public function getNextCode(): string
    {
        $parameter = Parameter::first();
        if ($parameter && $parameter->automatic_product) {
            $lastProduct = Product::withoutGlobalScopes()
                ->latest('id')
                ->first();

            if (!$lastProduct) {
                return 'P0001';
            }

            $number = (int) substr(
                $lastProduct->code,
                1
            );

            $number++;

            return 'P' . str_pad(
                $number,
                4,
                '0',
                STR_PAD_LEFT
            );
        } else {
            return '';
        }
    }

    public function countProduct()
    {
        return $totalProduct = Product::count();
    }
}
