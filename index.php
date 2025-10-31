<?php
require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/inc/session_start.php";

if (isset($_GET["views"])) {
    $url = explode("/", $_GET["views"]);
} else {
    $url = ["dashboard"];
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once "./app/views/inc/head.php"; ?>

<body>

    <?php

    use app\controllers\viewsController;
    use app\models\mainModel;

    $viewsController = new viewsController();
    $insMain = new mainModel();

    $vista = $viewsController->obtenerVistasContolador($url[0]);

    if ($vista == "404") {
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {

        require_once "./app/views/inc/navbar.php";

        require_once $vista;
    }

    include_once "./app/views/inc/script.php";
    ?>
</body>

</html>