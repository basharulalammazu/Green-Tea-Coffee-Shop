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
            <a href = "home.php">home</a><span>Our Shop</span>
        </div>
    </div>
    <section class = "products">
        <div class = "box-container">
            <?php 
                $select_product = $conn->prepare("SELECT * FROM 'Products'");
                $select_product -> execute();

                if ($select_product -> rowCount() > 0)
                {
                    while ($fetch_products = $select_product -> fetch(PDO::FETCH_ASSOC)) { 
            ?>
                <form action = "#" method = "post" class = "box">
                    <img src = "image/<?=$fetch_products['image']; ?>">
                    <div class = "button">
                        <button type = "submit" name = "add_to_cart"><i class = "bx bx-cart"></i></button>
                        <button type = "submit" name = "add_to_wishlist"><i class = "bx bx-heart"></i></button>
                        <a href = "view_page.php?pid = <?php $fetech_product['id']; ?>"class = "bx bxs-show"></a>
                    </div>
                    <h3 class = "name"> <?=$fetch_products['name']; ?></h3>
                    <input type = "hidden" name = "product_id" value = "<?=$fetch_products['id']; ?>">
                    <div class = "fles">
                        <p class = "price">Price $<?=$fetech_product['price']; ?>/-</p>
                        <input type = "number" name = "qty" required min = "1" value = "1" max = "99" maxlength = "2" class = "qty">
                    </div>
                    <a href = "checkout.php?get_id=<?=fetech_products['id']; ?>" class = "btn"> Buy Now </a> 
            <?php
                }
            }
            else 
                echo "<p class = "empty">No Products added yet!</p>;"
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