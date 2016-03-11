<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_accunt_type = new user;

$param = $_REQUEST['param'];
$adminid = $_SESSION['ses_admin_id'];

$obj_accunt_type->updateAccountType($param ,$adminid);

if($param == 0)
header("Location:".$obj_base_path->base_path()."/userprofile");
elseif($param == 1)
header("Location:".$obj_base_path->base_path()."/professional_userprofile");
?>		
  
		  
