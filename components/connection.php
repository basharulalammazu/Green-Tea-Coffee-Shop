<?php
    $connectionString = mysqli_connect("localhost", "root", " ", "coffee_shop");

    if (!$connectionString)
    {
        echo "Databsae not connected (components/Connection.php)";
        return;
    }

    
?>
