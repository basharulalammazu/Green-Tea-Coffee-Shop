<?php
   // include 'components/connection.php';

    session_start();
    if (!isset($_SESSION['user_id'])) 
        $user_id = '';
    else $user_id = $_SESSION['user_id']; 
        
    if (isset($_POST['logout'])) 
    {
        session_destroy();
        header("location: login.php");
    }
        
?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - About Us</title>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>About Us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span> / about</span>
        </div>

        <!-- About Categories -->
        <div class="about-category">
            <div class="box">
                <img src="assets/image/3.webp">
                <div class="detail">
                    <span style="display: block; text-align: right;">Have you tried?</span>
                    <h1>Lemon Green</h1>
                    <a href="view_products.php" class="btn">Shop Now</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/image/2.webp">
                <div class="detail">
                    <span style="display: block; text-align: right;">Our Green Coffee</span>
                    <h1>Made with finest beans and love</h1>
                    <a href="view_products.php" class="btn">Shop Now</a>
                </div>
            </div>
        </div>

        <!-- Testimonial Section -->
        <div class="testimonial-container">
            <div class="title">
                <img src="assets/image/download.png" class="logo">
                <h1>What People Say About Us</h1>
                <p>Our customers love the authentic flavors and quality of our teas. Discover why we're their go-to choice for relaxation and what they think about us.</p>
            </div>
            <div class="container slider">
                <div class="testimonial-item active">
                    <img src="assets/image/01.jpg">
                    <h1>Sara Smith</h1>
                    <p>"The best green tea I've ever had! So fresh and flavorful."</p>
                </div>
                <div class="testimonial-item">
                    <img src="assets/image/02.jpg">
                    <h1>Jason Smith</h1>
                    <p>"I love starting my day with their coffee. its refreshing and freshly brewed as always!"</p>
                </div>
                <div class="testimonial-item">
                    <img src="assets/image/03.jpg">
                    <h1>Selena Ansari</h1>
                    <p>"Great quality and fast delivery. I’m a loyal customer now!"</p>
                </div>
                <!-- Arrows -->
                <div class="left-arrow">
                    <i class="bx bxs-left-arrow-alt"></i>
                </div>
                <div class="right-arrow">
                    <i class="bx bxs-right-arrow-alt"></i>
                </div>
            </div>
        </div>

        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src = "script.js"></script>
</body>
</html>
