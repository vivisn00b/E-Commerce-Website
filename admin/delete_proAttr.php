<?php
require('connection.inc.php');
require('functions.inc.php');

$attrId = $_POST['attrId'];
mysqli_query($con, "DELETE FROM product_attributes WHERE id='$attrId'");
echo "Item removed successfully";
?>
