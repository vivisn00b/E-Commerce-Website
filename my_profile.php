<?php
require('header.php');

if (empty($_SESSION['USER_ID'])) {
    ?>
	<script>
		window.location.href='login.php';
        alert("Please log in to view your profile");
	</script>
	<?php
    exit();
} else {
    $userName=$_SESSION['USER_NAME'];
    $userId=$_SESSION['USER_ID'];
    $userRes=mysqli_query($con, "SELECT users.*, `order`.`address` AS temp_address, `order`.`city`, `order`.`state`, `order`.`pincode`
    FROM users
    LEFT JOIN `order` ON `order`.`user_id` = users.id
    WHERE users.id = '$userId'");
    $userInfo=mysqli_fetch_assoc($userRes);
    $Date = $userInfo['added_on'];
    $Pfp = $userInfo['pfp'];
    $Dob = $userInfo['dob'];
    $Gender = $userInfo['gender'];
    $Email = $userInfo['email'];
    $Phone = $userInfo['mobile'];
    $Address = $userInfo['address'];
    $tempAddress = $userInfo['temp_address'];
    $City = $userInfo['city'];
    $State = $userInfo['state'];
    $Pincode = $userInfo['pincode'];
    $countRes=mysqli_query($con, "SELECT COUNT(DISTINCT o.id) AS order_count, COUNT(od.order_id) AS item_count FROM `order` o LEFT JOIN `order_detail` od ON o.id = od.order_id WHERE o.user_id = '$userId' AND o.order_status != 4");
    $Count=mysqli_fetch_assoc($countRes);
    $countWishlist=mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS wishlist_count FROM `wishlist` WHERE user_id=1"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="profile_style.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/img/pngwing.com.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="Light-slider-Files/lightslider.css">
    <script src="Light-slider-Files/lightslider.js"></script>
</head>
<body>
    <section class="page-header">
        <h1>My Profile</h1>
        <p>View and edit your profile information</p>
    </section>

    <section>
        <div class="container">
            <div class="my_profile">
                <div class="brandLogo">
                    <span>My Profile</span>
                </div>
            </div>
            <section class="userProfile card">
                <div class="profile">
                    <?php
                    if (empty($Pfp)) {
                        echo '<figure><img src="img/blank-pfp.png" alt="profile" width="250px" height="250px"></figure>';
                    } else {
                        echo '<figure><img src="' . USER_IMAGE_SITE_PATH.$Pfp . '" alt="profile" width="250px" height="250px"></figure>';
                    }
                    ?>
                    <h2>Hi,</h2> <h1 class="name"><?php echo $userName?></h1>
                    <span class="mini-text">Joined on: <?php echo $Date?></span>
                </div>
            </section>
            <section class="work_skills card">
                <div class="work">
                    <div class="secondary active">
                        <span><a href="my_profile.php"><h1><i class="fa fa-user"></i>&nbsp; Profile Info</h1></a></span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span><h1><i class="fa fa-box"></i>&nbsp; My Orders</h1></span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span><h1><i class="fa fa-heart"></i>&nbsp; My Wishlist</h1></span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span><a href="edit_profile.php"><h1><i class="fa fa-edit"></i>&nbsp; Edit Profile</h1></a></span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span>
                            <?php if(isset($_SESSION['USER_LOGIN'])) {
                                echo '<a href="logout.php"><h1><i class="fa fa-power-off"></i>&nbsp; Log Out</h1></a>';
                            } else {
                                echo '<h1><i class="fa fa-power-off"></i>&nbsp; Log Out</h1>';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </section>
            <section class="userDetails card">
                <div class="userName">
                    <h1 class="name"><?php echo $userName?></h1>
                    <p>User ID: <?php echo $userId?></p>
                    <h1 class="date_joined">Date joined: <?php echo $Date?></h1>
                </div>
                <div class="order_no">
                    <div class="total_order order_no_items">
                        <h1 class="heading">Total orders:</h1>
                        <span class="total_order_no"><?php echo $Count['order_count']?></span>
                    </div>
                    <div class="total_item order_no_items">
                        <h1 class="heading">Items purchased:</h1>
                        <span class="total_item_no"><?php echo $Count['item_count']?></span>
                    </div>
                    <div class="wishlisted_items">
                        <h1 class="heading">Wishlisted items:</h1>
                        <span class="wishlisted_items_no"><?php echo $countWishlist['wishlist_count']?></span>
                    </div>
                </div>
                <div class="contact">
                    <h1 class="heading">Contact Information</h1>
                    <ul>
                        <div>
                            <li class="phone">
                                <h1 class="label">Phone:</h1>
                                <span class="info">+91 <?php echo $Phone?></span>
                            </li>
                            <li class="email">
                                <h1 class="label">E-mail:</h1>
                                <span class="info"><?php echo $Email?></span>
                            </li>
                        </div>
                        <li class="address">
                            <h1 class="label">Address:</h1>
                            <span class="info">
                                <?php if (empty($Address)) {
                                    echo "$tempAddress <br> $City-$Pincode <br> $State";
                                } else {
                                    echo $Address;
                                } ?>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="contact2">
                    <h1 class="heading">Basic Information</h1>
                    <ul>
                        <div>
                            <li class="birthday">
                                <h1 class="label">Birthday:</h1>
                                <span class="info">
                                    <?php if (empty($Dob) || $Dob === '0000-00-00') {
                                                $Dob = '';
                                            }
                                            echo $Dob;
                                            ?>
                                </span>
                            </li>
                            <li class="sex">
                                <h1 class="label">Gender:</h1>
                                <span class="info"><?php echo $Gender?></span>
                            </li>
                        </div>
                    </ul>
                </div>
            </section>
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

</body>
</html>