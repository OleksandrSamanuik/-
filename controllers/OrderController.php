<?php
require_once BASE_PATH . '/models/Product.php';
require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/OrderDetails.php';

class OrderController {
    public function __construct() {
        // Ініціалізуємо сесію, якщо вона ще не існує
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function addToOrder($productId, $quantity) {
        // Отримання інформації про товар (за потреби)
        $productModel = new Product();
        $product = $productModel->getProductById($productId);

        if (!$product) {
            return json_encode(['success' => false, 'message' => 'Product not found']);
        }

        // Перевірка, чи існує замовлення в сесії
        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = [];
        }

        // Перевірка, чи такий товар вже є в замовленні
        $found = false;
        foreach ($_SESSION['order'] as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // Якщо товару немає в замовленні, додаємо його
        if (!$found) {
            $_SESSION['order'][] = [
                'product_id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }

        return json_encode(['success' => true, 'message' => 'Product added to order']);
    }

    public function removeFromOrder($productId) {
        // Перевірка, чи існує замовлення в сесії
        if (isset($_SESSION['order'])) {
            // Пошук товару з вказаним product_id у замовленні
            foreach ($_SESSION['order'] as $key => $item) {
                if ($item['product_id'] == $productId) {
                    // Видаляємо товар з замовлення
                    unset($_SESSION['order'][$key]);
                    return json_encode(['success' => true, 'message' => 'Product removed from order']);
                }
            }
        }

        return json_encode(['success' => false, 'message' => 'Product not found in order']);
    }

    public function updateOrder($productId, $quantity) {
        // Перевірка, чи існує замовлення в сесії
        if (isset($_SESSION['order'])) {
            // Оновлюємо кількість товару з вказаним product_id у замовленні
            foreach ($_SESSION['order'] as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $quantity;
                    return json_encode(['success' => true, 'message' => 'Order updated']);
                }
            }
        }

        return json_encode(['success' => false, 'message' => 'Product not found in order']);
    }

    public function getOrderTotal() {
        $totalAmount = 0;

        // Підрахунок загальної суми замовлення на основі даних з сесії
        if (isset($_SESSION['order'])) {
            foreach ($_SESSION['order'] as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }
        }

        return $totalAmount;
    }

    public function placeOrder() {
        // Перевірка, чи є замовлення в сесії і чи не є воно пустим
        if (!isset($_SESSION['order']) || empty($_SESSION['order'])) {
            error_log('No order found in session or order is empty');
            return json_encode(['success' => false, 'message' => 'No items in order']);
        }

        // Отримання userId з сесії
        $userId = $_SESSION['user_id'];

        // Отримання загальної суми замовлення
        $totalAmount = $this->getOrderTotal();
        error_log('Total amount of order: ' . $totalAmount);

        // Створення нового замовлення в базі даних
        $orderModel = new Order();
        $orderId = $orderModel->createOrder($userId, $totalAmount);

        if (!$orderId) {
            error_log('Failed to create order in database');
            return json_encode(['success' => false, 'message' => 'Failed to create order']);
        }

        // Додавання деталей замовлення в базу даних
        $orderDetailsModel = new OrderDetails();
        foreach ($_SESSION['order'] as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $result = $orderDetailsModel->addOrderDetail($orderId, $productId, $quantity, $price);

            if (!$result) {
                error_log('Failed to add order detail for product ' . $productId);
                return json_encode(['success' => false, 'message' => 'Failed to add order detail']);
            }
        }

        // Після успішного збереження в базі даних, очищаємо замовлення з сесії
        unset($_SESSION['order']);
        error_log('Order placed successfully with order ID: ' . $orderId);

        return json_encode(['success' => true, 'message' => 'Order placed successfully']);
    }


    public function getinfo() {
        if (!isset($_SESSION['order']) || empty($_SESSION['order'])) {
            return json_encode(['success' => false, 'message' => 'Order is empty']);
        }

        return json_encode(['success' => true, 'order_items' => $_SESSION['order']]);
    }

    public function getOrderDetails($orderId) {
        $orderDetailsModel = new OrderDetails();
        $orderDetails = $orderDetailsModel->getOrderDetailsByOrderId($orderId);

        // Отримання деталей товарів (назви продуктів) з бази даних або іншого джерела
        foreach ($orderDetails as &$detail) {
            $productModel = new Product();
            $product = $productModel->getProductById($detail['product_id']);

            if ($product) {
                $detail['name'] = $product['name'];
            } else {
                $detail['name'] = 'Product Not Found'; // Можна встановити позначку, яка показує відсутність назви
            }
        }

        return $orderDetails;
    }


    public function getAllOrders() {
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();

        // Додатково отримуємо деталі для кожного замовлення
        foreach ($orders as &$order) {
            $orderDetails = $this->getOrderDetails($order['id']);
            $order['order_details'] = $orderDetails;
        }

        return $orders;
    }
    public function getOrderDetailsCart() {
        // Повертаємо деталі замовлення з сесії, якщо вони є
        if (isset($_SESSION['order'])) {
            return $_SESSION['order'];
        }
        return [];
    }
}
?>
