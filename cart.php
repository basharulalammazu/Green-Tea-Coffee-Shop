<?php
   // include 'components/connection.php';

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

    //Update cart
    if (isset($_POST['update_cart'])) {

        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    
        $update_qty = $conn->prepare("UPDATE `Cart` SET `Quantity` = ? WHERE `ID` = ?");
        $update_qty->execute([$qty, $cart_id]);
    
        $success_msg[] = 'cart quantity updated successfully';
    }
    
 

     // Delete item from wishlist
     if (isset($_POST['delete_item']))
     {
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        $verify_delete_items = $conn->prepare("SELECT * FROM `Cart' WHERE ID = ?");
        $verify_delete_items->execute([$cart_id]);

        if ($verify_delete_items -> rowsCount()>0)
        {
            $delete_cart_id = $conn -> prepare("DELETE FROM `Cart` WHERE ID = ?");
            $delete_cart_id -> execute([$cart_id]);
            $success_msg[] = "Cart item successfully deleted";
        }

        else 
            $warning_msg[] = "Cart item already deleted";
     }

     // Check if the "empty_cart" button was clicked
    if (isset($_POST['empty_cart'])) {

        // Prepare a SELECT statement to check if there are any items in the cart for the current user
        $verify_empty_item = $conn->prepare("SELECT * FROM `Cart` WHERE u`User ID` = ?"); 
        $verify_empty_item->execute([$user_id]); 

        // If there are items in the cart, proceed with deletion
        if ($verify_empty_item->rowCount() > 0) 
        {
            $delete_cart_id = $conn->prepare("DELETE FROM `Cart` WHERE `User ID` = ?");
            $delete_cart_id->execute([$user_id]);
            $success_msg[] = "empty successfully"; 
        } 
        else 
            $warning_msg[] = 'cart item already deleted';             // If there are no items in the cart, display a warning message
        
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
            <a href = "home.php">home</a><span>Cart</span>
        </div>
    </div>
    <section class = "products">
        <h1 class = "title">Products added in cart</h1>
        <div class = "box-container">
        <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0)
                {
                    while($fetech_cart = $select_cart->fetch(PDO::FETCH_ASSOC))
                    {
                        $select_products = $conn->prepare("SELECT * FROM `Products` WHERE `User ID` = ?");
                        $select_products->execute([$fetech_cart['product_id']]);
                        if($select_products->rowCount() > 0)
                        {
                            $fetch_products = $select_products->fetech(PDO::FETCH_ASSOC);
                ?>
                <form class = "box" action ="#" method = "post">
                    <input type = "hidden" name = "cart_id" value = "<?=$fetech_cart['id']; ?>">
                    <img src = "image/<?=$fetch_products['image']; ?>" class = "img">
                    <h3 class = "name"><?=$fetch_products['name'];?></h3>
                    <div class = "flex">
                        <p class = "price">Price $<?=$fetch_products['price']; ?>/-</p>
                        <input type = "number" name = "qty" min = "1" value = "<?=$fetech_cart['qty'];?>" max = "99" maxlength = "2" class = "qty" required>
                        <button type = "submit" name = "update_cart" class = "bx bxs-edit fa-edit"></button>
                    </div>
                    <p class = "sub-total">Sub Total: <span>$<?=$sub_total = ($fetch_cart['qty']*$fetch_cart['price']) ?></span></p>
                    <button type = "submit" name = "delete_item" class = "btn" onclick = "return confirm('Delete this item')">Delete</button>
                </form>
        <?php
                        $grand_total += $sub_total;
                        }
                        else 
                            echo "<p class = 'empty'>Products was not found</p>";
                    }
                }
                else 
                echo "<p class = 'empty'>No Products added yet!</p>;"
            ?>
        </div>  
        <?php 
            if ($grand_total != 0){
        ?>
        
            <div class="cart-total">
            <p>total amount payable : <span>$ <?= $grand_total; ?></span></p>

            <div class="button">
                <form method="post">
                    <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure to empty your cart?')">Empty Cart</button>
                </form>
                <a href="checkout.php" class="btn">Proceed to checkout</a>
            </div>
            </div>
        </div>
        <?php } ?>
    </section>
    
    <?php include 'components/footer.php'; ?>
        

    </div>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>