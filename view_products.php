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
        $id = unique_id(); //Function is to be created
        $product_id = $_POST['product_id'];

        $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
        $verify_wishlist -> execute([$user_id, $product_id]);

        $cart_num = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $cart_num -> execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0)
            $warning_mes[] = 'Producct already exist in you wishlist';
        else if ($cart_num  -> rowCount() > 0)
            $warning_mes[] = 'product already exist in your cart';
        else 
        {
            $select_price = $_conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $select_price -> execute([$product_id]);
            $fetch_price = $select_price -> fetch(PDO::FETCH_ASSOC);

            $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES ( ?, ?, ?)");
            $insert_wishlist -> execute([$user_id, $product_id, $fetch_price['price']]);
            $success_mess[] = 'product added to wishlist successfully';
        }
    }

     // Adding product in cart
     if(isset($_POST['add_to_cart']))
     {
         $id = unique_id(); //Function is to be created
         $product_id = $_POST['product_id'];

         $qty = $_POST['qty'];
         $qty = filter_var($qty, FILTER_SANITIZE_STRING);

         $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
         $verify_cart -> execute([$user_id, $product_id]);
 
         $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
         $max_cart_items -> execute([$user_id]);
 
         if ($verify_cart->rowCount() > 0)
             $warning_mes[] = 'Producct already exist in you wishlist';
         else if ($max_cart_items -> rowCount() > 20)
             $warning_mes[] = 'Cart is full';
         else 
         {
             $select_price = $_conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
             $select_price -> execute([$product_id]);
             $fetch_price = $select_price -> fetch(PDO::FETCH_ASSOC);
 
             $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
             $insert_cart -> execute([$id, $user_id, $product_id, $fetch_price['price']], $qty);
             $success_mess[] = 'product added to wishlist successfully';
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
    <title>Green Coffee - Shop Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Shop</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">home</a><span> / Our Shop</span>
        </div>
    </div>
    <section class="products">
    <div class="box-container">
        <?php 
            // Prepare SQL query to select products
            $select_product = $conn->prepare("SELECT * FROM `Products`");
            $select_product->execute();
            $result = $select_product->get_result(); // Fetch result set

            // Check if there are any products
            if ($result->num_rows > 0) 
            {
                // Loop through each product
                while ($fetch_products = $result->fetch_assoc()) 
                { 
        ?>
                    <form action="" method="post" class="box">
                       < <img src="image/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
                
                        <!-- Buttons -->
                        <div class="button">
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                            <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show"></a>
                        </div>
                
                        <!-- Product Name -->
                        <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                        
                        <!-- Price and Quantity -->
                        <div class="flex">
                            <p class="price">Price $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                            <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                        </div>

                        <!-- Buy Now Button -->
                        <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Buy Now</a> 
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
    <?php include 'components/alert.php'; ?>
</body>
</html>