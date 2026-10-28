@extends('layouts.app')

@section('title', 'Reporte de Inventario')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    <i class="bi bi-box-seam"></i>
                    Reporte de Inventario
                </h4>

                <p class="text-muted mb-0">
                    Resumen general del inventario actual
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('reports.index')  }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Volver

                </a>

              

            </div>

        </div>


        {{-- RESUMEN --}}

        <div class="row g-3 mb-4">

            <div class="col-md-6 col-xl-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Productos registrados
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-primary">

                                <i class="bi bi-box"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Stock total
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ number_format($stock ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-success">

                                <i class="bi bi-stack"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Inventario al costo
                                </p>

                                <h3 class="fw-bold mb-0">
                                    $ {{ number_format($inventory_cost ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-warning">

                                <i class="bi bi-cash-stack"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Inventario a precio de venta
                                </p>

                                <h3 class="fw-bold mb-0">
                                    $ {{ number_format($inventory_price ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-info">

                                <i class="bi bi-cart-check"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- UTILIDAD POTENCIAL --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <h5 class="mb-1">
                            <i class="bi bi-graph-up-arrow"></i>
                            Utilidad potencial del inventario
                        </h5>

                        <p class="text-muted mb-0">
                            Diferencia entre el valor del inventario
                            al precio de venta y su valor al costo.
                        </p>

                    </div>

                    <div class="col-md-4 text-md-end mt-3 mt-md-0">

                        <h3 class="fw-bold text-success mb-0">

                            $
                            {{ number_format($utility ?? 0, 0, ',', '.') }}

                        </h3>

                    </div>

                </div>

            </div>

        </div>



    </div>

@endsection
