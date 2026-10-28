<?php

namespace App\Jobs;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateSalesReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 300;

    public function __construct(
        public ?string $fechaDesde,
        public ?string $fechaHasta,
        public int $userId
    ) {}

    public function handle(): void
    {
        $query = Sale::with(['customer', 'user']);

        if ($this->fechaDesde) {
            $query->whereDate('date_sale', '>=', $this->fechaDesde);
        }

        if ($this->fechaHasta) {
            $query->whereDate('date_sale', '<=', $this->fechaHasta);
        }

        $totalGeneral = (clone $query)->sum('total');

        $cantidadTotal = (clone $query)->count();

        $sales = $query
            ->orderByDesc('date_sale')
            ->get();

        $pdf = Pdf::loadView('reports.pdf.sale.sales', [
            'sales' => $sales,
            'total' => $totalGeneral,
            'quantity' => $cantidadTotal,
            'fechaDesde' => $this->fechaDesde,
            'fechaHasta' => $this->fechaHasta,
        ]);


        $path = "reports/sale/ventas-{$this->userId}.pdf";

        Storage::disk('local')->put($path, $pdf->output());
    }
}
