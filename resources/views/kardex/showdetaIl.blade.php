@extends('layouts.app')

@section('content')
    <div class="container py-4 mt-4">

        <div class="card shadow-lg border-0 rounded-4">

            <!-- Encabezado -->

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="mb-0">

                        <i class="bi bi-clock-history me-2"></i>

                        Detalle del Movimiento

                    </h3>

                    <small>Kardex del Inventario</small>

                </div>



            </div>

            <!-- Cuerpo -->

            <div class="card-body">

                <!-- Información del producto -->

                <h5 class="border-bottom pb-2 mb-4">

                    <i class="bi bi-box-seam me-2"></i>

                    Información del Producto

                </h5>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Producto</label>

                        <h5>{{ $detail->product->name }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Código</label>

                        <h5>{{ $detail->product->code }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Categoría</label>

                        <h5>

                            <span class="btn bg-info">

                                {{ $detail->product->category->name }}

                            </span>

                        </h5>

                    </div>

                </div>

                <hr>

                <!-- Información del movimiento -->

                <h5 class="border-bottom pb-2 mb-4">

                    <i class="bi bi-arrow-left-right me-2"></i>

                    Información del Movimiento

                </h5>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Fecha</label>

                        <h5>{{ $detail->created_at }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Tipo</label>

                        <h5>

                            {{ $detail->movement_type }}

                        </h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Origen</label>

                        <h5>{{ $detail->origin }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Referencia</label>

                        <h5>{{ $detail->reference_id }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted">Usuario</label>

                        <h5>{{ $detail->user_name }}</h5>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="text-muted"></label>

                        <h5>



                        </h5>

                    </div>

                </div>

                <hr>

                <!-- Resumen -->

                <h5 class="border-bottom pb-2 mb-4">

                    <i class="bi bi-bar-chart me-2"></i>

                    Resumen del Inventario

                </h5>

                <div class="row">

                    <div class="col-lg-2">

                        <div class="card border-secondary">

                            <div class="card-body text-center">

                                <small class="text-muted">

                                    Stock Anterior

                                </small>

                                <h2>{{ $detail->stock_before }}</h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-2">

                        <div class="card border-success">

                            <div class="card-body text-center">

                                <small class="text-muted">

                                    Ingresado

                                </small>

                                <h2 class="text-success">

                                    {{ $detail->income }}

                                </h2>

                            </div>

                        </div>

                    </div>
                    <div class="col-lg-2">

                        <div class="card border-success">

                            <div class="card-body text-center">

                                <small class="text-muted">

                                    Salida

                                </small>

                                <h2 class="text-danger">

                                    {{ $detail->output }}

                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-2">

                        <div class="card border-primary">

                            <div class="card-body text-center">

                                <small class="text-muted">

                                    Stock Actual

                                </small>

                                <h2>{{ $detail->stock_after }}</h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="card border-warning">

                            <div class="card-body text-center">

                                <small class="text-muted">

                                    Costo Unitario

                                </small>

                                <h2>{{ $detail->unit_cost }}</h2>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-6">

                        <label class="text-muted">

                            Valor del Movimiento

                        </label>

                        <h3 class="text-success">

                            @if ($detail->income)
                                @php
                                    $value = (int) $detail->unit_cost * (int) $detail->income;
                                @endphp
                               {{ number_format($value, 0, ',', '.'); }}
                            @else
                                @php
                                    $value = (int) $detail->unit_cost * (int) $detail->output;
                                @endphp
                                {{ number_format($value, 0, ',', '.'); }}
                            @endif



                        </h3>

                    </div>

                </div>

                <hr>

                <!-- Observaciones -->

                <h5 class="border-bottom pb-2 mb-3">

                    <i class="bi bi-chat-left-text me-2"></i>

                    Observaciones

                </h5>

                <div class="alert alert-light border">

                    Compra realizada al proveedor
                    <strong>Distribuidora ABC</strong> mediante la
                    factura de compra <strong>CP-000012</strong>.

                </div>

            </div>

            <!-- Footer -->

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{route('kardex.show', $detail->product_id)}}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Volver

                    </a>

                    <button class="btn btn-primary">

                        <i class="bi bi-printer"></i>

                        Imprimir

                    </button>

                    <button class="btn btn-success">

                        <i class="bi bi-file-earmark-text"></i>

                        Ver Documento

                    </button>

                </div>

            </div>

        </div>

    </div>
@endsection
