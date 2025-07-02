<?php
require('connection.inc.php');
require('functions.inc.php');

$c_id=get_safe_value($con,$_POST['c_id']);
$pid=get_safe_value($con,$_POST['pid']);
$type=get_safe_value($con,$_POST['type']);

if($type=='color'){
	$resAttr=mysqli_query($con,"select product_attributes.size_id,size_master.size from product_attributes,size_master where product_attributes.product_id='$pid' and product_attributes.color_id=$c_id and size_master.id=product_attributes.size_id and size_master.status=1 order by size_master.order_by asc");
	$html='';
	if(mysqli_num_rows($resAttr)>0){
		while($rowAttr=mysqli_fetch_assoc($resAttr)){
			$html.=	"<P>
                        <input type='radio' name='size' value='".$rowAttr['size_id']."' id='size-".$rowAttr['size']."'>
                        <label for='size-".$rowAttr['size']."' class='circle'><span>".$rowAttr['size']."</span></label>
                    </P>";
		}
	}
	echo $html;
}

if ($type=='only_color') {
	$attrReq=mysqli_query($con,"SELECT product_attributes.* FROM product_attributes WHERE product_attributes.product_id='$pid' AND product_attributes.color_id='$c_id'");
	if (mysqli_num_rows($attrReq) > 0) {
        $row = mysqli_fetch_assoc($attrReq);
        $price = $row['price'];
        $mrp = $row['mrp'];
        $quantity = $row['qty'];
		$sid = $row['size_id'];
		header('Content-Type: application/json');
        echo json_encode(array('price' => $price, 'mrp' => $mrp, 'quantity' => $quantity, 'sizeId' => $sid));
	}
}
?>