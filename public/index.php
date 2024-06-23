<?php
session_start();

require_once '../config/config.php';
require_once '../app/controllers/AuthController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        if (isset($_SESSION['username'])) {
            require_once '../app/views/home.php';
        } else {
            header('Location: /login');
        }
        break;
    case '/register':
        $authController = new AuthController();
        $authController->register();
        break;
    case '/login':
        $authController = new AuthController();
        $authController->login();
        break;
    case '/logout':
        $authController = new AuthController();
        $authController->logout();
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
?>