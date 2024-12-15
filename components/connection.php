<?php
    $connectionString = mysqli_connect("localhost", "root", " ", "coffee_shop");

    if (!$connectionString)
    {
        echo "Databsae not connected (components/Connection.php)";
        return;
    }


    function unique_id()
    {
        $chars = "0123456789abcdefghijklmnopqrstuwvxyzABCDEFGHIJKMNLOPQRSTUWVXYZ";
        $charLength = strlen($chars);
        $randmonString = '';

        for ($i = 0; $i < 20; $i++)
            $randmonString = $chars[mt_rand(0, $charLength-1)];

        return $randmonString;
    }
    
?>
