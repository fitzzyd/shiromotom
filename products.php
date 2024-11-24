<?php

include 'components/connect.php';

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($contacts);
