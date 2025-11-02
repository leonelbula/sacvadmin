@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Lista Venta
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('sale.create') }}">
                        <button type="button" class="btn btn-primary">Nueva Venta</button>
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporteModal">
                        Generar reporte de ventas
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <form method="GET" action="{{ route('product.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-select" name="type" id="type" required>
                                                <option value="number_sale">N° Fact.</option>
                                                <option value="customer">Nombre</option>
                                                <option value="date_sale">Fecha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Buscar ..." value="{{ $search }}">
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                        <div class="col-3">
                            <a href="{{ route('product.index') }}" type="button" class="btn btn-block btn-primary">Mostrar
                                todos</a>

                        </div>
                    </div>

                    <table id="tableSales" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>fecha factura</th>
                                <th>valor</th>
                                <th>Tipo</th>
                                <th>acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $sale->sale_number }}</td>
                                    <td>{{ $sale->customer->full_name }}</td>
                                    <td>{{ $sale->date_sale }}</td>
                                    <td>{{ number_format($sale->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($sale->type_sale == '0')
                                            <button class="btn btn-info btn-sm">
                                                Credito
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm">Contado</button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('sale.invocesPdf', $sale) }}" target="_blank">
                                                <button class="btn btn-info" codesale="">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('sale.ticketepson', $sale) }}" target="_blank">
                                                <button class="btn btn-success" codesale="">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('sale.show', $sale) }}">
                                                <button class="btn btn-primary " idsale="">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('sale.edit', $sale) }}">
                                                <button type="button" class="btn btn-warning"><i
                                                        class="bi bi-pencil"></i></button>
                                            </a>
                                            <form action="{{ route('sale.destroy', $sale) }}" method="post"
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
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('reports.salesByUserPdf') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reporteModalLabel">Reporte de Ventas por Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body"> <!-- Usuario -->
                        @if (Auth::user()->type == 'vendor')
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuario</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach ($usuarios as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        @endif

                        <!-- Método de Pago -->
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Método de Pago</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">Seleccione un método</option>
                                <option value="1">Efectivo</option>
                                <option value="2">Consignación</option>
                            </select>
                        </div>

                        <!-- Fecha Inicial -->
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicial</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        </div>

                        <!-- Fecha Final -->
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Final</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $('#tableSales').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@endsection
