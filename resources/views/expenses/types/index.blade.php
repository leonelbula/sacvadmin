@extends('layouts.app')

@section('title', 'Tipos de gastos')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-tags me-2"></i>Tipos de gastos
                </h3>
                <p class="text-muted mb-0">
                    Administra las categorías de gastos de tu negocio.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- Formulario --}}
            <div class="col-12 col-xl-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-plus-circle me-2 text-primary"></i>
                            Registrar tipo de gasto
                        </h5>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ isset($typeExpense->id) ? route('expense-types.update', $typeExpense->id) : route('expense-types.store') }}"
                            method="POST">
                            @csrf
                            @isset($typeExpense->id)
                                @method('PUT')
                            @endisset

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Nombre del tipo de gasto
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description', $typeExpense->description ?? '') ? $typeExpense->description : ''  }}" placeholder="Ej. Servicios públicos" maxlength="100"
                                    required>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>
                                    Guardar tipo de gasto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Listado --}}
            <div class="col-12 col-xl-8">
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-list-ul me-2 text-primary"></i>
                                Tipos de gastos registrados
                            </h5>

                            <span class="badge bg-primary rounded-pill">
                                {{ $expenseTypes->total() }} registros
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($expenseTypes as $expenseType)
                                        <tr>
                                            <td class="ps-3">
                                                {{ $expenseTypes->firstItem() + $loop->index }}
                                            </td>

                                            <td>
                                                <span class="text-muted">
                                                    {{ $expenseType->description ?: 'Sin descripción' }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-inline-flex gap-2">

                                                    <a href="{{ route('expense-types.index', $expenseType) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <form action="{{ route('expense-types.destroy', $expenseType) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar este tipo de gasto?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                                <h6 class="text-muted">No hay tipos de gastos registrados</h6>
                                                <p class="text-muted small mb-0">
                                                    Utiliza el formulario para registrar el primero.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($expenseTypes->hasPages())
                        <div class="card-footer bg-white">
                            {{ $expenseTypes->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection
