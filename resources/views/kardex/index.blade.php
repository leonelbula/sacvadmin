@extends('layouts.app')
@section('subtitle')
    Kaedex
@endsection
@section('content')
    <div class="container-fluid py-4 mt-4">

        <!-- Encabezado -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-header bg-primary text-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h3 class="mb-0">

                            <i class="bi bi-clock-history"></i>

                            Kardex General

                        </h3>

                        <small>
                            Historial completo de movimientos del inventario
                        </small>

                    </div>

                    <div>

                        <button class="btn btn-light">

                            <i class="bi bi-file-earmark-excel"></i>

                            Excel

                        </button>

                        <button class="btn btn-success">

                            <i class="bi bi-file-earmark-pdf"></i>

                            PDF

                        </button>

                        <button class="btn btn-warning">

                            <i class="bi bi-printer"></i>

                            Imprimir

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Resumen -->

        <div class="row mb-4">

            <div class="col-md-3">

                <div class="card border-primary shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-box-seam fs-1 text-primary"></i>

                        <h3>{{ $totalProduct }}</h3>

                        <small>Productos</small>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-success shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-arrow-down-circle fs-1 text-success"></i>

                        <h3> {{ $movimentos->total_income }}</h3>

                        <small>Entradas</small>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-danger shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>

                        <h3>{{ $movimentos->total_output }}</h3>

                        <small>Salidas</small>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-warning shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-clock-history fs-1 text-warning"></i>

                        <h3>{{ $movimentos->total }}</h3>

                        <small>Movimientos</small>

                    </div>

                </div>

            </div>

        </div>

        <!-- Filtros -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">
                <div class="row">
                    <form class="row g-3" action="" method="GET">

                        <div class="col-lg-8">

                            <label class="form-label">Producto</label>

                            <input class="form-control" placeholder="Nombre o código" name="search">

                        </div>


                        <div class="col-lg-1 d-grid">

                            <label class="form-label">&nbsp;</label>

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-search"></i>

                            </button>

                        </div>
                        <div class="col-lg-2 d-grid">

                            <label class="form-label">&nbsp;</label>

                            <a href="{{ route('kardex.index') }}" type="button" class="btn btn-block btn-primary">Mostrar
                                todos</a>

                        </div>

                    </form>
                </div>





            </div>

        </div>

        <!-- Tabla -->

        <div class="card shadow border-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>Fecha</th>

                            <th>Producto</th>

                            <th>Movimiento</th>

                            <th>Origen</th>

                            <th>Referencia</th>

                            <th class="text-success">Entrada</th>

                            <th class="text-danger">Salida</th>

                            <th>Stock</th>
                            <th>Costo </th>

                            <th>Usuario</th>


                            <th>Detalle</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($all as $data)
                            <tr>

                                <td>{{ $data->created_at }}</td>

                                <td>{{ $data->product->name }}</td>

                                <td><span class="btn btn-sm bg-success">{{ $data->movement_type }}</span></td>

                                <td>{{ $data->origin }}</td>
                                <td>{{ $data->reference_id }}</td>

                                <td class="fw-bold text-success"> {{ $data->income }} </td>
                                <td class="fw-bold text-danger"> {{ $data->output }} </td>

                                <td> {{ $data->stock_after }} </td>

                                <td>{{ $data->unit_cost }} </td>
                                <td> {{ $data->user_name }} </td>


                                <td>

                                    <a href="{{ route('kardex.show', $data->product_id) }}" class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                </td>

                            </tr>
                        @endforeach ($all as $data)



                    </tbody>

                </table>

            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">

                <small class="text-muted">

                    Mostrando 1 a 20 de 15.840 movimientos

                </small>


                <div class="pagination pagination-sm mb-0">
                    {{ $all->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection
