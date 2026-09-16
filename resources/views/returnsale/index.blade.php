@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4 mt-4">


        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-arrow-return-left me-2"></i>
                    Devoluciones de ventas
                </h3>

                <p class="text-muted mb-0">
                    Consulta y administra las devoluciones realizadas
                </p>
            </div>

            <a href="{{ route('salereturn.create') }}" class="btn btn-primary rounded-3 px-4">

                <i class="bi bi-plus-lg me-2"></i>
                Nueva devolución

            </a>

        </div>


        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <div class="d-flex align-items-center">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-funnel fs-5"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            Buscar devoluciones
                        </h5>

                        <small class="text-muted">
                            Utiliza los filtros para encontrar una devolución
                        </small>
                    </div>

                </div>

            </div>


            <div class="card-body px-4 pb-4">

                <form action="{{ route('salereturn.index') }}" method="GET">

                    <div class="row g-3 align-items-end">

                        {{-- NUMERO DEVOLUCION --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                N.º devolución
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-hash"></i>
                                </span>

                                <input type="text" name="return_number" class="form-control border-start-0"
                                    value="{{ request('return_number') }}" placeholder="Número">

                            </div>

                        </div>



                        {{-- CLIENTE --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                Cliente
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input type="text" name="customer_name" class="form-control border-start-0"
                                    value="{{ request('customer_name') }}" placeholder="Nombre del cliente">

                            </div>

                        </div>



                        {{-- FECHA DESDE --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                Fecha desde
                            </label>

                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">

                        </div>


                        {{-- FECHA HASTA --}}
                        <div class="col-md-3">

                            <label class="form-label fw-semibold">
                                Fecha hasta
                            </label>

                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">

                        </div>


                        {{-- BOTONES --}}
                        <div class="col-md-6">

                            <div class="d-flex gap-2">

                                <button type="submit" class="btn btn-primary px-4">

                                    <i class="bi bi-search me-2"></i>
                                    Buscar

                                </button>


                                <a href="{{ route('salereturn.index') }}" class="btn btn-light border px-4">

                                    <i class="bi bi-x-lg me-2"></i>
                                    Limpiar

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>


      
        {{-- TABLA --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Historial de devoluciones
                        </h5>

                        <small class="text-muted">
                            Lista de devoluciones registradas
                        </small>

                    </div>

                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                        {{ $returns->total() }} registros
                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4">
                                    N.º devolución
                                </th>

                                <th>
                                    Cliente
                                </th>

                                <th>
                                    Fecha
                                </th>

                                <th class="text-center">
                                    Productos
                                </th>

                                <th class="text-end">
                                    Total
                                </th>

                                <th class="text-center">
                                    Estado
                                </th>

                                <th class="text-center px-4">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($returns as $return)
                                <tr>

                                    {{-- DEVOLUCION --}}
                                    <td class="px-4">

                                        <span class="fw-bold">
                                            #{{ $return->return_number }}
                                        </span>

                                    </td>


                                    {{-- CLIENTE --}}
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2">

                                                <i class="bi bi-person"></i>

                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    {{ $return->customer->full_name ?? 'Consumidor final' }}
                                                </div>

                                                @if (isset($return->sale->customer->identification))
                                                    <small class="text-muted">
                                                        {{ $return->sale->customer->identification }}
                                                    </small>
                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- FECHA --}}
                                    <td>

                                        <div class="fw-semibold">
                                            {{ optional($return->created_at)->format('d/m/Y') }}
                                        </div>

                                        <small class="text-muted">
                                            {{ optional($return->created_at)->format('h:i A') }}
                                        </small>

                                    </td>


                                    {{-- PRODUCTOS --}}
                                    <td class="text-center">

                                        <span class="badge bg-light text-dark border">

                                            {{ $return->details->count() }}

                                        </span>

                                    </td>


                                    {{-- TOTAL --}}
                                    <td class="text-end">

                                        <span class="fw-bold text-danger">

                                            ${{ number_format($return->total ?? 0, 0, ',', '.') }}

                                        </span>

                                    </td>


                                    {{-- ESTADO --}}
                                    <td class="text-center">

                                        @if ($return->state === 'completed')
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Completada
                                            </span>
                                        @elseif($return->state === 'pending')
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                                <i class="bi bi-clock me-1"></i>
                                                Pendiente
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Cancelada
                                            </span>
                                        @endif

                                    </td>


                                    {{-- ACCIONES --}}
                                    <td class="text-center px-4">

                                        <div class="dropdown">

                                            <button class="btn btn-light border rounded-3" type="button"
                                                data-bs-toggle="dropdown">

                                                <i class="bi bi-three-dots-vertical"></i>

                                            </button>


                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                <li>

                                                    <a href="{{ route('salereturn.show', $return->id) }}"
                                                        class="dropdown-item">

                                                        <i class="bi bi-eye me-2"></i>
                                                        Ver detalle

                                                    </a>

                                                </li>

                                                <li>
                                                    <a class="dropdown-item">
                                                        <form action="{{ route('salereturn.destroy', $return->id) }}"
                                                            method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-sm btn-outline-danger">

                                                                <i class="bi bi-x-circle me-2"></i>
                                                                Eliminar

                                                            </button>
                                                        </form>
                                                    </a>
                                                </li>


                                                <li>

                                                    <a href="" class="dropdown-item">

                                                        <i class="bi bi-file-earmark-pdf me-2"></i>
                                                        Descargar comprobante

                                                    </a>

                                                </li>

                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <div class="mb-3">

                                            <div class="bg-light rounded-circle d-inline-flex p-4">

                                                <i class="bi bi-arrow-return-left fs-1 text-muted"></i>

                                            </div>

                                        </div>

                                        <h5 class="fw-bold">
                                            No hay devoluciones
                                        </h5>

                                        <p class="text-muted mb-3">
                                            No se encontraron devoluciones con los filtros seleccionados.
                                        </p>

                                        <a href="{{ route('salereturn.create') }}" class="btn btn-primary">

                                            <i class="bi bi-plus-lg me-2"></i>
                                            Registrar devolución

                                        </a>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- PAGINACION --}}
            @if ($returns->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <small class="text-muted">

                            Mostrando
                            {{ $returns->firstItem() }}
                            -
                            {{ $returns->lastItem() }}
                            de
                            {{ $returns->total() }}

                        </small>

                        <div>

                            {{ $returns->withQueryString()->links() }}

                        </div>

                    </div>

                </div>
            @endif

        </div>


    </div>
@endsection
