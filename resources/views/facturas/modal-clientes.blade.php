<div class="modal fade" id="modalClientes" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seleccionar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control mb-3" placeholder="Buscar cliente..." id="buscarCliente">
        <table class="table table-bordered">
          <thead><tr><th>Nombre</th><th>Dirección</th><th>Acción</th></tr></thead>
          <tbody>
            @foreach($customers as $cliente)
              <tr>
                <td>{{ $cliente->full_name }}</td>
                <td>{{ $cliente->adress }}</td>
                <td>
                  <button class="btn btn-sm btn-primary" onclick="seleccionarCliente({{ $cliente->id }}, '{{ $cliente->nombre }}', '{{ $cliente->direccion }}')">Seleccionar</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
