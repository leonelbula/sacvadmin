@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Lista Venta
@endsection
@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="card shadow border-0 rounded-4">

            <!-- Header -->

            <div class="card-header bg-primary text-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h3 class="mb-0">

                            <i class="bi bi-receipt-cutoff me-2"></i>

                            Gestión de Ventas

                        </h3>

                        <small>Administración de facturas de venta</small>

                    </div>

                    <a href="{{ route('sale.create') }}" class="btn btn-light">

                        <i class="bi bi-plus-circle"></i>

                        Nueva Venta

                    </a>

                </div>

            </div>

            <div class="card-body">

                <!-- Encabezado -->

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="mb-0">

                        <i class="bi bi-search me-2"></i>

                        Buscar Venta

                    </h5>

                    <a href="{{ route('sale.index') }}" class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-clockwise"></i>

                        Mostrar Todas

                    </a>

                </div>

                <!-- Formulario -->

                <form class="row g-3 mb-4" action="{{ route('sale.index') }}" method="get">

                    <div class="col-lg-3">

                        <label class="form-label">
                            Cliente
                        </label>

                        <input type="text" class="form-control" name="customer_name" placeholder="Nombre del cliente">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Factura
                        </label>

                        <input type="text" class="form-control" name="sale_number" placeholder="1000">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Estado
                        </label>

                        <select class="form-select" name="payment_form">

                            <option value="all">Todos</option>
                            <option value="counted">Contado</option>
                            <option value="credit">Credito</option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Desde
                        </label>

                        <input type="date" class="form-control" name="date_from">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Hasta
                        </label>

                        <input type="date" class="form-control" name="date_to">

                    </div>

                    <div class="col-lg-1 d-grid">

                        <label class="form-label">&nbsp;</label>

                        <button class="btn btn-primary" type="submit">

                            <i class="bi bi-search"></i>

                        </button>

                    </div>

                </form>

                <!-- Tabla -->

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Factura</th>

                                <th>Fecha</th>

                                <th>Cliente</th>

                                <th class="text-end">Total</th>

                                <th>Pago</th>

                                <th>Tipo</th>

                                <th>Usuario</th>

                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($dataSales as $sale)
                                <tr>

                                    <td><strong>{{ $sale->sale_number }}</strong></td>

                                    <td>{{ $sale->date_sale }}</td>

                                    <td>{{ $sale->customer->full_name }}</td>

                                    <td class="text-end">{{ $sale->total }}</td>

                                    <td>{{ $sale->paymentMethod->name }}</td>

                                    <td>
                                        @if ($sale->payment_form == 'counted')
                                            <span class="badge bg-success text-white">

                                                Contado

                                            </span>
                                        @else
                                            <span class="badge bg-info text-white">

                                                Credito

                                            </span>
                                        @endif



                                    </td>

                                    <td>{{ $sale->user->name }}</td>

                                    <td class="text-center">

                                        <div class="btn-group">
                                            <a href="{{ route('sale.show', $sale) }}">
                                                <button class="btn btn-sm btn-outline-primary">

                                                    <i class="bi bi-eye"></i>

                                                </button>
                                            </a>
                                            <a href="{{ route('sale.print', $sale->id) }}" target="_blank">
                                                <button class="btn btn-sm btn-outline-success">

                                                    <i class="bi bi-printer"></i>

                                                </button>
                                            </a>
                                            <a href="{{ route('sale.ticket', $sale->id) }}" target="_blank">
                                                <button class="btn btn-sm btn-outline-success">

                                                    <i class="bi bi-receipt me-1"></i>

                                                </button>
                                            </a>
                                            <a href="{{ route('sale.edit', $sale) }}">
                                                <button class="btn btn-sm btn-outline-warning">

                                                    <i class="bi bi-pencil"></i>

                                                </button>
                                            </a>

                                            <a>
                                                <form action="{{ route('sale.destroy', $sale) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger">

                                                        <i class="bi bi-x-circle"></i>

                                                    </button>
                                                </form>
                                            </a>
                                        </div>

                                    </td>

                                </tr>
                            @endforeach



                        </tbody>

                    </table>

                </div>

            </div>



            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted">
                        Mostrando
                        <strong>{{ $dataSales->firstItem() ?? 0 }}</strong>
                        a
                        <strong>{{ $dataSales->lastItem() ?? 0 }}</strong>
                        de
                        <strong>{{ number_format($dataSales->total()) }}</strong>
                        ventas
                    </div>

                    <div>
                        {{ $dataSales->links() }}
                    </div>

                </div>

            </div>



        </div>

    </div>
@endsection
