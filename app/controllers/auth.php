<?php
require_once 'app/models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];

            if ($data['password'] == $data['confirm_password']) {
                if ($this->userModel->register($data)) {
                    header('Location: /login');
                } else {
                    die('Something went wrong.');
                }
            } else {
                die('Passwords do not match.');
            }
        } else {
            require_once 'app/views/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password'])
            ];

            $loggedInUser = $this->userModel->login($data['username'], $data['password']);

            if ($loggedInUser) {
                session_start();
                $_SESSION['user_id'] = $loggedInUser->id;
                $_SESSION['username'] = $loggedInUser->username;
                header('Location: /');
            } else {
                die('Login failed.');
            }
        } else {
            require_once 'app/views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
    }
}
?>