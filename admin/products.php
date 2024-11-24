<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
};

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $technology = filter_var($_POST['technology'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $announced = filter_var($_POST['announced'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $status = filter_var($_POST['status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $dimensions = filter_var($_POST['dimensions'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $weight = filter_var($_POST['weight'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $build = filter_var($_POST['build'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sim = filter_var($_POST['sim'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $display_type = filter_var($_POST['display_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $size = filter_var($_POST['size'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $resolution = filter_var($_POST['resolution'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $protection = filter_var($_POST['protection'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $os = filter_var($_POST['os'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $chipset = filter_var($_POST['chipset'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $cpu = filter_var($_POST['cpu'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $gpu = filter_var($_POST['gpu'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $card_slot = filter_var($_POST['card_slot'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $internal = filter_var($_POST['internal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $mc_modules = filter_var($_POST['mc_modules'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $mc_features = filter_var($_POST['mc_features'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $mc_video = filter_var($_POST['mc_video'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sc_modules = filter_var($_POST['sc_modules'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sc_features = filter_var($_POST['sc_features'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sc_video = filter_var($_POST['sc_video'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $loudspeaker = filter_var($_POST['loudspeaker'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sound_jack = filter_var($_POST['sound_jack'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $wlan = filter_var($_POST['wlan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $bluetooth = filter_var($_POST['bluetooth'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $positioning = filter_var($_POST['positioning'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $nfc = filter_var($_POST['nfc'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $infrared_port = filter_var($_POST['infrared_port'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $radio = filter_var($_POST['radio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $usb = filter_var($_POST['usb'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $sensors = filter_var($_POST['sensors'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $battery_type = filter_var($_POST['battery_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $charging = filter_var($_POST['charging'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $colors = filter_var($_POST['colors'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $models = filter_var($_POST['models'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");

   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exist!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO 
      `products` (
          name, details, price, image_01, image_02, image_03, technology, announced, status,
          dimensions, weight, build, sim, display_type, size, resolution, protection,
          os, chipset, cpu, gpu, mem_card_slot, mem_internal, mc_modules, mc_features, 
          mc_video, sc_modules, sc_features, sc_video, loudspeaker, sound_jack, wlan, 
          bluetooth, positioning, nfc, infrared_port, radio, usb, sensors, battery_type, 
          charging, colors, models
      ) VALUES (
          ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?
      )");
  
  // Ensure you have the correct number of variables
  $values = [
      $name,
      $details,
      $price,
      $image_01,
      $image_02,
      $image_03,
      $technology,
      $announced,
      $status,
      $dimensions,
      $weight,
      $build,
      $sim,
      $display_type,
      $size,
      $resolution,
      $protection,
      $os,
      $chipset,
      $cpu,
      $gpu,
      $card_slot,         // This should match mem_card_slot
      $internal,          // This should match mem_internal
      $mc_modules,
      $mc_features,
      $mc_video,
      $sc_modules,
      $sc_features,
      $sc_video,
      $loudspeaker,
      $sound_jack,
      $wlan,
      $bluetooth,
      $positioning,
      $nfc,
      $infrared_port,
      $radio,
      $usb,
      $sensors,
      $battery_type,
      $charging,
      $colors,
      $models,
  ];
  $insert_products->execute($values);
  
      if ($insert_products) {
         if ($image_size_01 > 2000000 or $image_size_02 > 2000000 or $image_size_03 > 2000000) {
            $message[] = 'image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }
      }
   }
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}
?>
<?php
if (isset($_POST['replenish_stock_btn'])) {
    $product_id = $_POST['product_id'];
    $additional_stock = filter_var($_POST['replenish_stock'], FILTER_SANITIZE_NUMBER_INT);

    // Update the stock in the database
    $update_stock = $conn->prepare("UPDATE `products` SET `stock` = `stock` + ? WHERE `id` = ?");
    $update_stock->execute([$additional_stock, $product_id]);

    // Store message in session
    if ($update_stock) {
        $_SESSION['message'] = 'Stock replenished successfully!';
    } else {
        $_SESSION['message'] = 'Failed to replenish stock!';
    }

    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit; // Stop further execution
}

// Display messages
if (isset($_SESSION['message'])) {
    echo '<div class="message">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Clear the message after displaying
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

<?php include '../components/sidebar.php'; ?>
<?php include '../components/header.php'; ?>

   <section class="add-products">



      <form action="" method="post" enctype="multipart/form-data" style="border: none; width: 80%">


         <div class="accordion w-100" id="accordionExample2">
            <div class="mb-3 ms-2 ">
            </div>

            <div class="accordion-item">
               <h2 class="accordion-header " id="headingOne2" >
                  <button  class="accordion-button bg-danger text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                     Product Details (required)
                  </button>
               </h2>
               <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Product Name" aria-label="ProductName" aria-describedby="basic-addon1" required>
                     </div>

                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-usd" aria-hidden="true"></i></span>
                        <input type="number" min="0" max="9999999999" class="form-control" onkeypress="if(this.value.length == 10) return false;" name="price" placeholder="Price" aria-label="Price" aria-describedby="basic-addon2" required>
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3"><i class="fa fa-info" aria-hidden="true"></i></span>
                        <input type="text" name="details" required maxlength="500" class="form-control" placeholder="Description" aria-label="Description" aria-describedby="basic-addon3" required>
                     </div>
                     <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile01">Image 1</label>
                        <input type="file" class="form-control" id="inputGroupFile01" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" required>

                     </div>
                     <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile02">Image 2</label>
                        <input type="file" class="form-control" id="inputGroupFile02" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" required>

                     </div>
                     <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile03">Image 3</label>
                        <input type="file" class="form-control" id="inputGroupFile03" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" required>

                     </div>
                  </div>
               </div>
            </div>

            <div class="accordion-item">

               <h2 class="accordion-header" id="headingTwo2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                     Network
                  </button>
               </h2>
               <div id="collapseTwo2" class="accordion-collapse collapse" aria-labelledby="headingTwo2" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-net-1"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="technology" placeholder="Technology" aria-label="Technology" aria-describedby="basic-addon-net-1">
                     </div>

                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="headingThree2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree2" aria-expanded="false" aria-controls="collapseThree2">
                     Launch
                  </button>
               </h2>
               <div id="collapseThree2" class="accordion-collapse collapse" aria-labelledby="headingThree2" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-lan-1"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="announced" placeholder="Announced" aria-label="Announced" aria-describedby="basic-addon-lan-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-lan-2"><i class="fa fa-tasks" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="status" placeholder="Status" aria-label="Status" aria-describedby="basic-addon-lan-2">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                     Body
                  </button>
               </h2>
               <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bod-1"><i class="fa fa-arrows-h" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="dimensions" placeholder="Dimensions" aria-label="Dimensions" aria-describedby="basic-addon-bod-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bod-2"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="weight" placeholder="Weight" aria-label="Weight" aria-describedby="basic-addon-bod-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bod-3"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="build" placeholder="Build" aria-label="Build" aria-describedby="basic-addon-bod-3">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bod-4"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sim" placeholder="Sim" aria-label="Sim" aria-describedby="basic-addon-bod-4">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                     Display
                  </button>
               </h2>
               <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-dp-1"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="display_type" placeholder="Type" aria-label="Type" aria-describedby="basic-addon-dp-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-dp-2"><i class="fa fa-arrows-h" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="size" placeholder="Size" aria-label="Size" aria-describedby="basic-addon-dp-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-dp-3"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="resolution" placeholder="Resolution" aria-label="Resolution" aria-describedby="basic-addon-dp-3">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-dp-4"><i class="fa fa-shield" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="protection" placeholder="Protection" aria-label="Protection" aria-describedby="basic-addon-dp-4">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                     Platform
                  </button>
               </h2>
               <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-1"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="os" placeholder="OS" aria-label="Os" aria-describedby="basic-addon-pf-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-2"><i class="fa fa-microchip" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="chipset" placeholder="Chipset" aria-label="Chipset" aria-describedby="basic-addon-pf-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-3"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="cpu" placeholder="CPU" aria-label="CPU" aria-describedby="basic-addon-pf-3">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-4"><i class="fa fa-ticket" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="gpu" placeholder="GPU" aria-label="GPU" aria-describedby="basic-addon-pf-4">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                     Memory
                  </button>
               </h2>
               <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-1"><i class="fa fa-ticket" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="card_slot" placeholder="Card Slot" aria-label="Card_Slot" aria-describedby="basic-addon-pf-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-pf-2"><i class="fa fa-microchip" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="internal" placeholder="Internal" aria-label="Internal" aria-describedby="basic-addon-pf-2">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                     Main Camera
                  </button>
               </h2>
               <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-mc-1"><i class="fa fa-book" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="mc_modules" placeholder="Modules" aria-label="Modules" aria-describedby="basic-addon-mc-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-mc-2"><i class="fa fa-podcast" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="mc_features" placeholder="Features" aria-label="Features" aria-describedby="basic-addon-mc-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-mc-2"><i class="fa fa-video-camera " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="mc_video" placeholder="Video" aria-label="Video" aria-describedby="basic-addon-mc-2">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                     Selfie Camera
                  </button>
               </h2>
               <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-sc-1"><i class="fa fa-book" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sc_modules" placeholder="Modules" aria-label="Modules" aria-describedby="basic-addon-sc-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-sc-2"><i class="fa fa-podcast" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sc_features" placeholder="Features" aria-label="Features" aria-describedby="basic-addon-sc-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-sc-2"><i class="fa fa-video-camera " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sc_video" placeholder="Video" aria-label="Video" aria-describedby="basic-addon-sc-2">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                     Sound
                  </button>
               </h2>
               <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-snd-1"><i class="fa fa-volume-up " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="loudspeaker" placeholder="Loudspeaker" aria-label="Loudspeaker" aria-describedby="basic-addon-snd-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-snd-2"><i class="fa fa-headphones  " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sound_jack" placeholder="3.5 mm jack" aria-label="Jack" aria-describedby="basic-addon-snd-2">
                     </div>

                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading10">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                     Comms
                  </button>
               </h2>
               <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-1"><i class="fa fa-wifi " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="wlan" placeholder="WLAN" aria-label="WLAN" aria-describedby="basic-addon-cms-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-2">B</span>
                        <input type="text" class="form-control" name="bluetooth" placeholder="Bluetooth" aria-label="Bluetooth" aria-describedby="basic-addon-cms-2">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-3"><i class="fa fa-signal " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="positioning" placeholder="Positioning" aria-label="Positioning" aria-describedby="basic-addon-cms-3">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-4">N</i></span>
                        <input type="text" class="form-control" name="nfc" placeholder="NFC" aria-label="NFC" aria-describedby="basic-addon-cms-4">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-5"><i class="fa fa-braille " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="infrared_port" placeholder="Infrared Port" aria-label="Infrared_Port" aria-describedby="basic-addon-cms-5">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-6"><i class="fa fa-podcast  " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="radio" placeholder="Radio" aria-label="Radio" aria-describedby="basic-addon-cms-6">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-cms-7">U</span>
                        <input type="text" class="form-control" name="usb" placeholder="USB" aria-label="USB" aria-describedby="basic-addon-cms-7">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading11">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                     Features
                  </button>
               </h2>
               <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-ft-1"><i class="fa fa-podcast " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="sensors" placeholder="Sensors" aria-label="Sensors" aria-describedby="basic-addon-ft-1">
                     </div>

                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading12">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                     Battery
                  </button>
               </h2>
               <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bt-1"><i class="fa fa-mobile " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="battery_type" placeholder="Type" aria-label="Type" aria-describedby="basic-addon-bt-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-bt-2"><i class="fa fa-plug " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="charging" placeholder="Charging" aria-label="Charging" aria-describedby="basic-addon-bt-2">
                     </div>
                  </div>
               </div>
            </div>
            <div class="accordion-item">
               <h2 class="accordion-header" id="heading101">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse101" aria-expanded="false" aria-controls="collapse101">
                     MISC
                  </button>
               </h2>
               <div id="collapse101" class="accordion-collapse collapse" aria-labelledby="heading101" data-bs-parent="#accordionExample2">
                  <div class="accordion-body">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-misc-1"><i class="fa fa-mobile " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="colors" placeholder="Colors" aria-label="Colors" aria-describedby="basic-addon-misc-1">
                     </div>
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-misc-2"><i class="fa fa-plug " aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="models" placeholder="Models" aria-label="Models" aria-describedby="basic-addon-misc-2">
                     </div>
                  </div>
               </div>
            </div>
            <input type="submit" value="add product" class="submit-btn" name="add_product">
         </div>
      </form>

   </section>
   <?php



// Fetch all products
$select_products = $conn->prepare("SELECT * FROM `products`");
$select_products->execute();

if (isset($_POST['replenish_stock_btn'])) {
   $product_id = $_POST['product_id'];
   $additional_stock = filter_var($_POST['replenish_stock'], FILTER_SANITIZE_NUMBER_INT);

   // Update the stock in the database
   $update_stock = $conn->prepare("UPDATE `products` SET `stock` = `stock` + ? WHERE `id` = ?");
   $update_stock->execute([$additional_stock, $product_id]);

   if ($update_stock) {
       $message[] = 'Stock replenished successfully!';
   } else {
       $message[] = 'Failed to replenish stock!';
   }
}
?>



   

<section class="show-products">

    <h1 class="heading">Products</h1>

    <div class="box-container">

    <?php
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="box">
                    <img src="../uploaded_img/<?= htmlspecialchars($fetch_products['image_01']); ?>" alt="">
                    <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
                    <div class="price">PHP. <span><?= number_format((float)$fetch_products['price'], 2); ?></span></div>
                    <div class="details"><span><?= htmlspecialchars($fetch_products['details']); ?></span></div>
                    <div class="stock">Stock: <span><?= htmlspecialchars($fetch_products['stock']); ?></span></div>
                    <div class="flex-btn">
                     
                    <form action="" method="post">
                     <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                     <input type="number" name="replenish_stock" min="1" placeholder="Add Stock" required>
                     <button type="submit" name="replenish_stock_btn">Replenish</button>
                    </form>
                       
                        <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                        <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>

    </div>
</section>









   <script src="../js/admin_script.js"></script>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to check stock and close accordion if stock is zero
    function checkStockAndCloseAccordion() {
        const boxes = document.querySelectorAll('.box');
        boxes.forEach(box => {
            const productId = box.id.split('-')[1];
            const stockElement = document.getElementById(`stock-${productId}`);
            const stockValue = parseInt(stockElement.textContent);

            if (stockValue <= 0) {
                // Close the accordion if stock is zero
                const accordionItem = document.querySelector(`#collapse${productId}`);
                if (accordionItem) {
                    const bsCollapse = new bootstrap.Collapse(accordionItem, {
                        toggle: false
                    });
                    bsCollapse.hide();
                }
            }
        });
    }

    // Check stock on page load
    checkStockAndCloseAccordion();

    // Re-check stock after replenishing
    document.querySelectorAll('form[name="replenish_stock"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const productId = this.querySelector('input[name="product_id"]').value;

            // Fetch the stock value for the product
            fetch(`get_product_stock.php?id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.stock <= 0) {
                        // Automatically close the accordion if out of stock
                        const accordionItem = document.querySelector(`#collapse${productId}`);
                        if (accordionItem) {
                            const bsCollapse = new bootstrap.Collapse(accordionItem, {
                                toggle: false
                            });
                            bsCollapse.hide();
                        }
                    }
                });
        });
    });
});
</script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>