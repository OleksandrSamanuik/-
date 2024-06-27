<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/controllers/CategoryController.php';
require_once BASE_PATH . '/controllers/ProductController.php';
require_once BASE_PATH . '/controllers/OrderController.php';

$categoryController = new CategoryController();
$productController = new ProductController();
$orderController = new OrderController();

// Ініціалізація сесії, якщо вона ще не існує
if (!isset($_SESSION)) {
    session_start();
}

// Обробка POST-запитів
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add' && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            $result = json_decode($orderController->addToOrder($productId, 1), true);

            if ($result['success']) {
                $_SESSION['message'] = $result['message'];
            } else {
                $_SESSION['message'] = 'Failed to add product to order.';
            }
        } elseif ($_POST['action'] === 'remove' && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            $result = json_decode($orderController->removeFromOrder($productId), true);

            if ($result['success']) {
                $_SESSION['message'] = $result['message'];
            } else {
                $_SESSION['message'] = 'Failed to remove product from order.';
            }
        }
        // Після обробки POST-запитів перенаправлення на той же URL, щоб уникнути повторних відправок форми
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Отримання інформації про замовлення з сесії
$orderDetails = isset($_SESSION['order']) ? $_SESSION['order'] : [];

// Отримання категорій для фільтрації
$categories = $categoryController->list();

// Отримання товарів на основі фільтрів
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $categoryId = $_GET['category'];
    $products = $productController->getByCategory($categoryId);
} elseif (isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = $_GET['search'];
    $products = $productController->search($keyword);
} else {
    $products = $productController->list();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/styles.css">

</head>
<body>
    <?php require_once BASE_PATH . '/views/layout/header.php'; ?>

    <main class="product-list">
        <section class="container">
            <h2 class="text-center mb-4">Product Catalog</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <p class="text-center">No products found.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card product-card">
                                <img src="<?php echo $product['image_path']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                    <p class="card-text"><?php echo $product['description']; ?></p>
                                    <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                                    <?php if (in_array($product['id'], array_column($orderDetails, 'product_id'))): ?>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger btn-action btn-remove">Remove from Order</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="add">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-primary btn-action btn-add">Add to Order</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php require_once BASE_PATH . '/views/layout/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
