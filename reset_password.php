<?php
include 'components/connect.php';

session_start();
if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot_password.php');
    exit;
}

$message = [];

if (isset($_POST['reset'])) {
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($new_pass !== $confirm_pass) {
        $message[] = 'Passwords do not match!';
    } else {
        // Hashing the new password using SHA-1
        $hashed_pass = sha1($new_pass);
        $hashed_pass = filter_var($hashed_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = $_SESSION['reset_email'];

        try {
            // Check if the reset code is valid
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND reset_code IS NOT NULL AND reset_expires > NOW()");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Update the password and clear the reset code
                $update_stmt = $conn->prepare("UPDATE `users` SET password = ?, reset_code = NULL, reset_expires = NULL WHERE email = ?");
                $update_stmt->execute([$hashed_pass, $email]);

                if ($update_stmt->rowCount() > 0) {
                    $message[] = 'Password reset successfully! You can now log in.';
                    unset($_SESSION['reset_email']);
                    header('Location: index.php');
                    exit;
                } else {
                    $message[] = 'Password reset failed. Please try again.';
                }
            } else {
                $message[] = 'Invalid or expired reset code.';
            }
        } catch (PDOException $e) {
            $message[] = 'Error updating password: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="formheader-container">

    <form action="" method="post">
        <h3>Reset Password</h3>
        <input type="password" name="new_pass" required placeholder="Enter your new password" maxlength="20" class="box">
        <input type="password" name="confirm_pass" required placeholder="Confirm your new password" maxlength="20" class="box">
        <input type="submit" value="Reset Password" class="btn" name="reset">
    </form>
    <?php if (isset($message)) { foreach ($message as $msg) { echo '<p>'.$msg.'</p>'; } } ?>
</section>
</body>
</html>