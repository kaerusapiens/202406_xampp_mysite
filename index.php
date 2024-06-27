<?php
session_start();

require_once 'libs/yaml_parser.php'; 
require_once 'app/controllers/auth.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//var_dump($uri); //debugging

switch ($uri) {
    case '/':
        require_once 'app/views/home.php';
        break;
    case '/register':
        require_once 'app/controllers/pw_validation.php';
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