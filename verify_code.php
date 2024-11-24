<?php
include 'components/connect.php';

$message = [];

if (isset($_POST['verify'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $code = $_POST['code'];

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND reset_code = ? AND reset_expires > NOW()");
    $stmt->execute([$email, $code]);

    if ($stmt->rowCount() > 0) {
        session_start();
        $_SESSION['reset_email'] = $email;
        header('Location: reset_password.php');
        exit;
    } else {
        $message[] = 'Invalid or expired reset code!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="formheader-container">
    <form action="" method="post">
        <h3>Verify Code</h3>
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box">
        <input type="text" name="code" required placeholder="Enter the verification code" maxlength="6" class="box">
        <input type="submit" value="Verify Code" class="btn" name="verify">
    </form>
    <?php if (isset($message)) { foreach ($message as $msg) { echo '<p>'.$msg.'</p>'; } } ?>
</section>
</body>
</html>
