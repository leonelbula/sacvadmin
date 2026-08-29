<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Parameter;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Busca productos paginados para el listado administrativo en Blade.
     * Corregido: Limpieza de consultas repetidas y uso correcto de $perPage.
     */
    public function searchProducts(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->with([
                'category:id,name'
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage); // Ahora respeta la paginación dinámica configurada
    }

    /**
     * Busca productos activos orientados al módulo de ventas.
     * Corregido para Blade: Retorna una Colección limpia para que puedas iterarla 
     * en un datalist, un select HTML dinámico o enviarlo a un componente.
     */
    public function searchProductSale(?string $search = null): Collection
    {
        return Product::query()
            ->with([
                'tax', // Asegúrate de que la relación se llame 'tax' o 'taxes' en tu modelo
                'category'
            ])
            ->where('state', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('code', 'LIKE', "%{$search}%");
                });
            })
            ->limit(10)
            ->get(); // Retorna Colección de Eloquent pura
    }

    /**
     * Obtiene todos los productos del sistema paginados para tablas Blade.
     * Corregido: Si la interfaz exige LengthAwarePaginator, aquí paginamos correctamente.
     */
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::query()
            ->with(['category'])
            ->orderBy('name', 'asc')
            ->paginate(15);
    }

    /**
     * Encuentra un producto por su ID o lanza un error 404 de Laravel de forma automática.
     */
    public function findOrFail(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Implementación obligatoria del bloqueo pesimista.
     * Evita que el stock se altere de forma corrupta en ventas concurrentes.
     */
    public function lockForUpdate(int $id): Product
    {
        return Product::lockForUpdate()->findOrFail($id);
    }

    /**
     * Crea un nuevo producto.
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(int $id, array $data): Product
    {
        $product = $this->findOrFail($id);
        $product->update($data);
        return $product;
    }

    /**
     * Elimina un producto por su ID.
     */
    public function delete(int $id): bool
    {
        $product = $this->findOrFail($id);
        return (bool) $product->delete();
    }

    /**
     * Genera el código correlativo de manera automatizada.
     */
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

            $number = (int) substr($lastProduct->code, 1);
            $number++;

            return 'P' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        return '';
    }

    /**
     * Cuenta la cantidad total de productos.
     */
    public function countProduct(): int
    {
        return Product::count();
    }
}
