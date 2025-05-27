<?php
require('connection.inc.php');
require('functions.inc.php');

$proId = get_safe_value($con,$_POST['pro_id']);
$colorId = get_safe_value($con,$_POST['color_id']);
$sizeId = get_safe_value($con,$_POST['size_id']);

$query = "SELECT qty FROM product_attributes WHERE product_id='$proId' AND color_id = '$colorId' AND size_id = '$sizeId'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $quantity = $row['qty'];
    echo $quantity;
} else {
    echo '';
}
?>
