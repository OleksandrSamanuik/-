<?php
require_once BASE_PATH . '/config/config.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = connect();
    }

    public function getCartItems($userId) {
        $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        return $stmt->execute();
    }

    public function updateCartItem($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $id);
        return $stmt->execute();
    }

    public function removeCartItem($id) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
