<?php

require_once 'app/controllers/auth.php';
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');


switch ($uri) {
    case '':
        require_once 'app/views/home.php';
        break;
    case 'register':
        $authController = new AuthController();
        $authController->register_controller();
        break;
    case 'login':
        $authController = new AuthController();
        $authController->login_controller();
        break;
    case 'logout':
        $authController = new AuthController();
        $authController->logout_controller();
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
?>