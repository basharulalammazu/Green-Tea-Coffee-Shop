<?php
include include '../components/connection.php';

header('Content-Type: application/json');


// Check for connection errors
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Get the category parameter from the query string
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : "all";

// Modify the SQL query based on the category
$sql = "SELECT name, price, size, product_category FROM products";
if ($category !== "all") {
    $sql .= " WHERE product_category = '$category'";
}

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode(["message" => "No products found for the selected category."]);
    }
} else {
    echo json_encode(["error" => "SQL query failed: " . $conn->error]);
}

// Close the connection
$conn->close();

?>
