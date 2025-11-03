<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">
            <i class="bi bi-clipboard-fill"></i>
            <strong>
                FACTURADOR
            </strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-clipboard"></i>
                        Facturas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>invoiceNew/">
                                <i class="bi bi-clipboard-plus"></i>
                                Crear Factura
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientList/">
                                <i class="bi bi-clipboard-data"></i>
                                Listar Facturas
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientSearch/">
                                <i class="bi bi-search"></i>
                                Buscar Facturas
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person"></i>
                        Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientNew/">
                                <i class="bi bi-person-add"></i>
                                Guardar Cliente
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientList/">
                                <i class="bi bi-people"></i>
                                Listar Clientes
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>clientSearch/">
                                <i class="bi bi-search"></i>
                                Buscar Cliente
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-box-seam"></i>
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productNew/">
                                <i class="bi bi-box2"></i>
                                Guardar Producto
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productList/">
                                <i class="bi bi-boxes"></i>
                                Listar Productos
                            </a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>productSearch/">
                                <i class="bi bi-search"></i>
                                Buscar Productos
                            </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <li class="nav-item navbar-nav">
            <a class="nav-link" aria-current="page" href="<?php echo APP_URL; ?>configBoard/1">
                <i class="bi bi-gear"></i>
                Configurar Usuario
            </a>
        </li>
    </div>
</nav>