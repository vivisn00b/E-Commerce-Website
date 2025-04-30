<?php
session_start();
$con=mysqli_connect("localhost","root","","ecom-mod");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/php/ecom_mod/');
define('SITE_PATH','http://127.0.0.1/php/ecom_mod/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');
define('USER_IMAGE_SERVER_PATH',SERVER_PATH.'media/user/');
define('USER_IMAGE_SITE_PATH',SITE_PATH.'media/user/');
?>