
<header>
    <nav>
        <ul>
            <li><a href="/myshop/views/product/index.php">Products</a></li>
            <li><a href="/myshop/views/order/cart.php">Cart</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/myshop/views/auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/myshop/views/auth/login.php">Login</a></li>
                <li><a href="/myshop/views/auth/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
function redirectTo(url) {
    window.location.href = url;
}
</script>
