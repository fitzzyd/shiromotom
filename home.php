<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/iphones.png" alt="">
         </div>
         <div class="content">
            <span>Latest Smartphones</span>
            <h3>Best Value</h3>
            <a href="shop.php" class="btn">Shop Now</a>
         </div>
         </div>

         <div class="swiper-slide slide">
         <div class="image">
            <img src="images/haha.png" alt="">
         </div>
         <div class="content">
            <span>Discover Your Perfect Phone</span>
            <h3>VERSUS</h3>
            <a href="compare.php" class="btn">Compare</a>
         </div>
      </div>
      
      </section>

    

   
   
   
   



      <h1 class="heading">Featured Products</h1>
<section class="home-products">


   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE `stock` > 0 LIMIT 3"); 
      $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <?php if(isset($_SESSION['user_id'])): // Only show the wishlist button if the user is signed in ?>
         <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <?php endif; ?>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye" <?php echo !isset($_SESSION['user_id']) ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>></a>      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
    <div class="price <?= empty($user_id) ? 'blurred' : ''; ?>">
    <span>₱ </span><?= number_format($fetch_product['price'], 2); ?>
         </div>
         <?php if(isset($_SESSION['user_id'])): // Only show these if the user is signed in ?>
    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
    <?php endif; ?>
   </div>
   <?php if(isset($_SESSION['user_id'])): // Only show the button if the user is signed in ?>

      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <?php endif; ?>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>



<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   autoplay: {
      delay: 3000, // Change this value to adjust the speed of the auto slide
      disableOnInteraction: false, // Keeps autoplay after user interactions
   },
});

</script>

</body>
</html>