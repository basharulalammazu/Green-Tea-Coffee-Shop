<header class = "header">
    <div class = "flex">
        <a herf = "home.php" class = "logo"> <img src = "assets/image/logo.jpg"></a>
        <nav class = "navbar">
            <a href = "home.php">Home</a>
            <a href = "view_product.php">Product</a>
            <a href = "order.php">Orders</a>
            <a href = "about.php">About Us</a>
            <a href = "contact.php">Contact Us</a>
        </nav>
        <div class = "icons">
            <i class = "bx bxs-user" id = "user-btn"></i>
            <?php 
                $count_wishlist_items = $conn->prepare("SELECT * FROM 'Wishlist' WHERE `User ID` = ?")
                $count_wishlist_items -> execute([$user_id]);
                $total_wishlist_items = $count_wishlist_items->rowCount();
            ?>
            <a href = "wishlist.php" class = "cart-btn"><i class = "bx bx-heart"></i><sup style="color: #fff;"><?=$total_wishlist_items ?></sup></a>
            <?php 
                $count_cart_items = $conn->prepare("SELECT * FROM 'Cart' WHERE `User ID` = ?")
                $count_cart_items -> execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href = "cart.php" class = "cart-btn"><i class = "bx bx-cart-download"></i><sup style="color: #fff;"><?=$total_cart_items ?></sup></a>
            <i class = "bx bx-list-plus" id = "menu-btn" style = "font-size: 2rem;"></i>
        </div>
        <div class = "user-box"> 
            <p>User Name: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <a href = "login.php" class = "btn">login</a>
            <a href = "registration.php" class = "btn">register</a>
            <form method = "post">
                <button type = "submit" name = "logout" class = "logout">log out</button>
        </form>
        </div>
    </div>
</header>