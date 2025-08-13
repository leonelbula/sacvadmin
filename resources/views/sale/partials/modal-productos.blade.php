<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Buscar Producto</h5>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="Buscar por código o nombre" onkeyup="buscarProducto(this.value)">
            <table class="table table-hover" id="tablaProductosModal">
                <tbody>
                    @foreach($products as $producto)
                    <tr onclick="agregarProducto({{ json_encode($producto) }})">
                        <td>{{ $producto->code }}</td>
                        <td>{{ $producto->name }}</td>
                        <td>${{ $producto->price }}</td>
                        <td>{{ $producto->cost }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
