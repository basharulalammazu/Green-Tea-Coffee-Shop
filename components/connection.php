<?php
    /// Database Connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'coffeeshop';

    // Create a MySQLi connection
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) 
        die("Database connection failed: " . $conn->connect_error);
       
?>
