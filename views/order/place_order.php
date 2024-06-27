<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/controllers/OrderController.php';

$orderController = new OrderController();
$result = $orderController->placeOrder();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
