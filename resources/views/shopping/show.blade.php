@extends('layouts.master')
@section('subtitle')
    Detalles Compra

@endsection
@section('content')
    <div class="container mt-1">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Detalle de Compra #{{ $shopping->id }}</h5>
                <a href="{{ route('shopping.index') }}" type="button" class="btn btn-block btn-primary">Volver</a>
                <a href="{{ route('shopping.edit', $shopping) }}" class="btn btn-warning ">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('shopping.destroy', $shopping) }}" method="post" style="display: inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger "> <i class="bi bi-trash3"></i></button>
                </form>
            </div>
            <div class="card-body">
                <p><strong>Proveedor:</strong> {{ $shopping->supplier->full_name }}</p>
                <p><strong>Factura:</strong> {{ $shopping->invoice_number }}</p>
                <p><strong>Tipo de Compra:</strong>
                    @if ($shopping->purchase_type == 'counted')
                        Contado
                    @else
                        Credito
                    @endif
                </p>
                <p><strong>Fecha:</strong> {{ $shopping->shopping_date }}</p>

                <hr>
                <h6>Productos Comprados</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shopping->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>${{ number_format($detail->price, 0) }}</td>
                                <td>${{ number_format($detail->quantity * $detail->price, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end">
                    <p><strong>Subtotal:</strong> ${{ number_format($shopping->subtotal, 0) }}</p>
                    <p><strong>IVA:</strong> ${{ number_format($shopping->iva, 0) }}</p>
                    <p><strong>Total:</strong> ${{ number_format($shopping->total, 0) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
