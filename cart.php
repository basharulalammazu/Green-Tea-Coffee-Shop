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
    $warning_msg = 'Please login to view your cart';
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Logout handling
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: login.php");
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    
    $update_qty = mysqli_prepare($conn, "UPDATE `cart` SET `quantity` = ? WHERE `id` = ?");
    mysqli_stmt_bind_param($update_qty, "ii", $qty, $cart_id);
    mysqli_stmt_execute($update_qty);
    
    $success_msg[] = 'Cart quantity updated successfully';
}

// Delete item from cart
if (isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

    $verify_delete_items = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete_items, "i", $cart_id);
    mysqli_stmt_execute($verify_delete_items);
    $result = mysqli_stmt_get_result($verify_delete_items);

    if (mysqli_num_rows($result) > 0) {
        $delete_cart_id = mysqli_prepare($conn, "DELETE FROM `cart` WHERE id = ?");
        mysqli_stmt_bind_param($delete_cart_id, "i", $cart_id);
        mysqli_stmt_execute($delete_cart_id);
        $success_msg[] = "Cart item successfully deleted";
    } else {
        $warning_msg[] = "Cart item already deleted";
    }
}

// Empty cart
if (isset($_POST['empty_cart'])) {
    // Check if there are any items in the cart
    $verify_empty_item = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE `user_id` = ?");
    mysqli_stmt_bind_param($verify_empty_item, "i", $user_id);
    mysqli_stmt_execute($verify_empty_item);
    $result = mysqli_stmt_get_result($verify_empty_item);

    if (mysqli_num_rows($result) > 0) {
        $delete_cart_id = mysqli_prepare($conn, "DELETE FROM `cart` WHERE `user_id` = ?");
        mysqli_stmt_bind_param($delete_cart_id, "i", $user_id);
        mysqli_stmt_execute($delete_cart_id);
        $success_msg[] = "Cart successfully emptied.";
    } else {
        $warning_msg[] = 'No items in the cart to delete.';
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
    <title>Green Coffee - My Cart Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>My Wishlist</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">home</a><span> / Cart</span>
        </div>
    </div>
    <h1 class = "title">Products added in cart</h1>
    <section class = "products">
        
        <div class = "box-container">
        <div class="box-container">
    <?php
        $grand_total = 0;
        // Fetch the cart items for the logged-in user
        $select_cart = "SELECT * FROM `cart` WHERE `user_id` = '$user_id'";
        $cart_result = $conn->query($select_cart); // Execute query using mysqli
        
        // Check if the cart has items
        if ($cart_result->num_rows > 0) {
            while ($fetch_cart = $cart_result->fetch_assoc()) {
                // Prepare a query to select products based on cart product_id
                $select_products = "SELECT * FROM `products` WHERE `id` = '" . $fetch_cart['product_id'] . "'";
                $product_result = $conn->query($select_products);  // Execute query to get product details
                
                if ($product_result->num_rows > 0) 
                {
                    $image_formats = ['jpg', 'jpeg', 'png'];
                    $fetch_products = $product_result->fetch_assoc();  // Fetch the product details
                    foreach ($image_formats as $format) 
                    {
                        $temp_path = "image/product/{$fetch_products['id']}.$format";
                        if (file_exists($temp_path)) 
                        {
                            $image_path = $temp_path;
                            break;
                        }
                    }

                    ?>
                    <form class="box" action="" method="post">
                        <input type="hidden" name="cart_id" value="<?=$fetch_cart['id']; ?>">
                        <img src="<?= $image_path; ?>" class="img">
                        <h3 class="name"><?=$fetch_products['name'];?></h3>
                        <div class="flex">
                            <p class="price">Price $<?=$fetch_products['price']; ?>/-</p>
                            <input type="number" name="qty" min="1" value="<?=$fetch_cart['quantity'];?>" max="99" maxlength="2" class="qty" required>
                            <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
                        </div>
                        <p class="sub-total">Sub Total: <span>$<?=($sub_total = $fetch_cart['quantity'] * $fetch_products['price']); ?></span></p>
                        <button type="submit" name="delete_item" class="bttn" onclick="return confirm('Delete this item')">Delete</button>
                    </form>
                    <?php
                    // Update the grand total after each iteration
                    $grand_total += $sub_total;
                }
                else {
                    echo "<p class='empty'>Product not found</p>";
                }
            }
        } else {
            echo "<p class='empty'>No products added yet!</p>";
        }
    ?>
</div>

        <?php 
            if ($grand_total != 0)
            {
        ?>
        
            <div class="cart-total">
            <p class="payable">Total amount payable : <span>$ <?= $grand_total; ?></span></p>

            <div class="button">
                <form method="post">
                    <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure to empty your cart?')">Empty Cart</button>
                </form>
                <a href="checkout.php" class="btn">Proceed to checkout</a>
            </div>
            </div>
        </div>
        <?php 
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