<?php
    include 'components/connection.php';

    
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
}

// Adding product to wishlist
if (isset($_POST['add_to_wishlist'])) {
    if (!isset($user_id)) {
        $warning_msg[] = 'Please login to add product to wishlist';
        header("location: login.php");
        exit();
    }

    $product_id = (int)$_POST['product_id'];

    // Check if the product exists in the wishlist
    $verify_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    $verify_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");

    if (mysqli_num_rows($verify_wishlist) > 0) {
        $warning_msg[] = 'Product already exists in your wishlist';
    } elseif (mysqli_num_rows($verify_cart) > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        // Fetch product price
        $select_price = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id LIMIT 1");
        $fetch_price = mysqli_fetch_assoc($select_price);

        // Insert into wishlist
        $price = $fetch_price['price'];
        mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id, price) VALUES ($user_id, $product_id, $price)");
        $succcess_msg[] = 'Product added to wishlist successfully';
    }
}

// Adding product to cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($user_id)) {
        $warning_msg[] = 'Please login to add product to cart';
        header("location: login.php");
        exit();
    }

    $product_id = (int)$_POST['product_id'];
    $qty = (int)filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    // Check if product exists in the cart
    $verify_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");

    // Check if the cart has 20 items already
    $max_cart_items = mysqli_query($conn, "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = $user_id");
    $cart_count = mysqli_fetch_assoc($max_cart_items)['cart_count'];

    if (mysqli_num_rows($verify_cart) > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } elseif ($cart_count >= 20) {
        $warning_msg[] = 'Cart is full';
    } else {
        // Fetch product price
        $select_price = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id LIMIT 1");
        $fetch_price = mysqli_fetch_assoc($select_price);

        // Insert into cart
        $price = $fetch_price['price'];
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, price, quantity) VALUES ($user_id, $product_id, $price, $qty)");
        $succcess_msg[] = 'Product added to cart successfully';
    }
}
?>

<style type = "text/css">
    <?php include 'style.css' ?>
</style>

<!DOCTYPE html>
<html lang = "en">
<head>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - View Product Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Products</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span> / Our Shop</span>
        </div>
    </div>
    
    <section class="products">
    <div class="box-container">
        <?php 
            // Fetch products from the database
            $select_product = $conn->prepare("SELECT * FROM `products`");
            $select_product->execute();
            $result = $select_product->get_result();

            // Check if there are any products
            if ($result->num_rows > 0) 
            {
                while ($fetch_products = $result->fetch_assoc()) 
                {
                    $product_id = $fetch_products['id'];
                    $image_formats = ['jpg', 'png', 'jpeg', 'gif'];
                    $image_path = "image/default.jpg"; 

                    foreach ($image_formats as $format) 
                    {
                        $image_file = "image/product/{$product_id}.{$format}";
                        if (file_exists($image_file)) {
                            $image_path = $image_file;
                            break;
                        }
                    }
        ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
            <img src="<?= $image_path; ?>" alt="Product Image" class="img">
            <div class="content">
                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                <p class="price">$<?= $fetch_products['price']; ?>/-</p>
                
                <div class="flex">
                    <input type="number" name="qty" min="1" value="1" max="99" class="qty">
                </div>
                <div class="buttons">
                    <button type="submit" name="add_to_cart" class="product-button">Cart</button>
                    <button type="submit" name="add_to_wishlist" class="product-button">Wishlist</button>
                    <a href="view_page.php?pid=<?= $product_id; ?>" class="product-button">View</a>
                </div>
            </div>
        </form>
        <?php
                }
            } 
            else 
                echo "<p class='empty'>No Products added yet!</p>";
            
        ?>
    </div>
</section>




    <?php include 'components/footer.php'; ?>
    
    <!-- Include SweetAlert and Custom Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
