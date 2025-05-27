<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_product($con, $type='', $limit=''){
	$sql="select * from product where status=1";
	if ($type=='latest') {
		$sql.=" order by id desc";
	}
	if ($type=='all') {
		$sql.=" order by id asc";
	}
	if ($limit!= '') {
		$sql .=" limit $limit";
	}
	$res=mysqli_query($con, $sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)) {
		$data[]=$row;
	}
	return $data;
}

function get_product_cat($con, $limit='', $cat_id=''){
	$sql="select * from product where status=1";
	if($cat_id!=''){
		$sql.=" and categories_id=$cat_id";
	}
	$sql.=" order by id desc";
	if ($limit!= '') {
		$sql.=" limit $limit";
	}
	$res=mysqli_query($con, $sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)) {
		$data[]=$row;
	}
	return $data;
}

function get_cat_zone($con, $limit = '', $start_id = '', $end_id = '') {
    $sql = "SELECT * FROM product WHERE status = 1";
    if ($start_id != '' && $end_id != '') {
        $sql .= " AND categories_id BETWEEN $start_id AND $end_id";
    } elseif ($start_id != '' && $end_id == '') {
        $sql .= " AND categories_id = $start_id";
    } elseif ($end_id != '' && $start_id == '') {
        $sql .= " AND categories_id = $end_id";
    }
    $sql .= " ORDER BY id DESC";
    if ($limit != '') {
        $sql .= " LIMIT $limit";
    }
    $res = mysqli_query($con, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}

function get_product_details($con, $limit='', $cat_id='', $product_id='', $attr_id=''){
	$sql="select product.*,categories.categories,product_attributes.mrp,product_attributes.price,product_attributes.qty from product,categories,product_attributes where product.status=1 and product.id=product_attributes.product_id";
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id";
	}
	if($product_id!=''){
		$sql.=" and product.id=$product_id";
	}
	if($attr_id>0){
		$sql.=" and product_attributes.id=$attr_id";
	}
	$sql.=" and product.categories_id=categories.categories_id";
	$sql.=" group by product.id order by product.id desc";
	if ($limit!= '') {
		$sql.=" limit $limit";
	}
	$res=mysqli_query($con, $sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)) {
		$data[]=$row;
	}
	return $data;
}

function get_safe_value ($con, $str) {
	if ($str !='') {
		$str = trim ($str);
		return mysqli_real_escape_string($con, $str);
	} else {
		return '';
	}
}

function get_search_product($con,$limit='',$cat_id='',$product_id='',$search_str=''){
	$sql="select product.*,categories.categories from product,categories where product.status=1 ";
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id ";
	}
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	$sql.=" and product.categories_id=categories.categories_id ";
	if($search_str!=''){
		$sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%') ";
	}
	$sql.=" order by product.id desc ";
	if($limit!=''){
		$sql.=" limit $limit";
	}
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function productSoldQtyByProductId($con,$pid,$attr_id){
	$sql="select sum(order_detail.qty) as qty from order_detail,`order` where `order`.id=order_detail.order_id and order_detail.product_id='$pid' and order_detail.product_attr_id='$attr_id' and `order`.order_status!=4 and ((`order`.payment_type='UPI' and `order`.payment_status='Success') or (`order`.payment_type='Card' and `order`.payment_status='Success') or (`order`.payment_type='COD' and `order`.payment_status!=''))";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function productQty($con,$p_id){
	$sql="select sum(qty) as qty from product_attributes where product_id='$p_id'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function getProductAttr($con,$pid){
	$sql="select id from product_attributes where product_id='$pid'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['id'];
}

function getProductPrice($con,$p_id){
	$sql="select sum(mrp) as mrp from product_attributes where product_id='$p_id'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['mrp'];

	$sql="select sum(price) as price from product_attributes where product_id='$p_id'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['mrp'];
}

function getProductDiscount($con, $p_id) {
    $sql = "SELECT SUM(mrp) AS mrp, SUM(price) AS price FROM product_attributes WHERE product_id='$p_id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    $discountPercent = round((($row['mrp'] - $row['price']) / $row['mrp']) * 100);
    return $discountPercent;
}
?>