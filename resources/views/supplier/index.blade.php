
@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
    <div class="container-fluid px-4 py-4">

        {{-- Encabezado --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-truck fs-4"></i>
                    </div>

                    <h4 class="fw-bold mb-0">Proveedores</h4>
                </div>

                <p class="text-muted mb-0">
                    Administra y consulta los proveedores registrados.
                </p>
            </div>

            <a href="{{ route('supplier.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Nuevo proveedor
            </a>

        </div>


        {{-- Tarjetas resumen --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 me-3">
                            <i class="bi bi-truck fs-4"></i>
                        </div>

                        <div>
                            <small class="text-muted">Total proveedores</small>
                            <h4 class="fw-bold mb-0">
                                {{ $suppliers->total() }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 me-3">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>

                        <div>
                            <small class="text-muted">Crédito registrado</small>
                            <h4 class="fw-bold mb-0">
                                ${{ number_format($suppliers->sum('credit_amount'), 0, ',', '.') }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 me-3">
                            <i class="bi bi-credit-card fs-4"></i>
                        </div>

                        <div>
                            <small class="text-muted">Con crédito</small>
                            <h4 class="fw-bold mb-0">
                                {{ $suppliers->where('credit_amount', '>', 0)->count() }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="rounded-3 bg-info bg-opacity-10 text-info p-3 me-3">
                            <i class="bi bi-geo-alt fs-4"></i>
                        </div>

                        <div>
                            <small class="text-muted">Ciudades</small>
                            <h4 class="fw-bold mb-0">
                                {{ $suppliers->pluck('city')->filter()->unique()->count() }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- Contenedor principal --}}
        <div class="card border-0 shadow-sm">

            {{-- Barra superior --}}
            <div class="card-header bg-white border-0 p-3">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-6">

                        <form action="{{ route('supplier.index') }}" method="GET">

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control bg-light border-start-0"
                                    placeholder="Buscar por nombre, identificación, teléfono o correo...">

                                @if (request('search'))
                                    <a href="{{ route('supplier.index') }}" class="btn btn-light border"
                                        title="Limpiar búsqueda">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif

                                <button class="btn btn-primary" type="submit">
                                    Buscar
                                </button>

                            </div>

                        </form>

                    </div>

                    <div class="col-12 col-lg-6 text-lg-end">

                        <span class="text-muted small">
                            Mostrando
                            <strong>{{ $suppliers->firstItem() ?? 0 }}</strong>
                            -
                            <strong>{{ $suppliers->lastItem() ?? 0 }}</strong>
                            de
                            <strong>{{ $suppliers->total() }}</strong>
                            proveedores
                        </span>

                    </div>

                </div>

            </div>


            {{-- Tabla --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">Proveedor</th>

                            <th>Identificación</th>

                            <th>Contacto</th>

                            <th>Ubicación</th>

                            <th class="text-end">Crédito</th>

                            <th class="text-center">Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($suppliers as $provider)
                            <tr>

                                {{-- Proveedor --}}
                                <td class="px-4">

                                    <div class="d-flex align-items-center">

                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary
                                            d-flex align-items-center justify-content-center me-3"
                                            style="width: 42px; height: 42px;">

                                            <i class="bi bi-building"></i>

                                        </div>

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $provider->full_name }}
                                            </div>

                                            @if ($provider->email)
                                                <small class="text-muted">
                                                    {{ $provider->email }}
                                                </small>
                                            @else
                                                <small class="text-muted">
                                                    Sin correo registrado
                                                </small>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Identificación --}}
                                <td>

                                    <span class="badge bg-light text-dark border">
                                        {{ $provider->identification_card }}
                                    </span>

                                </td>


                                {{-- Contacto --}}
                                <td>

                                    @if ($provider->phone)
                                        <div class="d-flex align-items-center gap-2">

                                            <i class="bi bi-telephone text-muted"></i>

                                            <span>
                                                {{ $provider->phone }}
                                            </span>

                                        </div>
                                    @else
                                        <span class="text-muted">
                                            No registrado
                                        </span>
                                    @endif

                                </td>


                                {{-- Ubicación --}}
                                <td>

                                    <div class="d-flex align-items-start gap-2">

                                        <i class="bi bi-geo-alt text-muted mt-1"></i>

                                        <div>

                                            @if ($provider->city)
                                                <div class="fw-medium">
                                                    {{ $provider->city }}
                                                </div>
                                            @endif

                                            @if ($provider->departament)
                                                <small class="text-muted">
                                                    {{ $provider->departament }}
                                                </small>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Crédito --}}
                                <td class="text-end">

                                    @if ($provider->credit_amount > 0)
                                        <span class="fw-semibold text-danger">
                                            ${{ number_format($provider->credit_amount, 0, ',', '.') }}
                                        </span>

                                        <div>
                                            <small class="text-muted">
                                                Crédito pendiente
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-success fw-semibold">
                                            $0
                                        </span>

                                        <div>
                                            <small class="text-muted">
                                                Sin crédito
                                            </small>
                                        </div>
                                    @endif

                                </td>


                                {{-- Acciones --}}
                                <td class="text-center">

                                    <div class="dropdown">

                                        <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('supplier.show', $provider->id) }}">
                                                    <i class="bi bi-eye me-2 text-primary"></i>
                                                    Ver proveedor
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('supplier.edit', $provider->id) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i>
                                                    Editar
                                                </a>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>

                                                <form action="{{ route('supplier.destroy', $provider->id) }}"
                                                    method="POST" class="delete-provider-form">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>
                                                        Eliminar
                                                    </button>

                                                </form>

                                            </li>

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <div class="mb-3">

                                        <div class="rounded-circle bg-light d-inline-flex
                                           align-items-center justify-content-center"
                                            style="width: 70px; height: 70px;">
                                            <i class="bi bi-truck fs-2 text-muted"></i>
                                        </div>

                                    </div>

                                    @if (request('search'))
                                        <h5 class="fw-semibold">
                                            No se encontraron proveedores
                                        </h5>

                                        <p class="text-muted mb-3">
                                            No hay resultados para
                                            <strong>"{{ request('search') }}"</strong>.
                                        </p>

                                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-left me-1"></i>
                                            Ver todos
                                        </a>
                                    @else
                                        <h5 class="fw-semibold">
                                            No hay proveedores registrados
                                        </h5>

                                        <p class="text-muted mb-3">
                                            Comienza registrando tu primer proveedor.
                                        </p>

                                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Registrar proveedor
                                        </a>
                                    @endif

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginación --}}
            @if ($suppliers->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">

                    <div
                        class="d-flex flex-column flex-md-row
                            justify-content-between align-items-center gap-3">

                        <small class="text-muted">
                            Página {{ $suppliers->currentPage() }}
                            de {{ $suppliers->lastPage() }}
                        </small>

                        {{ $suppliers->withQueryString()->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-provider-form').forEach(function(form) {

                form.addEventListener('submit', function(event) {

                    if (!confirm('¿Está seguro de eliminar este proveedor?')) {
                        event.preventDefault();
                    }

                });

            });

        });
    </script>


<div class="row">

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <a href="{{ route('dashboard') }}">
                    <button type="button" class="btn btn-primary">Volver</button>
                </a>
                <a href="{{ route('supplier.create') }}">
                    <button type="button" class="btn btn-primary">Nuevo Proveedor</button>
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="" class="table table-bordered table-striped">
                    <tr>
                        <th style="width:10px">Codigo</th>
                        <th>Razon Social o Nombre</th>
                        <th>Nit</th>
                        <th>Telefono</th>
                        <th>Ciudad</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->full_name }}</td>
                                <td>{{ $supplier->identification_card }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->city }}</td>
                                <td>{{ $supplier->departament }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-primary ">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-warning ">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('supplier.destroy', $supplier) }}" method="post"
                                            style="display: inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger "> <i
                                                    class="bi bi-trash3"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
