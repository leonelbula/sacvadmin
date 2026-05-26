<?php

namespace App\Services;

use App\DTOs\ProductDTO;

//use App\Repositories\ProductRepository;

use App\Actions\Product\CreateProductAction;
use App\Actions\Product\UpdateProductAction;
use App\Actions\Product\DeleteProductAction;
use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    public function __construct(

        protected ProductRepositoryInterface $repository,
        protected CreateProductAction $createAction,
        protected UpdateProductAction $updateAction,
        protected DeleteProductAction $deleteAction

    ) {}

    public function getAllProducts()
    {
        return $this->repository->getAllProducts();
    }


    public function searchProducts(?string $search = null)
    {
        return $this->repository->searchProducts($search);
    }

    public function findOrFail(int $id)
    {

        return $this->repository->findOrFail($id);
    }


    public function create(ProductDTO $dto)
    {
        return $this->createAction->execute($dto);
    }

    public function update(int $id, ProductDTO $dto)
    {

        $product = $this->repository->findOrFail($id);
        return $this->updateAction->execute($product, $dto);
    }


    public function delete(int $id)
    {

        $product = $this->repository->findOrFail($id);
        return $this->deleteAction->execute($product);
    }
}
