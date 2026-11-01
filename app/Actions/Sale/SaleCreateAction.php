<?php

namespace App\Actions\Sale;

use App\DTOs\SaleDTO;
use App\Interfaces\KardexRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Parameter;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class SaleCreateAction
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected KardexRepositoryInterface $kardexRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Ejecuta la creación de la venta
     *
     * @param SaleDTO $dto
     * @param array $products Estructura esperada: [['id' => 1, 'quantity' => 2, 'price' => 100, 'cost' => 70, 'tax' => 19], ...]
     * @return Sale
     */
    public function execute(SaleDTO $dto, array $products): Sale
    {
        if (empty($products)) {
            throw new Exception("No se pueden registrar ventas sin productos.");
        }

        return DB::transaction(function () use ($dto, $products) {
            $data = $dto->toArray();

            $data['sale_number'] = $this->resolveSaleNumber();
            $data = array_merge($data, $this->calculatePaymentTerms($data));


            $taxesMap = $this->preloadTaxes($products);

            $data['cost'] = $this->calculateCost($products);
            $data['utility'] = $this->calculateUtility($products);
            $data['total'] = $this->calculateTotal($products);
            $data['balance'] = $data['payment_form'] === 'counted' ? 0 : $data['total'];
            $data['hour']        = date('H:i:s');
            $data['state']       = 'active';
            $sale = $this->saleRepository->create($data);

            $detailsData = [];
            $userName = Auth::user()->name ?? 'Sistema';

            foreach ($products as $prod) {
                // lockForUpdate previene condiciones de carrera concurrentes
                $product = $this->productRepository->lockForUpdate($prod['id']);

                if ($product->stock < $prod['quantity']) {
                    throw new Exception("Stock insuficiente en BD para el producto: {$product->name}");
                }

                $stockBefore = $product->stock;
                $product->stock -= $prod['quantity'];
                $product->save();
                $stockAfter = $product->stock;

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

                // Registro del movimiento Kardex
                $this->kardexRepository->create([
                    'product_id'    => $prod['id'],
                    'date'          => now(),
                    'movement_type' => 'SALIDA',
                    'origin'        => "VENTA NRO: {$data['sale_number']}",
                    'reference_id'  => $sale->id,
                    'income'        => 0,
                    'output'        => $prod['quantity'],
                    'stock_before'  => $stockBefore,
                    'stock_after'   => $stockAfter,
                    'unit_cost'     => $prod['cost'],
                    'user_name'     => $userName, // CORREGIDO: Variable segura de Laravel Auth
                ]);
            }


            $sale->details()->createMany($detailsData);

            return $sale;
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

    private function resolveSaleNumber(): int
    {
        $lastSale = $this->saleRepository->lastSale();

        if ($lastSale) {
            return $lastSale->sale_number + 1;
        }
        $parameter = Parameter::first();
        return $parameter ? ($parameter->sale_code + 1) : 1;
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
