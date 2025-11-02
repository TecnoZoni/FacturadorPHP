<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">Productos</h1>
            <small class="text-muted">Lista de productos</small>
        </div>
        <a href="<?php echo APP_URL; ?>productNew/" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo producto
        </a>
    </div>
</div>

<div class="container py-4">
    <?php

    use app\controllers\productController;

    $insProducto = new productController();
    echo $insProducto->listarProductoControlador($url[1], 10, $url[0], "");
    ?>
</div>