<?php
require_once '../../config/config.php';
require_once '../../models/Product.php';
require_once '../../models/Category.php';
require_once '../../controllers/ProductController.php';

$productController = new ProductController();

// Використання гетер для отримання доступу до $categoryModel
$categoryModel = $productController->getCategoryModel();

$id = $_GET['id'];
$product = $productController->getProductModel()->getProductById($id);
$categories = $categoryModel->getAllCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Обробка завантаження зображення
    $imagePath = '';
    if ($_FILES['image']['size'] > 0) {
        $uploadDir = BASE_PATH . '/assets/images/products/';
        $imageName = $_FILES['image']['name'];
        $imagePath = '/myshop/assets/images/products/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }

    if ($productController->getProductModel()->updateProduct($id, $categoryId, $name, $description, $price, $imagePath)) {
        header('Location: /myshop/view/product/list.php');
        exit();
    } else {
        echo "Failed to update product";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>
    <div class="container">
        <?php include 'form.php'; ?>
    </div>
    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
