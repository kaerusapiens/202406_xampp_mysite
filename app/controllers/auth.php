<?php
require_once 'app/models/users.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register_controller() {
        ini_set('display_errors', 1); // Display errors on screen
        echo "Debug: Inside register_controller<br>";
        var_dump($_POST); // Check if POST data is received
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            error_log('POST request detected'); // Log to PHP error log
            echo "start post";
            $data = [
                'user_id' => trim($_POST['user_id']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];
            if ($data['password'] == $data['confirm_password']) {
                if ($this->userModel->register($data)) {
                    header('Location: /');
                    exit;
                } else {
                    die('Something went wrong.');
                }
            } else {
                die('Passwords do not match.');
            }
        } 
        else {
            echo "not yetstart post";
            require_once 'app/views/register.php';
        }
    }

    public function login_controller() {
        require_once 'app/views/login.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => trim($_POST['user_id']),
                'password' => trim($_POST['password'])
            ];

            $loggedInUser = $this->userModel->login($data['user_id'], $data['password']);

            if ($loggedInUser) {
                session_start();
                $_SESSION['session_id'] = $loggedInUser->id;
                $_SESSION['session_id'] = $loggedInUser->user_id;
                header('Location: /');
            } else {
                die('Login failed.');
            }
        } else {
            require_once 'app/views/login.php';
        }
    }

    public function logout_controller() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
    }
}
?>