<?php
    include 'components/connection.php';

    session_start();

    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'Admin') {
            // Redirect to admin dashboard if user is Admin
            header('location: admin/dashboard.php');
            exit();
        }
    }

    if (isset($_SESSION['user_id'])) 
        $user_id = $_SESSION['user_id'];
    else 
        $user_id = '';
    
    
    if (isset($_POST['logout'])) 
    {
        session_destroy();
        header("location: login.php");
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
                        <h1>Experience the Essence of Pure Green Tea</h1>
                        <p>Discover a Sip of Wellness in Every Cup, Handpicked for Freshness and Flavor.</p>
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
                        <p>Crafting Comfort, One Cup at a Time, with Ingredients that Nurture Your Soul.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <div class = "slider__slider slide3"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>From Nature to Your Cup, For A Healthier You.</h1>
                    <p>Savor the Rich Flavor of Authentic Matcha, Sourced from the Finest Tea Gardens.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <!--end-->

            <div class = "slider__slider slide4"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>Indulge in the Art of Matcha Perfection.</h1>
                    <p>Brewed with Passion, Served with Love, Bringing You the True Essence of Green Tea.</p>
                        <a href = "view_products.php" class = "btn">shop now</a>
                    </div>
                    <div class = "hero-dec-top"></div>
                    <div class = "hero-dec-bottom"></div>
            </div>
            <!--end-->

            <div class = "slider__slider slide5"> 
                <div class = "overlay"></div>
                    <div class = "slide-detail">
                    <h1>Your Journey to Serenity Starts Here</h1>
                    <p>Elevate Your Tea Ritual with Every Brew, Creating Moments of Relaxation and Joy.</p>
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
                    <h3>Green Tea, Just a Plain Ol' Green Tea</h3>
                    <p>Sip into serenity with a refreshing green tea, a literal boost to the body and soul. Crafted to boost your well-being naturally.</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                <img src = "assets/image/thumb0.jpg">
                    <h3>Lemon Tea For Some Extra Kick To The Tastebud</h3>
                    <p>Zesty and invigorating, made of freshly picked lemons our lemon tea is your perfect partner for a refreshing quick pick-me-up.</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/thumb1.jpg">
                    <h3>Green Coffee, A perfect after snack drink</h3>
                    <p>Fuel your day with the smooth, natural energy of our premium green coffee blends alongside your evening snacks.</p>
                    <i class = "bx bx-chevron-right"></i>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/thumb.jpg">
                    <h3>Hand Picked Premium Coffee Beans</h3>
                    <p>Discover the rich tradition of green coffee, infused with the finest beans from Caribbeans for a mid day relaxation</p>
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
                    <p>Embrace the goodness of nature with every sip. Discover premium blends designed to refresh your body and mind, now at unbeatable prices and special offers made just for you.</p>
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
                        <span>Looking for offers?</spam>
                        <h1>Here's an Extra 15% off!</h1>
                        <a href = "view_products.php" class = "btn">Shop Now</a>
                    </div>
                </div>
                <div class = "box"> 
                    <img src = "assets/image/7.jpg">
                    <div class = "detail">
                        <span>NEW IN TASTE</spam>
                        <h1>Wanna see what's new?</h1>
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
         <!-- Chatbot Integration -->
        <!--Home Slider end-->
        

    </div>
    <?php include 'chatbot/index.php'; ?>

    <!-- Scroll to Top Button -->
    <a href="#" id="scrollToTop">
            <i class="bx bxs-up-arrow"></i>
    </a>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>