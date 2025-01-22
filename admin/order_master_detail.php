<?php
require('top.inc.php');

$order_id=get_safe_value($con,$_GET['id']);

if(isset($_POST['update_order_status'])){
	$cancelRes=mysqli_query($con,"select order_detail.* from order_detail where order_detail.order_id='$order_id'");
	$rows=[];
	while ($cancelled = mysqli_fetch_assoc($cancelRes)) {
		$rows[]=$cancelled;
	}
	$update_order_status=$_POST['update_order_status'];
	
	if($update_order_status=='5'){
		mysqli_query($con,"update `order` set order_status='$update_order_status',payment_status='Success' where id='$order_id'");
	}else if($update_order_status=='4'){
		mysqli_query($con,"update `order` set order_status='$update_order_status',payment_status='Refunding' where id='$order_id'");
		foreach ($rows as $key=>$val) {
			$p_id=$val['product_id'];
			$attr_id=$val['product_attr_id'];
			$availableQty=mysqli_fetch_assoc(mysqli_query($con,"SELECT product_attributes.qty FROM product_attributes WHERE product_attributes.id='$attr_id' AND product_attributes.product_id='$p_id'"));
			$newQty=$val['qty']+$availableQty['qty'];
			$sql = "UPDATE product_attributes SET qty='$newQty' WHERE product_attributes.id='$attr_id' AND product_attributes.product_id='$p_id'";
			mysqli_query($con,$sql);
		}
	}else{
		mysqli_query($con,"update `order` set order_status='$update_order_status' where id='$order_id'");
	}
}
?>
<div class="content pb-0">
	<div class="orders">
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
				<div class="card-body">
					<h4 class="box-title">Order Detail </h4>
				</div>
				<div class="card-body--">
					<div class="table-stats order-table ov-h">
						<table class="table">
								<thead>
									<tr>
										<th class="product-thumbnail">Product Name</th>
										<th class="product-thumbnail">Product Image</th>
										<th class="product-name">Qty</th>
										<th class="product-price">Price</th>
										<th class="product-price">Total Price</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// $res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image,`order`.address,`order`.city,`order`.pincode from order_detail,product ,`order` where order_detail.order_id='$order_id' and  order_detail.product_id=product.id GROUP by order_detail.id");
									$res=mysqli_query($con,"select order_detail.*,product.name,product.image,`order`.address,`order`.city,`order`.state,`order`.pincode from order_detail,product,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id and `order`.id=order_detail.order_id");
									// $res=mysqli_query($con,"select order_detail.*,product.name,product.image,`order`.address,`order`.city,`order`.state,`order`.pincode, users.name as user_name from order_detail,product,`order`,users where order_detail.order_id='$order_id' and order_detail.product_id=product.id and `order`.id=order_detail.order_id and users.id=`order`.`user_id`");
									$total_price=0;

									$userInfo=mysqli_fetch_assoc(mysqli_query($con,"select * from `order` where id='$order_id'"));
									$address=$userInfo['address'];
									$city=$userInfo['city'];
									$state=$userInfo['state'];
									$pincode=$userInfo['pincode'];
									
									while($row=mysqli_fetch_assoc($res)){
										$total_price=$total_price+($row['qty']*$row['price']);
									?>
									<tr>
										<td class="product-name"><?php echo $row['name']?></td>
										<td class="product-name"> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"></td>
										<td class="product-name"><?php echo $row['qty']?></td>
										<td class="product-name"><?php echo $row['price']?></td>
										<td class="product-name"><?php echo $row['qty']*$row['price']?></td>
										
									</tr>
									<?php } ?>
									<tr>
										<td colspan="3"></td>
										<td class="product-name">Total Price</td>
										<td class="product-name"><?php echo $total_price?></td>
										
									</tr>
								</tbody>
							
						</table>
						<div id="address_details" class="col-xl-12">
							<strong>Deliver to: </strong>
							<?php
							$nbspString = str_repeat('&nbsp;', 31);
							$userName=mysqli_fetch_assoc(mysqli_query($con,"SELECT users.* FROM `order`, users WHERE `order`.id='$order_id' AND users.id=`order`.user_id"));
							echo $userName['name'];
							?><br/><br/>
							<strong>Deliver at: </strong>
							<?php echo $address?>, <?php echo $city?> - <?php echo $pincode?>, <?php echo $state?><br/><br/>
							<strong>Contact details: </strong>
							Phone number: <?php echo $userName['mobile']?><br/>
							<?php echo $nbspString;?>Email address: <?php echo $userName['email']?><br/><br/>
							<strong>Order Status: </strong>
							<?php 
							$order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,`order` where `order`.id='$order_id' and `order`.order_status=order_status.id"));
							echo $order_status_arr['name'];
							?>
							
							<div>
								<form method="post">
									<?php
									$query=mysqli_query($con,"SELECT id, order_status FROM `order` WHERE id='$order_id'");
									while ($row = mysqli_fetch_assoc($query)) {
										$value = $row['order_status'];
										$disabled = ($value == 4 || $value == 5) ? 'disabled' : 'required';
									}
									?>
									<select class="form-control" name="update_order_status" <?php echo $disabled?>>
										<option value="">Select Status</option>
										<?php										
										$res=mysqli_query($con,"select * from order_status");
										while($row=mysqli_fetch_assoc($res)){
											echo "<option value=".$row['id'].">".$row['name']."</option>";
										}
										?>
									</select>
									<input type="submit" class="form-control"/>
								</form>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('footer.inc.php');
?>