<?php
require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/inc/session_start.php";

if (isset($_GET["vista"])) {
    $url = explode("/", $_GET["vista"]);
} else {
    $url = ["login"];
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once "./app/views/inc/head.php"; ?>

<body>
    
    <?php include_once "./app/views/inc/script.php"; ?>
</body>

</html>