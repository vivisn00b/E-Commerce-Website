<?php
require('header.php');
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
	?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
    exit();
}

if (!isset($_SESSION['USER_ID'])) {
    ?>
	<script>
		window.location.href='login.php';
        alert("Please log in to proceed to checkout");
	</script>
	<?php
    exit();
}

$cart_total=0;
$errMsg="";
$address='';
$city='';
$pincode='';

if(isset($_POST['submit']) && isset($_SESSION['USER_ID'])){
	$address=get_safe_value($con,$_POST['address']);
	$city=get_safe_value($con,$_POST['city']);
	$state=get_safe_value($con,$_POST['state']);
	$pincode=get_safe_value($con,$_POST['pincode']);
	$payment_type=get_safe_value($con,$_POST['payment_type']);
	$user_id=$_SESSION['USER_ID'];
	foreach($_SESSION['cart'] as $key=>$val){
        foreach($val as $key1=>$val1)	{
			$resAttr=mysqli_fetch_assoc(mysqli_query($con,"select price from product_attributes where id='$key1'"));
			$price=$resAttr['price'];
			$qty=$val1['qty'];
			$cart_total=$cart_total+($price*$qty);
		}
	}
	$total_price=$cart_total;
	$payment_status='Pending';
	if($payment_type!=='COD'){
		$payment_status='Success';
	}
	$order_status='1';
	$added_on=date('Y-m-d h:i:s');
	
	mysqli_query($con,"insert into `order`(user_id,address,city,state,pincode,payment_type,payment_status,order_status,added_on,total_price) values('$user_id','$address','$city','$state','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price')");
	
	$order_id=mysqli_insert_id($con);
	
    $pAttrId=0;
    $pQty=0;
	foreach($_SESSION['cart'] as $key=>$val){
        foreach($val as $key1=>$val1)	{
			$resAttr=mysqli_fetch_assoc(mysqli_query($con,"select price from product_attributes where id='$key1'"));
			$price=$resAttr['price'];
			$qty=$val1['qty'];
            $pQty=$qty;
            $pAttrId=$key1;
            mysqli_query($con,"insert into `order_detail`(order_id,product_id,product_attr_id,qty,price) values('$order_id','$key','$key1','$qty','$price')");
		}
        if ($payment_status!=='' && ($order_status!=='4' && $order_status!=='')) {
            // $qtySql="select sum(qty) as sold_qty from order_detail where product_id=''";
            $qtySql="select qty from product_attributes where product_attributes.id='$pAttrId' and product_id='$key'";
            $soldQty=mysqli_fetch_assoc(mysqli_query($con, $qtySql));
            $qtyLeft=$soldQty['qty']-$pQty;
            $updateQtySql="UPDATE product_attributes SET qty='$qtyLeft' WHERE id=$pAttrId AND product_id=$key";
            mysqli_query($con,$updateQtySql);
        }
	}

	unset($_SESSION['cart']);
	?>
	<script>
		window.location.href='thank_you.php';
	</script>
	<?php
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="quantity.js"></script>
</head>

<body>
    <section class="page-header cart-page-header">
        <h1>CHECKOUT</h1>
        <p>Add your cupon code & SAVE upto 50%</p>
    </section>

    <section id="checkout" class="section-p1">
        <div class="checkout">
            <div class="item left styled">
                <h1>Shipping Address</h1>
                <form method="post" onsubmit="return validatePayment()">
                    <?php
                    $lastOrderCheckRes=mysqli_query($con,"SELECT `order`.user_id FROM `order` WHERE `order`.user_id = '".$_SESSION['USER_ID']."'");
                    if(isset($_SESSION['USER_LOGIN']) && mysqli_num_rows($lastOrderCheckRes)>0) {
                        $lastOrderDetailsRes=mysqli_query($con,"SELECT `order`.address, `order`.city, `order`.state, `order`.pincode, users.name, users.mobile FROM `order` JOIN users ON `order`.user_id = users.id WHERE `order`.user_id = '".$_SESSION['USER_ID']."'");
                        if(mysqli_num_rows($lastOrderDetailsRes)>0){
                            $lastOrderDetailsRow=mysqli_fetch_assoc($lastOrderDetailsRes);
                            $name=$lastOrderDetailsRow['name'];
                            $mobile=$lastOrderDetailsRow['mobile'];
                            $address=$lastOrderDetailsRow['address'];
                            $city=$lastOrderDetailsRow['city'];
                            $state=$lastOrderDetailsRow['state'];
                            $pincode=$lastOrderDetailsRow['pincode'];
                        }
                    ?>
                    <div class="shipping-details">
                    <p>
                        <label for="fname">Name <span>*</span></label>
                        <input type="text" id="name" required value="<?php echo $name?>">
                    </p>
                    <!-- <p>
                        <label for="fname">First Name <span>*</span></label>
                        <input type="text" id="fname" required>
                    </p>
                    <p>
                        <label for="lname">Last Name <span>*</span></label>
                        <input type="text" id="lname" required>
                    </p> -->
                    <p>
                        <label for="address">Street Address <span>*</span></label>
                        <input type="text" name="address" id="address" required value="<?php echo $address?>">
                    </p>
                    <p>
                        <label for="city">City <span>*</span></label>
                        <input type="text" name="city" id="city" required value="<?php echo $city?>">
                    </p>
                    <p>
                        <label for="state">State / Province <span>*</span></label>
                        <input type="text" name="state" id="state" required value="<?php echo $state?>">
                    </p>
                    <p>
                        <label for="postal">Zip / Postal Code <span>*</span></label>
                        <input type="text" name="pincode" id="pincode" required value="<?php echo $pincode?>">
                    </p>
                    <!-- <p>
                        <label for="country">Country <span>*</span></label>
                        <select name="country" id="country" required>
                            <option value="1">Afganistan</option>
                            <option value="2">Bangladesh</option>
                            <option value="3">Bhutan</option>
                            <option value="4">India</option>
                            <option value="5">Indonesia</option>
                            <option value="6">Nepal</option>
                            <option value="7">Sri Lanka</option>
                            <option value="8">Others</option>
                        </select>
                    </p> -->
                    <p>
                        <label for="phone">Phone Number <span>*</span></label>
                        <input type="number" id="phone" required value="<?php echo $mobile?>">
                    </p>
                    <p>
                        <label>Order Notes (optional)</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </p>
                    </div>

                    <?php } else{ ?>

                <div class="shipping-details">
                    <p>
                        <label for="fname">Name <span>*</span></label>
                        <input type="text" id="name" required>
                    </p>
                    <p>
                        <label for="address">Street Address <span>*</span></label>
                        <input type="text" name="address" id="address" required>
                    </p>
                    <p>
                        <label for="city">City <span>*</span></label>
                        <input type="text" name="city" id="city" required>
                    </p>
                    <p>
                        <label for="state">State / Province <span>*</span></label>
                        <input type="text" name="state" id="state" required>
                    </p>
                    <p>
                        <label for="postal">Zip / Postal Code <span>*</span></label>
                        <input type="text" name="pincode" id="pincode" required>
                    </p>
                    <p>
                        <label for="phone">Phone Number <span>*</span></label>
                        <input type="number" id="phone" required>
                    </p>
                    <p>
                        <label>Order Notes (optional)</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </p>
                    </div>

                    <?php } ?>

                    <div class="shipping-methods">
                    <h2>Shipping Methods</h2>
                    <p class="checkset">
                        <input type="radio" name="" id="">
                        <label>$5.00 Flat Rate</label>
                    </p>
                    <p class="checkset">
                        <input type="radio" name="" id="" checked="checked">
                        <label>$0.00 Free <span class="mini-text">(First Order)</span></label>
                    </p>
                </div>
                <div class="shipping-methods">
                    <h2>Payment Methods</h2>
                    <p class="checkset">
                        <input type="radio" name="payment_type" value="UPI" id="">
                        <label>UPI</label>
                    </p>
                    <p class="checkset">
                        <input type="radio" name="payment_type" value="Card" id="">
                        <label>Credit/Debit Card</span></label>
                    </p>
                    <p class="checkset">
                        <input type="radio" name="payment_type" value="COD" id="">
                        <label>Cash on Delivery</span></label>
                    </p>
                </div>
                <div class="primary-checkout">
                    <?php
                        if (isset($_SESSION['USER_ID'])) {
                            echo '<button class="primary-button" type="submit" name="submit">Place order</button>';
                        } else {
                            echo '<button class="primary-button" type="button" onclick="showLoginAlert()">Place order</button>';
                        }
                    ?>
                </div>
                </form>
            </div>
            <div class="item right">
                <h1>Order Summary</h1>
                <div class="summary-order">
                    <ul class="products mini">
                    <?php
                    $cart_total=0;
                    foreach($_SESSION['cart'] as $key=>$val){
                        foreach($val as $key1=>$val1){
                            $resAttr=mysqli_fetch_assoc(mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 left join size_master on product_attributes.size_id=size_master.id and size_master.status=1 where product_attributes.id='$key1'"));						
                            $productArr=get_product_details($con,'','',$key,$key1);
                            $pname=$productArr[0]['name'];
                            $mrp=$productArr[0]['mrp'];
                            $price=$productArr[0]['price'];
                            $image=$productArr[0]['image'];
                            $qty=$val1['qty'];
                            $cart_total=$cart_total+($price*$qty);
                    ?>
                    <li class="item">
                            <div class="thumbnail object-cover">
                                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>" alt="">
                            </div>
                            <div class="item-content">
                                <p><?php echo $pname ?></p>
                                <span class="price">
                                    <span>$<?php echo $price ?></span>
                                    <span>x <?php echo $qty ?></span>
                                </span>
                            </div>
                        </li>
                    <?php }
                    } ?>
                    </ul>
                </div>
                <div class="summary-totals">
                        <ul>
                            <li>
                                <span>Subtotal</span>
                                <span>$<?php echo $cart_total?></span>
                            </li>
                            <li>
                                <span>Discount</span>
                                <span>-$10.00</span>
                            </li>
                            <li>
                                <span>Shippping: Free <span class="mini-text">(First Order)</span></span>
                                <span>$0.00</span>
                            </li>
                            <li>
                                <span>Total</span>
                                <span><strong>$<?php echo $cart_total-10?></strong></span>
                            </li>
                        </ul>
                    </div>
            </div>
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
    <script>
        function showLoginAlert() {
            alert('Please log in/sign up to place an order');
        }

        function validatePayment() {
            var paymentOptions = document.getElementsByName("payment_type");
            var isChecked = false;
            for (var i = 0; i < paymentOptions.length; i++) {
                if (paymentOptions[i].checked) {
                    isChecked = true;
                    break;
                }
            }
            if (!isChecked) {
                alert("Please select a payment method.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>