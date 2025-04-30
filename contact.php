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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="Light-slider-Files/lightslider.css">
    <script src="Light-slider-Files/lightslider.js"></script>
    <script src="script.js"></script>
    <script src="submit_form.js"></script>
</head>

<body>
    <section class="page-header about-header">
        <h1>Let's Talk</h1>
        <p>LEAVE A MESSAGE. We love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit one of our agency locations or contact us today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fas fa-map"></i>
                    <p>56 Glassford Street Glasgow G1 1UL New York</p>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <p>contact@example.com </p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>contact@example.com </p>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p>Monday to Saturday: 9:00am to 4:00pm </p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387198.0689485971!2d-74.60354067621142!3d40.69632990427857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1697719301235!5m2!1sen!2sin"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <section id="form-details">
        <form id="myForm" method="post" action="send_message.php">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" id="name" name="name" placeholder="Your Name">
            <div class="email-phone">
                <input type="text" id="email" name="email" placeholder="E-mail">
                <input type="tel" id="mobile" name="mobile" placeholder="Phone Number">
            </div>
            <textarea id="message" name="message" cols="30" rows="10" placeholder="Your Message"></textarea>
            <button type="button" id="submitButton">SEND</button>
        </form>
        <div class="people">
            <div>
                <img src="img/people/1.png" alt="">
                <p><span>John Doe</span> Senior Marketing Manager <br> Phone: + 000 123
                    000 77 88 <br>Email: contact@example.com</p>
            </div>
            <div>
                <img src="img/people/2.png" alt="">
                <p><span>William Smith</span> Senior Marketing Manager <br> Phone: + 000 123
                    000 77 88 <br>Email: contact@example.com</p>
            </div>
            <div>
                <img src="img/people/3.png" alt="">
                <p><span>Emma Stone</span> Senior Marketing Manager <br> Phone: + 000 123
                    000 77 88 <br>Email: contact@example.com</p>
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
</body>

</html>