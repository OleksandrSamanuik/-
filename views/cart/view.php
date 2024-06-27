<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/controllers/OrderController.php';

$orderController = new OrderController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $productId = $_POST['product_id'];
        switch ($_POST['action']) {
            case 'add':
                $quantity = $_POST['quantity'];
                $orderController->addToCart($productId, $quantity);
                break;
            case 'remove':
                $orderController->removeFromCart($productId);
                break;
            case 'update':
                $quantity = $_POST['quantity'];
                $orderController->updateCart($productId, $quantity);
                break;
            case 'order':
                $userId = $_POST['user_id']; // Replace with actual user ID
                if ($orderController->placeOrder($userId)) {
                    header('Location: order_success.php');
                    exit();
                } else {
                    $errorMessage = "Failed to place order.";
                }
                break;
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Shopping Cart</h2>
        <?php if (!empty($cartItems)): ?>
            <form action="<?php echo BASE_URL; ?>/views/order/cart.php" method="POST">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo $item['product_id']; ?></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" value="<?php echo $item['quantity']; ?>" min="1">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary update-cart" type="submit" name="action" value="update" data-product-id="<?php echo $item['product_id']; ?>">Update</button>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $orderController->getProductPrice($item['product_id']); ?></td> <!-- Replace with actual function call -->
                                <td><?php echo $orderController->getProductPrice($item['product_id']) * $item['quantity']; ?></td> <!-- Replace with actual function call -->
                                <td>
                                    <button type="submit" name="action" value="remove" class="btn btn-danger" data-product-id="<?php echo $item['product_id']; ?>">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="action" value="order" class="btn btn-success btn-block">Place Order</button>
                <input type="hidden" name="user_id" value="1"> <!-- Change this to the actual user ID -->
            </form>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
