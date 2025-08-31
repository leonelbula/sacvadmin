@extends('layouts.master')
@section('title')

@endsection
@section('subtitle')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('returnsale.create') }}">
                        <button type="button" class="btn btn-primary">Nueva Devolucion</button>
                    </a>
                </div>
                <div class="card-body">
                    <table id="tableSales" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>fecha </th>
                                <th>valor</th>
                                <th>acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($returnsales as $returnsale)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $returnsale->returnsale_number }}</td>
                                    <td>{{ $returnsale->customer->full_name }}</td>
                                    <td>{{ $returnsale->date_sale }}</td>
                                    <td>{{ number_format($returnsale->total, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('returnsale.ticket', $returnsale) }}" target="_blank">
                                                <button class="btn btn-info" codesale="">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('returnsale.show', $returnsale) }}">
                                                <button class="btn btn-primary " idsale="">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('returnsale.edit', $returnsale) }}">
                                                <button type="button" class="btn btn-warning"><i
                                                        class="bi bi-pencil"></i></button>
                                            </a>
                                            <form action="{{ route('returnsale.destroy', $returnsale) }}" method="post"
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
