<?php
    include 'components/alert.php';
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
    <title>Green Coffee - Contact Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    <div class = "banner">
            <h1>Contact Us</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">home</a><span>Contact Us</span>
        </div>
    </div>
    <section class = "services">
        <div class = "box-container">
                <div class = "box"> 
                    <img src = "assets/icon/icon2.png">
                    <div class = "detail">
                        <h3>Great Savings</h3>
                        <p>Save Big by Every Order</p>
                    </div>
                </div>
                <div class = "box"> 
                    <img src = "assets/icon/icon1.png">
                    <div class = "detail">
                        <h3>24*7 Support</h3>
                        <p>One-On-One Support</p>
                    </div>
                </div>
                <div class = "box"> 
                    <img src = "assets/icon/icon0.png">
                    <div class = "detail">
                        <h3>Gift Voucher</h3>
                        <p>Voucher on every festivals</p>
                    </div>
                </div>
                <div class = "box"> 
                    <img src = "assets/icon/icon.png">
                    <div class = "detail">
                        <h3>Worldwide Delivery</h3>
                        <p>Dropship Worldwide</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class = "form-container">
        <form method = "post">
            <div class = "title">
                <img src = "assets/image/download.png" class = "logo">
                <h1>Leave a message</h1>
            </div>
            <div class = "input-field">
                <p>Your Name<sup>*</sup></p>
                <input type = "text" name = "name">
            </div>
            <div class = "input-field">
                <p>Email<sup>*</sup></p>
                <input type = "text" name = "email">
            </div>
            <div class = "input-field">
                <p>Phone Number<sup>*</sup></p>
                <input type = "text" name = "number">
            </div>
            <div class = "input-field">
                <p>Message<sup>*</sup></p>
                <textarea name = "message"></textarea>
            </div>
            <button type = "submit" name = "submit-btn" clas = "btn">Send a message</button>
        </form>
    </div>
    <div class = "address">
        <div class = "title">
            <img src = "assets/image/download.png" class = "logo">
            <h1>Contact Details</h1>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
        </div>
        <div class = "box-container">
            <div class = "box">
                <i class = "bx bxs-map-pin"></pin>
                <div>
                    <h4>Address</h4>
                    <p>408/1 (Old KA 66/1), Kuratoli, Khilkhet, Dhaka 1229, Bangladesh</p>
                </div>
            </div>
            <div class = "box">
                <i class = "bx bxs-phone-cell"></pin>
                <div>
                    <h4>Phone Number</h4>
                    <p> +88 02 841 4046-9</p>
                </div>
            </div>
            <div class = "box">
                <i class = "bx bxs-map-pin"></pin>
                <div>
                    <h4>Email</h4>
                    <p>info@aiub.edu</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <!--Home Slider end-->
        

    </div>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>