<?php
include '../components/connect.php';

session_start();

$user_id = $_SESSION['user_id']; // Assuming you have the user ID in the session
$products = $_POST['products']; // Assuming products are sent as an array from the form
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$method = $_POST['method'];
$address = $_POST['address'];
$total_price = $_POST['total_price']; // Assuming total price is calculated on the frontend

// Validate input data here (e.g., check if required fields are filled)

try {
    $conn->beginTransaction();

    // Insert into orders table
    $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_price, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_price, 'Pending']);
    $order_id = $conn->lastInsertId(); // Get the last inserted order ID

    // Insert into order_items table
    foreach ($products as $product) {
        $insert_order_item = $conn->prepare("INSERT INTO `order_items` (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert_order_item->execute([$order_id, $product['id'], $product['quantity']]);
    }

    $conn->commit();
    echo "Order placed successfully!";
} catch (Exception $e) {
    $conn->rollBack();
    echo "Failed to place order: " . $e->getMessage();
}
?>