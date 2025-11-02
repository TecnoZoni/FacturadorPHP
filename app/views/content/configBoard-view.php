<?php
$datos = $insMain->seleccionarDatos("Unico", "configuracion", "configuracion_id ", 1);
?>

<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">Perfil</h1>
            <small class="h5 text-muted">Configuracion general</small>
        </div>
        <a href="<?php echo APP_URL; ?>configPhoto/" class="btn btn-warning ">
            <i class="bi bi-image"></i>
            Editar Logo
        </a>
    </div>
</div>

<div class="container py-4">
    <?php
    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
    ?>
        <form action="<?php echo APP_URL; ?>app/ajax/configuracionAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" class="FormularioAjax">

            <input type="hidden" name="modulo_configuracion" value="actualizar">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="configuracion_nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="configuracion_nombre" name="configuracion_nombre"
                        value="<?php echo $datos['configuracion_nombre']; ?>"
                        placeholder="Nombre de la empresa o perfil" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ .-]{3,60}" maxlength="60" required>
                </div>
                <div class="col-md-6">
                    <label for="configuracion_telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="configuracion_telefono" name="configuracion_telefono"
                        value="<?php echo $datos['configuracion_telefono']; ?>"
                        placeholder="+54 341 1234567"
                        pattern="\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}"
                        maxlength="20" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="configuracion_direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="configuracion_direccion" name="configuracion_direccion"
                    value="<?php echo $datos['configuracion_direccion']; ?>"
                    placeholder="Calle y número" 
                    maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="configuracion_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="configuracion_email" name="configuracion_email"
                        value="<?php echo $datos['configuracion_email']; ?>"
                        placeholder="ejemplo@email.com" maxlength="70" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="configuracion_cuit" class="form-label">CUIT</label>
                    <input type="text" class="form-control" id="configuracion_cuit" name="configuracion_cuit"
                        value="<?php echo $datos['configuracion_cuit']; ?>"
                        placeholder="Ej: 30-12345678-9" pattern="\d{2}-\d{8}-\d{1}" maxlength="13" required>
                </div>
                <div class="col-md-6">
                    <label for="configuracion_inicio_actividad" class="form-label">Inicio de actividad</label>
                    <input type="date" class="form-control" id="configuracion_inicio_actividad" name="configuracion_inicio_actividad"
                        value="<?php echo $datos['configuracion_inicio_actividad']; ?>"
                        required>
                </div>

            </div>

            <div class="text-center">
                <button type="reset" class="btn btn-outline-primary rounded-pill me-2">Limpiar</button>
                <button type="submit" class="btn btn-success rounded-pill">Guardar configuración</button>

            </div>
        </form>
    <?php
    } else {
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>