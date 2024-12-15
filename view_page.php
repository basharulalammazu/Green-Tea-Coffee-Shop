<?php
    //include 'components/connection.php';

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
        //$id = unique_id(); //Function is to be created
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
         //$id = unique_id(); //Function is to be created
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
            <a href = "home.php">home</a><span>Product Details</span>
        </div>
    </div>
    <section class = "view_page">
        <?php 
            if (isset($_GET['pid']))
            {
                $pid = $_GET['pid'];
                $select_products = $conn -> prepare("SELECT * FROM `Product` WHERE ID = '$pid'");
                $select_products -> execute();

                if ($select_products -> rowCount() > 0)
                {
                    while($fetech_products = $select_products-fetch(PDO::FETCH_ASSOC))
                    {
        ?>
        <form method = "post">
            <img src = "image/<?php echo $fetech_products['images']; ?>">
            <div class = "detail">
                <div class = "price"><?php echo $fetech_products['price']; ?></div>
                <div class = "name"><?php echo $fetech_products['name']; ?></div>
                <div class = "detail">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, 
                        vel quis sed possimus veniam facere repellat ea voluptatibus culpa 
                        officia dignissimos expedita laudantium nam rerum repudiandae 
                        consequatur suscipit dolor non? Lorem ipsum dolor, sit amet consectetur 
                        adipisicing elit. Corrupti, ratione eum tenetur culpa delectus molestiae 
                        saepe iusto repudiandae voluptatum et facere hic excepturi cumque mollitia 
                        cupiditate quam eveniet porro explicabo.
                    </p>
                </div>
                <input type = "hidden" name = "product_id" value = "<?php echo $fetech_products['id']; ?>">;
                <div class = "button">
                    <button type = "submit" name = "add_to_wishlist" class = "btn">Add to wishlist<i class = "bx bx-heart"></i><button>
                    <input type = "hidden" name = "qty" value = "1" min = "0" class = "quantity">
                    <button type = "submit" name = "add_to_cart" class = "btn">Add to wishlist<i class = "bx bx-cart"></i><button>
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
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>