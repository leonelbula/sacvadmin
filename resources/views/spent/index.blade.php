@extends('layouts.master')
@section('subtitle')
    Detalles
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('spent.create') }}">
                        <button type="button" class="btn btn-primary">Nuevo Gasto</button>
                    </a>
                </div>
                <div class="card-body">
                    <table id="spentTable" class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Valor</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Aciones</th>
                        </thead>
                        <tbody>
                            @foreach ($spents as $spent)
                                <tr>
                                    <td>{{ $spent->id }}</td>
                                    <td>{{ $spent->total }}</td>
                                    <td>{{ $spent->description }}</td>
                                    <td>{{ $spent->date_spent }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('spent.edit', $spent) }}">
                                                <button class="btn btn-warning ">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </a>

                                            <form action="{{ route('spent.destroy', $spent) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>

                                            </a>
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
            $('#spentTable').DataTable({
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
