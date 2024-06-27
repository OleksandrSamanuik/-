<header>
    <nav>
        <ul>
            <li><a href="/myshop/views/category/list.php">Categories</a></li>
            <li><a href="/myshop/views/product/list.php">Products</a></li>
            <li><a href="/myshop/views/user/list.php">Users</a></li>
            <li><a href="/myshop/views/order/list.php">Orders</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/myshop/views/auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/myshop/views/auth/login.php">Login</a></li>
                <li><a href="/myshop/views/auth/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
