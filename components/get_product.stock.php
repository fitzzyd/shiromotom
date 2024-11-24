<?php
include '../components/connect.php'; // Include your database connection

// Check if the product ID is set in the query parameters
if (isset($_GET['id'])) {
    $product_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize the input

    // Prepare and execute the SQL statement to fetch the product's stock
    $select_product = $conn->prepare("SELECT stock FROM `products` WHERE id = ?");
    $select_product->execute([$product_id]);

    // Check if the product exists
    if ($select_product->rowCount() > 0) {
        $product = $select_product->fetch(PDO::FETCH_ASSOC);
        // Return the stock level as a JSON response
        echo json_encode(['stock' => $product['stock']]);
    } else {
        // If the product is not found, return a stock of zero
        echo json_encode(['stock' => 0]);
    }
} else {
    // If no ID is provided, return an error response
    echo json_encode(['error' => 'No product ID provided']);
}
?>