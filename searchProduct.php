<?php

include 'components/connect.php';
if (isset($_GET['query'])) {

   
    $query = $_GET['query'];
    if(strlen($query) < 1){
        echo json_encode([]);
        return;
    }
    $query = "%" . $query . "%"; // Prepare for LIKE query

    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute([$query]);

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($contacts);
} 

if (isset($_GET['p1']) && isset($_GET['p2'])) {
    $p1 = $_GET['p1'];
    $p2 = $_GET['p2'];
    $product1Details = [];
    $product2Details = [];
    $getProduct1Data = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $getProduct1Data->execute([$p1]);
    $getProduct2Data = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $getProduct2Data->execute([$p2]);
    if ($getProduct1Data->rowCount() > 0) {
        $product1Details = $getProduct1Data->fetch(PDO::FETCH_ASSOC);

      
    }
    if ($getProduct2Data->rowCount() > 0) {
        $product2Details = $getProduct2Data->fetch(PDO::FETCH_ASSOC);
      
    }

    $data = array(
        "prod_1" => $product1Details,
        "prod_2" => $product2Details
    );

    echo json_encode($data);
}
