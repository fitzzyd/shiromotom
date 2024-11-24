<?php
include 'components/connect.php';
session_start();
$grand_total = 0;

$name = "";
$email = "";
$number = "";
$method = "";
$address = "";
$brgy = "";
$city = "";
$pin_code = "";

// Currency formatting function
function formatCurrency($amount) {
   return '₱ ' . number_format($amount, 2);
}

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
   $userinfo = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC LIMIT 1");
   $userinfo->execute([$user_id]);
   if ($userinfo->rowCount() > 0) {
      $userDetails = $userinfo->fetch(PDO::FETCH_ASSOC);
      $name = $userDetails['name'];
      $email = $userDetails['email'];
      $number = $userDetails['number'];
      $method = $userDetails['method'];

      $location = explode(', ', $userDetails['address']);

      $address = $location[0];
      $brgy = $location[1];
      $city =  $location[2];
      $pin_code =  $location[3];
   }
} else {
   $user_id = '';
   header('location:index.php');
};
if (isset($_POST['order'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $address = $_POST['address'] . ', ' . $_POST['brgy'] . ', ' . $_POST['city'] . ', ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);
   if ($check_cart->rowCount() > 0) {
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if ($select_cart->rowCount() > 0) {
         while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $statistics = $conn->prepare("INSERT INTO `statistics_tbl` (product_id, type) VALUES(?,?)");
            $statistics->execute([
               $fetch_cart['pid'],
               3
            ]);
         }
      }
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      if ($method == "paypal") {
         $message[] = 'Paid, order placed successfully.';
      } else {
         $message[] = 'Cash on Delivery, order placed successfully.';
      }
   } else {
      $message[] = 'Your cart is empty!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://www.paypal.com/sdk/js?client-id=AT5elf7ZFu9wxQEUX73VhWgv2KtXCJRG3Rr-gZY0FNJvEbQ8h6FFk0sBYQ3aiiHoiJDVB8xnXAv9eiQI&currency=PHP"></script>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'components/user_header.php'; ?>
   <section class="checkout-orders">
      <form action="" method="POST">
         <h3>Your Orders</h3>
         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . formatCurrency($fetch_cart['price']) . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                  <p> <?= $fetch_cart['name']; ?> <span>(<?= formatCurrency($fetch_cart['price']) . ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
                  <?php
               }
            } else {
               echo '<p class="empty">your cart is empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="grand-total"> Total : <span><?= formatCurrency($grand_total); ?></span></div>
         </div>
         <h3>Input Details</h3>
         <div class="flex">
            <div class="inputBox">
               <span>Name :</span>
               <input type="text" name="name" id="name" value="<?php echo $name; ?>" placeholder="enter your name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>Number :</span>
               <input type="text" name="number" id="number" value="<?php echo $number; ?>" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>Email :</span>
               <input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="enter your email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Mode of Payment :</span>
               <select name="method" id="method" value="<?php echo $method; ?>" class="box" required>
                  <option value="paypal">Paypal</option>
                
               </select>
            </div>
            <div class="inputBox">
               <span>Address:</span>
               <input type="text" name="address" value="<?php echo $address; ?>" id="address" placeholder="" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Barangay/Street:</span>
               <input type="text" name="brgy" id="brgy" value="<?php echo $brgy; ?>" placeholder="" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>City :</span>
               <input type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Postal Code :</span>
               <input type="number" min="0" name="pin_code" value="<?php echo $pin_code; ?>" id="pin_code" placeholder="" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
            </div>
         </div>
         <input type="submit" style="display: none;" id="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="place order">
         <input type="button" id="proceed" onclick="payment()" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Proceed to Payment">
         <div id="paypal-button-container" style="margin-top: 10px;display: <?= ($grand_total > 1) ? '' : 'disabled'; ?>"></div>
      </form>
   </section>
   <script>
      function checkRequiredField() {
         let ifAllFilled = true;
         const inputIds = ['name', 'number', 'email', 'address', 'brgy', 'city', 'pin_code', 'method'];
         for (let i = 0; i < inputIds.length; i++) {
            const value = document.getElementById(inputIds[i]).value
            if (value.trim() == '') {
               ifAllFilled = false
               break
            }
         }
         return ifAllFilled
      }

      function payment() {
         if (checkRequiredField()) {
            if (document.getElementById('method').value == "paypal") {
               paypal.Buttons({
                  style: {
                     layout: 'vertical', // 'horizontal' or 'vertical'
                     color: 'gold', // Button color
                     shape: 'rect', // Button shape
                     label: 'paypal', // Label on the button
                     disableMaxWidth: true,
                     width: '100%' // Width set to 100%
                  },
                  createOrder: function(data, actions) {
                     return actions.order.create({
                        purchase_units: [{
                           amount: {
                              value: <?php echo json_encode($grand_total); ?>, // The amount you're charging
                              currency_code: 'PHP' // Specify the currency as Philippine Peso
                           }
                        }]
                     });
                  },
                  onApprove: function(data, actions) {
                     return actions.order.capture().then(function(details) {
                        document.getElementById('submit').click();
                     });
                  }
               }).render('#paypal-button-container');
            } else {
               if (confirm('Place order as Cash on Delivery') == true) {
                  document.getElementById('submit').click();
               }
            }
         } else {
            document.getElementById('submit').click();
         }
      }
   </script>
   <?php include 'components/footer.php'; ?>
   <script src="js/script.js"></script>
   <script>
   </script>
</body>

</html>