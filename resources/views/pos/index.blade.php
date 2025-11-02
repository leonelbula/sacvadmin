@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Lista Cierres
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('sale.index') }}">
                        <button type="button" class="btn btn-primary">Lista Ventas</button>
                    </a>
                    <a href="{{ route('sale.create') }}">
                        <button type="button" class="btn btn-primary">Nueva Ventas</button>
                    </a>
                    @if ($closingpos)
                        <a href="{{ route('previewclose') }}">
                            <button type="button" class="btn btn-primary">Cerrar ventas</button>
                        </a>
                    @else
                        <a href="{{ route('pos.create') }}">
                            <button type="button" class="btn btn-primary">Iniciar ventas</button>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="tableSales" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>fecha cierre</th>
                                <th>Venta Total</th>
                                <th>diferencia</th>
                                <th>Estado</th>
                                <th>acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($closings as $closing)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $closing->user->name }}</td>
                                    <td>{{ $closing->start_date }}</td>
                                    <td>{{ $closing->closing_date }}</td>
                                    <td>{{ number_format($closing->total_sale, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($closing->difference > 0)
                                            <button class="btn btn-info btn-sm">
                                                {{ $closing->difference }}
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm">{{ $closing->difference }}</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($closing->state == 0)
                                            <button class="btn btn-info btn-sm">
                                                Cerrado
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm">Activo</button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('cierre.caja', $closing) }}" target="_blank">
                                                <button class="btn btn-success" codesale="">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('pos.show', $closing) }}">
                                                <button class="btn btn-primary " idsale="">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </a>
                                            <a href="">
                                                <button type="button" class="btn btn-warning"><i
                                                        class="bi bi-pencil"></i></button>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $closings->links() }}
                    </div>
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
