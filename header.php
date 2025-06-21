<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$cat_res=mysqli_query($con,"select * from categories where status=1");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
}

$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	
	if(isset($_GET['wishlist_id'])){
		$wid=get_safe_value($con,$_GET['wishlist_id']);
		mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
	}

	$wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <header>
        <div class="nav-container">
            <div class="logo">
                <a href="index.php"><img src="img/pngwing.com.png"></a>
            </div>
            <div class="nav-list">
                <ul id="navbar" data-visible="false">
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="shop.php" class="nav-link">Shop</a></li>
                    <li><a href="blog.php" class="nav-link">Blog</a></li>
                    <li><a href="about.php" class="nav-link">About</a></li>
                    <li><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="display-none"><hr width="100%"></li>
                    <li class="display-none"><a href=""><p><i class="fa fa-user" aria-hidden="true"></i> Profile</p></a></li>
                    <li class="display-none"><a href=""><p><i class="fas fa-shopping-bag"></i> Cart</p></a></li>
                    <li class="display-none"><a href=""><p><i class="fas fa-heart"></i> Wishlist</p></a></li>
                    <li class="display-none"><a href=""><p><i class="fas fa-box"></i> Orders</p></a></li>
                </ul>
            </div>
            <div class="search">
                <div class="search-container">
                    <form action="search.php" method="get" id="searchForm">
                        <input type="text" class="search-box" name="str" id="searchInput" placeholder="Search for products, brands and more...">
                        <div class="">
                            <button type="submit" class="search-btn" id="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="display-none" id="resetButtonContainer">
                            <button type="reset" class="search-btn" id="resetButton">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="nav-list-2">
                <ul id="navbar-2">
                    <li class="navbar-2-container dropdown rotate display-none-2"><a class="navbar-2-a" href="">
                        <div class="profile-container">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                        <p>Profile <i class="fa fa-angle-down"></i></p></a>
                        <div class="megamenu">
                            <ul class="content">
                                <li class="megamenu_item header_megamenu">
                                    <?php if(isset($_SESSION['USER_LOGIN'])){
                                            echo '<h4>Welcome, ' .$_SESSION['USER_NAME'] .'</h4>';
                                        } else{
                                            echo '<h4>New customer?</h4>';
                                        }
                                        ?>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <?php if(isset($_SESSION['USER_LOGIN'])){
                                            echo '<p>You can log out of this session</p>';
                                        } else{
                                            echo '<p>To access account and manage orders</p>';
                                        }
                                        ?>
                                    </div>
                                    <div class="menu_link_btn">
                                        <?php if(isset($_SESSION['USER_LOGIN'])){
                                            echo '<a href="logout.php"><button id="form-open">LOGOUT</button></a>';
                                        } else{
                                            echo '<a href="login.php"><button id="form-open">LOGIN / SIGNUP</button></a>';
                                        }
                                        ?>
                                    </div>
                                </li>
                                <hr>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="my_profile.php">My Profile</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="orders.php">Orders</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="wishlist.php">Wishlist</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">Rewards</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">Gift Cards</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">Coupons</a>
                                    </div>
                                </li>
                                <hr>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">Notification Preferences</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">24x7 Customer Care</a>
                                    </div>
                                </li>
                                <li class="megamenu_item">
                                    <div class="menu_link">
                                        <a href="">Download App</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="navbar-2-container display-none-2"><a class="navbar-2-a" href="cart.php">
                        <div class="cart-container">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <p>Cart</p>
                        <div class="fly-item">
                            <span class="item-number1"><?php echo $totalProduct?></span>
                        </div>
                    </a></li>
                    <li class="navbar-2-container display-none-2"><a class="navbar-2-a" href="wishlist.php">
                        <div class="wishlist-container">
                            <i class="fas fa-heart"></i>
                        </div> 
                        <p>Wishlist</p>
                        <div class="fly-item">
                            <span class="item-number2">
                                <?php
									if(isset($_SESSION['USER_ID'])){
                                        echo $wishlist_count;
                                    } else{
                                        echo "0";
                                    }
								?>
                            </span>
                        </div>
                    </a></li>
                    <li class="navbar-2-container display-none"><a>
                        <button class="mobile-nav-toggle" aria-controls="navbar" aria-expanded="false">
                            <span class="sr-only">Menu</span>
                            <i class="fa fa-bars hamburger-icon"></i>
                        </button>
                    </a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="offer">
        <ul class="offer-ul">
            <li>
                <div class="offer-1-item">
                    <a href=""><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/178cf5a874cd697a.png?q=100" alt="image">
                    Top Offers</a>
                </div>
            </li>
            <li class="rotate">
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=1&end_id=10"><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/6e3e1efa83bc56c3.png?q=100" alt="image">
                        <p>Electronics <i class="fa fa-angle-down"></i></p>
                    </a>
                </div>
                <div class="drop-menu">
                    <ul class="drop-content">
                        <?php
                        foreach ($cat_arr as $list) {
                            if ($list['categories_id'] <= 10) {
                            ?>
                            <li><a href="categories.php?categories_id=<?php echo $list['categories_id'] ?>"><?php echo
                            $list['categories'] ?></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div> 
            </li>
            <li>
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=41&end_id="><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/e2268d56d09df684.png?q=100" alt="image">
                        Mobiles & Tablets</a>
                </div>
            </li>
            <li>
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=42&end_id="><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/b3e1225e6bda1c9e.png?q=100" alt="image">
                        TVs & Appliances</a>
                </div>
            </li>
            <li class="rotate"> 
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=11&end_id=20"><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/a11d5d13e54bf964.png?q=100" alt="image">
                        <p>Fashion <i class="fa fa-angle-down"></i></p>
                    </a>
                </div>
                <div class="drop-menu">
                    <ul class="drop-content">
                        <?php
                        foreach ($cat_arr as $list) {
                            if ($list['categories_id'] >= 11 && $list['categories_id'] <= 20) {
                            ?>
                            <li><a href="categories.php?categories_id=<?php echo $list['categories_id'] ?>"><?php echo
                            $list['categories'] ?></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="rotate">
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=21&end_id=30"><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/5f09b2d254acb48a.png?q=100" alt="image">
                        <p>Beauty <i class="fa fa-angle-down"></i></p>
                    </a>
                </div>
                <div class="drop-menu">
                    <ul class="drop-content">
                        <?php
                        foreach ($cat_arr as $list) {
                            if ($list['categories_id'] >= 21 && $list['categories_id'] <= 30) {
                            ?>
                            <li><a href="categories.php?categories_id=<?php echo $list['categories_id'] ?>"><?php echo
                            $list['categories'] ?></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li>
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=43&end_id="><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/d154c0b4d536c1cf.png?q=100" alt="image">
                        Grocery</a>
                </div>
            </li>
            <li class="rotate">
                <div class="offer-1-item">
                    <a href="categories_zone.php?start_id=31&end_id=40"><img src="https://rukminim1.flixcart.com/fk-p-flap/128/128/image/5972d5da375c81c7.png?q=100" alt="image">
                        <p>Home & Kitchen <i class="fa fa-angle-down"></i></p>
                    </a>
                </div>
                <div class="drop-menu">
                    <ul class="drop-content">
                        <?php
                        foreach ($cat_arr as $list) {
                            if ($list['categories_id'] >= 31 && $list['categories_id'] <= 40) {
                            ?>
                            <li><a href="categories.php?categories_id=<?php echo $list['categories_id'] ?>"><?php echo
                            $list['categories'] ?></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </li>
        </ul>

        <script>
            const searchInput = document.getElementById("searchInput");
            const resetButtonContainer = document.getElementById("resetButtonContainer");
            searchInput.addEventListener("input", function () {
                if (searchInput.value.trim() === "") {
                    resetButtonContainer.classList.add("display-none");
                } else {
                    resetButtonContainer.classList.remove("display-none");
                }
            });
            searchForm = document.getElementById("searchForm");
            searchForm.addEventListener("reset", function (event) {
                resetButtonContainer.classList.add("display-none");
            });

            document.addEventListener("DOMContentLoaded", function () {
                var navLinks = document.querySelectorAll(".nav-link");
                let homeLink = document.querySelector(".nav-link[href='index.php']");
                function removeActiveFromHomeLink() {
                    homeLink.classList.remove("active");
                    homeLink.removeAttribute("aria-current");
                }
                if (homeLink) {
                    homeLink.classList.add("active");
                    homeLink.setAttribute("aria-current", "page");
                }
                navLinks.forEach(function (link) {
                    if (link.href === window.location.href) {
                        link.classList.add("active");
                        link.setAttribute("aria-current", "page");
                        if (homeLink && homeLink !== link) {
                            removeActiveFromHomeLink();
                        }
                    }
                });
            });
        </script>
    </section>