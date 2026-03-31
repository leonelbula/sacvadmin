@extends('layouts.master')
@section('subtitle')
    Reportes
@endsection
@section('content')
    <div class="card-header">
        <a href="{{ route('report.reporteinventario') }}">
            <button type="button" class="btn btn-primary">Volver</button>
        </a>
        <a href="{{ route('inventory.reports.downloadPdflowStock') }}" target="_blank">

            <button type="button" class="btn btn-outline-danger">Descargar en pdf <i class="bi bi-file-pdf"></i></button>
        </a>
        <a href="{{ route('sale.create') }}">
            <button type="button" class="btn btn-outline-success">Descargar en Exel <i
                    class="bi bi-filetype-xls"></i></button>
        </a>

    </div>
    <div class="container py-4">
        <h4 class="fw-bold mb-3 text-warning">⚠️ Productos con Bajo Stock</h4>

        <table class="table table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Mínimo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->amount }}</td>
                        <td>{{ $p->minimum_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
