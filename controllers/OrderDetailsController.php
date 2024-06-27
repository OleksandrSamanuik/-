<?php
require_once '../models/OrderDetails.php';

class OrderDetailsController {
    private $orderDetailsModel;

    public function __construct() {
        $this->orderDetailsModel = new OrderDetails();
    }

    public function view($params) {
        $orderId = $params[0];
        $orderDetails = $this->orderDetailsModel->getOrderDetailsByOrderId($orderId);
        require_once '../views/order/details.php';
    }
    public function getOrderDetails($orderId) {
    $orderDetailsModel = new OrderDetails();
    return $orderDetailsModel->getOrderDetailsByOrderId($orderId);
}

}
?>
