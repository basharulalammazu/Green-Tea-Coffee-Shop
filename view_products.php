<?php
    /*include 'components/connection.php';

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

        $verify_wishlist = $conn->prepare("SELECT * FROM `Wishlist` WHERE `User ID` = ? AND `Product ID` = ?");
        $verify_wishlist -> execute([$user_id, $product_id]);

        $cart_num = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ? AND `Product ID` = ?");
        $cart_num -> execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0)
            $warning_mes[] = 'Producct already exist in you wishlist';
        else if ($cart_num  -> rowCount() > 0)
            $warning_mes[] = 'product already exist in your cart';
        else 
        {
            $select_price = $_conn->prepare("SELECT * FROM 'Products' WHERE ID = ? LIMIT 1");
            $select_price -> execute([$product_id]);
            $fetch_price = $select_price -> fetch(PDO::FETCH_ASSOC);

            $insert_wishlist = $conn->prepare("INSERT INTO `Wishlist` (`ID`, `User ID`, `Product ID`, `Price`) VALUES (?, ?, ?, ?)");
            $insert_wishlist -> execute([$id, $user_id, $product_id, $fetch_price['price']]);
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

         $verify_cart = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ? AND `Product ID` = ?");
         $verify_cart -> execute([$user_id, $product_id]);
 
         $max_cart_items = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ?");
         $max_cart_items -> execute([$user_id]);
 
         if ($verify_cart->rowCount() > 0)
             $warning_mes[] = 'Producct already exist in you wishlist';
         else if ($max_cart_items -> rowCount() > 20)
             $warning_mes[] = 'Cart is full';
         else 
         {
             $select_price = $_conn->prepare("SELECT * FROM 'Products' WHERE ID = ? LIMIT 1");
             $select_price -> execute([$product_id]);
             $fetch_price = $select_price -> fetch(PDO::FETCH_ASSOC);
 
             $insert_cart = $conn->prepare("INSERT INTO `Cart` (`ID`, `User ID`, `Product ID`, `Price`, `Quantity`) VALUES (?, ?, ?, ?, ?)");
             $insert_cart -> execute([$id, $user_id, $product_id, $fetch_price['price']], $qty);
             $success_mess[] = 'product added to wishlist successfully';
        }
    }
    */
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
    <section class = "products">
        <div class = "box-container">
            <?php 
               $select_product = $conn->prepare("SELECT * FROM `Products`");
                $select_product -> execute();

                if ($select_product -> rowCount() > 0)
                {
                    while ($fetch_products = $select_product -> fetch(PDO::FETCH_ASSOC)) 
                    { 
            ?>
                <form action = "#" method = "post" class = "box">
                    <img src = "image/<?=$fetch_products['image']; ?>">
                    <div class = "button">
                        <button type = "submit" name = "add_to_cart"><i class = "bx bx-cart"></i></button>
                        <button type = "submit" name = "add_to_wishlist"><i class = "bx bx-heart"></i></button>
                        <a href = "view_page.php?pid = <?php $fetch_product['id']; ?>"class = "bx bxs-show"></a>
                    </div>
                    <h3 class = "name"> <?=$fetch_products['name']; ?></h3>
                    <input type = "hidden" name = "product_id" value = "<?=$fetch_products['id']; ?>">
                    <div class = "fles">
                        <p class = "price">Price $<?=$fetch_product['price']; ?>/-</p>
                        <input type = "number" name = "qty" required min = "1" value = "1" max = "99" maxlength = "2" class = "qty">
                    </div>
                    <a href = "checkout.php?get_id=<?=$fetech_products['id']; ?>" class = "btn"> Buy Now </a> 
            <?php
                }
            }
            else 
                echo "<p class = 'empty'>No Products added yet!</p>;"
            ?>
        </div> 
    </section>
    
    <?php include 'components/footer.php'; ?>
    <!--Home Slider end-->
        

    </div>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>