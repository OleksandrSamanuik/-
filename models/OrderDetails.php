<?php
require_once BASE_PATH . '/config/config.php';

class OrderDetails {
    private $db;

    public function __construct() {
        $this->db = connect();
    }

    public function getOrderDetailsByOrderId($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_details WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addOrderDetail($orderId, $productId, $quantity, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        return $stmt->execute();
    }


    public function deleteOrderDetailsByOrderId($orderId) {
        $stmt = $this->db->prepare("DELETE FROM order_details WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        return $stmt->execute();
    }
}
?>
