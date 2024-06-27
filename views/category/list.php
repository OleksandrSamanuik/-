
<?php
require_once '../../config/config.php';
require_once '../../models/Category.php';
require_once '../../controllers/CategoryController.php';

// Створення об'єкту контролера категорій
$categoryController = new CategoryController();

// Обробка POST-запитів
$categoryController->handleRequest();

// Виклик методу list для отримання всіх категорій
$categories = $categoryController->list();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <!-- Підключення Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php include '../layout/adminheader.php'; ?>
    <div class="container">
        <h2 class="mt-4">Categories</h2>
        <a href="/myshop/views/category/create.php" class="btn btn-primary mb-2">Add New Category</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr id="category-<?php echo $category['id']; ?>">
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td><?php echo $category['description']; ?></td>
                        <td>
                            <a href="/myshop/views/category/edit.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="/myshop/views/category/list.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <!-- Підключення Bootstrap JS та jQuery (необхідно для певних функцій Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <?php include '../layout/footer.php'; ?>
</body>
</html>
