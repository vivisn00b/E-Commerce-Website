<?php
require('connection.inc.php');
require('functions.inc.php');

$pid = get_safe_value($con,$_POST['pro_id']);
$sid = get_safe_value($con,$_POST['size_id']);
$cid = get_safe_value($con,$_POST['color_id']);
$html = '';

$sql = "SELECT mrp, price FROM product_attributes WHERE product_id = '$pid' AND size_id = '$sid' AND color_id = '$cid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$discountPercent = round((($row['mrp'] - $row['price']) / $row['mrp']) * 100);
$html .= $discountPercent."%<br>OFF";
echo $html;
?>