<div class="container-fluid mb-4">
    <h1 class="h3">Clientes</h1>
    <h2 class="h5 text-muted">Nuevo cliente</h2>
</div>

<div class="container py-4">

    <form action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" method="POST" autocomplete="off" class="FormularioAjax">

        <input type="hidden" name="modulo_cliente" value="registrar">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cliente_nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre"
                      placeholder="Nombre del cliente" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
            </div>
            <div class="col-md-6">
                <label for="cliente_apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="cliente_apellido" name="cliente_apellido"
                      placeholder="Apellido del cliente" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cliente_telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="cliente_telefono" name="cliente_telefono"
                       placeholder="+54 341 1234567"
                       pattern="^\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}$"
                       maxlength="20" required>
            </div>
            <div class="col-md-6">
                <label for="cliente_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="cliente_email" name="cliente_email" placeholder="ejemplo@email.com">
            </div>
        </div>

        <div class="text-center">
            <button type="reset" class="btn btn-outline-primary rounded-pill me-2">Limpiar</button>
            <button type="submit" class="btn btn-success rounded-pill">Guardar cliente</button>
        </div>
    </form>
</div>