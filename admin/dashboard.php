<?php

    include './components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
        header("Location: ../login.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin Panel - Dashboard Page</title>
</head>
<body>
    <?php include 'http://localhost/demoh/components/admin_header.php';?>
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
                    <h3>WEelcome!</h3>
                    <p><?=$fetch_profile['Name'];?></p>
                    <a href="" class="btn">Profile</a>
                </div>
                <div class="box">
                    <?php 
                        $select_product = $conn->prepare("SELECT * FROM `products`");
                        $select_product->execute();
                        $num_of_products = $select_product->rowCount();
                    ?>
                    <h3><?=  $num_of_products ;?></h3>
                    <p>Product added</p>
                    <a href="admin/dd_product.php" class="btn">Add new product</a>
                </div>
                <div class="box">
                    <?php 
                        $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_active_product -> execute(['active']);
                        $num_of_active_products = $select_active_product->rowCount();
                    ?>
                    <h3><?=  $num_of_active_products;?></h3>
                    <p>Total active products</p>
                    <a href="admin/view_product.php" class="btn">View active product</a>
                </div>
                <div class="box">
                    <?php 
                        $select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_deactive_product->execute(['active']);
                        $num_of_deactive_products = $select_deactive_product->rowCount();
                    ?>
                    <h3><?=  $num_of_deactive_products ;?></h3>
                    <p>Total deactive products</p>
                    <a href="admin/view_product.php" class="btn">View deactive product</a>
                </div>
                <div class="box">
                    <?php 
                        $select_user = $conn->prepare("SELECT * FROM `users`");
                        $select_user->execute();
                        $num_of_users = $select_user->rowCount();
                    ?>
                    <h3><?=  $num_of_users ;?></h3>
                    <p>Rregistered ysers</p>
                    <a href="admin/user_account.php" class="btn">View users</a>
                </div>
                <div class="box">
                    <?php 
                        $select_admin = $conn->prepare("SELECT * FROM `admin`");
                        $select_admin->execute();
                        $num_of_admin = $select_admin->rowCount();
                    ?>
                    <h3><?=  $num_of_admin ;?></h3>
                    <p>Registered admin</p>
                    <a href="admin/user_account.php" class="btn">View admin</a>
                </div>
                <div class="box">
                    <?php 
                        $select_message = $conn->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $num_of_message = $select_message->rowCount();
                    ?>
                    <h3><?=  $num_of_message ;?></h3>
                    <p>Unread message</p>
                    <a href="admin/admin_message.php" class="btn">View message</a>
                </div>
                <div class="box">
                    <?php 
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $num_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?=  $num_of_orders ;?></h3>
                    <p>totle orders placed</p>
                    <a href="admin/order.php" class="btn">View orders</a>
                </div>
                <div class="box">
                    <?php 
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_confirm_orders->execute(['in progress']);
                        $num_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?=  $num_of_confirm_orders ;?></h3>
                    <p>Total confirm orders</p>
                    <a href="admin/order.php" class="btn">View confirm orders</a>
                </div>
                <div class="box">
                    <?php 
                        $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_canceled_orders->execute(['canceled']);
                        $num_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?=  $num_of_canceled_orders ;?></h3>
                    <p>Total canceled orders</p>
                    <a href="admin/order.php" class="btn">view canceled orders</a>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>   
</body>
</html>