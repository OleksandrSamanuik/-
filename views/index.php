<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Clothing Store</title>
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
</head>
<body>
    <?php
    session_start();
    require_once __DIR__ . '/../config/config.php';

    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        include BASE_PATH . '/views/layout/adminheader.php';
    } else {
        include BASE_PATH . '/views/layout/header.php';
    }
    ?>
    <div class="container">
        <h1>Welcome to Our Clothing Store</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque magna eget ligula condimentum, sed finibus enim vestibulum.</p>
        <a href="/myshop/index.php?url=category/list" class="btn">View Categories</a>
    </div>
    <?php include BASE_PATH . '/views/layout/footer.php'; ?>
</body>
</html>
