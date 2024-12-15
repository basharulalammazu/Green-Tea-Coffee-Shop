<header class = "header">
    <div class = "flex">
        <!-- Logo Section -->
        <a href = "home.php" class = "logo"> 
            <img src = "assets/image/logo.jpg">
        </a>

        <!-- Navigation Bar -->
        <nav class = "navbar">
            <a href = "home.php">Home</a>
            <a href = "view_product.php">Product</a>
            <a href = "order.php">Orders</a>
            <a href = "about.php">About Us</a>
            <a href = "contact.php">Contact Us</a>
        </nav>

        <!-- Icon Section -->
        <div class = "icons">
            <!-- User Icon -->
            <i class = "bx bxs-user" id = "user-btn"></i>

            <?php 
            /*
                // Database Query to Count Wishlist Items
                // Prepares a SQL query to count all rows in the 'Wishlist' table for the logged-in user
                $count_wishlist_items = $conn->prepare("SELECT * FROM `Wishlist` WHERE `User ID` = ?");
                
                // Executes the query with the `User ID` passed as a parameter (from the session or logged-in user context)
                $count_wishlist_items -> execute([$user_id]);
                
                // Fetches the number of rows returned by the query
                $total_wishlist_items = $count_wishlist_items->rowCount();
                */
            ?>
            <!-- Wishlist Icon with Total Count -->
            <a href = "wishlist.php" class = "cart-btn">
                <i class = "bx bx-heart"></i>
                <sup style="color: #fff;"> 0 </sup>
                <!-- <sup style="color: #fff;"><?php /* echo $total_wishlist_items ; */ ?></sup> -->
            </a>

            <?php 
            /*
                // Database Query to Count Cart Items
                // Prepares a SQL query to count all rows in the 'Cart' table for the logged-in user
                $count_cart_items = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ?");
                
                // Executes the query with the `User ID` passed as a parameter (from the session or logged-in user context)
                $count_cart_items -> execute([$user_id]);
                
                // Fetches the number of rows returned by the query
                $total_cart_items = $count_cart_items->rowCount();
            */
            ?>
            <!-- Cart Icon with Total Count -->
            <a href = "cart.php" class = "cart-btn">
                <i class = "bx bx-cart-download"></i>
                <sup style="color: #fff;"> 0 </sup>
                <!-- <sup style="color: #fff;"><?php  /* echo $total_cart_items; */ ?></sup> -->
            </a>

            <!-- Menu Icon -->
            <i class = "bx bx-list-plus" id = "menu-btn" style = "font-size: 2rem;"></i>
        </div>

        <!-- User Information Box -->
        <div class = "user-box"> 
            <p>User Name: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href = "login.php" class = "btn">login</a>
            <a href = "registration.php" class = "btn">register</a>

            <!-- Logout Form -->
            <form method = "post">
                <button type = "submit" name = "logout" class = "logout">log out</button>
            </form>
        </div>
    </div>
</header>
