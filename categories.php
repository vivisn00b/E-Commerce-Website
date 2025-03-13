<?php
require('header.php');
$cat_id=mysqli_real_escape_string($con, $_GET['categories_id']);
if($cat_id>0){
    $get_product_cat=get_product_cat($con,'',$cat_id);
} else{
    ?>
    <script>
        window.location.href='index.php';
    </script>
    <?php
}

$cat_req=mysqli_query($con, "select * from product where status=1 order by name asc");
$cat_ar=array();
while ($row=mysqli_fetch_assoc($cat_req)) {
$cat_ar[]=$row;
}
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
<?php if(count($get_product_cat)>0) { ?>
    <section class="page-header">
        <h1>FLAT &#8377;300 OFF</h1>
        <p>On your 1<sup>st</sup> purchase from E-COMMERCE!</p>
    </section>

    <section id="product1" class="section-p1">
        <div class="pro-container">
            <?php
            foreach($get_product_cat as $pro_list){
                $resAttr=mysqli_query($con,"select mrp,price from product_attributes where product_id='{$pro_list['id']}'");
                $proAttr=[];
                $Mrp=0;
                $Price=0;
                while($rowAttr=mysqli_fetch_assoc($resAttr)){
                    $proAttr[]=$rowAttr;
                }
                if (!empty($proAttr)) {
                    $minPrice = PHP_INT_MAX;
                    $PriceDetails = null;
                    foreach ($proAttr as $attr) {
                        $currentPrice = $attr['price'];
                        if ($currentPrice < $minPrice) {
                            $minPrice = $currentPrice;
                            $PriceDetails = $attr;
                        }
                    }
                    $Mrp = $PriceDetails['mrp'];
                    $Price = $PriceDetails['price'];
                }
            ?>
            <div class="pro">
                <a href="s-product.php?categories_id=<?php echo $pro_list['categories_id']?>&id=<?php echo $pro_list['id']?>">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$pro_list['image']?>" alt="">
                </a>
                <div class="des">
                    <span>adidas</span>
                    <h5><?php echo $pro_list['name']?></h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <div class="pro-price">
                        <h3>$<?php echo $Price?></h3>
                        <h5><s>$<?php echo $Mrp?></s></h5>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="manage_cart('<?php echo $pro_list['id']?>','add')"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <?php } ?>
        </div>
    </section>

    <section id="pagination" class="section-p1">
        <a href="">1</a>
        <a href="">2</a>
        <a href=""><i class="fa fa-long-arrow-alt-right"></i></a>
    </section>

<?php } else{ ?>
    <section id="product1" class="section-p1">
        <p><?php echo "No product available!"; ?></p>
        <a href="index.php" class="continue-shopping"><button type="button">Continue Shopping</button></a>
    </section>
<?php } ?>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>buy 1 get 1 free</h2>
            <span>The best classic dress is on sale</span>
            <button>Learn More</button>
        </div>
        <div class="banner-box box-2">
            <h4>spring/summer</h4>
            <h2>upcoming season</h2>
            <span>The best classic dress is on sale</span>
            <button>Learn More</button>
        </div>
    </section>
        
    <section id="banner-3">
        <div class="banner-box">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection - 50% OFF</h3>
        </div>
        <div class="banner-box box-3">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection - 50% OFF</h3>
        </div>
        <div class="banner-box box-4">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection - 50% OFF</h3>
        </div>
    </section>

    <section id="newsletter">
        <div class="newstext">
            <h2>Sign Up For Newsletters</h2>
            <p>Get E-mail updates about our latest shop and <span>special offers</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button>Sign Up</button>
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
    <script src="quantity.js"></script>
</body>

</html>