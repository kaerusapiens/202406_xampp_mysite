<?php
require_once 'app/models/users.php';
session_start();

class AuthController {
    private $userModel;
    private $sessionModel;
    public function __construct() {
        $this->userModel = new User();

    }

    public function register_controller() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => trim($_POST['user_id']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];
            if ($data['password'] == $data['confirm_password']) {
            // Attempt to register user
                $result = $this->userModel->register($data);
                
                if ($result === true) {
                    echo "Registration successful!";
                    $session_id = session_create_id(); // Generate session ID
                
                    // Insert session into session database
                    $insert_result = $this->sessionModel->insertSession($user_id, $session_id);
                    exit;
                } else {
                    echo $result;
                    exit; // Error message from registration attempt
                }
            } else {
                echo 'Passwords do not match.';
            }
        } 
        else {
            require_once 'app/views/register.php';
        }
    }

    public function login_controller() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => trim($_POST['user_id']),
                'password' => trim($_POST['password'])
            ];

            $loggedInUser = $this->userModel->login($data['user_id'], $data['password']);

            if ($loggedInUser) {
                $_SESSION['session_id'] = $loggedInUser->id;
                $_SESSION['session_id'] = $loggedInUser->user_id;
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