<?php

namespace App\Services;



use App\Actions\Shopping\ShoppingDeleteAction;
use App\Actions\Shopping\ShoppingCreateAction;
use App\Actions\Shopping\ShoppingUpdateAction;
use App\DTOs\ShoppingDTO;
use App\Interfaces\ShoppingRepositoryInterface;
use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShoppingService
{
    public function __construct(
        protected ShoppingRepositoryInterface $shopping_repository,
        protected ShoppingCreateAction $shopping_create_action,
        protected ShoppingUpdateAction $shopping_update_action,
        protected ShoppingDeleteAction $shopping_delete_action
    ) {}

    public function All(): array
    {
        return $this->shopping_repository->All();
    }

    public function findShopping(int $id): Shopping
    {
        return $this->shopping_repository->findById($id);
    }

    public function storeShopping(ShoppingDTO $dto, array $products): Shopping
    {
        // El servicio recupera los productos del controlador y los delega a la acción
        return $this->shopping_create_action->execute($dto, $products);
    }

    public function updateShopping(
        int $id,
        ShoppingDTO $dto,
        array $products
    ) {
        return $this->shopping_update_action->execute($id, $dto, $products);
    }

    public function deleteShopping(int $id): bool
    {
        return $this->shopping_delete_action->execute($id);
    }

    public function searchSales(array $filters): LengthAwarePaginator
    {
        return $this->shopping_repository->searchShopping($filters);
    }
}
