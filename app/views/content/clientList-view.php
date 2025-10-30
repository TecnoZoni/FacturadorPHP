<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">Usuarios</h1>
            <small class="text-muted">Lista de usuarios</small>
        </div>
        <a href="<?php echo APP_URL; ?>clientNew/" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo usuario
        </a>
    </div>
</div>

<div class="container py-4">
    <?php

    use app\controllers\clientController;

    $insCliente = new clientController();
    echo $insCliente->listarClienteControlador($url[1], 10, $url[0], "");
    ?>
</div>