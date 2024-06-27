<?php
require_once '../../config/config.php';
require_once '../../controllers/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
    <style>
        .order-details {
            display: none;
        }
    </style>
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>

    <div class="container mt-4">
        <h2>Orders</h2>
        <div class="accordion" id="orderAccordion">
            <?php foreach ($orders as $order): ?>
                <div class="card">
                    <div class="card-header" id="heading<?php echo $order['id']; ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $order['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $order['id']; ?>">
                                Order #<?php echo $order['id']; ?>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse<?php echo $order['id']; ?>" class="collapse" aria-labelledby="heading<?php echo $order['id']; ?>" data-parent="#orderAccordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p><strong>User ID:</strong> <?php echo $order['user_id']; ?></p>
                                </div>
                                <div class="col">
                                    <p><strong>Total Amount:</strong> $<?php echo $order['total_amount']; ?></p>
                                </div>
                            </div>
                            <hr>
                            <p><strong>Order Details:</strong></p>
                            <?php if (!empty($order['order_details'])): ?>
                                <ul>
                                    <?php foreach ($order['order_details'] as $detail): ?>
                                        <li>
                                            Product ID: <?php echo $detail['product_id']; ?>,
                                            Name: <?php echo $detail['name']; ?>,
                                            Price: $<?php echo $detail['price']; ?>,
                                            Quantity: <?php echo $detail['quantity']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No order details found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>

    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
