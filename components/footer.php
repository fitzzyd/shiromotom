<footer class="footer">
<?php if (isset($_SESSION['user_id'])): ?>
    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2024/11/06/20/20241106205656-B82PM9RB.js"></script>
<?php else: ?>
    <p class="login-message">Please <a href="index.php">login</a> to access more features.</p>
<?php endif; ?>

<section class="grid">
    <div class="box">
        <h3>Quick links</h3>
        <a href="home.php"> <i class="fas fa-angle-right"></i> Home</a>
        <a href="shop.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>"> <i class="fas fa-angle-right"></i> Shop</a>
        <a href="contact.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>"> <i class="fas fa-angle-right"></i> Contact</a>
        <a href="#"> <i class="fas fa-angle-right"></i> Compare</a>
    </div>

    <div class="box">
        <h3>Extra links</h3>
        <a href="user_login.php"> <i class="fas fa-angle-right"></i> Login</a>
        <a href="user_register.php"> <i class="fas fa-angle-right"></i> Register</a>
        <a href="cart.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>"> <i class="fas fa-angle-right"></i> Cart</a>
        <a href="orders.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>"> <i class="fas fa-angle-right"></i> Orders</a>
    </div>
</section>
</footer>