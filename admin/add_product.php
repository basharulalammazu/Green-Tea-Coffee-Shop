<?php

    include '../components/connection.php';


    session_start();
    $admin_id = $_SESSION['user_id'];

    
    if(!isset($admin_id))
        header("Location: ../login.php");
    
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $stmt->bind_param("i", $admin_id); // Bind the admin ID as an integer
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set
    $fetch_profile = $result->fetch_assoc(); // Fetch as an associative array
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin Panel - Add product Page</title>
</head>
<body>
    <?php include 'components/admin_header.php';?>
    <div class="main">
        <dib class="banner">
            <h1>Dashboard</h1>
        </dib>
        <div class="title2">
            <a href="dashboard.php">Home</a><span> / Add products</span>
        </div>
        <section class="dashboard">
            <h1 class="heading">Add Products</h1>
                <div class="box">


            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>   
</body>
</html>