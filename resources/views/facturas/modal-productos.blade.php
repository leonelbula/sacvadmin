<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seleccionar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control mb-3" placeholder="Buscar producto..." id="buscarProducto">
        <table class="table table-bordered">
          <thead><tr><th>Nombre</th><th>Código</th><th>Precio</th><th>IVA (%)</th><th>Acción</th></tr></thead>
          <tbody>
            @foreach($products as $producto)
              <tr>
                <td>{{ $producto->name }}</td>
                <td>{{ $producto->code }}</td>
                <td>{{ $producto->price }}</td>
                <td>19</td>
                <td>
                  <button class="btn btn-sm btn-success" onclick="agregarProducto({{ $producto->id }}, '{{ $producto->nombre }}', '{{ $producto->codigo }}', {{ $producto->precio }},19)">Agregar</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
