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
    

    // Unique ID Generator Function
    function unique_id() 
    {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charLength = strlen($chars);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) 
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        
        return $randomString;
    }
?>
