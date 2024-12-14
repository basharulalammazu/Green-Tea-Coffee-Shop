<header class = "header">
    <div class = "flex">
        <a herf = "home.php" class = "logo"> <img src = "assets/image/logo.jpg"></a>
        <nav class = "navbar">
            <a href = "home.php">Home</a>
            <a href = "view_product.php">Product</a>
            <a href = "order.php">Order</a>
            <a href = "contact.php">Contact Us</a>
        </nav>
        <div class = "icon"> 
            <i class = "bx bxs-user" id = "user-btn"></i>
            <a href = "wishlist.php" class = "cart-btn"><i class = "bx bx-heart"></i><sup>0</sup></a>
            <a href = "cart.php" class = "cart-btn"><i class = "bx bx-cart-download"></i><sup>0</sup></a>
            <i class = "bx bx-list-plus" id = "menu-btn" style = "font-size: 2rem;"></i>
        </div>
        <div class = "user-box"> 
            <p>User Name: <span><?php // echo $_SESSION['user_name']; ?></span></p>
            <p>Email: <span><?php // echo $_SESSION['user_name']; ?></span></p>
            <a href = "login.php" class = "btn">login</a>
            <a href = "registration.php" class = "btn">register</a>
            <form method = "post">
                <button type = "submit" name = "logout" class = "logout">log out</button>
        </form>
        </div>
    </div>
</header>