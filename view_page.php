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
    
    if(isset($_POST['add_to_wishlist'])) 
    {
        if (!isset($_SESSION['user_id'])) 
        {
            $warning_msg[] = 'Please login to add product to wishlist';
            header("location: login.php");
            exit();
        }
        $product_id = $_POST['product_id'];

        // Fix SQL syntax
        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ? AND `product_id` = ?");
        $verify_wishlist->bind_param("ii", $user_id, $product_id); // Bind user_id and product_id as integers
        $verify_wishlist->execute();
        $wishlist_result = $verify_wishlist->get_result();

        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ? AND `product_id` = ?");
        $cart_num->bind_param("ii", $user_id, $product_id); // Bind user_id and product_id as integers
        $cart_num->execute();
        $cart_result = $cart_num->get_result();

        if ($wishlist_result->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your wishlist';
        else if ($cart_result->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your cart';
        else 
        {
            // Fetch product price
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE `id` = ? LIMIT 1");
            $select_price->bind_param("i", $product_id); // Bind product_id as integer
            $select_price->execute();
            $price_result = $select_price->get_result();
            $fetch_price = $price_result->fetch_assoc();

            // Insert into wishlist
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (`user_id`, `product_id`, `price`) VALUES (?, ?, ?)");
            $insert_wishlist->bind_param("iid", $user_id, $product_id, $fetch_price['price']); // Bind user_id, product_id as integers and price as double
            $insert_wishlist->execute();

            $succcess_msg[] = 'Product added to wishlist successfully';
        }
    }


    // Adding product in cart
    if(isset($_POST['add_to_cart']))
    {
        if (!isset($_SESSION['user_id'])) 
        {
            $warning_msg[] = 'Please login to add product to cart';
            header("location: login.php");
            exit();
        }
        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Verify if the product is already in the cart
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ? AND `product_id` = ?");
        $verify_cart->bind_param("ii", $user_id, $product_id);
        $verify_cart->execute();
        $verify_cart->store_result(); // Store the result to avoid sync issues

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
        $max_cart_items->bind_param("i", $user_id);
        $max_cart_items->execute();
        $max_cart_items->store_result(); // Store the result to avoid sync issues

        if ($verify_cart->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your cart';
        else if ($max_cart_items->num_rows > 20) 
            $warning_msg[] = 'Cart is full';
        else 
        {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
            $select_price->bind_param("i", $product_id);
            $select_price->execute();
            $select_price->store_result(); // Store the result to avoid sync issues
            $select_price->bind_result($price);
            $select_price->fetch();

            // Insert into cart
            $insert_cart = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `price`, `quantity`) VALUES (?, ?, ?, ?)");
            $insert_cart->bind_param("iidi", $user_id, $product_id, $price, $qty);
            $insert_cart->execute();

            $success_msg[] = 'Product added to cart successfully';

            // Close prepared statements to free resources
            $insert_cart->close();
            $select_price->close();
        }

        // Free resources for these queries
        $verify_cart->close();
        $max_cart_items->close();
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
    <title>Green Coffee - Product Details Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Product Details</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a><span> / Product Details</span>
        </div>
    </div>
    <section class = "view_page">
    <?php 
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            
            // Prepare and execute query to fetch the product by id
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->bind_param("i", $pid); // Bind the product id as integer
            $select_products->execute();
            $result = $select_products->get_result(); // Get the result of the query

            if ($result->num_rows > 0) 
            {
                while ($fetch_products = $result->fetch_assoc()) 
                {
                    $image_formats = ['jpg', 'png', 'jpeg', 'gif'];
                    $image_path = "image/default.jpg"; 

                    foreach ($image_formats as $format) 
                    {
                        $image_file = "image/product/{$fetch_products['id']}.{$format}";
                        if (file_exists($image_file)) {
                            $image_path = $image_file;
                            break;
                        }
                    }
    ?>
                    <form method="post">
                        <img src="<?php echo $image_path; ?>" alt="Product Image">
                        <div class="detail">
                            <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                            <div class="name"><?php echo $fetch_products['name']; ?></div>
                            <div class="detail">
                                <p><?php echo $fetch_products['product_details']; ?></p>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                            <div class="button">
                                <button type="submit" name="add_to_wishlist" class="btn">Add to wishlist<i class="bx bx-heart"></i></button>
                                <input type="hidden" name="qty" value="1" min="0" class="quantity">
                                <button type="submit" name="add_to_cart" class="btn">Add to cart<i class="bx bx-cart"></i></button>
                            </div>
                        </div>
                    </form>
        <?php 
                    }
                }
            }
        ?>
    </section>
    
    <?php include 'components/footer.php'; ?>
        

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>