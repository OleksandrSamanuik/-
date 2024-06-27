<?php
require_once '../../config/config.php';
require_once '../../models/Product.php';
require_once '../../models/Category.php';
require_once '../../controllers/ProductController.php';

$productController = new ProductController();

// Використовуємо гетер для отримання доступу до $categoryModel
$categoryModel = $productController->getCategoryModel();
$categories = $categoryModel->getAllCategories();

$errors = [];

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

        // Переміщуємо завантажене зображення в папку products, якщо такої папки ще не існує
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Створюємо директорію з правами доступу 0777
        }

        $targetPath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    } else {
        $errors[] = 'Please upload an image.';
    }

    if (empty($errors)) {
        if ($productController->getProductModel()->createProduct($categoryId, $name, $description, $price, $imagePath)) {
            header('Location: /myshop/views/product/list.php');
            exit();
        } else {
            echo "Failed to create product";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>
    <div class="container">
        <h2 class="mt-4">Create Product</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="/myshop/views/product/create.php" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </div>
    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
