<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Facturas generadas</h1>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearFacturaModal">
      Crear factura
    </button>
  </div>

  <!-- Tabla de facturas -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>001</td>
          <td>Juan Pérez</td>
          <td>2025-10-29</td>
          <td>$12.500</td>
          <td>
            <button class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#detalleFacturaModal">Ver detalle</button>
            <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editarFacturaModal">Editar</button>
            <a href="/factura/001/pdf" class="btn btn-sm btn-danger">Generar PDF</a>
          </td>
        </tr>
        <!-- Más filas dinámicas -->
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Crear Factura -->
<div class="modal fade" id="crearFacturaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title">Crear nueva factura</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Selección de cliente -->
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select class="form-select" name="cliente_id">
              <option value="1">Juan Pérez</option>
              <option value="2">María López</option>
              <!-- dinámico -->
            </select>
          </div>

          <!-- Productos dinámicos -->
          <div id="productosContainer">
            <div class="row g-2 align-items-end mb-2 producto-item">
              <div class="col-md-6">
                <label class="form-label">Producto</label>
                <select class="form-select" name="producto_id[]">
                  <option value="1">Producto A</option>
                  <option value="2">Producto B</option>
                  <!-- dinámico -->
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="cantidad[]" min="1" value="1">
              </div>
              <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-producto">Eliminar</button>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-secondary" id="addProducto">Agregar producto</button>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar factura</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detalle Factura -->
<div class="modal fade" id="detalleFacturaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle de factura #001</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Cliente:</strong> Juan Pérez</p>
        <p><strong>Fecha:</strong> 2025-10-29</p>
        <table class="table">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio unitario</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Producto A</td>
              <td>2</td>
              <td>$5000</td>
              <td>$10000</td>
            </tr>
            <tr>
              <td>Producto B</td>
              <td>1</td>
              <td>$2500</td>
              <td>$2500</td>
            </tr>
          </tbody>
        </table>
        <p class="text-end"><strong>Total:</strong> $12.500</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Factura -->
<div class="modal fade" id="editarFacturaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title">Editar factura #001</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Similar al modal de crear, pero precargado con datos -->
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select class="form-select" name="cliente_id">
              <option selected>Juan Pérez</option>
              <option>María López</option>
            </select>
          </div>
          <!-- Productos ya cargados -->
          <div id="productosEditarContainer">
            <div class="row g-2 align-items-end mb-2 producto-item">
              <div class="col-md-6">
                <label class="form-label">Producto</label>
                <select class="form-select" name="producto_id[]">
                  <option selected>Producto A</option>
                  <option>Producto B</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="cantidad[]" value="2">
              </div>
              <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-producto">Eliminar</button>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-secondary" id="addProductoEditar">Agregar producto</button>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// JS para agregar/eliminar productos dinámicamente
document.getElementById('addProducto').addEventListener('click', function() {
  const container = document.getElementById('productosContainer');
  const item = container.querySelector('.producto-item').cloneNode(true);
  item.querySelector('input').value = 1;
  container.appendChild(item);
});

document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-producto')) {
    e.target.closest('.producto-item').remove();
  }
});
</script>