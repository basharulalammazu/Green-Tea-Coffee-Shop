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
    if (isset($_POST['add_to_wishlist'])) {
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
    
        if ($result_wishlist->num_rows > 0) {
            $warning_mes[] = 'Product already exists in your wishlist';
        } elseif ($result_cart->num_rows > 0) {
            $warning_mes[] = 'Product already exists in your cart';
        } else {
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
            $success_mess[] = 'Product added to wishlist successfully';
    
            // Close the prepared statements
            $insert_wishlist->close();
            $select_price->close(); // Safely closing after initialization
        }
    
        // Close the prepared statements and results
        $verify_wishlist->close();
        $cart_num->close();
    }
    
    // Adding product to cart
    if (isset($_POST['add_to_cart'])) {
        $id = uniqid(); // Generate unique ID for the cart entry
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
            $warning_mes[] = 'Product already exists in your cart';
        else if ($cart_count >= 20) 
            $warning_mes[] = 'Cart is full';
        else 
        {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
            $select_price->bind_param("i", $product_id);
            $select_price->execute();
            $result_price = $select_price->get_result();
            $fetch_price = $result_price->fetch_assoc();
    
            // Insert into cart
            $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $insert_cart->bind_param("siiid", $user_id, $product_id, $fetch_price['price'], $qty);
            $insert_cart->execute();
            $success_mess[] = 'Product added to cart successfully';
    
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel = 'stylesheet'>
    <title>Green Coffee - Shop Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Shop</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a><span> / Our Shop</span>
        </div>
    </div>
    <section class="products">
    <div class="box-container">
        <?php 
            // Prepare SQL query to select products
            $select_product = $conn->prepare("SELECT * FROM `products`");
            $select_product->execute();
            $result = $select_product->get_result(); // Fetch result set

            // Check if there are any products
            if ($result->num_rows > 0) 
            {
                while ($fetch_products = $result->fetch_assoc()) 
                {
                    $product_id = $fetch_products['id'];
                    
                    // Check for the existence of the product image file
                    $image_formats = ['jpg', 'png', 'jpeg', 'gif']; // Supported formats
                    $image_path = "image/default.jpg"; // Default placeholder image
                    
                    foreach ($image_formats as $format) {
                        $image_file = "image/product/{$product_id}.{$format}";
                        if (file_exists($image_file)) 
                        {
                            $image_path = $image_file; // Set the correct image path
                            break;
                        }
                        else 
                            $image_path = "image/default_product.png"; // Set the default image path
                    }
            ?>
                    <form action="" method="post" class="box">
                        <img src="<?= ($image_path); ?>" alt="Product Image">
                        
                        <!-- Buttons -->
                        <div class="button">
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                            <a href="view_page.php?pid=<?= ($product_id); ?>" class="bx bxs-show"></a>
                        </div>
                        
                        <!-- Product Name -->
                        <h3 class="name"><?= ($fetch_products['name']); ?></h3>
                        <input type="hidden" name="product_id" value="<?= ($product_id); ?>">
                        
                        <!-- Price and Quantity -->
                        <div class="flex">
                            <p class="price">Price $<?= ($fetch_products['price']); ?>/-</p>
                            <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                        </div>
            
                        <!-- Buy Now Button -->
                        <a href="checkout.php?get_id=<?= ($product_id); ?>" class="btn">Buy Now</a> 
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
    <!--Home Slider end-->
        

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>