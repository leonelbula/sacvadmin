@extends('layouts.app')

@section('content')
    <div class="container-fluid  py-4 mt-4">

        <!-- Header -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="mb-0">

                        <i class="bi bi-clock-history"></i>

                        Kardex del Producto

                    </h3>

                    <small>Historial completo de movimientos de inventario</small>

                </div>

                <div>


                    <a href="{{ route('kardex.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Volver

                    </a>

                </div>

            </div>

        </div>

        <!-- Información del producto -->

        <div class="row mb-4">


            <div class="col-lg-3">

                <div class="card border-primary shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted mt-2">Producto</h6>

                        <strong>{{ $produc->name }}</strong>



                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted mt-2">Código</h6>

                        <strong>{{ $produc->code }}</strong>

                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted mt-2">Categoría</h6>

                        <strong>{{ $produc->category->name }}</strong>

                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm border-success">

                    <div class="card-body text-center">

                        <h6 class="text-muted mt-2">Stock</h6>

                        <strong>{{ $produc->stock }}</strong>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card shadow-sm border-warning">

                    <div class="card-body text-center">


                        <h6 class="text-muted mt-2">Stock Mínimo</h6>

                        <strong>{{ $produc->stock_min }}</strong>

                    </div>

                </div>

            </div>

        </div>

        <!-- Filtros -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form class="row g-3 align-items-end">

                    <div class="col-lg-3">

                        <label class="form-label">Buscar</label>

                        <input type="text" class="form-control" placeholder="Referencia..." readonly>

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Desde</label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Hasta</label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Movimiento</label>

                        <select class="form-select">

                            <option>Todos</option>

                            <option>Entrada</option>

                            <option>Salida</option>

                            <option>Ajuste</option>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Buscar

                        </button>

                        <button class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                            Limpiar

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- Tabla -->

        <div class="card shadow border-0">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>Fecha</th>

                                <th>Movimiento</th>

                                <th>Origen</th>

                                <th>Referencia</th>

                                <th class="text-success">Entrada</th>

                                <th class="text-danger">Salida</th>

                                <th>Stock</th>

                                <th>Costo</th>

                                <th>Usuario</th>

                                <th width="80">Acción</th>

                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($detail as $reg)
                                <tr>

                                    <td>{{ $reg->date }}</td>

                                    <td>

                                        <span class="badge  bg-success">

                                            {{ $reg->movement_type }}

                                        </span>

                                    </td>

                                    <td> {{ $reg->origin }}</td>

                                    <td>{{ $reg->reference_id }}</td>

                                    <td class="text-success fw-bold">{{ $reg->income }}</td>

                                    <td>{{ $reg->output }}</td>

                                    <td>{{ $reg->stock_after }}</td>

                                    <td>{{ $reg->unit_cost }}</td>

                                    <td>{{ $reg->user_name }}</td>

                                    <td>

                                        <a href="{{ route('kardex.showDetail', $reg->id) }}" class="btn btn-sm btn-primary">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>

                                </tr>
                            @endforeach



                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                <div class="d-flex justify-content-center mt-4">
                    {{ $detail->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection
