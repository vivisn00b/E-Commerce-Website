<?php
require('top.inc.php');
$categories_id='';
$name='';
// $mrp='';
// $price='';
// $qty='';
$image='';
$short_desc='';
$description='';
$multipleImageArr=[];
$msg='';
$image_required='required';
$attrProduct=[];
// $attrProduct[0]['product_id']='';
// $attrProduct[0]['size_id']='';
// $attrProduct[0]['color_id']='';
// $attrProduct[0]['mrp']='';
// $attrProduct[0]['price']='';
// $attrProduct[0]['qty']='';
// $attrProduct[0]['id']='';

if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from product where id='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$categories_id=$row['categories_id'];
		$name=$row['name'];
		// $mrp=$row['mrp'];
		// $price=$row['price'];
		// $qty=$row['qty'];
		$short_desc=$row['short_desc'];
		$description=$row['description'];
		$image=$row['image'];
		
		$resMultipleImage=mysqli_query($con,"select id, image1, image2, image3, image4, image5 from product_images where product_id='$id'");
		if(mysqli_num_rows($resMultipleImage)>0){
			$jj=0;
			while($rowMultipleImage=mysqli_fetch_assoc($resMultipleImage)){
				$multipleImageArr[$jj]['image1']=$rowMultipleImage['image1'];
				$multipleImageArr[$jj]['image2']=$rowMultipleImage['image2'];
				$multipleImageArr[$jj]['image3']=$rowMultipleImage['image3'];
				$multipleImageArr[$jj]['image4']=$rowMultipleImage['image4'];
				$multipleImageArr[$jj]['image5']=$rowMultipleImage['image5'];
				$multipleImageArr[$jj]['id']=$rowMultipleImage['id'];
				$jj++;
				
				// $multipleImageArr[$jj] = [
				// 	'image1' => $rowMultipleImage['image1'],
				// 	'image2' => $rowMultipleImage['image2'],
				// 	'image3' => $rowMultipleImage['image3'],
				// 	'image4' => $rowMultipleImage['image4'],
				// 	'image5' => $rowMultipleImage['image5'],
				// 	'id' => $rowMultipleImage['id']
				// ];
				// $jj++;
			}
		}

		$resProductAttr=mysqli_query($con,"select * from product_attributes where product_id='$id'");
		$ii=0;
		while($rowProductAttr=mysqli_fetch_assoc($resProductAttr)){
			$attrProduct[$ii]['product_id']=$rowProductAttr['product_id'];
			$attrProduct[$ii]['size_id']=$rowProductAttr['size_id'];
			$attrProduct[$ii]['color_id']=$rowProductAttr['color_id'];
			$attrProduct[$ii]['mrp']=$rowProductAttr['mrp'];
			$attrProduct[$ii]['price']=$rowProductAttr['price'];
			$attrProduct[$ii]['qty']=$rowProductAttr['qty'];
			$attrProduct[$ii]['id']=$rowProductAttr['id'];
			$ii++;
		}
	}else{
		header('location:product.php');
		die();
	}
}

if(isset($_POST['submit'])){
	$categories_id=get_safe_value($con,$_POST['categories_id']);
	$name=get_safe_value($con,$_POST['name']);
	// $mrp=get_safe_value($con,$_POST['mrp']);
	// $price=get_safe_value($con,$_POST['price']);
	// $qty=get_safe_value($con,$_POST['qty']);
	$short_desc=get_safe_value($con,$_POST['short_desc']);
	$description=get_safe_value($con,$_POST['description']);
	
	$res=mysqli_query($con,"select product.* from product where product.name='$name'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['id']){
			
			}else{
				$msg="Product already exists";
			}
		}else{
			$msg="Product already exists";
		}
	}
	
	if(isset($_GET['id']) && $_GET['id']==0){
		if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
			$msg="Please select only png, jpg and jpeg image format";
		}
	}else{
		if($_FILES['image']['type']!=''){
				if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
				$msg="Please select only png, jpg and jpeg image format";
			}
		}
	}

	// $allowedFileTypes = ['image/png', 'image/jpg', 'image/jpeg'];
	for ($i = 1; $i <= 5; $i++) {
		$fileKey = 'image' . $i;
		if (isset($_FILES[$fileKey])) {
			if ($_FILES[$fileKey]['type'] != '') {
				// if (!in_array($_FILES[$fileKey]['type'], $allowedFileTypes)) {
				// 	$msg = "Please select only png, jpg, and jpeg image formats for $fileKey";
				// }
				if($_FILES[$fileKey]['type']!='image/png' && $_FILES[$fileKey]['type']!='image/jpg' && $_FILES[$fileKey]['type']!='image/jpeg'){
					$msg="Please select only png, jpg and jpeg image format";
				}
			}
		}
	}

	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			if($_FILES['image']['name']!=''){
				$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
				$update_sql="update product set categories_id='$categories_id',name='$name',short_desc='$short_desc',description='$description',image='$image' where id='$id'";
			}else{
				$update_sql="update product set categories_id='$categories_id',name='$name',short_desc='$short_desc',description='$description' where id='$id'";
			}
			mysqli_query($con,$update_sql);
		}else{
			$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
			mysqli_query($con,"insert into product(categories_id,name,short_desc,description,status,image) values('$categories_id','$name','$short_desc','$description',1,'$image')");
			$id=mysqli_insert_id($con);
		}
		
		/*Product Multiple Images Start*/
		if(isset($_GET['id']) && $_GET['id']!=''){
			if ($_FILES['image1']['name'] != '') {
				$image1 = rand(111111111, 999999999) . '_' . $_FILES['image1']['name'];
				move_uploaded_file($_FILES['image1']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image1);
				$update_sql = "UPDATE product_images SET image1='$image1' WHERE product_id='$id'";
				mysqli_query($con, $update_sql);
			}
			if ($_FILES['image2']['name'] != '') {
				$image2 = rand(111111111, 999999999) . '_' . $_FILES['image2']['name'];
				move_uploaded_file($_FILES['image2']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image2);
				$update_sql = "UPDATE product_images SET image2='$image2' WHERE product_id='$id'";
				mysqli_query($con, $update_sql);
			}
			if ($_FILES['image3']['name'] != '') {
				$image3 = rand(111111111, 999999999) . '_' . $_FILES['image3']['name'];
				move_uploaded_file($_FILES['image3']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image3);
				$update_sql = "UPDATE product_images SET image3='$image3' WHERE product_id='$id'";
				mysqli_query($con, $update_sql);
			}
			if ($_FILES['image4']['name'] != '') {
				$image4 = rand(111111111, 999999999) . '_' . $_FILES['image4']['name'];
				move_uploaded_file($_FILES['image4']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image4);
				$update_sql = "UPDATE product_images SET image4='$image4' WHERE product_id='$id'";
				mysqli_query($con, $update_sql);
			}
			if ($_FILES['image5']['name'] != '') {
				$image5 = rand(111111111, 999999999) . '_' . $_FILES['image5']['name'];
				move_uploaded_file($_FILES['image5']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image5);
				$update_sql = "UPDATE product_images SET image5='$image5' WHERE product_id='$id'";
				mysqli_query($con, $update_sql);
			}
		}else{
			$image1=rand(111111111,999999999).'_'.$_FILES['image1']['name'];
			$image2=rand(111111111,999999999).'_'.$_FILES['image2']['name'];
			$image3=rand(111111111,999999999).'_'.$_FILES['image3']['name'];
			$image4=rand(111111111,999999999).'_'.$_FILES['image4']['name'];
			$image5=rand(111111111,999999999).'_'.$_FILES['image5']['name'];
			move_uploaded_file($_FILES['image1']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image1);
			move_uploaded_file($_FILES['image2']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image2);
			move_uploaded_file($_FILES['image3']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image3);
			move_uploaded_file($_FILES['image4']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image4);
			move_uploaded_file($_FILES['image5']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image5);
			mysqli_query($con,"insert into product_images(product_id,image1,image2,image3,image4,image5) values('$id','$image1','$image2','$image3','$image4','$image5')");
		}
		/*Product Multiple Images End*/

		/*Product Attributes Start*/
		if(isset($_POST['mrp'])){
			foreach($_POST['mrp'] as $key=>$val){
				$mrp=get_safe_value($con,$_POST['mrp'][$key]);
				$price=get_safe_value($con,$_POST['price'][$key]);
				$qty=get_safe_value($con,$_POST['qty'][$key]);
				$size_id=get_safe_value($con,$_POST['size_id'][$key]);
				$color_id=get_safe_value($con,$_POST['color_id'][$key]);
				$attr_id=get_safe_value($con,$_POST['attr_id'][$key]);
				// if($attr_id>0){
				// 	mysqli_query($con,"update product_attributes set size_id='$size_id',color_id='$color_id',mrp='$mrp',price='$price',qty='$qty' where id='$attr_id'");
				// }else{
				// 	mysqli_query($con,"insert into product_attributes(product_id,size_id,color_id,mrp,price,qty) values('$id','$size_id','$color_id','$mrp','$price','$qty')");
				// }
				if (!empty($mrp) && !empty($price) && !empty($qty) && !empty($color_id)) {
					if ($attr_id > 0) {
						mysqli_query($con, "update product_attributes set size_id='$size_id', color_id='$color_id', mrp='$mrp', price='$price', qty='$qty' where id='$attr_id'");
					} else {
						mysqli_query($con, "insert into product_attributes(product_id, size_id, color_id, mrp, price, qty) values('$id', '$size_id', '$color_id', '$mrp', '$price', '$qty')");
					}
                }
			}
		}
		/*Product Attributes End*/

		redirect('product.php');
		die();
	}
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
                <div class="card">
						<div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
								<div class="form-group">
									<label for="categories" class=" form-control-label">Categories</label>
									<select class="form-control" name="categories_id">
										<option>Select Category</option>
										<?php
										$res=mysqli_query($con,"select categories_id,categories from categories order by categories asc");
										while($row=mysqli_fetch_assoc($res)){
											if($row['categories_id']==$categories_id){
												echo "<option selected value=".$row['categories_id'].">".$row['categories']."</option>";
											}else{
												echo "<option value=".$row['categories_id'].">".$row['categories']."</option>";
											}
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Product Name</label>
									<input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name?>">
								</div>
								
								<div class="form-group"  id="product_attr_box">
									<?php if (count($attrProduct) > 0) { 
										foreach($attrProduct as $list){ ?>
										<div class="row"id="attr_1">
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">MRP</label>
												<input type="text" name="mrp[]" placeholder="MRP" class="form-control" value="<?php echo $list['mrp']?>">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Price</label>
												<input type="text" name="price[]" placeholder="Price" class="form-control" value="<?php echo $list['price']?>">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Qty</label>
												<input type="text" name="qty[]" placeholder="Qty" class="form-control" value="<?php echo $list['qty']?>">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Size</label>
												<select class="form-control" name="size_id[]" id="size_id" required>
													<option value="0">Size</option>
													<?php
													$res=mysqli_query($con,"select id,size from size_master order by order_by asc");
													while($row=mysqli_fetch_assoc($res)){
														if($list['size_id']==$row['id']){
															echo "<option value=".$row['id']." selected>".$row['size']."</option>";
														}else{
															echo "<option value=".$row['id']." >".$row['size']."</option>";	
														}
													} ?>
												</select>
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Color</label>
												<select class="form-control" name="color_id[]" id="color_id" required>
													<option value="0">Color</option>
													<?php
													$res=mysqli_query($con,"select id,color from color_master order by color asc");
													while($row=mysqli_fetch_assoc($res)){
														if($list['color_id']==$row['id']){
															echo "<option value=".$row['id']." selected>".$row['color']."</option>";
														}else{
															echo "<option value=".$row['id']." >".$row['color']."</option>";	
														}
													} ?>
												</select>
											</div>
											<input type="hidden" name="attr_id[]" value='<?php echo $list['id']?>'/>
											<div class="col-lg-2">
												<button type="button" class="btn btn-lg btn-danger btn-block remove-btn" name="delete_attr" onclick="removeAttr('<?php echo $list['id']?>')">Remove</button>
											</div>
										</div>
									<?php
									}
									for ($i = 0; $i < max(5 - count($attrProduct), 0); $i++) {
										?>
										<div class="row"id="attr_1">
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">MRP</label>
												<input type="text" name="mrp[]" placeholder="MRP" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Price</label>
												<input type="text" name="price[]" placeholder="Price" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Qty</label>
												<input type="text" name="qty[]" placeholder="Qty" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Size</label>
												<select class="form-control" name="size_id[]" id="size_id">
													<option value="0">Size</option>
													<?php
													$res=mysqli_query($con,"select id,size from size_master order by order_by asc");
													while($row=mysqli_fetch_assoc($res)){
														echo "<option value=".$row['id']." >".$row['size']."</option>";	
													} ?>
												</select>
											</div>
											<div class="col-lg-4">
												<label for="categories" class=" form-control-label">Color</label>
												<select class="form-control" name="color_id[]" id="color_id">
													<option value="0">Color</option>
													<?php
													$res=mysqli_query($con,"select id,color from color_master order by color asc");
													while($row=mysqli_fetch_assoc($res)){
														echo "<option value=".$row['id']." >".$row['color']."</option>";
													} ?>
												</select>
											</div>
											<input type="hidden" name="attr_id[]"/>
										</div>
										<?php
										}
									} else{
										for ($i = 0; $i < 5; $i++){ ?>
										<div class="row"id="attr_1">
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">MRP</label>
												<input type="text" name="mrp[]" placeholder="MRP" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Price</label>
												<input type="text" name="price[]" placeholder="Price" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Qty</label>
												<input type="text" name="qty[]" placeholder="Qty" class="form-control">
											</div>
											<div class="col-lg-2">
												<label for="categories" class=" form-control-label">Size</label>
												<select class="form-control" name="size_id[]" id="size_id">
													<option value="0">Size</option>
													<?php
													$res=mysqli_query($con,"select id,size from size_master order by order_by asc");
													while($row=mysqli_fetch_assoc($res)){
														echo "<option value=".$row['id']." >".$row['size']."</option>";	
													} ?>
												</select>
											</div>
											<div class="col-lg-4">
												<label for="categories" class=" form-control-label">Color</label>
												<select class="form-control" name="color_id[]" id="color_id">
													<option value="0">Color</option>
													<?php
													$res=mysqli_query($con,"select id,color from color_master order by color asc");
													while($row=mysqli_fetch_assoc($res)){
														echo "<option value=".$row['id']." >".$row['color']."</option>";
													} ?>
												</select>
											</div>
											<input type="hidden" name="attr_id[]"/>
										</div>
									<?php }
									}?>
								</div>

								<div class="form-group">
									<div class="row"  id="image_box">
										<div class="col-lg-12">
											<label for="categories" class=" form-control-label">Main Image</label>
											<input type="file" name="image" class="form-control" <?php echo  $image_required?>>
											<?php
											if($image!=''){
												echo "<a target='_blank' href='".PRODUCT_IMAGE_SITE_PATH.$image."'><img width='150px' src='".PRODUCT_IMAGE_SITE_PATH.$image."'/></a>";
											} ?>
										</div>
										
									<?php
									if (count($multipleImageArr) > 0) {
										foreach($multipleImageArr as $list) {
											for ($i = 0; $i < 5; $i++) {
												$fileKey = 'image'.$i+1;
												?>
												<div class="col-lg-6">
												<label for="categories" class="form-control-label">Image <?php echo $i+1; ?></label>
												<input type="file" name="<?php echo $fileKey; ?>" class="form-control" <?php echo $image_required; ?>>
												<?php
													echo "<a target='_blank' href='" . PRODUCT_IMAGE_SITE_PATH . $list[$fileKey] . "'><img width='150px' src='" . PRODUCT_IMAGE_SITE_PATH . $list[$fileKey] . "'/></a>";
												?>
												</div>
												<?php }
										}
										} else { ?>
										<?php for ($i = 0; $i < 5; $i++) {
										$fileKey = 'image' . $i+1; ?>
											<div class="col-lg-6">
											<label for="categories" class="form-control-label">Image <?php echo $i+1; ?></label>
											<input type="file" name="<?php echo $fileKey; ?>" class="form-control" <?php echo $image_required; ?>>
											</div>
											<?php }
										} ?>
									</div>							 
								</div>

								<div class="form-group">
									<label for="categories" class=" form-control-label">Short Description</label>
									<textarea name="short_desc" placeholder="Enter product short description" class="form-control" required><?php echo $short_desc?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Description</label>
									<textarea name="description" placeholder="Enter product description" class="form-control" required><?php echo $description?></textarea>
								</div>
								
								<button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
									<span id="payment-button-amount">Submit</span>
								</button>
								<div class="field_error"><?php echo $msg?></div>

							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require('footer.inc.php');
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
	function removeAttr(attr_id) {
		let confirmDelete = confirm("Are you sure you want to remove this item?");
        if (confirmDelete) {
            $.ajax({
                url: 'delete_proAttr.php', 
                method: 'POST',
                data: { attrId: attr_id },
                success: function(response) {
                    location.reload();
					alert(response);
                },
            });
        }
	}
</script>