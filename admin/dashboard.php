<?php

include '../components/connect.php';
include '../components/header.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

$count_messages_query = $conn->prepare("SELECT COUNT(*) as total_messages FROM `messages`");
$count_messages_query->execute();
$message_count = $count_messages_query->fetch(PDO::FETCH_ASSOC)['total_messages'];

// Count total users
$select_users = $conn->prepare("SELECT * FROM `users`");
$select_users->execute();
$number_of_users = $select_users->rowCount()


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
        <?php include '../components/sidebar.php'; ?>
        <main>
        <div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
				<li>
            <?php
            $total_paid = 0; // Initialize total paid variable
            $select_paid_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_paid_orders->execute(['paid']); // Fetch only paid orders
            if($select_paid_orders->rowCount() > 0){
                while($fetch_paid_order = $select_paid_orders->fetch(PDO::FETCH_ASSOC)){
                    $total_paid += $fetch_paid_order['total_price']; // Sum total price of paid orders
                }
            }
         ?>
         <h3><span>₱ </span><?= $total_paid; ?></h3>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<p>Total paid order</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
               <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
         <h3><?= $number_of_users; ?></h3>
						<p>User</p>
					</span>
				</li>
				<li>
					<i class='bx bx-package' ></i>
               <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
					<span class="text">
               <h3><?= $number_of_orders; ?></h3>
						<p>Orders Placed</p>
					</span>

               
				</li>
            <li>
            <i class='bx bxs-message'></i> <!-- You can choose a different icon -->
            <span class="text">
                <h3><?= htmlspecialchars($message_count); ?></h3>
                <p>Messages</p>
            </span>
        </li>
        <li>
        <i class='bx bxl-product-hunt'></i>
              <?php
// Prepare the SQL statement to count the total number of products
      $select_products = $conn->prepare("SELECT COUNT(*) AS total_products FROM `products`");
         $select_products->execute();

// Fetch the total product count
      $product_count = $select_products->fetch(PDO::FETCH_ASSOC)['total_products'];
            ?>
            <span class="text">
    <h3><?= $product_count; ?></h3>
    <p>Total Products</p>
</span>
         </li>
   
            
			</ul>


			
				
			</div>
		</main>
		<!-- MAIN -->
	</section>
        
      
   

    <script src="../js/admin_script.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>