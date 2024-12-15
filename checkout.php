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

    if (isset($_POST['place_order'])) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
    
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
    
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
    
        $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
    
        $address_type = $_POST['address_type'];
        $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
    
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
    
        $varify_cart = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ?");
        $varify_cart->execute([$user_id]);
    
        if (isset($_GET['get_id'])) 
        {
            $get_product = $conn->prepare("SELECT * FROM `Products` WHERE `ID` = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);
        
            if ($get_product->rowCount() > 0) 
            {
                while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) 
                {
                    // Prepare the SQL query
                    $insert_order = $conn->prepare(
                        "INSERT INTO `Orders` 
                        (ID, `User ID`, Name, number, Email, Address, Address_type, Method, `Product ID`, Price, Quantity) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    
                    // Execute the query with the proper parameters
                    $insert_order->execute([
                        uniqid(),         // Generates a unique ID
                        $user_id,         // User ID (make sure it's set and valid)
                        $name,            // Name of the user
                        $number,          // Phone number
                        $email,           // Email address
                        $address,         // Delivery address
                        $address_type,    // Address type (e.g., Home, Office)
                        $method,          // Payment method
                        $fetch_p['id'],   // Product ID fetched from the `$fetch_p` array
                        $fetch_p['price'],// Product price fetched from the `$fetch_p` array
                        1                 // Quantity (fixed value in this example)
                    ]);
                }
                
                header("location: order.php"); 
            } else 
                $warning_msg[] = "something went wrong";
            
        }
        else if ($varify_cart->rowCount() > 0) 
        {
            while ($f_cart = $varify_cart->fetch(PDO::FETCH_ASSOC)) 
            {
                // Check if the product exists in the Products table
                $select_products = $conn->prepare("SELECT * FROM `Products` WHERE ID = ?");
                $select_products->execute([$f_cart['product_id']]);
            
                if ($select_products->rowCount() > 0) 
                {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
            
                    // Insert data into the Orders table
                    $insert_order = $conn->prepare(
                        "INSERT INTO `Orders` 
                        (ID, `User ID`, Name, Number, Email, Address, `Address Type`, Method, `Product ID`, `Price`, `Quantity`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
            
                    $result = $insert_order->execute([
                        uniqid(), // Use `uniqid()` for unique ID generation
                        $user_id, 
                        $name, 
                        $number, 
                        $email, 
                        $address, 
                        $address_type, 
                        $method, 
                        $f_cart['product_id'], 
                        $fetch_products['price'], 
                        $f_cart['qty']
                    ]);
            
                    if ($result) 
                    {
                        // Delete the user's cart after order placement
                        $delete_cart_id = $conn->prepare("DELETE FROM `Cart` WHERE `User ID` = ?");
                        $delete_cart_id->execute([$user_id]);
            
                        // Redirect the user to the order page
                        header('location: order.php');
                    } 
                    else 
                        $warning_msg[] = 'Something went wrong while placing the order.';
                    
                } 
                else 
                    $warning_msg[] = 'The product is no longer available.';
                
            }
            
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
    <title>Green Coffee - Checkout Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Checkout Summery</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">home</a><span>Checkout Summery</span>
        </div>
    </div>
    <section class = "checkout">
        <div class="title">
            <img src="img/download.png" class="logo">
            <h1>checkout summary</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolorum deserunt minus veniam tenetur</p>
        </div>
            <form method="post">
                <div class="row">
                <h3>billing details</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>your name <span>*</span></p>
                            <input type="text" name="name" required maxlength="50" placeholder="Enter Your name" class="input">
                        </div>
                        <div class="input-field">
                            <p>your number <span>*</span></p>
                            <input type="number" name="number" required maxlength="11" placeholder="Enter Your number" class="input">
                        </div>
                        <div class="input-field">
                            <p>your email <span>*</span></p>
                            <input type="email" name="email" required maxlength="50" placeholder="Enter Your email" class="input">
                        </div>
                        <div class="input-field">
                            <p>payment method <span>*</span></p>
                            <select name="method" class="input">
                                <option value="cash on delivery">cash on delivery</option>
                                <option value="credit or debit card">credit or debit card</option>
                                <option value="net banking">net banking</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>address type <span>*</span></p>
                            <select name="address_type" class="input">
                                <option value="home">home</option>
                                <option value="office">office</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>address line 01 <span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" placeholder="e.g flat & building number" class="input">
                        </div>
                        <div class="input-field">
                            <p>address line 02 <span>*</span></p>
                            <input type="text" name="street" required maxlength="50" placeholder="e.g street name" class="input">
                        </div>
                        <div class="input-field">
                            <p>city name <span>*</span></p>
                            <input type="text" name="city" required maxlength="50" placeholder="Enter your city name" class="input">
                        </div>
                        <div class="input-field">
                            <p>country name <span>*</span></p>
                            <input type="text" name="country" required maxlength="50" placeholder="Enter your country name" class="input">
                        </div>
                        <div class="input-field">
                            <p>pincode <span>*</span></p>
                            <input type="text" name="pincode" required maxlength="6" placeholder="110022" min="0" max="999999" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>
            <div class="summary">
                <h3>my bag</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;

                        if (isset($_GET['get_id'])) 
                        {
                            $select_get = $conn->prepare("SELECT * FROM `Products` WHERE `ID` = ?");
                            $select_get->execute([$_GET['get_id']]);

                            while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) 
                            {
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total; 
                    ?>
                    <div class="flex">
                        <img src="image/<?=$fetch_get['image']; ?>" class="image">
                        <div>
                            <h3 class="name"><?=$fetch_get['name']; ?></h3>
                            <p class="price"><?=$fetch_get['price']; ?></p>
                        </div>
                    </div>
                    <?php
                            }
                        }

                        else 
                        {
                            $select_cart = $conn->prepare("SELECT * FROM `Cart` WHERE `User ID` = ?");
                            $select_cart->execute([$user_id]);
                        
                            if ($select_cart->rowCount() > 0) 
                            {
                                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) 
                                {
                                    $select_products = $conn->prepare("SELECT * FROM `Products` WHERE `ID` = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                        
                                    $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                    $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="image/<?=$fetch_product['image']; ?>">
                        <div>
                            <h3 class="name"><?=$fetch_product['name']; ?></h3>
                            <p class="price"><?=$fetch_product['price']; ?> X <?=$fetch_cart['qty']; ?></p>
                        </div>
                    </div>
                    <?php 
                                }
                            }
                             else 
                                echo "<p class = 'empty'>Your cart is empty</p>;"
                        }

                    ?>
                </div>
                <div class = "grand-total"><span>Total payable amount: </span>$<?= $grand_total ?>/-</div>
            </div>
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