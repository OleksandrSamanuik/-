<?php
require_once BASE_PATH . '/models/User.php';

class UserController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function registerUser($username, $password, $email) {
        // Валідація вхідних даних - в цьому прикладі лише базова перевірка
        if (empty($username) || empty($password) || empty($email)) {
            return json_encode(['success' => false, 'message' => 'All fields are required']);
        }

        // Перевірка, чи користувач з таким іменем вже існує
        $existingUser = $this->userModel->getUserByUsername($username);
        if ($existingUser) {
            return json_encode(['success' => false, 'message' => 'Username already exists']);
        }

        // Реєстрація нового користувача
        $registered = $this->userModel->register($username, $password, $email);
        if ($registered) {
            return json_encode(['success' => true, 'message' => 'User registered successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Registration failed']);
        }
    }

    public function getAllUsers() {
    // Отримання всіх користувачів
    return $this->userModel->getAllUsers();
    }


    public function deleteUser($userId) {
        // Видалення користувача за його ID
        $deleted = $this->userModel->deleteUser($userId);
        if ($deleted) {
            return json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }

  
}
?>
