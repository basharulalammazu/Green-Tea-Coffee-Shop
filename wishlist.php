<?php
    include 'components/connection.php';
    session_start();
    if (isset($_SESSION['user_id']))
        $user_id = $_SESSION['user_id'];
    else
    {
        $warning_msg = 'Please login to view your wishlist';
        header("location: login.php");
        exit();

    }

    if (isset($_POST['logout'])) 
    {
        session_unset();
        session_destroy();
        header("location: login.php");
    }

    // Adding product to wishlist
    if (isset($_POST['add_to_wishlist'])) 
    {
        $product_id = $_POST['product_id'];

        $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->bind_param("ss", $user_id, $product_id);
        $verify_wishlist->execute();
        $result_wishlist = $verify_wishlist->get_result();

        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $verify_cart->bind_param("ss", $user_id, $product_id);
        $verify_cart->execute();
        $result_cart = $verify_cart->get_result();

        if ($result_wishlist->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your wishlist';
        else if ($result_cart->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your cart';
        else 
        {
            $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
            $select_price->bind_param("s", $product_id);
            $select_price->execute();
            $result_price = $select_price->get_result();
            $fetch_price = $result_price->fetch_assoc();

            $insert_wishlist = $conn->prepare("INSERT INTO wishlist (user_id, product_id, price) VALUES (?, ?, ?)");
            $insert_wishlist->bind_param("ssd", $user_id, $product_id, $fetch_price['price']);
            $insert_wishlist->execute();
            $success_msg[] = 'Product added to wishlist successfully';
        }
    }

    // Adding product to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $qty = 1;

        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $verify_cart->bind_param("ss", $user_id, $product_id);
        $verify_cart->execute();
        $result_cart = $verify_cart->get_result();

        $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $max_cart_items->bind_param("s", $user_id);
        $max_cart_items->execute();
        $result_max = $max_cart_items->get_result();

        if ($result_cart->num_rows > 0) 
            $warning_msg[] = 'Product already exists in your cart';
        else if ($result_max->num_rows > 20) 
            $warning_msg[] = 'Cart is full';
        else 
        {
            $select_price = $conn->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
            $select_price->bind_param("s", $product_id);
            $select_price->execute();
            $result_price = $select_price->get_result();
            $fetch_price = $result_price->fetch_assoc();

            $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
            $insert_cart->bind_param("ssdi", $user_id, $product_id, $fetch_price['price'], $qty);
            $insert_cart->execute();
            $success_msg[] = 'Product added to cart successfully';
        }
    }

    // Delete item from wishlist
    if (isset($_POST['delete_item'])) 
    {
        $wishlist_id = $_POST['wishlist_id'];
        $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

        $verify_delete_items = $conn->prepare("SELECT * FROM wishlist WHERE id = ?");
        $verify_delete_items->bind_param("s", $wishlist_id);
        $verify_delete_items->execute();
        $result_delete = $verify_delete_items->get_result();

        if ($result_delete->num_rows > 0) 
        {
            $delete_wishlist_id = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
            $delete_wishlist_id->bind_param("s", $wishlist_id);
            $delete_wishlist_id->execute();
            $success_msg[] = "Wishlist item successfully deleted";
        } 
        else 
            $warning_msg[] = "Wishlist item already deleted";
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
    <title>Green Coffee - Wishlist Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
        <div class = "banner">
                <h1>My Wishlist</h1>
            </div>
            <div class = "title2">
                <a href = "home.php">home</a><span> / Wishlist</span>
            </div>
        </div>
        <section class = "products">
            <h1 class = "title">Your Wishlist</h1>
            <div class = "box container">
            <?php
                $grand_total = 0;

                // Use prepared statements with MySQLi
                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ?");
                $select_wishlist->bind_param("s", $user_id); // Bind the user_id parameter
                $select_wishlist->execute();
                $result_wishlist = $select_wishlist->get_result();

                if ($result_wishlist->num_rows > 0) 
                {
                    while ($fetch_wishlist = $result_wishlist->fetch_assoc()) 
                    {
                        $product_id = $fetch_wishlist['product_id'];
                        
                        // Fetch product details
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE `id` = ?");
                        $select_products->bind_param("s", $product_id);
                        $select_products->execute();
                        $result_products = $select_products->get_result();

                        if ($result_products->num_rows > 0) 
                        {
                            $fetch_products = $result_products->fetch_assoc();
                            
                            // Check for image existence with different formats
                            $image_formats = ['jpg', 'png', 'jpeg', 'gif'];
                            $image_path = '';
                            foreach ($image_formats as $format) {
                                $potential_path = "image/product/" . $fetch_products['id'] . "." . $format;
                                if (file_exists($potential_path)) 
                                {
                                    $image_path = $potential_path;
                                    break;
                                }
                            }
                            
                            // Use a default image if no file is found
                            if (empty($image_path)) 
                                $image_path = "image/product/default.png";
                ?>
                            <form class="box" action="" method="post">
                                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                                <img src="<?= $image_path; ?>" alt="<?= $fetch_products['name']; ?>" class = "img">
                                <div class="button">
                                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                    <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                                    <button type="submit" name="delete_item" onclick="return confirm('Delete this item from your wishlist?');"><i class="bx bx-heart"></i></button>
                                </div>
                                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                                <div class="flex">
                                    <p class="price">Price $<?= $fetch_products['price']; ?>/-</p>
                                </div>
                                <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn"> Buy Now </a>
                            </form>
                <?php
                            $grand_total += $fetch_wishlist['price'];
                        }
                        $select_products->close();
                    }
                } 
                else 
                    echo "<p class='empty'>No Products added yet!</p>";
                
                $select_wishlist->close();
                ?>

            </div>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>