<?php
    // Database Connection
    $connectionString = mysqli_connect("localhost", "root", "", "coffee_shop");

    if (!$connectionString) 
    {
        echo "Database not connected (components/Connection.php)";
        return;
    }

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
