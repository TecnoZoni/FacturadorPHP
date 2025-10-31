<?php
$id = $insMain->limpiarCadena($url[1]);
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            include_once "./app/views/inc/btn_back.php";
            $datos = $insMain->seleccionarDatos("Unico", "cliente", "cliente_id", $id);

            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
            ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Actualizar cliente</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" method="POST" autocomplete="off" class="FormularioAjax">

                            <input type="hidden" name="modulo_cliente" value="actualizar">
                            <input type="hidden" name="cliente_id" value="<?php echo $datos['cliente_id']; ?>">
                            <div class="mb-3">
                                <label for="cliente_nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" value="<?php echo $datos["cliente_nombre"]; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                            </div>

                            <div class="mb-3">
                                <label for="cliente_apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="cliente_apellido" name="cliente_apellido" value="<?php echo $datos["cliente_apellido"]; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                            </div>

                            <div class="mb-3">
                                <label for="cliente_telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="cliente_telefono" name="cliente_telefono" value="<?php echo $datos["cliente_telefono"]; ?>" placeholder="+54 341 1234567"
                                    pattern="^\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}$"
                                    maxlength="20" required>
                            </div>

                            <div class="mb-3">
                                <label for="cliente_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="cliente_email" name="cliente_email" value="<?php echo $datos["cliente_email"]; ?>">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-secondary me-2">Limpiar</button>
                                <button type="submit" class="btn btn-success">Actualizar cliente</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            } else {
                include "./app/views/inc/error_alert.php";
            }
            ?>
        </div>
    </div>
</div>