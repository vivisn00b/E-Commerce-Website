<?php
require('connection.inc.php');
require('functions.inc.php');

$quantity = get_safe_value($con,$_POST['qty']);
$pid = get_safe_value($con,$_POST['pro_id']);

$getProductAttr = getProductAttr($con, $pid);
$productQty = productQty($con, $pid);
$productSoldQtyByProductId = productSoldQtyByProductId($con, $pid, $getProductAttr);
$cart_show = 'yes';
$html='';
if ($quantity > $productSoldQtyByProductId) {
    $html.= 'In Stock';
} else {
    $html.= 'Out of Stock';
    $cart_show = '';
}
echo $html;
?>