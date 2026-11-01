<?php

namespace App\Actions\Sale;

use App\DTOs\SaleDTO;
use App\Repositories\Contracts\KardexRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Exception;

class SaleUpdateAction
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Actualiza una venta existente.
     */
    public function execute(int $id, SaleDTO $dto, array $products): Sale
    {


        if (empty($products)) {
            throw new Exception(
                'No se pueden actualizar ventas sin productos.'
            );
        }

        return DB::transaction(function () use ($id, $dto, $products) {

            $userName = Auth::user()->name ?? 'Sistema';

            $sale = $this->saleRepository->findById($id);

            if (!$sale) {
                throw new Exception(
                    "La venta con ID {$id} no existe."
                );
            }
            $saleNumber = $sale->sale_number;
            $oldDetails = $sale->details()->get();

            foreach ($oldDetails as $oldDetail) {

                $product = $this->productRepository
                    ->lockForUpdate($oldDetail->product_id);

                if (!$product) {
                    throw new Exception(
                        "El producto {$oldDetail->product_id} no existe."
                    );
                }

                $stockBefore = $product->stock;
                $product->stock += $oldDetail->quantity;
                $product->save();

                $stockAfter = $product->stock;
                $this->kardexRepository->create([

                    'product_id' => $oldDetail->product_id,
                    'date' => now(),
                    'movement_type' => 'REVERSION',
                    'origin' => "ACTUALIZACION VENTA NRO: {$saleNumber}",
                    'reference_id' => $sale->id,
                    'income' => $oldDetail->quantity,
                    'output' => 0,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'unit_cost' => $oldDetail->cost,
                    'user_name' => $userName,
                ]);
            }


            $sale->details()->delete();
            $taxesMap = $this->preloadTaxes($products);

            $data = $dto->toArray();
            $data = array_merge($data, $this->calculatePaymentTerms($data));
            $data['cost'] = $this->calculateCost($products);
            $data['utility'] = $this->calculateUtility($products);
            $data['total'] = $this->calculateTotal($products);
            $data['balance'] = $data['payment_form'] === 'counted' ? 0 : $data['total'];
            $data['state'] = 'active';

            $sale = $this->saleRepository->update($id, $data);

            $detailsData = [];

            foreach ($products as $prod) {

                $product = $this->productRepository->lockForUpdate($prod['id']);

                if (!$product) {
                    throw new Exception(
                        "El producto {$prod['id']} no existe."
                    );
                }


                if ($product->stock < $prod['quantity']) {

                    throw new Exception(
                        "Stock insuficiente para el producto: "
                            . $product->name
                            . ". Disponible: "
                            . $product->stock
                    );
                }


                $stockBefore = $product->stock;
                $product->stock -=  $prod['quantity'];
                $product->save();
                $stockAfter = $product->stock;

                /*
                |--------------------------------------------------------------------------
                | Impuesto
                |--------------------------------------------------------------------------
                */

                if (!isset($taxesMap[$prod['tax']])) {
                    throw new Exception("No se encontró el impuesto con valor: {$prod['tax']}");
                }
                $taxRecord = $taxesMap[$prod['tax']];

                $subtotalItem = $prod['price'] * $prod['quantity'];
                $costTotalItem = $prod['cost'] * $prod['quantity'];
                $utilityItem = $subtotalItem - $costTotalItem;

                // Estructura idéntica a tu migración de 'sale_details'
                $detailsData[] = [
                    'product_id' => $prod['id'],
                    'price'      => $prod['price'],
                    'cost'       => $prod['cost'],
                    'quantity'   => $prod['quantity'],
                    'subtotal'   => $subtotalItem,
                    'utility'    => $utilityItem,
                    'tax_id'     => $taxRecord->id,
                ];

                /*
                |--------------------------------------------------------------------------
                | Kardex - Salida
                |--------------------------------------------------------------------------
                */

                $this->kardexRepository->create([
                    'product_id' => $prod['id'],
                    'date' => now(),
                    'movement_type' => 'SALIDA',
                    'origin' => "ACTUALIZACION VENTA NRO: " . $sale->sale_number,
                    'reference_id' => $sale->id,
                    'income' => 0,
                    'output' => $prod['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'unit_cost' => $prod['cost'],
                    'user_name' => $userName,
                ]);
            }

            $sale->details()->createMany($detailsData);

            return $sale->fresh('details');
        });
    }


    private function calculateUtility(array $products): int
    {
        return collect($products)->sum(fn($prod) => ($prod['price'] - $prod['cost']) * $prod['quantity']);
    }

    private function calculateCost(array $products): int
    {
        return collect($products)->sum(fn($prod) => $prod['cost'] * $prod['quantity']);
    }

    private function calculateTotal(array $products): int
    {
        return collect($products)->sum(fn($prod) => $prod['price'] * $prod['quantity']);
    }

    private function calculatePaymentTerms(array $data): array
    {
        if ($data['payment_form'] === 'counted') {
            return [
                'expiration_date' => $data['date_sale'],
                'term'            => '0',
            ];
        } else {
            $days = (int) ($data['term'] ?: 30);
            return [
                'expiration_date' => date('Y-m-d', strtotime($data['date_sale'] . " + $days days")),
                'term'            => $days,
            ];
        }
    }
    private function preloadTaxes(array $products)
    {
        $taxValues = collect($products)->pluck('tax')->unique()->toArray();
        return DB::table('taxes')
            ->whereIn('value', $taxValues)
            ->get()
            ->keyBy('value');
    }
}
