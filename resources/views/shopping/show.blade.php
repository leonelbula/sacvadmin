@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
    <div class="container-fluid py-4 mt-5">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <a href="{{ route('shopping.index') }}" class="text-decoration-none text-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <span class="text-muted">Compras</span>
                    <i class="bi bi-chevron-right text-muted small"></i>
                    <span class="text-dark">Detalle</span>
                </div>

                <h2 class="fw-bold mb-1">
                    <i class="bi bi-cart-check text-primary me-2"></i>
                    Compra #{{ $shopping->id }}
                </h2>

                <p class="text-muted mb-0">
                    Información completa de la compra registrada.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('shopping.index') }}" class="btn btn-light border">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('shopping.edit', $shopping->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <form action="{{ route('shopping.destroy', $shopping->id) }}" method="POST" class="form-delete d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-xl-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-receipt text-primary me-2"></i>
                                    Información de la compra
                                </h5>
                                <small class="text-muted">
                                    Datos generales de la operación
                                </small>
                            </div>

                            @php
                                $state = $shopping->balance;

                                if ($state == 0) {
                                    $stateClass = 'success';
                                    $stateText = 'Pagada';
                                } elseif ($state > 0) {
                                    $stateClass = 'danger';
                                    $stateText = 'Cedito';
                                } else {
                                    $stateClass = 'secondary';
                                    $stateText = 'N/N';
                                }
                            @endphp

                            <span class="badge bg-{{ $stateClass }}-subtle text-{{ $stateClass }} px-3 py-2">
                                <i class="bi bi-circle-fill small me-1"></i>
                                {{ $stateText }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="rounded-3 bg-primary-subtle text-primary p-3">
                                        <i class="bi bi-calendar-event fs-4"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Fecha</small>
                                        <strong>
                                            {{ $shopping->shopping_date ? \Carbon\Carbon::parse($shopping->shopping_date)->format('d/m/Y') : 'N/A' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="rounded-3 bg-info-subtle text-info p-3">
                                        <i class="bi bi-credit-card fs-4"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Fecha de pago</small>
                                        <strong>
                                            {{ $shopping->due_date ?? 'Pagada' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="rounded-3 bg-success-subtle text-success p-3">
                                        <i class="bi bi-person-badge fs-4"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Registrado por</small>
                                        <strong>
                                            {{ $shopping->user->name ?? 'N/A' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="rounded-3 bg-warning-subtle text-warning p-3">
                                        <i class="bi bi-clock fs-4"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Registrado</small>
                                        <strong>
                                            {{ $shopping->created_at ? $shopping->created_at->format('d/m/Y H:i') : 'N/A' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-truck text-primary me-2"></i>
                            Proveedor
                        </h5>
                        <small class="text-muted">
                            Información del proveedor asociado
                        </small>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">
                                    Proveedor
                                </small>
                                <div class="fw-semibold">
                                    {{ $shopping->supplier->full_name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">
                                    Identificación
                                </small>
                                <div class="fw-semibold">
                                    {{ $shopping->supplier->identification ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">
                                    Teléfono
                                </small>
                                <div>
                                    <i class="bi bi-telephone text-primary me-1"></i>
                                    {{ $shopping->supplier->phone ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">
                                    Correo
                                </small>
                                <div>
                                    <i class="bi bi-envelope text-primary me-1"></i>
                                    {{ $shopping->supplier->email ?? 'N/A' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-box-seam text-primary me-2"></i>
                                    Productos
                                </h5>
                                <small class="text-muted">
                                    Detalle de los productos incluidos en la compra
                                </small>
                            </div>

                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                {{ $shopping->details->count() }} productos
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if ($shopping->details->count())
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Producto</th>
                                            <th>Código</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Costo</th>
                                            <th class="text-end pe-4">Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($shopping->details as $detail)
                                            @php
                                                $product = $detail->product ?? null;
                                                $quantity = $detail->quantity ?? 0;
                                                $cost = $detail->cost ?? ($detail->unit_cost ?? 0);
                                                $subtotal = $detail->subtotal ?? $quantity * $cost;
                                            @endphp

                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="rounded-3 bg-light p-2">
                                                            <i class="bi bi-box text-primary fs-5"></i>
                                                        </div>

                                                        <div>
                                                            <div class="fw-semibold">
                                                                {{ $product->name ?? 'Producto no disponible' }}
                                                            </div>

                                                            @if ($product)
                                                                <small class="text-muted">
                                                                    ID: {{ $product->id }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $product->code ?? 'N/A' }}
                                                    </span>
                                                </td>

                                                <td class="text-center fw-semibold">
                                                    {{ number_format($quantity, 0, ',', '.') }}
                                                </td>

                                                <td class="text-end">
                                                    ${{ number_format($cost, 0, ',', '.') }}
                                                </td>

                                                <td class="text-end pe-4 fw-semibold">
                                                    ${{ number_format($subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-box-seam display-5 text-muted"></i>
                                <h6 class="fw-bold mt-3">
                                    No hay productos registrados
                                </h6>
                                <p class="text-muted mb-0">
                                    Esta compra no tiene detalles asociados.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($shopping->observation)
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-chat-left-text text-primary me-2"></i>
                                Observaciones
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="bg-light rounded-3 p-3">
                                {{ $shopping->observation }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-xl-4">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-calculator me-2"></i>
                            Resumen de compra
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Subtotal
                            </span>
                            <strong>
                                ${{ number_format($shopping->subtotal ?? 0, 0, ',', '.') }}
                            </strong>
                        </div>



                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Impuestos
                            </span>
                            <strong>
                                ${{ number_format($shopping->tax ?? ($shopping->iva ?? 0), 0, ',', '.') }}
                            </strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">
                                Total
                            </span>

                            <span class="fw-bold fs-4 text-primary">
                                ${{ number_format($shopping->total ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-wallet2 text-success me-2"></i>
                            Información de pago
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Método
                            </span>

                            <span class="fw-semibold">
                                {{ $shopping->paymentMethod->name ?? 'No especificado' }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Valor pagado
                            </span>

                            <strong>
                                ${{ number_format($shopping->payment_amount ?? ($shopping->paid ?? 0), 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">
                                Pendiente
                            </span>

                            <strong class="{{ ($shopping->balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                                ${{ number_format($shopping->balance ?? 0, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary-subtle text-primary p-3">
                                <i class="bi bi-info-circle fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1">
                                    Información
                                </h6>

                                <small class="text-muted">
                                    Compra registrada el
                                    {{ $shopping->created_at ? $shopping->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection


<script>
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!confirm('¿Está seguro de eliminar esta compra?')) {
                event.preventDefault();
            }
        });
    });
</script>
