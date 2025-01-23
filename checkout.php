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
    
if (!isset($_SESSION['user_id'])) {
    $warning_msg = 'Please login to checkout';
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: login.php");
}

// Fetch user details
$query = "SELECT name, phone_number, email FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['place_order'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $address = filter_var(
        $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'],
        FILTER_SANITIZE_STRING
    );
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

    // Verify cart
    $cart_query = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_query);

    if (isset($_GET['get_id'])) {
        // Single product order
        $product_id = (int)$_GET['get_id'];
        $product_query = "SELECT * FROM products WHERE id = $product_id LIMIT 1";
        $product_result = mysqli_query($conn, $product_query);

        if (mysqli_num_rows($product_result) > 0) {
            while ($fetch_p = mysqli_fetch_assoc($product_result)) {
                $insert_order_query = "INSERT INTO orders 
                    (user_id, name, phone_number, email, address, address_type, method, product_id, price, quantity, status)
                    VALUES ('$user_id', '$name', '$number', '$email', '$address', '$address_type', '$method', '{$fetch_p['id']}', '{$fetch_p['price']}', 1, 'pending')";
                mysqli_query($conn, $insert_order_query);
            }
            header("location: order.php");
            exit;
        } else {
            $warning_msg[] = "Something went wrong. Product not found.";
        }
    } else if (mysqli_num_rows($cart_result) > 0) {
        // Cart order
        while ($f_cart = mysqli_fetch_assoc($cart_result)) {
            // Check product availability
            $product_id = $f_cart['product_id'];
            $select_products_query = "SELECT * FROM products WHERE id = $product_id";
            $product_result = mysqli_query($conn, $select_products_query);

            if ($fetch_products = mysqli_fetch_assoc($product_result)) {
                // Insert order
                $insert_order_query = "INSERT INTO orders 
                    (user_id, name, phone_number, email, address, address_type, method, product_id, price, quantity, status)
                    VALUES ('$user_id', '$name', '$number', '$email', '$address', '$address_type', '$method', '{$fetch_products['id']}', '{$fetch_products['price']}', '{$f_cart['quantity']}', 'pending')";
                mysqli_query($conn, $insert_order_query);
            } else {
                $warning_msg[] = "The product is no longer available.";
            }
        }
        // Clear the cart after placing the order
        $delete_cart_query = "DELETE FROM cart WHERE user_id = '$user_id'";
        mysqli_query($conn, $delete_cart_query);

        header("location: order.php");
        exit;
    } else {
        $warning_msg[] = "Your cart is empty.";
    }
}
?>



