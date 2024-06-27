<?php
require_once BASE_PATH . '/models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Инициализация сессии, если еще не запущена
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                header('Location: /myshop/index.php');
                exit();
            } else {
                echo "Invalid username or password";
            }
        } else {
            require_once BASE_PATH . 'views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = isset($_POST['role']) ? $_POST['role'] : 'user';

            if ($this->userModel->register($username, $password, $email, $role)) {
                header('Location: /myshop/index.php?url=auth/login');
                exit();
            } else {
                echo "Registration failed";
            }
        } else {
            require_once BASE_PATH . 'views/auth/register.php';
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Инициализация сессии, если еще не запущена
        }
        session_unset();
        session_destroy();
        header('Location: /myshop/index.php?url=auth/login');
        exit();
    }

    public function printSessionUserId() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Инициализация сессии, если еще не запущена
        }
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            echo "<script>console.log('User ID from session:', $userId);</script>";
        } else {
            echo "<script>console.log('User ID not found in session');</script>";
        }
    }
}
?>
