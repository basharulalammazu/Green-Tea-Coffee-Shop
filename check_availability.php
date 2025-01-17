<?php
  # create database connection
  include 'components/connection.php';


  if (!empty($_POST["email"])) 
  {
    $email = $_POST["email"]; // Fetch the email from the POST request

    // Query to check if email already exists in the database
    $query = "SELECT * FROM users WHERE email='" . $email . "'";
    $result = mysqli_query($conn, $query);

    // Check the number of rows returned
    $count = mysqli_num_rows($result);

    if ($count > 0) 
    {
        // If email exists
        echo "<span style='color:red'>Sorry, this email already exists</span>";
        echo "<script>document.getElementById('submit').disabled = true;</script>";
    } 
    else
    {
      // If email is available
      echo "<span style='color:green'>Email available for registration</span>";
      echo "<script>document.getElementById('submit').disabled = false;</script>";
    }
  }
?>