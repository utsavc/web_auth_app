<?php
require '../app/controllers/AuthController.php';
$controller = new AuthController();

if (isset($_GET['username']) && isset($_GET['token'])) {
    $controller->reAuthenticate();
}



?>