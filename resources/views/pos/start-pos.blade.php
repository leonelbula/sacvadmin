{{-- resources/views/pos/start-pos.blade.php --}}

@extends('layouts.app')

@section('title', 'Iniciar POS')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-shop-window text-primary me-2"></i>
                    Iniciar POS
                </h2>

                <p class="text-muted mb-0">
                    Abre la caja para comenzar la jornada de ventas.
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->format('d/m/Y') }}
                </span>

                <span class="badge bg-light text-dark border px-3 py-2 ms-2">
                    <i class="bi bi-clock me-1"></i>
                    <span id="currentTime">
                        {{ now()->format('h:i A') }}
                    </span>
                </span>
            </div>

        </div>


        <div class="row g-4">

            {{-- ========================================= --}}
            {{-- COLUMNA PRINCIPAL --}}
            {{-- ========================================= --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">

                    {{-- CARD HEADER --}}
                    <div class="card-header bg-white border-0 p-4 rounded-top-4">

                        <div class="d-flex align-items-center">

                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                <i class="bi bi-cash-register fs-3"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1">
                                    Apertura de caja
                                </h4>

                                <p class="text-muted mb-0">
                                    Ingresa la información inicial de tu punto de venta.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <form action="{{ route('pos.store') }}" method="POST" id="startPosForm">

                            @csrf

                            {{-- ========================================= --}}
                            {{-- PUNTO DE VENTA --}}
                            {{-- ========================================= --}}
                            <div class="mb-4">

                                <label for="pos_id" class="form-label fw-semibold">
                                    Fecha de Inicio
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group input-group-lg">

                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shop text-primary"></i>
                                    </span>

                                    <input type="date" name="start_date" id="start_date" class="form-control" required>

                                </div>

                                @error('pos_id')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ========================================= --}}
                            {{-- USUARIO --}}
                            {{-- ========================================= --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Cajero
                                </label>

                                <div class="card bg-light border-0 rounded-3">

                                    <div class="card-body d-flex align-items-center">

                                        <div class="rounded-circle bg-primary text-white d-flex
                                               align-items-center justify-content-center me-3"
                                            style="width: 48px; height: 48px;">
                                            <i class="bi bi-person fs-4"></i>
                                        </div>

                                        <div>

                                            <div class="fw-bold">
                                                {{ auth()->user()->name ?? 'Usuario' }}
                                            </div>

                                            <small class="text-muted">
                                                Cajero responsable de la apertura
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ========================================= --}}
                            {{-- BASE INICIAL --}}
                            {{-- ========================================= --}}
                            <div class="mb-4">

                                <label for="box_base" class="form-label fw-semibold">

                                    Base inicial

                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group input-group-lg">

                                    <span class="input-group-text bg-light">
                                        $
                                    </span>

                                    <input type="number" name="box_base" id="box_base" class="form-control" min="0"
                                        step="100" value="{{ old('box_base', 0) }}" placeholder="0" required>

                                    <span class="input-group-text bg-light">
                                        COP
                                    </span>

                                </div>

                                <div class="form-text">
                                    Ingresa el dinero físico disponible al iniciar la jornada.
                                </div>

                                @error('box_base')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- ========================================= --}}
                            {{-- OBSERVACIONES --}}
                            {{-- ========================================= --}}



                            {{-- ========================================= --}}
                            {{-- ALERTA --}}
                            {{-- ========================================= --}}
                            <div class="alert alert-info border-0 rounded-3 d-flex align-items-start">

                                <i class="bi bi-info-circle-fill fs-5 me-3"></i>

                                <div>

                                    <strong>Importante</strong>

                                    <div class="small mt-1">
                                        Verifica que la base inicial corresponda al dinero
                                        disponible físicamente antes de abrir la caja.
                                    </div>

                                </div>

                            </div>


                            {{-- ========================================= --}}
                            {{-- BOTONES --}}
                            {{-- ========================================= --}}
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">

                                <a href="{{ url()->previous() }}" class="btn btn-light border btn-lg px-4">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Volver
                                </a>

                                <button type="submit" class="btn btn-primary btn-lg px-5 flex-grow-1" id="btnOpenPos">
                                    <i class="bi bi-unlock-fill me-2"></i>
                                    Abrir caja
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- COLUMNA RESUMEN --}}
            {{-- ========================================= --}}
            <div class="col-lg-4">

                {{-- ESTADO DE CAJA --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <h5 class="fw-bold mb-0">
                                Estado de caja
                            </h5>

                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                <i class="bi bi-circle-fill small me-1"></i>
                                Cerrada
                            </span>

                        </div>


                        <div class="text-center py-3">

                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle
                                   d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-lock-fill fs-1"></i>
                            </div>

                            <h5 class="fw-bold">
                                Caja cerrada
                            </h5>

                            <p class="text-muted small mb-0">
                                Debes abrir la caja para comenzar a registrar ventas.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- RESUMEN --}}
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-clipboard-data me-2 text-primary"></i>
                            Resumen de apertura
                        </h5>


                        {{-- FECHA --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                <i class="bi bi-calendar3 me-2"></i>
                                Fecha
                            </span>

                            <strong id="init-start_date">
                                /-/-/
                            </strong>

                        </div>


                        {{-- HORA --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                <i class="bi bi-clock me-2"></i>
                                Hora
                            </span>

                            <strong id="summaryTime">
                                {{ now()->format('h:i A') }}
                            </strong>

                        </div>


                        {{-- CAJERO --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                <i class="bi bi-person me-2"></i>
                                Cajero
                            </span>

                            <strong>
                                {{ auth()->user()->name ?? 'Usuario' }}
                            </strong>

                        </div>


                        <hr>


                        {{-- BASE --}}
                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-semibold">
                                Base inicial
                            </span>

                            <span class="fw-bold text-primary fs-5" id="summaryBase">
                                $0
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- ESTILOS --}}
    {{-- ========================================= --}}

    <style>
        body {
            background-color: #f6f8fb;
        }

        .card {
            transition: all .2s ease;
        }

        .form-control,
        .form-select,
        .input-group-text {
            border-color: #e5e7eb;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .08);
        }

        .btn {
            border-radius: .75rem;
            font-weight: 600;
        }

        .input-group-lg .form-control,
        .input-group-lg .form-select,
        .input-group-lg .input-group-text {
            min-height: 52px;
        }

        .badge {
            font-weight: 600;
        }
    </style>


    {{-- ========================================= --}}
    {{-- JAVASCRIPT --}}
    {{-- ========================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const start_date = document.getElementById('start_date');
            const init_start_date = document.getElementById('init-start_date');

            const boxBase = document.getElementById('box_base');
            const summaryBase = document.getElementById('summaryBase');

            const currentTime = document.getElementById('currentTime');
            const summaryTime = document.getElementById('summaryTime');

            const form = document.getElementById('startPosForm');
            const btnOpenPos = document.getElementById('btnOpenPos');


            /* =========================================
               FORMATEAR MONEDA
            ========================================= */

            function formatCurrency(value) {

                return new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    maximumFractionDigits: 0
                }).format(value || 0);

            }


            /* =========================================
               ACTUALIZAR BASE
            ========================================= */

            function updateBase() {

                const value = parseFloat(boxBase.value) || 0;

                summaryBase.textContent = formatCurrency(value);

            }

            function updateDate_star(){
                const dateStr = start_date.value;
                init_start_date.textContent = dateStr;
            }

            start_date.addEventListener('input', updateDate_star);

            boxBase.addEventListener('input', updateBase);

            updateBase();


            /* =========================================
               RELOJ
            ========================================= */

            function updateClock() {

                const now = new Date();

                const time = now.toLocaleTimeString('es-CO', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });

                currentTime.textContent = time;
                summaryTime.textContent = time;

            }


            updateClock();

            setInterval(updateClock, 1000);


            /* =========================================
               CONFIRMAR APERTURA
            ========================================= */

            form.addEventListener('submit', function(event) {

                const base = parseFloat(boxBase.value) || 0;

                if (base < 0) {

                    event.preventDefault();

                    alert('La base inicial no puede ser negativa.');

                    boxBase.focus();

                    return;

                }


                btnOpenPos.disabled = true;

                btnOpenPos.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-2"
                role="status"
            ></span>

            Abriendo caja...
        `;

            });

        });
    </script>

@endsection
