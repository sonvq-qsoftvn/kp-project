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
$obj_del_altphn = new user;
$obj_save = new user;

$password = $_POST['password'];
$mode = $_POST['mode'];
$md5pass = md5($password);

if($mode=="del"){
// =================================== Delete Altername Email Id ====================================
	$obj_del_altphn->deleteAltPhone($phone);
	
// =================================== Delete Altername Email Id ====================================
}
else if($mode=="save"){
// =================================== Save Altername Email Id ====================================

	$obj_save->savepass($md5pass,$_SESSION['ses_admin_id']);
	$obj_save->next_record();
	
	//$obj_sendmail->alt_email_change($altername_email,$obj_getDtls->f('fname'));
	
	
	
	echo 1;
	
// =================================== Save Altername Email Id ====================================
}
else{
// =================================== Add Altername Email Id ====================================
	/*$obj_email_check->checkEmail($altername_email);
	if($obj_email_check->num_rows()){
		echo 0;
	}*/
	//else{
		
			//$obj_getDtls->checkpass($_SESSION['ses_admin_id']);
			//$obj_getDtls->next_record();
			
			// Send Email
			//$obj_sendmail->send_confrimation($altername_email,$obj_getDtls->f('fname'));
	
			$obj_del_altphn->add_more_phone_user($phone);
			//$_SESSION['duplicate_email'] = "You have added a new email address to your account. A confirmation email has been sent to that address. Please confirm this new email address by clicking on the link in the email.!";
		echo 1;
	//}
// =================================== Add Altername Email Id ====================================
}




?>		
  
		  
