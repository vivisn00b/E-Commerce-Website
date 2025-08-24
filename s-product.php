<?php
require('header.php');
// $cat_id=mysqli_real_escape_string($con, $_GET['categories_id']);
// $product_id=mysqli_real_escape_string($con, $_GET['id']);
// $get_product_details=get_product_details($con, '', $cat_id, $product_id);

if(isset($_GET['id'], $_GET['categories_id'])){
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
    $cat_id=mysqli_real_escape_string($con, $_GET['categories_id']);
	if($product_id>0){
		$get_product_details=get_product_details($con, '', $cat_id, $product_id);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
	
	$resMultipleImages=mysqli_query($con,"select image1,image2,image3,image4,image5 from product_images where product_id='$product_id'");
	$multipleImages=[];
	while ($row=mysqli_fetch_assoc($resMultipleImages)) {
        $multipleImages[]=$row;
	}
	
    // $resAttr=mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes,color_master,size_master where product_attributes.product_id='$product_id' and color_master.id=product_attributes.color_id and color_master.status=1 and size_master.id=product_attributes.size_id and size_master.status=1");
	// $productAttr=[];
	// $colorArr=[];
	// $sizeArr=[];
	// if(mysqli_num_rows($resAttr)>0){
	// 	while($rowAttr=mysqli_fetch_assoc($resAttr)){
	// 		$productAttr[]=$rowAttr;
	// 		$colorArr[$rowAttr['color_id']][]=$rowAttr['color'];
	// 		$sizeArr[]=$rowAttr['size'];
	// 	}
	// }
    // $sizeArr=array_unique($sizeArr);

    $resAttr=mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes 
	left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 
	left join size_master on product_attributes.size_id=size_master.id and size_master.status=1
	where product_attributes.product_id='$product_id'");
	$productAttr=[];
	$colorArr=[];
	$sizeArr=[];
	if(mysqli_num_rows($resAttr)>0){
		while($rowAttr=mysqli_fetch_assoc($resAttr)){
			$productAttr[]=$rowAttr;
			$colorArr[$rowAttr['color_id']][]=$rowAttr['color'];
			$sizeArr[]=$rowAttr['size'];
			$colorArr1[]=$rowAttr['color'];
		}
	}
    $is_size=count(array_filter($sizeArr));
    $is_color=count(array_filter($colorArr1));
	$sizeArr=array_unique($sizeArr);
    
    if (!empty($productAttr)) {
        $minPrice = PHP_INT_MAX;
        $minPriceDetails = null;
        foreach ($productAttr as $attr) {
            $currentPrice = $attr['price'];
            if ($currentPrice < $minPrice) {
                $minPrice = $currentPrice;
                $minPriceDetails = $attr;
            }
        }
        $minMrp = $minPriceDetails['mrp'];
        $minPrice = $minPriceDetails['price'];
    }

if(isset($_POST['review_submit'])){
    if (isset($_SESSION['USER_ID'])) {
        pr($_POST);
        $rating=get_safe_value($con,$_POST['rating']);
        $rname=get_safe_value($con,$_POST['name']);
        $summary=get_safe_value($con,$_POST['summary']);
        $review=get_safe_value($con,$_POST['review']);
        $added_on=date('Y-m-d');
        mysqli_query($con,"insert into product_review(product_id,user_id,rating,name,summary,review,status,added_on) values('$product_id','".$_SESSION['USER_ID']."','$rating','$rname','$summary','$review','1','$added_on')");
        header('location:s-product.php?categories_id='.$cat_id.'&id='.$product_id);
    }else{
        echo '<script>alert("Please login/signup to post review");</script>';
        die();
    }
}

$product_review_res=mysqli_query($con,"select users.name,product_review.id,product_review.rating,product_review.review,product_review.added_on from users,product_review where product_review.status=1 and product_review.user_id=users.id and product_review.product_id='$product_id' order by product_review.added_on desc");
}else{
	?>
	<script>
	window.location.href='index.php';
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
    <script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <section id="p-details" class="section-p1">
        <div class="single-pro-image">
            <div class="swiffy-slider">
                <ul class="slider-container">
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product_details['0']['image']?>" id="MainImg1" style="max-width: 100%;height: auto;"></li>
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image1']?>" id="MainImg2" style="max-width: 100%;height: auto;"></li>
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image2']?>" id="MainImg3" style="max-width: 100%;height: auto;"></li>
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image3']?>" id="MainImg4" style="max-width: 100%;height: auto;"></li>
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image4']?>" id="MainImg5" style="max-width: 100%;height: auto;"></li>
                    <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image5']?>" id="MainImg6" style="max-width: 100%;height: auto;"></li>
                </ul>
                <button type="button" class="slider-nav"></button>
                <button type="button" class="slider-nav slider-nav-next"></button>
            </div>
            <div class="price">
                <?php
                $discount=getProductDiscount($con,$get_product_details['0']['id']);
                ?>
                <span class="discount"><?php echo $discount?>%<br>OFF</span>
            </div>
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product_details['0']['image']?>" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col middle">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image1']?>" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col middle">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image2']?>" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col middle">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image3']?>" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col middle">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image4']?>" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col middle">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$multipleImages['0']['image5']?>" width="100%" class="small-img" alt="">
                </div>
            </div>
        </div>
        <div class="single-pro-details">
            <div class="breadcrumb">
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="categories.php?id=<?php echo $get_product_details['0']['categories_id']?>"><?php echo $get_product_details['0']['categories']?></a></li>
                    <li><?php echo $get_product_details['0']['name']?></li>
                </ul>
            </div>
            <div class="item">
                <h1><?php echo $get_product_details['0']['name']?></h1>
                <div class="content">
                    <div class="rating">
                        <div class="stars">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <a href="" class="mini-text">1,232 reviews</a>
                        <a href="" class="add-review mini-text">Add Your Review</a>
                    </div>

                    <div class="stock-sku">
                        <?php
						$getProductAttr=getProductAttr($con,$get_product_details['0']['id']);
                        $productQty=productQty($con,$get_product_details['0']['id']);
                        $productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product_details['0']['id'],$getProductAttr);
						$pending_qty=$productQty-$productSoldQtyByProductId;
						$cart_show='yes';
						if($productQty>$productSoldQtyByProductId){
							$stock='In Stock';			
						}else{
							$stock='Out of Stock';
							$cart_show='';
						}
						?>
                        <span class="available" id="qty_avail"><?php echo $stock?></span>
                        <span class="sku mini-text">SKU-881</span>
                    </div>

                    <div class="price" id="pro-price">
                        <span class="current">$<?php echo $minPrice?></span>
                        <span class="normal">$<?php echo $minMrp?></span>
                    </div>
                    <?php if($is_color>0){ 
                            if($is_size>0){ ?>
                                <div class="colors">
                                    <p>Colors</p>
                                    <div class="variant">
                                        <form action="">
                                            <?php
                                            foreach($colorArr as $key=>$val){ ?>
                                                <P>
                                                    <input type="radio" name="color" id="<?php echo $val[0] ?>">
                                                    <label for="<?php echo $val[0] ?>" onclick="loadAttr('<?php echo $key?>','<?php echo $get_product_details['0']['id']?>','color')" class="circle"></label>
                                                </P>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <div class="colors">
                                    <p>Colors</p>
                                    <div class="variant">
                                        <form action="" onchange="">
                                            <?php
                                            foreach($colorArr as $key=>$val){ ?>
                                                <P>
                                                    <input type="radio" name="color" id="<?php echo $val[0] ?>">
                                                    <label for="<?php echo $val[0] ?>" onclick="showQuantity('<?php echo $key?>','<?php echo $get_product_details['0']['id']?>','only_color')" class="circle"></label>
                                                </P>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            <?php }
                            } ?>

                    <?php 
                    if($is_size>0) { ?>
                    <div class="sizes">
                        <p>Sizes</p>
                        <div class="variant">
                            <form action="" id="size_attr" onchange="showQty('<?php echo $get_product_details['0']['id']?>')">
                                <?php
                                foreach($sizeArr as $list){
                                    if (!empty($list)) { ?>
                                    <P>
                                        <input type="radio" name="size" class="size_inp" id="size-<?php echo $list ?>">
                                        <label for="size-<?php echo $list ?>" class="circle"><span><?php echo $list ?></span></label>
                                    </P>
                                <?php }
                                } ?>
                            </form>
                        </div>
                    </div><?php } ?>

                    <div class="actions">
                        <div class="qty-control" hidden>
                            <?php
							if($cart_show!=''){
							?>
                            <button class="minus">-</button>
                            <input type="number" value="1" id="qty">
                            <button class="plus">+</button>
                            <?php } ?>
                        </div>
                        <div class="button-cart">
                            <?php
							if($cart_show!=''){
							?>
                            <a href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product_details['0']['id']?>','add','<?php echo $is_color?>','<?php echo $is_size?>')">
                                <button id="addToCart"><i class="fas fa-cart-plus cart"></i> ADD TO CART</button>
                            </a>
                            <?php 
                            } else{ 
                            ?>
                            <a href="#">
                                <button id="addToCart" disabled><i class="fas fa-cart-plus cart"></i> ADD TO CART</button>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="wish-share">
                        <ul class="second-links">
                            <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $get_product_details['0']['id']?>','add')">
                                    <span class="icon-large"><i class="fa fa-heart"></i> Wishlist</span>
                                </a></li>
                            <li><a href="">
                                    <span class="icon-large"><i class="fa fa-share-alt"></i> Share</span>
                                </a></li>
                        </ul>
                    </div>
                    <div class="description collapse">
                        <ul>
                            <li class="has-child">
                                <a href="#0" class="icon-small">Information</a>
                                <ul class="content list-content">
                                    <li><span>Brands</span> <span>Nike</span></li>
                                    <li><span>Fit</span> <span>Loose</span></li>
                                    <li><span>Material</span> <span>Cotton</span></li>
                                    <li><span>Gender</span> <span>Men</span></li>
                                </ul>
                            </li>
                            <li class="has-child">
                                <a href="#0" class="icon-small">Details</a>
                                <div class="content">
                                    <p><?php echo $get_product_details['0']['description']?></p>
                                </div>
                            </li>
                            <li class="has-child">
                                <a href="#0" class="icon-small">Custom</a>
                                <div class="content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Bust <span class="mini-text">(cm)</span></th>
                                                <th>Waist <span class="mini-text">(cm)</span></th>
                                                <th>Hip <span class="mini-text">(cm)</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>XS</td>
                                                <td>82.5</td>
                                                <td>62</td>
                                                <td>87.5</td>
                                            </tr>
                                            <tr>
                                                <td>S</td>
                                                <td>85</td>
                                                <td>63.5</td>
                                                <td>89</td>
                                            </tr>
                                            <tr>
                                                <td>M</td>
                                                <td>87.5</td>
                                                <td>67.5</td>
                                                <td>93</td>
                                            </tr>
                                            <tr>
                                                <td>L</td>
                                                <td>90</td>
                                                <td>72.5</td>
                                                <td>98</td>
                                            </tr>
                                            <tr>
                                                <td>XL</td>
                                                <td>93</td>
                                                <td>77.5</td>
                                                <td>103</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li class="has-child">
                                <?php
                                $review_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT ROUND(AVG(rating),1) AS avg_rate, COUNT(*) AS rcount FROM `product_review` WHERE product_id='$product_id'"));
                                ?>
                                <a href="#0" class="icon-small">Reviews &nbsp; <span class="mini-text"><?php echo $review_count['rcount']?></span></a>
                                <div class="content">
                                    <div class="reviews">
                                        <h4>Customer Reviews</h4>
                                        <div class="review-block">
                                            <div class="review-block-head">
                                                <div class="flexitem">
                                                    <span class="rate-sum">
                                                        <?php 
                                                        if (empty($review_count['avg_rate'])) {
                                                            echo 'No rating';
                                                        } else {
                                                            echo $review_count['avg_rate'];
                                                        }
                                                        ?>
                                                    </span>
                                                    <span><?php echo $review_count['rcount']?> reviews</span>
                                                    <div class="secondary-button">
                                                        <a href="#review-rorm">Write review</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-block-body">
                                                <ul>
                                                    <?php 
                                                    if(mysqli_num_rows($product_review_res)>0){
                                                        while($product_review_row=mysqli_fetch_assoc($product_review_res)){
                                                            $added_on=strtotime($product_review_row['added_on']);
                                                    ?>
                                                    <li class="item">
                                                        <div class="review-form">
                                                            <p class="person">Review by <?php echo $product_review_row['name'] ?></p>
                                                            <p class="mini-text">On <?php echo date('d M, Y',$added_on); ?></p>
                                                        </div>
                                                        <div class="review-rating rating">
                                                            <div class="stars">
                                                                <?php
                                                                for($i=0;$i<$product_review_row['rating'];$i++) {
                                                                    echo '<span class="fa fa-star checked"></span>';
                                                                }
                                                                $rating_left=5-$product_review_row['rating'];
                                                                if ($rating_left!=0) {
                                                                    for($i=0;$i<$rating_left;$i++) {
                                                                        echo '<span class="fa fa-star"></span>';
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>
                                                        <div class="review-text">
                                                            <p><?php echo $product_review_row['review'] ?></p>
                                                        </div>
                                                    </li>
                                                    <?php } 
                                                    }else { 
                                                        echo "<li class='item'><h3 class='submit_review_hint'>No review added</h3></li>";
                                                    } ?>
                                                </ul>
                                                <div class="view-all-link">
                                                    <a href="" class="view-all">View all reviews &nbsp; <i class="fa fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_SESSION['USER_ID'])) {
                                                $pro_buy=mysqli_query($con,"SELECT order_detail.id AS check_buy, `order`.id FROM order_detail, `order` WHERE `order`.`user_id`=".$_SESSION['USER_ID']." AND `order`.`order_status`!=4 AND order_detail.order_id=`order`.id AND order_detail.product_id='$product_id'");
                                                $buy_count=mysqli_num_rows($pro_buy);
                                                if ($buy_count>=1) {
                                                    echo '<div id="review-rorm" class="review-form">
                                                        <h4>Write a review</h4>
                                                        <form method="post">
                                                            <div class="star-rating">
                                                                <span>How would you rate the product?</span>
                                                                <div class="rate">
                                                                    <input type="radio" id="star5" value="5" name="rating" required/>
                                                                    <label for="star5" title="5 stars"></label>
                                                                    <input type="radio" id="star4" value="4" name="rating" required/>
                                                                    <label for="star4" title="4 stars"></label>
                                                                    <input type="radio" id="star3" value="3" name="rating" required/>
                                                                    <label for="star3" title="3 stars"></label>
                                                                    <input type="radio" id="star2" value="2" name="rating" required/>
                                                                    <label for="star2" title="2 stars"></label>
                                                                    <input type="radio" id="star1" value="1" name="rating" required/>
                                                                    <label for="star1" title="1 star"></label>
                                                                </div>
                                                            </div>
                                                        
                                                            <p>
                                                                <label for="name">Name</label>
                                                                <input type="text" name="name" required>
                                                            </p>
                                                            <p>
                                                                <label for="summary">Summary</label>
                                                                <input type="text" name="summary" required>
                                                            </p>
                                                            <p>
                                                                <label for="">Review</label>
                                                                <textarea cols="30" rows="10" name="review" required></textarea>
                                                            </p>
                                                            <button type="submit" name="review_submit">Submit review</button>
                                                        </form>
                                                    </div>';
                                                }
                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="cid"/>
	<input type="hidden" id="sid"/>
    <input type="hidden" id="qty_res"/>

    <section id="product1" class="similar-p">
        <h1>Similar Products</h1>
        <div class="similar-p-container">
            <div class="pro">
                <img src="img/products/n1.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n2.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n3.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
            </div>
            <div class="pro">
                <img src="img/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h4>$78.00</h4>
                </div>
                <a href="#"><i class="fas fa-cart-plus cart"></i></a>
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
        <p>&copy; 2024, Vivek Dey - E-Commerce Website Project</p>
    </section>

    <script src="script.js"></script>
    <script src="quantity.js"></script>
</body>

</html>