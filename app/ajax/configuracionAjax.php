<?php

require_once "../../config/app.php";
require_once  "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\configController;

if (isset($_POST["modulo_configuracion"])) {

    $insConfig = new configController();

    if ($_POST["modulo_configuracion"] == "actualizar") {
        echo $insConfig->actualizarConfiguracionControlador();
    }
    if ($_POST["modulo_configuracion"] == "eliminarFoto") {
        echo $insConfig->eliminarFotoConfiguracionControlador();
    }
    if ($_POST["modulo_configuracion"] == "actualizarFoto") {
        echo $insConfig->actualizarFotoConfiguracionControlador();
    }
} else {
    session_destroy();
    header("Location: " . APP_URL . "dashboard/");
}
