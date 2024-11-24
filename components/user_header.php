<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
         <div id="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
   }
}
?>
<link rel="stylesheet" href="css/header.css">

<header class="header">

   <section class="flex">
      <a href="home.php" class="logo"><span>Shiromoto</span></a>

      <nav class="navbar">
      <a href="home.php">HOME</a>
   <a href="shop.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>">SHOP</a>
   <a href="compare.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>">COMPARE</a>
   <a href="trending.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>">TRENDING</a>
   <a href="contact.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>">CONTACT US</a>
   <a href="orders.php" onclick="<?= empty($user_id) ? 'event.preventDefault(); window.location.href=\'index.php\';' : ''; ?>">ORDERS</a>
      </nav>

      <div class="icons">
         <?php
         $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
         $count_wishlist_items->execute([$user_id]);
         $total_wishlist_counts = $count_wishlist_items->rowCount();

         $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $count_cart_items->execute([$user_id]);
         $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php"><i class="fas fa-search"></i></a>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
               <p><?= $fetch_profile["name"]; ?></p>
               <a href="update_user.php" class="btn">Update Profile</a>
               <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>
            <?php
            } else {
            ?>
               <p>Login or Register first to proceed!</p>
               <div class="flex-btn">
                  <a href="user_register.php" class="option-btn">Register</a>
                  <a href="index.php" class="btn">Login</a>
               </div>
            <?php
            }
            ?>


         </div>

   </section>

</header>