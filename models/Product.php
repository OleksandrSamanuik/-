<?php
require_once BASE_PATH . '/config/config.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = connect(); // Припускаю, що `connect()` повертає з'єднання mysqli
    }

    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function search($keyword) {
        $query = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $this->db->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bind_param('s', $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createProduct($categoryId, $name, $description, $price, $imagePath) {
        $stmt = $this->db->prepare("INSERT INTO products (category_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $categoryId, $name, $description, $price, $imagePath);
        return $stmt->execute();
    }

    public function updateProduct($id, $categoryId, $name, $description, $price, $imagePath) {
        $stmt = $this->db->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, image_path = ? WHERE id = ?");
        $stmt->bind_param("issdsi", $categoryId, $name, $description, $price, $imagePath, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
?>
