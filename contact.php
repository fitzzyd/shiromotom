<?php

include 'components/connect.php';

session_start();

// Initialize user variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // User ID
$name = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // User name
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; // User email

// Check if the user is logged in
if ($user_id === '') {
    // User is not logged in, redirect to login page or show a message
    header("Location: login.php"); // Redirect to login page
    exit; // Stop further execution
}

// Initialize message array for feedback
$message = []; // Ensure this is always an array

// Handle form submission
if (isset($_POST['send'])) {
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitize the message input

    // Check if the message already exists
    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND message = ?");
    $select_message->execute([$name, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Already sent message!'; // Append to the array
    } else {
        // Insert message with user information
        $insert_message = $conn->prepare("INSERT INTO `messages` (user_id, name, email, message) VALUES (?, ?, ?, ?)");
        if ($insert_message->execute([$user_id, $name, $email, $msg])) {
            $message[] = 'Sent message successfully!'; // Append to the array
        } else {
            $message[] = 'Failed to send message. Please try again.'; // Append to the array
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Get in touch</h3> 
      <textarea name="msg" class="box" placeholder="Enter your Message/Concern" cols="30" rows="10" required></textarea>
      <input type="submit" value="Send Message" name="send" class="btn">
   </form>

   <?php
   // Display messages
   if (!empty($message) && is_array($message)) { // Check if $message is an array and not empty
       foreach ($message as $msg) {
           echo '<p class="message">' . htmlspecialchars($msg) . '</p>'; // Display messages with HTML escape
       }
   }
   ?>

</section>

</body>
</html>