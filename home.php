<?php
    /*
    include 'components/connection.php';

    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    }
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
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
    <title>Green Coffee - home page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class = "main">
    
        <section class="home-section">
        <div class = "slider"> 
            <div class = "slider__slider slide1"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            
            <!--end-->
         <div class = "slider__slider slide2"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                        <h1>Welcome to the shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <div class = "slider__slider slide3"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>Lorem ipsum dolor sit</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <!--end-->

            <div class = "slider__slider slide4"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>Lorem ipsum dolor sit</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <!--end-->

            <div class = "slider__slider slide5"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>Lorem ipsum dolor sit</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <!--end-->
            <div class = "left-arrow"><i class = "bx bxs-left-arrow"></i></div>
            <div class = "right-arrow"><i class = "bx bxs-right-arrow"></i></div>
        </div>
        </section>
        <section class = "thumb">
            <div class = "box-container"> 
                <div class = "box"> 
                    <img src = "assets/image/thumb2.jpg">
                    <h3>Green Tea</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                <img src = "assets/image/thumb0.jpg">
                    <h3>Lemon Tea</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/thumb1.jpg">
                    <h3>Green Coffee</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/thumb.jpg">
                    <h3>Green Tea</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
            </div>
        </section>
        <section class = "container"> 
            <div class = "box-container"> 
                <div class = "box"> 
                    <img src = "assets/image/about-us.jpg">
                </div> 
                <div class = "box">
                    <img src = "assets/image/download.png">
                    <span>Healthy Tea</span>
                    <h1>Save up to 50% off</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam et ab, dolore placeat voluptatem nobis.</p>
                </div>
            </div>
        </section>
        <section class = "shop">
            <div class = "title">
                <img src = "assets/image/download.png">
                <h1>Trending Products </h1>
            </div>
            <div class = "row"> 
                <img src = "assets/image/about.jpg">
                <div class = "row-detail">
                    <img src = "assets/image/basil.jpg">
                    <div class = "top-footer">
                        <h1>A cup of green tea makes you healthy</h1>
                    </div>
                </div>
            </div>
            <div class = "box-container"> 
                <div class = "box"> 
                    <img src = "assets/image/card.jpg">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/card0.jpg">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/card1.jpg">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/card2.jpg">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/10.jpg">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/6.webp">
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
        </section>
        <section class = "shop-category">
            <div class = "box-container">
                <div class = "box"> 
                    <img src = "assets/image/6.jpg">
                    <div class = "detail">
                        <span>BIG OFFERS</spam>
                        <h1>Extra 15% off</h1>
                        <a href = "view_products.php" class = "btn">Shop Now</a>
                    </div>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/7.jpg">
                    <div class = "detail">
                        <span>NEW IN TASTE</spam>
                        <h1>COffee House</h1>
                        <a href = "view_products.php" class = "btn">Shop Now</a>
                    </div>
                </div>
            </div>
        </section>
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
        </section>
        <section class = "brand">
            <div class = "box-container">
                <div class = "box"> 
                    <img src = "assets/image/brand (1).jpg">
                </div>
                <div class = "box"> 
                    <img src = "assets/image/brand (2).jpg">
                </div>
                <div class = "box"> 
                    <img src = "assets/image/brand (3).jpg">
                </div>
                <div class = "box"> 
                    <img src = "assets/image/brand (4).jpg">
                </div>
                <div class = "box"> 
                    <img src = "assets/image/brand (5).jpg">
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