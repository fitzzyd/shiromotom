<?php
include 'components/connect.php';

$message = [];

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email address!';
    } else {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() > 0) {
            // Generate reset code and expiration
            $code = rand(100000, 999999); // Generate a 6-digit random code
$expires = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Set expiration time

// Save the reset code and expiration in the database
$conn->prepare("UPDATE `users` SET reset_code = ?, reset_expires = ? WHERE email = ?")
     ->execute([$code, $expires, $email]);

            // Send email with PHPMailer
            require 'send_email.php'; // Separate email logic
            sendPasswordResetEmail($email, $code);

            header('Location: verify_code.php?email=' . urlencode($email)); // Pass email to verify.php
            exit(); // Ensure no further code is executed
        } else {
            $message[] = 'Email not found!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="formheader-container">
    <form action="" method="post">
        <h3>Forgot Password</h3>
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box">
        <input type="submit" value="Send Reset Code" class="btn" name="submit">
    </form>
    <?php if (isset($message)) { foreach ($message as $msg) { echo '<p>'.$msg.'</p>'; } } ?>
</section>
</body>
</html>
