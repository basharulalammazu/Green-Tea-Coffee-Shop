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
    <title>Green Coffee Admin Panel - Dashboard Page</title>
</head>
<body>
    <?php include 'components/admin_header.php';?>
    <div class="main">
        <dib class="banner">
            <h1>Dashboard</h1>
        </dib>
        <div class="title2">
            <a href="dashboard.php">Home</a><span> / Dashboard</span>
        </div>
        <section class="dashboard">
            <h1 class="heading">Dashboard</h1>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p><?=$fetch_profile['name'];?></p>
                    <a href="" class="btn">Profile</a>
                </div>
                <div class="box">
                    <?php 
                        $select_product = $conn->prepare("SELECT * FROM `products`");
                        $select_product->execute();
                        
                        $result = $select_product->get_result(); 
                        $num_of_products = $result->num_rows;                    
                    ?>
                    <h3><?=  $num_of_products ;?></h3>
                    <p>Product added</p>
                    <a href="../admin/add_products.php" class="btn">Add new product</a>
                </div>
                <div class="box">
                    <?php 
                        $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_active_product -> execute(['active']);
                        $result = $select_active_product->get_result();
                        $num_of_active_products = $result->num_rows;
                        $result->free();
                        $select_active_product->close();
                    ?>
                    <h3><?=  $num_of_active_products;?></h3>
                    <p>Total active products</p>
                    <a href="../admin/view_products.php" class="btn">View active product</a>
                </div>
                <div class="box">
                    <?php 
                        $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_active_product -> execute(['in progress']);
                        $result = $select_active_product->get_result();
                        $num_of_active_products = $result->num_rows;
                        $result->free();
                        $select_active_product->close();
                    ?>
                    <h3><?=  $num_of_active_products;?></h3>
                    <p>Total active products</p>
                    <a href="../admin/view_product.php" class="btn">View deactive product</a>
                </div>
                <div class="box">
                    <?php
                    // Select users with user_type 'Customer'
                    $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                    $select_user->execute(['Customer']);
                    $result = $select_user->get_result();
                    $num_of_users = $result->num_rows;
                    $result->free();
                    $select_user->close();
                    ?>
                    <h3><?= $num_of_users; ?></h3>
                    <p>Registered users</p>
                    <a href="../admin/user_account.php" class="btn">View users</a>
                </div>

                <div class="box">
                    <?php
                    // Select users with user_type 'Admin'
                    $select_admin = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
                    $select_admin->execute(['Admin']);
                    $result = $select_admin->get_result();
                    $num_of_admin = $result->num_rows;
                    $result->free();
                    $select_admin->close();
                    ?>
                    <h3><?= $num_of_admin; ?></h3>
                    <p>Registered admins</p>
                    <a href="../admin/user_account.php" class="btn">View admins</a>
                </div>

                <div class="box">
                    <?php
                    // Select all messages
                    $select_message = $conn->prepare("SELECT * FROM `message`");
                    $select_message->execute();
                    $result = $select_message->get_result();
                    $num_of_message = $result->num_rows;
                    $result->free();
                    $select_message->close();
                    ?>
                    <h3><?= $num_of_message; ?></h3>
                    <p>Unread messages</p>
                    <a href="../admin/admin_message.php" class="btn">View messages</a>
                </div>

                <div class="box">
                    <?php
                    // Select all orders
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    $result = $select_orders->get_result();
                    $num_of_orders = $result->num_rows;
                    $result->free();
                    $select_orders->close();
                    ?>
                    <h3><?= $num_of_orders; ?></h3>
                    <p>Total orders placed</p>
                    <a href="../admin/order.php" class="btn">View orders</a>
                </div>

                <div class="box">
                    <?php
                    // Select confirmed orders
                    $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                    $status = 'in progress';
                    $select_confirm_orders->bind_param("s", $status);
                    $select_confirm_orders->execute();
                    $result = $select_confirm_orders->get_result();
                    $num_of_confirm_orders = $result->num_rows;
                    $result->free();
                    $select_confirm_orders->close();
                    ?>
                    <h3><?= $num_of_confirm_orders; ?></h3>
                    <p>Total confirmed orders</p>
                    <a href="../admin/order.php" class="btn">View confirmed orders</a>
                </div>

                <div class="box">
                    <?php
                    // Select canceled orders
                    $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                    $status = 'canceled';
                    $select_canceled_orders->bind_param("s", $status);
                    $select_canceled_orders->execute();
                    $result = $select_canceled_orders->get_result();
                    $num_of_canceled_orders = $result->num_rows;
                    $result->free();
                    $select_canceled_orders->close();
                    ?>
                    <h3><?= $num_of_canceled_orders; ?></h3>
                    <p>Total canceled orders</p>
                    <a href="../admin/order.php" class="btn">View canceled orders</a>
                </div>

            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>   
</body>
</html>