<style type = "text/css">
    <?php include 'style.css' ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel = 'stylesheet'>
    <title>Green Coffee - Checkout Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Checkout Summery</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a><span> / Checkout Summery</span>
        </div>
    </div>
    <section class = "checkout">
        <div class="title">
            <img src="assets/image/download.png" class="logo">
            <h1>checkout summary</h1>
            <p>Thank you for shopping with us. Make sure to use valid billing details to have the product delivered to your place hassle free!</p>
        </div>
            <div class="summary">
                <h3>my bag</h3>
                <div class="box-container">
                <?php
                    $grand_total = 0;

                    // Function to dynamically fetch the product image
                    function get_product_image($product_id)
                    {
                        $image_formats = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Supported image formats
                        foreach ($image_formats as $format) 
                        {
                            $image_path = "image/product/{$product_id}.{$format}";
                            if (file_exists($image_path))
                                return $image_path; // Return the first valid image found
                        }
                        return "image/default.png"; // Return a default image if none is found
                    }

                    if (isset($_GET['get_id'])) 
                    {
                        // Use prepared statement to select a product by ID
                        $select_get = $conn->prepare("SELECT * FROM `products` WHERE `id` = ?");
                        $select_get->bind_param("i", $_GET['get_id']);
                        $select_get->execute();
                        $result_get = $select_get->get_result();

                        while ($fetch_get = $result_get->fetch_assoc()) {
                            $sub_total = $fetch_get['price'];
                            $grand_total += $sub_total;
                            $image_path = get_product_image($fetch_get['id']); // Get product image dynamically
                    ?>
                            <div class="flex">
                                <img src="<?= $image_path; ?>" class="image" alt="<?= $fetch_get['name']; ?>">
                                <div>
                                    <h3 class="name"><?= $fetch_get['name']; ?></h3>
                                    <p class="price">$<?= $fetch_get['price']; ?></p>
                                </div>
                            </div>
                    <?php
                        }
                        $select_get->close();
                    } 
                    else 
                    {
                        // Use prepared statement to select all cart items by User ID
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
                        $select_cart->bind_param("i", $user_id);
                        $select_cart->execute();
                        $result_cart = $select_cart->get_result();

                        if ($result_cart->num_rows > 0) 
                        {
                            while ($fetch_cart = $result_cart->fetch_assoc()) 
                            {
                                $select_products = $conn->prepare("SELECT * FROM `products` WHERE `id` = ?");
                                $select_products->bind_param("i", $fetch_cart['product_id']);
                                $select_products->execute();
                                $result_product = $select_products->get_result();

                                if ($fetch_product = $result_product->fetch_assoc()) 
                                {
                                    $sub_total = ($fetch_cart['quantity'] * $fetch_product['price']);
                                    $grand_total += $sub_total;
                                    $image_path = get_product_image($fetch_product['id']); // Get product image dynamically
                    ?>
                                    <div class="flex">
                                        <img src="<?= $image_path; ?>" alt="<?= $fetch_product['name']; ?>">
                                        <div>
                                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                            <p class="price">$<?= $fetch_product['price']; ?> x <?= $fetch_cart['quantity']; ?></p>
                                        </div>
                                    </div>
                    <?php
                                }
                                $select_products->close();
                            }
                        } 
                        else 
                            echo "<p class='empty'>Your cart is empty</p>";
                        $select_cart->close();
                    }
                    ?>
                </div>
                <div class = "grand-total"><span>Total payable amount: </span>$<?= $grand_total ?>/-</div>
            </div>
        </div>
        <form method="post">
        <h3>Billing Details</h3>
        
            <div class="flex">
                <!-- First Column -->
                <div class="column">
                    <div class="input-field">
                        <p>Your Name <span>*</span></p>
                        <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input" value = "<?php echo $row['name']?>">
                    </div>
                    <div class="input-field">
                        <p>Your Number <span>*</span></p>
                        <input type="tel" name="number" required maxlength="15" pattern="[0-9]{6,15}" placeholder="Enter your phone number" class="input" value = "<?php echo $row['phone_number']?>">
                    </div>
                    <div class="input-field">
                        <p>Your Email <span>*</span></p>
                        <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="input" value = "<?php echo $row['email']?>">
                    </div>
                    <div class="input-field">
                        <p>Payment Method <span>*</span></p>
                        <select name="method" class="input" required>
                            <option value="" disabled selected>Choose a payment method</option>
                            <option value="cash on delivery">Cash on Delivery</option>
                            <option value="credit or debit card">Credit or Debit Card</option>
                            <option value="net banking">Net Banking</option>
                            <option value="mobile banking">Mobile Banking</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <p>address type <span>*</span></p>
                        <select name="address_type" class="input">
                            <option value="home">home</option>
                            <option value="office">office</option>
                        </select>
                    </div>
                </div>

                <!-- Second Column -->
                <div class="column">
                    <div class="input-field">
                        <p>Address Line 01 <span>*</span></p>
                        <input type="text" name="flat" required maxlength="50" placeholder="e.g. Flat & Building Number" class="input">
                    </div>
                    <div class="input-field">
                        <p>Address Line 02 <span>*</span></p>
                        <input type="text" name="street" required maxlength="50" placeholder="e.g. Street Name" class="input">
                    </div>
                    <div class="input-field">
                        <p>City Name <span>*</span></p>
                        <input type="text" name="city" required maxlength="50" placeholder="Enter your city name" class="input">
                    </div>
                    <div class="input-field">
                        <p>Country Name <span>*</span></p>
                        <input type="text" name="country" required maxlength="50" placeholder="Enter your country name" class="input">
                    </div>
                    <div class="input-field">
                        <p>Pincode <span>*</span></p>
                        <input type="text" name="pincode" required maxlength="6" pattern="[0-9]{4,6}" placeholder="e.g. 110022" class="input">
                    </div>
                </div>
            </div>    
            <button type="submit" name="place_order" class="btn">place order</button>
        </form>
    </section>
    
    <?php include 'components/footer.php'; ?>
    <!--Home Slider end-->
        

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
