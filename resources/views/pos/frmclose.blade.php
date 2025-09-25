@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Nuevo inicio de ventas
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pos.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>


                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('previewcloseConfirmar') }}" id="frmclose">
                                @csrf

                                {{-- Campo Fecha --}}
                                <div class="mb-4">
                                    <label for="fecha" class="form-label fw-bold">Fecha</label>
                                    <input type="date" id="fecha" name="date" class="form-control form-control-lg" value="{{date('Y-m-d')}}"
                                        required>
                                </div>

                                {{-- Campo Valor Base de Caja --}}
                                <div class="mb-4">
                                    <label for="valor_base" class="form-label fw-bold">Valor Efectivo</label>
                                    <input type="text" id="amount" name="amount" step="0"
                                        placeholder="Ingrese el valor del efectivo" class="form-control form-control-lg" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        Cerrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
const input = document.getElementById('amount');

input.addEventListener('input', function (e) {
    let cursor = this.selectionStart; // posición actual del cursor
    let valor = this.value.replace(/\D/g, ''); // solo dígitos

    if (valor === "") {
        this.value = "";
        return;
    }

    // Formatear con puntos
    let nuevoValor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    this.value = nuevoValor;

    // Ajustar el cursor (lo mueve al final si hay cambio de formato)
    this.setSelectionRange(nuevoValor.length, nuevoValor.length);
});

// 👉 Limpiar antes de enviar
document.getElementById('frmclose').addEventListener('submit', function () {
    input.value = input.value.replace(/\./g, ''); // quitar los puntos
});
</script>
@endsection
