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
    <title>Green Coffee - about us page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
        <div class = "banner">
            <h1>About Us</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">home</a><span>about</span>
        </div>
       <div class = "about-category">
            <div class = "box">
                <img src = "assets/image/3.webp">
                <div class = "detail">
                    <span>Coffee</span>
                    <h1>Lemon Green</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
            <div class = "box">
                <img src = "assets/image/2.webp">
                <div class = "detail">
                    <span>Coffee</span>
                    <h1>Lemon Teaname</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
            <div class = "box">
                <img src = "assets/image/1.webp">
                <div class = "detail">
                    <span>Coffee</span>
                    <h1>Lemon Green</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
       </div>
       <section class = "services">
            <div class = "box-container">
                <div class = "title">
                    <img src = "assets/image/download.png" class = "Logo">
                    <h1>Why Choose Us</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat 
                        voluptatem 
                        nobis.
                    </p>
                </div>
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
        </section>
        <div class = "about">
            <div class = "row">
                <div class = "img-box">
                    <img src = "assets/image/3.png">
                </div>
                <div class = "details">
                    <h1>Visit Our Beautiful Showrooms!</h1>
                    <p>Our showrooms is an expression of what we love doing; creative wirth floral and
                        plant
                        arrangements.
                        Whether you are looking for a florist for your perfect wedding, or just want to upligt 
                        any room 
                        with 
                        some one of a kinf living decor, Blossom with Love can help.
                    </p>
                    <a href = "view_products.php">Shop Now</a>
                </div>
            </div>
        </div>
        <div class = "testimonial-container">
            <div class = "title">
                <img src = "assets/image/download.png" class = "logo">
                <h1>What people say about us</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat 
                        voluptatem 
                        nobis.
                </p>
            </div>
            <div class = "container">
                <div class = "testimonial-item active">
                    <img src = "assets/image/01.jpg">
                    <h1>Sara Smith</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus illum, 
                        in vel enim laborum rem porro iusto ad, voluptatem fugiat itaque odio. Debitis, 
                        quam nulla nisi dolore ipsum quibusdam neque. Lorem ipsum dolor sit amet 
                        consectetur adipisicing elit. 
                    </p>
                </div> 
                <div class = "testimonial-item active">
                    <img src = "assets/image/02.jpg">
                    <h1>Jason Smith</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus illum, 
                        in vel enim laborum rem porro iusto ad, voluptatem fugiat itaque odio. Debitis, 
                        quam nulla nisi dolore ipsum quibusdam neque. Lorem ipsum dolor sit amet 
                        consectetur adipisicing elit. 
                    </p>
                </div> 
                <div class = "testimonial-item active">
                    <img src = "assets/image/013jpg">
                    <h1>Sara Smith</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus illum, 
                        in vel enim laborum rem porro iusto ad, voluptatem fugiat itaque odio. Debitis, 
                        quam nulla nisi dolore ipsum quibusdam neque. Lorem ipsum dolor sit amet 
                        consectetur adipisicing elit. 
                    </p>
                </div> 
                <div class = "left-arrow" onclick = "nextSlide()"><i class = "bx bxs-left-arrow-alt"></i></div>
                <div class = "right-arrow" onclick = "prevSlide()"><i class = "bx bxs-right-arrow-alt"></i></div>
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