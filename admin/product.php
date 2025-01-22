<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='status'){
		$operation=get_safe_value($con,$_GET['operation']);
		$id=get_safe_value($con,$_GET['id']);
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		$update_status_sql="update product set status='$status' where id='$id'";
		mysqli_query($con,$update_status_sql);
	}
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from product where id='$id'";
		mysqli_query($con,$delete_sql);
		mysqli_query($con, "DELETE FROM product_attributes WHERE product_id = '$id'");
	}
}

// $sql="select product.*,categories.categories from product,categories where product.categories_id=categories.categories_id order by product.id asc";
$sql="select product.*,categories.categories from product,categories where product.categories_id=categories.categories_id order by product.id asc";
$res=mysqli_query($con,$sql);

// $query="select * from product_attributes where product_id='$id' order by id asc";
// $req=mysqli_query($con,$sql);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Products </h4>
				   <h4 class="box-link"><a href="manage_product.php">Add Product</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th>ID</th>
							   <th>Categories</th>
							   <th>Name</th>
							   <th>Image</th>
							   <th>MRP</th>
							   <th>Price</th>
							   <th>Qty</th>
							   <th>Sold Qty</th>
							   <th></th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){
								$pid=$row['id'];
								$req=mysqli_query($con, "select min(product_attributes.mrp) as min_mrp, max(product_attributes.mrp) as max_mrp, min(product_attributes.price) as min_price, max(product_attributes.price) as max_price, min(product_attributes.qty) as min_qty, max(product_attributes.qty) as max_qty from product_attributes where product_attributes.product_id='$pid' order by id asc");
								$result=mysqli_fetch_assoc($req);
							?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
							   <td><?php echo $row['id']?></td>
							   <td><?php echo $row['categories']?></td>
							   <td><?php echo $row['name']?></td>
							   <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"/></td>
							   <td><?php echo $result['min_mrp']." - ".$result['max_mrp']?></td>
							   <td><?php echo $result['min_price']." - ".$result['max_price']?></td>
							   <td><?php echo $result['min_qty']." - ".$result['max_qty']?></td>
							   <td>
								<?php
								$soldQty=productSoldQtyByProductId($con, $pid);
								if ($soldQty>0) {
									echo $soldQty;
								} else {
									echo 0;
								}
								
								?>
							   </td>
							   <td>
								<?php
								if($row['status']==1){
									echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp;";
								}else{
									echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></span>&nbsp;";
								}
								echo "<span class='badge badge-edit'><a href='manage_product.php?id=".$row['id']."'>Edit</a></span>&nbsp;";
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
								?>
							   </td>
							</tr>
							<?php
							$i++;
							} ?>
						 </tbody>
					  </table>
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