<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='status'){
		$operation=get_safe_value($con,$_GET['operation']);
		$categories_id=get_safe_value($con,$_GET['categories_id']);
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		$update_status_sql="update categories set status='$status' where categories_id='$categories_id'";
		mysqli_query($con,$update_status_sql);
	}
	
	if($type=='delete'){
		$categories_id=get_safe_value($con,$_GET['categories_id']);
		$delete_sql="delete from categories where categories_id='$categories_id'";
		mysqli_query($con,$delete_sql);
	}
}

$sql="select * from categories order by categories_id asc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<h4 class="box-title">Categories </h4>
						<h4 class="box-link"><a href="manage_categories.php">Add Categories</a> </h4>
					</div>
					<div class="card-body--">
						<div class="table-stats order-table ov-h">
						<table class="table ">
							<thead>
							<tr>
								<th class="serial">#</th>
								<th>categories_id</th>
								<th>Categories</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
								<td class="serial"><?php echo $i?></td>
								<td><?php echo $row['categories_id']?></td>
								<td><?php echo $row['categories']?></td>
								<td>
								<?php
								if($row['status']==1){
									echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&categories_id=".$row['categories_id']."'>Active</a></span>&nbsp;";
								}else{
									echo "<span class='badge badge-pending'><a href='?type=status&operation=active&categories_id=".$row['categories_id']."'>Deactive</a></span>&nbsp;";
								}
								echo "<span class='badge badge-edit'><a href='manage_categories.php?categories_id=".$row['categories_id']."'>Edit</a></span>&nbsp;";
								
								echo "<span class='badge badge-delete'><a href='?type=delete&categories_id=".$row['categories_id']."'>Delete</a></span>";
								
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