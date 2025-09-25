@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php date_default_timezone_set('America/Bogota'); ?>

                    <a href="{{ route('spent.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                </div>
                <div class="row">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                                <form action="{{ route('spent.store') }}" method="POST" id="frmspent">
                                    @csrf
                                    <div class="col-md-8">

                                        <div class="box box-danger">
                                            <div class="box-header">
                                                <h3 class="box-title">Informacion de Gasto</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="col-md-6">
                                                    <!-- Date dd/mm/yyyy -->

                                                    <div class="form-group">
                                                        <label>Fecha del gasto:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="date" class="form-control" name="date_spent" id="date_spent"
                                                                value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label>Valor gasto:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-tag"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="total" id="total" required>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->

                                                <!-- phone mask -->
                                                <div class="form-group">
                                                    <label>Descripcion:</label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bookmark-o"></i>
                                                        </div>
                                                        <textarea class="form-control" rows="3" name="description" placeholder="Descripcion ..." required></textarea>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>


                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->

                                        <button class="btn btn-primary" type="submit">

                                            Guardar
                                        </button>
                                        <!-- /.box -->

                                    </div>
                                    <!-- /.col (left) -->

                                    <!-- /.col (right) -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('total');

        input.addEventListener('input', function(e) {
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
        document.getElementById('frmspent').addEventListener('submit', function() {
            input.value = input.value.replace(/\./g, ''); // quitar los puntos
        });
    </script>
@endsection
