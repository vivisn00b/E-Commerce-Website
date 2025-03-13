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
    <script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="quantity.js"></script>
</head>

<body>
    <section class="page-header cart-page-header">
        <h1>CART</h1>
        <p>Add your cupon code & SAVE upto 50%</p>
    </section>

    <section id="cart" class="section-p1">
        <?php
        if (empty($_SESSION['cart'])) {
            echo '<section class="empty-cart-message">
                    <p>Your shopping cart is empty!</p>
                    <a href="index.php" class="continue-shopping"><button type="button">Continue Shopping</button></a>
                </section>';
        } else {
        ?>
        <div class="breadcrumb">
            <ul>
                <li><a href="">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
        <div class="page-title">
            <h1>Shopping Cart</h1>
        </div>
        <div class="cart-table">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Remove</td>
                        <td>Image</td>
                        <td>Product(s)</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($_SESSION['cart'] as $key=>$val){
                        foreach($val as $key1=>$val1){
                            $resAttr=mysqli_fetch_assoc(mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 left join size_master on product_attributes.size_id=size_master.id and size_master.status=1 where product_attributes.id='$key1'"));
                            $productArr=get_product_details($con, '', '', $key, $key1);
                            $pname=$productArr[0]['name'];
                            $mrp=$productArr[0]['mrp'];
                            $price=$productArr[0]['price'];
                            $image=$productArr[0]['image'];
                            // $qty=$val1['qty'];
                            $qty = (isset($val1['qty']) && is_numeric($val1['qty'])) ? $val1['qty'] : "1";
                    ?>
                    <tr>
                        <td><a href="javascript:void(0)" onclick="manage_cart_update('<?php echo $key?>','remove','<?php echo $resAttr['size_id']?>','<?php echo $resAttr['color_id']?>','<?php echo $qty?>')"><i class="far fa-times-circle"></i></a></td>
                        <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>" alt=""></td>
                        <td><?php echo $pname ?>
                        <span class="mini-text"><?php
                        if(isset($resAttr['color']) && $resAttr['color']!=''){
                            echo "<br> Color: ".$resAttr['color'].''; 
                        }
                        if(isset($resAttr['size']) && $resAttr['size']!=''){
                            echo "<br> Size: ".$resAttr['size'].''; 
                        }
                        ?></span>
                        </td>
                        <td>$<?php echo $price ?></td>
                        <td><input type="number" value="<?php echo $qty?>"></td>
                        <td>$<?php echo $qty*$price ?></td>
                    </tr>
                    <?php
                    } } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter your coupon code">
                <button>Apply</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <?php
                    $total=0;
                    foreach($_SESSION['cart'] as $key=>$val){
                        foreach($val as $key1=>$val1){
                            $proArr=get_product_details($con, '', '', $key, $key1);
                            $price=$proArr[0]['price'];
                            $qty = (isset($val1['qty']) && is_numeric($val1['qty'])) ? $val1['qty'] : "1";
                            $total+=$qty*$price;
                        }
                    } ?>
                    <td>Cart Subtotal</td>
                    <td>$<?php echo $total?></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>- $10</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>$<?php echo $total-10?></strong></td>
                </tr>
            </table>
            <a href="<?php echo SITE_PATH?>checkout.php"><button>Proceed to checkout</button></a>
        </div>
        <?php } ?>
    </section>

    <input type="hidden" id="sid">
	<input type="hidden" id="cid">
	<input type="hidden" id="qty">

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
</body>
</html>