<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/controllers/ProductController.php';

// Створення об'єкту контролера продуктів
$productController = new ProductController();

// Обробка POST-запитів
$productController->handleRequest();

// Виклик методу list для отримання всіх продуктів
$products = $productController->list();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/list.css">
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>
    <div class="container">
        <h2 class="mt-4">Products</h2>
        <a href="/myshop/views/product/create.php" class="btn btn-primary mb-2">Add New Product</a>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-6 col-md-6" id="product-<?php echo $product['id']; ?>">
                    <div class="card product-card">
                        <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                            <a href="/myshop/views/product/edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="/myshop/views/product/list.php">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
