<?php
require_once '../../config/config.php';
require_once '../../models/Category.php';
require_once '../../controllers/CategoryController.php';

$categoryController = new CategoryController();

$id = $_GET['id'];
$category = $categoryController->categoryModel->getCategoryById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryController->edit([$id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>
    <div class="container">
        <?php include '../category/form.php'; ?>
    </div>
    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
