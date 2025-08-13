<div class="modal fade" id="modalClientes" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Buscar Cliente 000</h5>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="Buscar por nombre o NIT" onkeyup="buscarCliente(this.value)">
            <table class="table table-hover" id="tablaClientes">
                <tbody>
                    @foreach($customers as $cliente)
                    <tr onclick="seleccionarCliente({{ json_encode($cliente) }})">
                        <td>{{ $cliente->full_name }}</td>
                        <td>{{ $cliente->identification_card44 }}</td>
                        <td>{{ $cliente->address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
