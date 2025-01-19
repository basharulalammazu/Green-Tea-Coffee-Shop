<?php
    include 'components/connection.php';

    session_start();
    if (isset($_SESSION['user_id']))
        $user_id = $_SESSION['user_id'];
    else 
        $user_id = '';

    if (isset($_POST['logout']))
    {
        session_unset();
        session_destroy();
        header("location: login.php");
    }

    // Adding product in wishlist
    if (isset($_POST['add_to_wishlist'])) 
    {
        if (!isset($_SESSION['user_id'])) 
        {
            $warning_msg[] = 'Please login to add product to wishlist';
            header("location: login.php");
            exit();
        }
        $product_id = $_POST['product_id'];
    
        // Verify if the product exists in the wishlist
        $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->bind_param("ii", $user_id, $product_id);
        $verify_wishlist->execute();
        $result_wishlist = $verify_wishlist->get_result();
    
        // Verify if the product exists in the cart
        $cart_num = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $cart_num->bind_param("ii", $user_id, $product_id);
        $cart_num->execute();
        $result_cart = $cart_num->get_result();
    
        if ($result_wishlist->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your wishlist';
        else if ($result_cart->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your cart';
        else 
        {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
            $select_price->bind_param("i", $product_id);
            $select_price->execute();
            $result_price = $select_price->get_result();
            $fetch_price = $result_price->fetch_assoc();
    
            // Insert into wishlist
            $insert_wishlist = $conn->prepare("INSERT INTO wishlist (user_id, product_id, price) VALUES (?, ?, ?)");
            $insert_wishlist->bind_param("iid", $user_id, $product_id, $fetch_price['price']);
            $insert_wishlist->execute();
            $succcess_msg[] = 'Product added to wishlist successfully';
    
            // Close the prepared statements
            $insert_wishlist->close();
            $select_price->close(); // Safely closing after initialization
        }
    
        // Close the prepared statements and results
        $verify_wishlist->close();
        $cart_num->close();
    }
    
    // Adding product to cart
    if (isset($_POST['add_to_cart'])) 
    {
        if (!isset($_SESSION['user_id'])) 
        {
            $warning_msg[] = 'Please login to add product to cart';
            header("location: login.php");
            exit();
        }
        $product_id = $_POST['product_id'];
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);
    
        // Verify if the product already exists in the cart
        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $verify_cart->bind_param("ii", $user_id, $product_id);
        $verify_cart->execute();
        $result_cart = $verify_cart->get_result();
    
        // Check the cart item count for the user
        $max_cart_items = $conn->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?");
        $max_cart_items->bind_param("i", $user_id);
        $max_cart_items->execute();
        $result_cart_count = $max_cart_items->get_result();
        $cart_count = $result_cart_count->fetch_assoc()['cart_count'];
    
        if ($result_cart->num_rows > 0)
            $warning_msg[] = 'Product already exists in your cart';
        else if ($cart_count >= 20) 
            $warning_msg[] = 'Cart is full';
        else 
        {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
            $select_price->bind_param("i", $product_id);
            $select_price->execute();
            $result_price = $select_price->get_result();
            $fetch_price = $result_price->fetch_assoc();
    
            // Insert into cart
            $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
            $insert_cart->bind_param("iidi", $user_id, $product_id, $fetch_price['price'], $qty);
            $insert_cart->execute();
            $succcess_msg[] = 'Product added to cart successfully';
    
            // Close the prepared statements
            $insert_cart->close();
            $select_price->close(); // Safely closing after initialization
            $max_cart_items->close();
        }
    
        // Close the prepared statements and results
        $verify_cart->close();
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
