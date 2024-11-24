<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendPasswordResetEmail($toEmail, $resetCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fitzanthonymiano@gmail.com'; // Replace with your email
        $mail->Password = 'xlxc jkdy kzzb yfqy'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@yshiromoto.com', 'Shiromoto.com');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code';
        $mail->Body = "<p>Your password reset code is:</p> <h3>{$resetCode}</h3>";

        $mail->send();
    } catch (Exception $e) {
        echo "Email error: {$mail->ErrorInfo}";
    }
}
?>
