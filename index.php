<?php
session_start();

require_once 'config/config.php';
require_once 'app/controllers/auth.php';

use Symfony\Component\Yaml\Yaml;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//var_dump($uri); //debugging

switch ($uri) {
    case '/':
        require_once 'app/views/home.php';
        break;
    case '/register':

        $authController = new AuthController();
        $authController->register_controller();
        break;
    case '/login':

        $authController = new AuthController();
        $authController->login_controller();
        break;
    case '/logout':
        $authController = new AuthController();
        $authController->logout_controller();
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
?>