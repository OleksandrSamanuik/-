<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php include '../views/layout/header.php'; ?>
    <div class="container">
        <h2>Order Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $detail): ?>
                    <tr>
                        <td><?php echo $detail['product_name']; ?></td>
                        <td><?php echo $detail['quantity']; ?></td>
                        <td><?php echo $detail['price']; ?></td>
                        <td><?php echo $detail['quantity'] * $detail['price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/myshop/index.php?url=order/list/<?php echo $userId; ?>" class="btn">Back to Orders</a>
    </div>
    <?php include '../views/layout/footer.php'; ?>
</body>
</html>
