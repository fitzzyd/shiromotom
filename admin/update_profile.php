<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit; // Ensure the script stops after redirection
}

// Fetch the admin's profile information
$fetch_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$fetch_profile->execute([$admin_id]);
$fetch_profile = $fetch_profile->fetch(PDO::FETCH_ASSOC);

if (!$fetch_profile) {
   // Handle the case where the admin profile is not found
   $message[] = 'Profile not found!';
}

if(isset($_POST['submit'])){

   // Sanitize inputs using htmlspecialchars
   $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

   $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // SHA-1 hash of an empty string
   $prev_pass = $fetch_profile['password']; // Use the fetched password
   $old_pass = sha1($_POST['old_pass']); // Hash the old password using SHA-1
   $new_pass = sha1($_POST['new_pass']); // Hash the new password using SHA-1
   $confirm_pass = sha1($_POST['confirm_pass']); // Hash the confirm password using SHA-1

   if($old_pass == $empty_pass){
      $message[] = 'Please enter old password!';
   } elseif($old_pass != $prev_pass){
      $message[] = 'Old password not matched!';
   } elseif($new_pass != $confirm_pass){
      $message[] = 'Confirm password not matched!';
   } else {
      if($new_pass != $empty_pass){
         // Update the password using SHA-1 hashing
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$new_pass, $admin_id]); // Use the SHA-1 hashed password
         $message[] = 'Password updated successfully!';
      } else {
         $message[] = 'Please enter a new password!';
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
   <title>Update Profile</title>

   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/sidebar.php'; ?>
<?php include '../components/header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="hidden" name="prev_pass" value="<?= htmlspecialchars($fetch_profile['password']); ?>">
      <input type="text" name="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" class="btn" name="submit">
   </form>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>