<?php 
include 'components/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) 
{
    $warning_msg = 'Please login to view your order';
    header("location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];


if(isset($_POST['logout'])) 
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
    <title>Green Coffee - Order page</title>
</head>
<body>
<?php  include './components/header.php'; ?>
<div class="main">
    <div class="banner">
        <h1>My Order</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / Order</span>
    </div>
    <section class="orders">
        <div class="box-container">
            <div class="title">
                <img src="./assets/image/download.png" class="logo">
                <h1>My Orders</h1>
                <p>You can confirm your orders from here or feel free to browse some more.</p>
            <!-- </div> -->
                <div class="box-container">
                <?php
    // Assuming you already have a valid $conn for the mysqli connection
    $query = "SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id); // Binding the user_id parameter
    $stmt->execute();
    $result_orders = $stmt->get_result(); // Get the result set

    // Supported image formats
    $image_formats = ['jpg', 'jpeg', 'png'];

    if ($result_orders->num_rows > 0) {
        while ($fetch_order = $result_orders->fetch_assoc()) 
        {
            // Fetch product details for each order
            $query_product = "SELECT * FROM `products` WHERE id = ?";
            $stmt_product = $conn->prepare($query_product);
            $stmt_product->bind_param("i", $fetch_order['product_id']); // Binding product_id parameter
            $stmt_product->execute();
            $result_products = $stmt_product->get_result();

            if ($result_products->num_rows > 0) {
                while ($fetch_product = $result_products->fetch_assoc()) 
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
            $stmt_product->close(); // Close the product statement
        }
    } else {
        echo '<p class="empty">You havent placed any orders yet &#x1F615;</p>';
    }
    $stmt->close(); // Close the orders statement
?>

                </div>
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'?>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://cdnjs.Cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php  include 'components/alert.php'; ?>
</body>
</html>