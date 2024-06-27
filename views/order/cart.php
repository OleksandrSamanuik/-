<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/controllers/OrderController.php';

$orderController = new OrderController();
$orderDetails = $orderController->getOrderDetailsCart();
$totalAmount = $orderController->getOrderTotal();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/styles.css">

</head>
<body>
    <?php include '../../views/layout/header.php'; ?>

    <div class="container">
        <h2>Order Details</h2>
        <?php if (!empty($orderDetails)): ?>
            <form id="updateOrderForm">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                            <tr id="row_<?php echo $item['product_id']; ?>">
                                <td><?php echo $item['product_id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['price']; ?></td>
                                <td>
                                    <input type="number" name="quantity_<?php echo $item['product_id']; ?>" value="<?php echo $item['quantity']; ?>" class="form-control" min="1">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFromOrder(<?php echo $item['product_id']; ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-right">
                    <button type="button" class="btn btn-primary" onclick="updateOrder()">Update Order</button>
                </div>
            </form>
            <div class="text-right mt-3">
                <h4>Total Amount: $<?php echo number_format($totalAmount, 2); ?></h4>
                <button type="button" class="btn btn-success" onclick="placeOrder()">Place Order</button>
            </div>
        <?php else: ?>
            <p>No items in order.</p>
        <?php endif; ?>
    </div>

    <?php require_once BASE_PATH . '/views/layout/footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        function updateOrder() {
            var formData = $('#updateOrderForm').serialize();
            $.ajax({
                type: 'POST',
                url: 'update_order.php',
                data: formData,
                success: function(response) {
                    alert('Order updated successfully.');
                    // Optionally, update any UI elements or perform additional actions after successful update
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order:', error);
                    alert('Failed to update order. Please try again.');
                }
            });
        }

        function removeFromOrder(productId) {
            $.ajax({
                type: 'POST',
                url: 'remove_product.php',
                data: { product_id: productId },
                success: function(response) {
                    $('#row_' + productId).remove();
                    alert('Product removed from order.');
                },
                error: function(xhr, status, error) {
                    console.error('Error removing product:', error);
                    alert('Failed to remove product from order. Please try again.');
                }
            });
        }

        function placeOrder() {
            $.ajax({
                type: 'POST',
                url: 'place_order.php',
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Order placed successfully.');
                        window.location.reload(); // Reload page or redirect to another page
                    } else {
                        alert('Failed to place order. ' + result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error placing order:', error);
                    alert('Failed to place order. Please try again.');
                }
            });
        }



    </script>
</body>
</html>
