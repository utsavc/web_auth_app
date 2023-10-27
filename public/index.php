<?php
require '../app/controllers/AuthController.php';

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'register') {
        $controller->register();
    } elseif ($_POST['action'] === 'login') {
        $controller->login();
    }
}

// Load the appropriate view
if (isset($_GET['page'])) {
    if ($_GET['page'] === 'register') {
        $controller->showRegisterForm();
    } elseif ($_GET['page'] === 'login') {
        $controller->showLoginForm();
    } elseif($_GET['page'] === 'logout'){
        $controller->logout();
    }
}
?>
