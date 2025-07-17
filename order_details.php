<?php 
require('header.php');

if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
    die();
}
$order_id=get_safe_value($con,$_GET['id']);
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
        <h1>PRODUCT DETAILS</h1>
        <p>See the details of the products you are purchasing</p>
    </section>

    <section id="cart" class="section-p1">
        <div class="breadcrumb">
            <ul>
                <li><a href="">Home</a></li>
                <li>Orders</li>
                <li>Product Details</li>
            </ul>
        </div>
        <div class="page-title">
            <h1>Product Details</h1>
        </div>
        <div class="cart-table">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Product Name</td>
                        <td>Image</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Total Price</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$uid=$_SESSION['USER_ID'];
					// $res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
					$res=mysqli_query($con,"SELECT
                                        order_detail.*,
                                        product.name,
                                        product.image,
                                        product_attributes.size_id,
                                        product_attributes.color_id,
                                        size_master.size,
                                        color_master.color
                                    FROM
                                        order_detail
                                    LEFT JOIN
                                        product ON order_detail.product_id = product.id
                                    LEFT JOIN
                                        `order` ON order_detail.order_id = `order`.id
                                    LEFT JOIN
                                        product_attributes ON order_detail.product_attr_id = product_attributes.id
                                    LEFT JOIN
                                        size_master ON product_attributes.size_id = size_master.id
                                    LEFT JOIN
                                        color_master ON product_attributes.color_id = color_master.id
                                    WHERE
                                        order_detail.order_id = '$order_id' AND `order`.user_id = '$uid';");
					$total_price=0;
					while($row=mysqli_fetch_assoc($res)){
					$total_price=$total_price+($row['qty']*$row['price']);
					?>
                    <tr>
                        <td><?php echo $row['name']?>
                        <span class="mini-text"><?php
                        if(isset($row['color']) && $row['color']!=''){
                            echo "<br> Color: ".$row['color'].''; 
                        }
                        if(isset($row['size']) && $row['size']!=''){
                            echo "<br> Size: ".$row['size'].''; 
                        }
                        ?></span>
                        </td>
                        <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"></td>
                        <td><?php echo $row['qty']?></td>
                        <td>$<?php echo $row['price']?></td>
                        <td>$<?php echo $row['qty']*$row['price']?></td>
                    </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
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

</body>

</html>