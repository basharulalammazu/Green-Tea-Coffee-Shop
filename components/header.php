<?php
    include './components/connection.php';
    $user_id = null;
    if (isset($_SESSION['user_id'])) 
        $user_id = $_SESSION['user_id'];

    if (isset($_POST['logout'])) 
    {
        session_unset();
        session_destroy();
        header('Location: home.php');
    }
?>
<header class = "header">
    <div class = "flex">
        <!-- Logo Section -->
        <a href = "home.php" class = "logo"> 
            <img src = "assets/image/logo.jpg">
        </a>

        <!-- Navigation Bar -->
        <nav class = "navbar">
            <a href = "home.php">Home</a>
            <a href = "view_products.php">Product</a>
            <a href = "order.php">Orders</a>
            <a href = "about.php">About Us</a>
            <a href = "contact.php">Contact Us</a>
        </nav>

        <!-- Icon Section -->
        <div class="icons">
            <!-- User Icon -->
            <i class="bx bxs-user" id="user-btn"></i>

            <?php 
            // Ensure `$user_id` is defined and valid
            if (isset($user_id)) 
            {
                // Database Query to Count Wishlist Items
                $count_wishlist_items = $conn->prepare("SELECT COUNT(*) AS total FROM `wishlist` WHERE `user_id` = ?");
                $count_wishlist_items->bind_param("i", $user_id);
                $count_wishlist_items->execute();
                $result = $count_wishlist_items->get_result();
                $wishlist_data = $result->fetch_assoc();
                $total_wishlist_items = $wishlist_data['total'];
                $count_wishlist_items->close(); // Free the statement
            } 
            else 
                $total_wishlist_items = 0; // Default to 0 if `$user_id` is not set
            ?>

            <!-- Wishlist Icon with Total Count -->
            <a href="wishlist.php" class="cart-btn">
                <i class="bx bx-heart"></i>
                <sup style="color: #fff;"><?php echo $total_wishlist_items; ?></sup>
            </a>

            <?php 
            // Ensure `$user_id` is defined and valid
            if (isset($user_id)) 
            {
                // Database Query to Count Cart Items
                $count_cart_items = $conn->prepare("SELECT COUNT(*) AS total FROM `cart` WHERE `user_id` = ?");
                $count_cart_items->bind_param("i", $user_id);
                $count_cart_items->execute();
                $result = $count_cart_items->get_result();
                $cart_data = $result->fetch_assoc();
                $total_cart_items = $cart_data['total'];
                $count_cart_items->close(); // Free the statement
            } 
            else 
                $total_cart_items = 0; // Default to 0 if `$user_id` is not set
            
            ?>

            <!-- Cart Icon with Total Count -->
            <a href="cart.php" class="cart-btn">
                <i class="bx bx-cart-download"></i>
                <sup style="color: #fff;"><?php echo $total_cart_items; ?></sup> 
            </a>

            <!-- Menu Icon -->
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>

        <!-- User Information Box -->
        <div class="user-box"> 
            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Show User Info and Logout Button -->
                <p style="font-size: 1.2em; font-weight: bold; color: green;">
                    User Name: <span style="color: #333;"><?php echo ($_SESSION['user_name']); ?></span>
                </p>
                <p style="font-size: 1.2em; font-weight: bold; color: green;">
                    Email: <span style="color: #333;"><?php echo ($_SESSION['user_email']); ?></span>
                </p>

                
                <!-- Logout Form -->
                <form method="post">
                    <button type="submit" name="logout" class="logout">log out</button>
                    <a href="profile.php" class="btn">profile</a>
                </form>
            <?php else: ?>
                <!-- Show Login and Register Buttons -->
                <a href="login.php" class="btn">login</a>
                <a href="registration.php" class="btn">register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
