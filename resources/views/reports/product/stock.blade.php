@extends('layouts.master')
@section('subtitle')
    Reportes
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('report.reporteinventario') }}">
                <button type="button" class="btn btn-primary">Volver</button>
            </a>
            <a href="{{ route('inventory.reports.downloadPdfStock') }}">

                <button type="button" class="btn btn-outline-danger">Descargar en pdf <i class="bi bi-file-pdf"></i></button>
            </a>
               <a href="{{ route('sale.create') }}">
                <button type="button" class="btn btn-outline-success">Descargar en Exel <i class="bi bi-filetype-xls"></i></button>
            </a>

        </div>
        <div class="container py-4">
            <h4 class="fw-bold mb-3">📦 Stock General</h4>
            <h4 class="fw-bold mb-3">Valor de Inventario Actual:$ {{ number_format($totalCosto, 0, ',','.') }} </h4>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Costo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr>
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->amount }}</td>
                            <td>${{ number_format($p->cost, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    @endsection
