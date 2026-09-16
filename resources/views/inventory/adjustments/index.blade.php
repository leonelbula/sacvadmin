@extends('layouts.app')

@section('title', 'Ajustes de Inventario')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-boxes me-2"></i>
                    Ajustes de Inventario
                </h4>

                <p class="text-muted mb-0">
                    Gestiona las entradas y salidas manuales de inventario.
                </p>
            </div>

            <a href="{{ route('inventory.adjustments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Nuevo ajuste
            </a>

        </div>


        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <form method="GET" action="{{ route('inventory.adjustments.index') }}" class="row g-3 mb-4">

                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Buscar producto
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Código o nombre del producto">

                        </div>

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tipo de ajuste
                        </label>

                        <select name="type" class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>
                                Entrada
                            </option>

                            <option value="output" {{ request('type') === 'output' ? 'selected' : '' }}>
                                Salida
                            </option>

                        </select>

                    </div>


                    <div class="col-md-2">

                        <label class="form-label fw-semibold">
                            Desde
                        </label>

                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">

                    </div>


                    <div class="col-md-2">

                        <label class="form-label fw-semibold">
                            Hasta
                        </label>

                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">

                    </div>


                    <div class="col-12 d-flex gap-2">

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>
                            Buscar

                        </button>

                        <a href="{{ route('inventory.adjustments.index') }}" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Limpiar

                        </a>

                    </div>

                </form>


                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>

                                <th>Fecha</th>

                                <th>Producto</th>

                                <th>Tipo</th>

                                <th class="text-center">
                                    Cantidad
                                </th>

                                <th class="text-center">
                                    Stock anterior
                                </th>

                                <th class="text-center">
                                    Stock final
                                </th>

                                <th>Usuario</th>

                                <th class="text-end">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($adjustments as $adjustment)
                                <tr>

                                    <td>
                                        {{ $adjustment->id }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($adjustment->date)->format('d/m/Y') }}
                                    </td>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $adjustment->product->name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $adjustment->product->code }}
                                        </small>

                                    </td>


                                    <td>

                                        @if ($adjustment->movement_type === 'income')
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="bi bi-arrow-down-circle me-1"></i>
                                                Entrada
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="bi bi-arrow-up-circle me-1"></i>
                                                Salida
                                            </span>
                                        @endif

                                    </td>


                                    <td class="text-center fw-semibold">

                                        @if ($adjustment->movement_type === 'income')
                                            <span class="text-success">
                                                +{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                -{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                            </span>
                                        @endif

                                    </td>


                                    <td class="text-center">
                                        {{ number_format($adjustment->stock_before, 0, ',', '.') }}
                                    </td>


                                    <td class="text-center fw-bold">
                                        {{ number_format($adjustment->stock_after, 0, ',', '.') }}
                                    </td>


                                    <td>
                                        {{ $adjustment->user->name ?? 'N/A' }}
                                    </td>


                                    <td class="text-end">

                                        <a href="{{ route('inventory.adjustments.show', $adjustment->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Ver ajuste">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>

                                            <h6>
                                                No hay ajustes de inventario
                                            </h6>

                                            <p class="mb-3">
                                                Todavía no se han registrado ajustes.
                                            </p>

                                            <a href="{{ route('inventory.adjustments.create') }}" class="btn btn-primary">

                                                <i class="bi bi-plus-lg me-1"></i>
                                                Crear ajuste

                                            </a>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>




        </div>

    </div>

@endsection
