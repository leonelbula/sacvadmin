@extends('layouts.master')
@section('subtitle')
    Lista de Productos
@endsection
@section('content')
 <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('sale.create') }}">
                        <button type="button" class="btn btn-primary">Nueva Venta</button>
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteModal">
                        Generar reporte de ventas
                    </button>
                </div>
    <div class="container py-4">
        <h3 class="fw-bold mb-2">📦 Reportes de Inventario</h3>
        <p class="text-muted mb-4">Selecciona el reporte que deseas generar</p>

        <div class="row g-4">
            @php
                $reports = [
                    ['Stock General', 'inventory.reports.stock', 'primary', 'box-seam'],
                    ['Bajo Stock', 'inventory.reports.low_stock', 'warning', 'exclamation-triangle'],
                    ['Kardex', 'inventory.reports.kardex', 'success', 'arrow-left-right'],
                    ['Por Categoría', 'inventory.reports.category', 'info', 'tags'],
                    ['Por Proveedor', 'inventory.reports.supplier', 'secondary', 'truck'],
                    ['Valorización', 'inventory.reports.valuation', 'dark', 'currency-dollar'],
                    ['No Vendidos', 'inventory.reports.expired', 'danger', 'calendar-x'],
                    ['Historial', 'inventory.reports.history', 'primary', 'clock-history'],
                ];
            @endphp

            @foreach ($reports as $r)
                <div class="col-md-3">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-{{ $r[3] }} fs-1 text-{{ $r[2] }}"></i>
                            <h6 class="mt-3">{{ $r[0] }}</h6>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route($r[1]) }}" class="btn btn-{{ $r[2] }} btn-sm w-100">
                                Ver reporte
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
