<?php

namespace App\Actions\InventoryAdjustment;

use App\DTOs\InventoryAdjustmentDTO;
use App\Interfaces\InventoryAdjustmentRepositoryInterface;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class InventoryAdjustmentCreateAction
{
    public function __construct(
        protected InventoryAdjustmentRepositoryInterface $adjustmentRepository,
        protected ProductRepositoryInterface $productRepository,
        protected KardexRepositoryInterface $kardexRepository
    ) {}

    public function execute(InventoryAdjustmentDTO $dto): mixed
    {
        return DB::transaction(function () use ($dto) {

            $data = $dto->toArray();

            $product = $this->productRepository->findById(
                $dto->product_id
            );

            if (!$product) {
                throw new RuntimeException(
                    'El producto no existe.'
                );
            }

            $stockBefore = (int) $product->stock;

            if ($dto->movement_type === 'income') {

                $stockAfter = $stockBefore + $dto->quantity;

                $data['stock_before'] = $stockBefore;
                $data['stock_after'] = $stockAfter;

                $income = $dto->quantity;
                $output = 0;
            } else {

                if ($dto->quantity > $stockBefore) {
                    throw new RuntimeException(
                        'La cantidad de salida no puede ser mayor al stock disponible.'
                    );
                }

                $stockAfter = $stockBefore - $dto->quantity;

                $income = 0;
                $output = $dto->quantity;

                $data['stock_before'] = $stockBefore;
                $data['stock_after'] = $stockAfter;
            }

            $adjustment = $this->adjustmentRepository->create($data);

            $this->productRepository->updateStock(
                $dto->product_id,
                $stockAfter
            );

              $userName = Auth::user()->name ?? 'Sistema';

            $this->kardexRepository->create([
                'product_id' => $dto->product_id,
                'date' => now(),
                'movement_type' => $dto->movement_type,
                'origin' => 'adjustment',
                'reference_id' => $adjustment->id,
                'income' => $income,
                'output' => $output,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'unit_cost' => $product->cost,
                 'user_name'     => $userName,
            ]);

            return $adjustment;
        });
    }
}
