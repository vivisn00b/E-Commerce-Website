<?php
require('header.php');

if (empty($_SESSION['USER_ID'])) {
    ?>
	<script>
		window.location.href='login.php';
	</script>
	<?php
    exit();
} else {
    $userName=$_SESSION['USER_NAME'];
    $userId=$_SESSION['USER_ID'];
    $userRes=mysqli_query($con, "SELECT users.*, `order`.`city`, `order`.`state`, `order`.`pincode` FROM users LEFT JOIN `order` ON `order`.`user_id` = users.id WHERE users.id = '$userId'");
    $userInfo=mysqli_fetch_assoc($userRes);
    $Date = $userInfo['added_on'];
    $Pfp = $userInfo['pfp'];
    $Dob = $userInfo['dob'];
    $Gender = $userInfo['gender'];
    $Email = $userInfo['email'];
    $Phone = $userInfo['mobile'];
    $Address = $userInfo['address'];
    $City = $userInfo['city'];
    $State = $userInfo['state'];
    $Pincode = $userInfo['pincode'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUserName = mysqli_real_escape_string($con, $_POST['name']);
    $newDob = mysqli_real_escape_string($con, $_POST['dob']);
    $newGender = mysqli_real_escape_string($con, $_POST['gender']);
    $newPhone = mysqli_real_escape_string($con, $_POST['phone']);
    $newEmail = mysqli_real_escape_string($con, $_POST['email']);
    $newAddress = mysqli_real_escape_string($con, $_POST['address']);

    $updateQuery = "UPDATE users SET name = '$newUserName', dob = '$newDob', gender = '$newGender', mobile = '$newPhone', email = '$newEmail', address = '$newAddress' WHERE id = '$userId'";

    $result = mysqli_query($con, $updateQuery);
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
    <script src="submit_form.js"></script>
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
                        echo '<figure><img src="img/blank-pfp.png" id="preview1" alt="profile" width="250px" height="250px"></figure>';
                    } else {
                        echo '<figure><img src="' . USER_IMAGE_SITE_PATH.$Pfp . '" id="preview1" alt="profile" width="250px" height="250px"></figure>';
                    }
                    ?>
                    <h2>Hi,</h2>
                    <h1 class="name">
                        <?php echo $userName?>
                    </h1>
                    <span class="mini-text">
                        Joined on: <?php echo $Date?>
                    </span>
                </div>
            </section>
            <section class="work_skills card">
                <div class="work">
                    <div class="secondary">
                        <span>
                            <a href="my_profile.php"><h1><i class="fa fa-user"></i>&nbsp; Profile Info</h1></a>
                        </span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span>
                            <h1><i class="fa fa-box"></i>&nbsp; My Orders</h1>
                        </span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary">
                        <span>
                            <h1><i class="fa fa-heart"></i>&nbsp; My Wishlist</h1>
                        </span>
                    </div>
                </div>
                <div class="work">
                    <div class="secondary active">
                        <span>
                            <a href="edit_profile.php"><h1><i class="fa fa-edit"></i>&nbsp; Edit Profile</h1></a>
                        </span>
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
                    <h1 class="name">
                        Username: <?php echo $userName?>
                    </h1>
                    <p>User ID: <?php echo $userId?>
                    </p>
                    <h1 class="date_joined">Date joined: <?php echo $Date?>
                    </h1>
                </div>
                <div class="pfp-form">
                    <form class="media" method="post" action="upload_profile_picture.php" enctype="multipart/form-data">
                        <div class="pfp-flex">
                            <div class="u-lg-avatar">
                                <?php
                                if (empty($Pfp)) {
                                    $pathPfp="img/blank-pfp.png";
                                    echo '<img src="img/blank-pfp.png" id="preview2" alt="profile picture" width="250px" height="250px">';
                                } else {
                                    $pathPfp=USER_IMAGE_SITE_PATH.$Pfp;
                                    echo '<img src="' . USER_IMAGE_SITE_PATH.$Pfp . '" id="preview2" alt="profile picture" width="250px" height="250px">';
                                }
                                ?>
                            </div>
                            <div class="media-body">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla architecto in, molestiae sunt voluptas pariatur.
                                </p>
                                <label class="pfpAttach" for="fileAttachmentBtn">
                                    Upload Picture
                                    <input id="fileAttachmentBtn" name="profilePicture" type="file" class="file-attachment" onchange="previewFile('<?php echo $pathPfp?>')">
                                </label>
                                <button type="button" class="del-btn" onclick="resetPfp('<?php echo $pathPfp?>')">Reset</button>
                            </div>
                        </div>
                        <div class="form-btn">
                            <button type="submit" name="submit" class="submit-btn">Save Changes</button>
                            <button type="reset" name="reset" class="reset-btn" onclick="deleteProfilePic('<?php echo $userId?>')">Delete</button>
                        </div>
                    </form>
                </div>
                <div class="prof-info-form">
                    <form class="profile-info" method="post">
                                <div class="f-grid f-pad-grid">
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" value="<?php echo $userName?>">
                                </div>
                                <div class="dob-g f-pad-grid">
                                    <div class="dob f-grid">
                                        <label for="dob">Date of Birth:</label>
                                        <input type="date" id="dob" name="dob" value="<?php echo $Dob?>">
                                    </div>
                                    <div class="gender f-grid">
                                        <label for="gender">Gender:</label>
                                        <select id="gender" name="gender">
                                            <option value="Male" <?php echo ($Gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($Gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo ($Gender === 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ph-email f-pad-grid">
                                    <div class="phn-no f-grid">
                                        <label for="phone">Phone:</label>
                                        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" value="<?php echo $Phone?>">
                                    </div>
                                    <div class="email-id f-grid">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" value="<?php echo $Email?>">
                                    </div>
                                </div>
                                <div class="f-grid f-pad-grid">
                                    <label for="address">Address:</label>
                                    <textarea id="address" name="address" rows="4">
                                        <?php
                                        if (!empty($Address)) {
                                            echo $Address;
                                        }
                                        ?>
                                    </textarea>
                                </div>
                                <div class="form-btn">
                                    <button type="submit" class="submit-btn">Save Changes</button>
                                    <button type="reset" class="reset-btn">Reset</button>
                                </div>
                    </form>
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