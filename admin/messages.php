<?php

include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit; // It's a good practice to exit after a redirect
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
   exit; // It's a good practice to exit after a redirect
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/sidebar.php'; ?>
<?php include '../components/header.php'; ?>

<section class="contacts">
<div class="box-container">

   <?php
      // Joining messages with users to get user details
      $select_messages = $conn->prepare("
          SELECT messages.*, users.name AS user_name, users.email AS user_email 
          FROM `messages` 
          JOIN `users` ON messages.user_id = users.id
      ");
      $select_messages->execute();
      
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">   
      <p><strong>User Name:</strong> <span><?= htmlspecialchars($fetch_message['user_name']); ?></span></p>
      <p><strong>User Email:</strong> <span><?= htmlspecialchars($fetch_message['user_email']); ?></span></p>
      <p><strong>Message:</strong> <span><?= htmlspecialchars($fetch_message['message']); ?></span></p>
      <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="message-btn">Delete</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no messages</p>';
      }
   ?>

</div>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>