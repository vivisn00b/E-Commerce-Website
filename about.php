<?php
require('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/img/pngwing.com.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="Light-slider-Files/lightslider.css">
    <script src="Light-slider-Files/lightslider.js"></script>
</head>

<body>
    <section class="page-header about-header">
        <h1>Know US</h1>
        <p>The emerging E-Commerce website of India!</p>
    </section>

    <section id="about-head" class="section-p1">
        <div class="about-container">
            <img src="img/about/a6.jpg" alt="">
            <div class="about-text">
                <h1>Who Are We?</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla alias architecto delectus sit doloribus sed atque
                nostrum earum accusamus hic exercitationem quam, officiis, velit veritatis a et provident corporis voluptatibus
                possimus saepe. Alias rerum ut nihil quidem repudiandae, error quaerat sit eos quam veniam rem, facere molestias
                ducimus corrupti! Officiis dolorem dolorum quos impedit, adipisci quisquam commodi dolor sint fugit libero error
                iure, nostrum autem reiciendis porro voluptatum quas beatae accusamus cum voluptatibus nesciunt? Repellat
                consectetur, architecto tempora asperiores laudantium ratione praesentium dolore corporis quisquam animi autem
                voluptatibus? Hic asperiores itaque reiciendis accusantium velit, dolorem libero exercitationem amet. Dolores
                voluptate quia nam ea quasi. Distinctio sint iusto architecto sit quasi soluta a dolorem est officia adipisci
                esse numquam labore, dolore error asperiores sequi voluptatibus corrupti fuga tenetur maxime eligendi quae!
                Dignissimos asperiores explicabo vitae natus atque eveniet sed assumenda provident cupiditate? Molestias
                possimus, perspiciatis excepturi officia sit nulla dignissimos assumenda, voluptates voluptatibus doloribus
                dolores. Doloremque, quis inventore possimus porro ipsa sapiente fugiat non mollitia ab vero et sed qui,
                voluptates nam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nulla explicabo, fuga exercitationem
                repudiandae consectetur labore veritatis a? Beatae praesentium illum fugit necessitatibus placeat blanditiis unde sit
                eius corrupti voluptatibus. Ea atque vitae pariatur repudiandae nobis ex aperiam voluptatem quod consectetur, id itaque
                modi tempora.</p>
                <br><br>
                <marquee behavior="" direction="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae nemo quidem
                    rerum, minima laboriosam maxime repellendus culpa, sunt ipsum in provident minus quo debitis! Accusantium quod
                    quis mollitia laudantium culpa labore unde corporis error amet? Soluta quisquam nihil, necessitatibus quasi
                    accusamus mollitia veniam?</marquee>
            </div>
        </div>
        <div class="features">
            <div class="feature">
                <img src="pseudocode/img/shipping.png" alt="" class="featureIcon">
                <span class="featureTitle">FREE SHIPPING</span>
                <span class="featureDesc">Free worldwide shipping on all orders.</span>
            </div>
            <div class="feature">
                <img class="featureIcon" src="pseudocode/img/return.png" alt="">
                <span class="featureTitle">30 DAYS RETURN</span>
                <span class="featureDesc">No question return and easy refund in 14 days.</span>
            </div>
            <div class="feature">
                <img class="featureIcon" src="pseudocode/img/gift.png" alt="">
                <span class="featureTitle">GIFT CARDS</span>
                <span class="featureDesc">Buy gift cards and use coupon codes easily.</span>
            </div>
            <div class="feature">
                <img class="featureIcon" src="pseudocode/img/contact.png" alt="">
                <span class="featureTitle">CONTACT US!</span>
                <span class="featureDesc">Keep in touch via email and support system.</span>
            </div>
        </div>
        <div id="about-app">
            <h1>Download Our <a href="">App</a></h1>
            <div class="video">
                <video autoplay muted loop src="img/about/1.mp4"></video>
            </div>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col con-col">
            <div class="con">
                <h4>Contact</h4>
                <p><strong>Address:</strong> 562 Wellington Road, Street 32, San Francisco</p>
                <p><strong>Phone:</strong> +01 2222 365 /(+91) 01 2345 6789</p>
                <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
            </div>
            <div class="follow">
                <h4>Keep In Touch</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="con-2">
            <div class="col">
                <h4>About</h4>
                <a href="#">About us</a>
                <a href="#">Delivery Information</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Contact Us</a>
            </div>
            <div class="col">
                <h4>Help</h4>
                <a href="#">Payments</a>
                <a href="#">Shipping</a>
                <a href="#">Cancellation & Returns</a>
                <a href="#">FAQ</a>
                <a href="#">Report Infringement</a>
            </div>
            <div class="col">
                <h4>My Account</h4>
                <a href="#">Sign In</a>
                <a href="#">View Cart</a>
                <a href="#">My Wishlist</a>
                <a href="#">Track My Order</a>
                <a href="#">Help</a>
            </div>
            <div class="col install">
                <h4>Install App</h4>
                <p>From App Store or Google Play</p>
                <div class="row">
                    <img src="img/pay/app.jpg" alt="">
                    <img src="img/pay/play.jpg" alt="">
                </div>
                <p>Secured Payment Gateways </p>
                <div class="row-2">
                    <img src="img/pay/pay.png" alt="">
                </div>
            </div>
        </div>
    </footer>

    <section class="copyright">
        <p>&copy; 2023, Vivek Dey - E-Commerce Website Project</p>
    </section>

    <script src="script.js"></script>
</body>

</html>