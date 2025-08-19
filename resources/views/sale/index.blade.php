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
                </div>
                <div class="card-body">
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
                                            <a href="{{ route('sale.show', $sale) }}">
                                                <button class="btn btn-primary btnverfacturaVenta" idsale="">
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
                </div>
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
