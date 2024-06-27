<?php
require_once BASE_PATH . '/config/config.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = connect();
    }

    public function getAllOrders() {
        $stmt = $this->db->prepare("SELECT * FROM orders");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createOrder($userId, $totalAmount) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
        $stmt->bind_param("id", $userId, $totalAmount);
        if ($stmt->execute()) {
            return $stmt->insert_id; // Повертаємо ID нового замовлення
        }
        return false;
    }


    public function getOrderDetails($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_details WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addOrderDetails($orderId, $productId, $quantity, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        return $stmt->execute();
    }
}
?>
