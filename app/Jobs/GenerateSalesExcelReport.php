<?php

namespace App\Jobs;

use App\Exports\SalesExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class GenerateSalesExcelReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 600;

    public function __construct(
        public ?string $fechaDesde,
        public ?string $fechaHasta,
        public string $fileName,
    ) {}

    public function handle(): void
    {
        $directory = 'reports/sales';

        Storage::disk('local')->makeDirectory($directory);

        Excel::store(
            new SalesExport(
                $this->fechaDesde,
                $this->fechaHasta
            ),
            "{$directory}/{$this->fileName}",
            'local'
        );
    }

    public function failed(?Throwable $exception): void
    {
        logger()->error('Falló la generación del reporte de ventas en Excel.', [
            'file' => $this->fileName,
            'error' => $exception?->getMessage(),
        ]);
    }
}
