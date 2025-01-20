<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "coffeeshop";

$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Fetch products from the database
$sql = "SELECT name, price, size, product_category FROM products";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
    } else 
        echo json_encode(["message" => "No products found."]);
    
} else {
    echo json_encode(["error" => "SQL query failed: " . $conn->error]);
}

// Close the connection
$conn->close();
?>
