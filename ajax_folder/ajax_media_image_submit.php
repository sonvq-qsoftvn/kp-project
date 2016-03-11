<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_email_check = new user;
$obj_add_altemail = new user;
$obj_getDtls = new user;
$obj_sendmail = new user;
$obj_del_altemail = new user;
$obj_save = new user;
$obj_get_dtls1 = new user;
$obj_get_dtls3 = new user;
$obj_get_dtls2 = new user;
$altername_email = $_POST['altername_email'];
$mode = $_POST['mode'];

$image_gallery=$_POST['image_gallery'];
$image_ext=$_POST['image_ext'];
echo $image_gallery;
echo $image_ext;
?>		
  
		  
