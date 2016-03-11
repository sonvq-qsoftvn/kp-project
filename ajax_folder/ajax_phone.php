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

$phone = $_POST['phone'];
$mode = $_POST['mode'];

if($mode=="del"){
// =================================== Delete Altername Email Id ====================================
	$obj_del_altemail->deletephn($phone,$_SESSION['ses_admin_id']);
	
// =================================== Delete Altername Email Id ====================================
}
else if($mode=="save"){
// =================================== Save Altername Email Id ====================================

	$obj_save->savephn($phone,$_SESSION['ses_admin_id']);
	$obj_save->next_record();
	echo 1;
	
// =================================== Save Altername Email Id ====================================
}
else{
// =================================== Add Altername Email Id ====================================
			
			$obj_save->savephn($phone,$_SESSION['ses_admin_id']);
			$obj_save->next_record();
					
			echo 1;
// =================================== Add Altername Email Id ====================================
}




?>		
  
		  
