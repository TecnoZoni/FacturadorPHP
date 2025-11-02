<div class="container-fluid mb-4">
    <?php
    $id = 1;
    ?>
    <h2 class="h5 text-muted">Actualizar logo de perfil</h2>

</div>

<div class="container py-4">
    <?php
    include "./app/views/inc/btn_back.php";
    $datos = $insMain->seleccionarDatos("Unico", "configuracion", "configuracion_id", 1);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
    ?>

        <h2 class="h4 text-center"><?php echo $datos['configuracion_nombre'] ?></h2>

        <div class="row">
            <div class="col-md-5">
                <?php if (is_file("./app/views/fotos/" . $datos['configuracion_logo'])) { ?>
                    <div class="mb-4 text-center">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/<?php echo $datos['configuracion_logo']; ?>" class="rounded-circle img-fluid" alt="Logo de la empresa">
                    </div>

                    <form class="FormularioAjax text-center" action="<?php echo APP_URL; ?>app/ajax/configuracionAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_configuracion" value="eliminarFoto">
                        <input type="hidden" name="configuracion_id" value="<?php echo $datos['configuracion_id']; ?>">
                        <button type="submit" class="btn btn-danger rounded-pill">Eliminar logo</button>
                    </form>
                <?php } else { ?>
                    <div class="mb-4 text-center">
                        <img src="" class="rounded-circle img-fluid" alt="Sin Logo">
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-7">
                <form class="FormularioAjax text-center mb-4" action="<?php echo APP_URL; ?>app/ajax/configuracionAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="modulo_configuracion" value="actualizarFoto">
                    <input type="hidden" name="configuracion_id" value="<?php echo $datos['configuracion_id']; ?>">

                    <label class="form-label">Fogo o imagen de la empresa</label>
                    <input type="file" class="form-control mb-2" name="configuracion_logo" accept=".jpg, .png, .jpeg">
                    <div class="form-text mb-3">Formatos permitidos: JPG, JPEG, PNG. (MAX 5MB)</div>

                    <button type="submit" class="btn btn-success rounded-pill">Actualizar logo</button>
                </form>
            </div>
        </div>

    <?php
    } else {
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>