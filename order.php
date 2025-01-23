<?php 
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_type'])) 
    {
        if ($_SESSION['user_type'] === 'Admin') 
        {
            // Redirect to admin dashboard if user is Admin
            header('location: admin/dashboard.php');
            exit();
        }
    }
    
if (!isset($_SESSION['user_id'])) 
{
    $warning_msg = 'Please login to view your order';
    header("location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) 
{
    session_destroy();
    header("location: login.php");
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - Order Page</title>
</head>
<body>
<?php include './components/header.php'; ?>
<div class="main">
    <div class="banner">
        <h1>My Orders</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / Orders</span>
    </div>
    <section class="orders">
        <div class="box-container">
            <div class="title">
                <img src="./assets/image/download.png" class="logo">
                <h1>My Orders</h1>
                <p>Your previous order details all in one place.</p>
                <div class="box-container">
                <?php
                // Fetch orders for the current user
                $query_orders = "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY date DESC";
                $result_orders = mysqli_query($conn, $query_orders);

                // Supported image formats
                $image_formats = ['jpg', 'jpeg', 'png'];

                if (mysqli_num_rows($result_orders) > 0) 
                {
                    while ($fetch_order = mysqli_fetch_assoc($result_orders)) 
                    {
                        // Fetch product details for each order
                        $query_product = "SELECT * FROM `products` WHERE id = '{$fetch_order['product_id']}'";
                        $result_products = mysqli_query($conn, $query_product);

                        if (mysqli_num_rows($result_products) > 0) 
                        {
                            while ($fetch_product = mysqli_fetch_assoc($result_products)) 
                            {
                                // Construct the dynamic image path
                                $image_path = "";
                                foreach ($image_formats as $format) 
                                {
                                    $temp_path = "image/product/{$fetch_product['id']}.$format";
                                    if (file_exists($temp_path)) 
                                    {
                                        $image_path = $temp_path;
                                        break;
                                    }
                                }

                                // Fallback if no image is found
                                if (!$image_path) 
                                    $image_path = "image/product/default.png"; // Default image path
                                
                                ?>
                                <div class="order-box" style="border: 2px solid <?= $fetch_order['status'] == 'canceled' ? 'red' : '#ddd'; ?>;">
                                    <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>" class="order-link">
                                        <div class="order-header">
                                            <i class="bi bi-calendar-fill"></i>
                                            <span><?= $fetch_order['date']; ?></span>
                                        </div>
                                        <div class="order-image">
                                            <img src="<?= $image_path; ?>" alt="Product Image" class="product-img">
                                        </div>
                                        <div class="order-details">
                                            <h3 class="product-name"><?= $fetch_product['name']; ?></h3>
                                            <p class="product-price">Price: $<?= $fetch_order['price']; ?> x <?= $fetch_order['quantity']; ?></p>
                                            <p class="order-status" style="color: 
                                                <?= $fetch_order['status'] == 'delivered' ? 'green' : ($fetch_order['status'] == 'canceled' ? 'red' : 'orange'); ?>;">
                                                <?= ucfirst($fetch_order['status']); ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                    }
                } 
                else 
                {
                    echo '<p class="empty">You haven’t placed any orders yet &#x1F615;</p>';
                }
                ?>
                </div>
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://cdnjs.Cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>
