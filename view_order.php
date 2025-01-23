<?php 
    include './components/connection.php';
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
    if (isset($_SESSION['user_id'])) 
        $user_id = $_SESSION['user_id'];
    else
    {
        $warning_mes = 'Please login to view your order';
        header("location: login.php");
        exit();
    
    }

    if(isset($_POST['logout'])) 
    {
        session_destroy();
        header("location: login.php");
    }
    if(isset($_GET['get_id'])) 
        $get_id = $_GET['get_id'];
    else
    {
        $get_id = '';
        header("location: order.php");
    }
    if(isset($_POST['cancel'])) 
    {
        $update_order = $conn->prepare("UPDATE `orders` SET `status` = ? WHERE id =? ");
        $update_order->execute(['canceled', $get_id]);
        header("location: order.php");
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
    <title>Green Coffee - Order Details</title>
</head>
<body>
    
<?php  include './components/header.php'; ?>
<div class="main">
    <div class="banner">
        <h1>Order Details</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / Order Details</span>
    </div>
    <section class="order-detail">
        <div class="box-container">
            <div class="title">
                <img src="./assets/image/download.png" class="logo">
                <h1>Order Details</h1>
                <p>enjoy your green tea experience</p>
                <!-- </div> -->
                <div class="box-container">
                <?php
    $grand_total = 0;
    $query_orders = "SELECT * FROM `orders` WHERE id = ? LIMIT 1";
    $stmt_orders = $conn->prepare($query_orders);
    $stmt_orders->bind_param("i", $get_id);
    $stmt_orders->execute();
    $result_orders = $stmt_orders->get_result();

    // Supported image formats
    $image_formats = ['jpg', 'jpeg', 'png'];

    if ($result_orders->num_rows > 0) {
        while ($fetch_order = $result_orders->fetch_assoc()) 
        {
            $query_product = "SELECT * FROM `products` WHERE id = ? LIMIT 1";
            $stmt_product = $conn->prepare($query_product);
            $stmt_product->bind_param("i", $fetch_order['product_id']);
            $stmt_product->execute();
            $result_products = $stmt_product->get_result();

            if ($result_products->num_rows > 0) 
            {
                while ($fetch_product = $result_products->fetch_assoc()) 
                {
                    // Dynamic image path resolution
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

                    // Fallback to default image if no file is found
                    if (!$image_path) 
                        $image_path = "image/default_product.png"; // Default image
                    

                    $sub_total = ($fetch_order['price'] * $fetch_order['quantity']);
                    $grand_total += $sub_total;
?>
                    <div class="order-detail">
    <div class="box-container">
        <div class="box">
            <div class="col product-details">
                <p class="title"><i class="bi bi-calendar-fill"></i><?= $fetch_order['date']; ?></p>
                <img src="<?= $image_path; ?>" class="img" alt="Product Image">
                <p class="price">$<?= $fetch_product['price']; ?> x <?= $fetch_order['quantity']; ?></p>
                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                <p class="grand-total">Total amount payable: <span>$<?= $grand_total; ?></span></p>
            </div>
            <div class="col billing-address">
                <p class="title">Billing Address</p>
                <p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_order['name']; ?></p>
                <p class="user"><i class="bi bi-phone"></i><?= $fetch_order['phone_number']; ?></p>
                <p class="user"><i class="bi bi-envelope"></i><?= $fetch_order['email']; ?></p>
                <p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?></p>
                <p class="title">Status</p>
                <p class="status" style="color:<?php 
                    if ($fetch_order['status'] == 'complete') 
                        echo 'green'; 
                    else if ($fetch_order['status'] == 'canceled') 
                        echo 'red'; 
                    else 
                        echo 'orange'; 
                    ?>"><?= ucfirst($fetch_order['status']); ?></p>
                
                <?php 
                    if ($fetch_order['status'] == 'canceled') 
                    { 
                ?>
                    <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy again</a>
                <?php 
                    } 
                    else  if($fetch_order['status'] == 'pending')
                    { 
                ?>
                        <form action="" method="post">
                            <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?')">Cancel order</button>
                        </form>
                <?php 
                    } 
                ?>
            </div>
        </div>
    </div>
</div>

<?php
                }
            } 
            else 
                echo '<p class="empty">Product not found!</p>';
            
            $stmt_product->close(); // Close product statement
        }
    } 
    else 
        echo '<p class="empty">No order found!</p>';
    
    $stmt_orders->close(); // Close orders statement
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
<?php  include './components/alert.php'; ?>
</body>
</html>
