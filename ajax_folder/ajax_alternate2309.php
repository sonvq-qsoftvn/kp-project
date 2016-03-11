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

$altername_email = $_POST['altername_email'];
$mode = $_POST['mode'];

if($mode=="del"){
// =================================== Delete Altername Email Id ====================================
	$obj_del_altemail->deleteAltEmail($altername_email);
	
// =================================== Delete Altername Email Id ====================================
}
else if($mode=="save"){
// =================================== Save Altername Email Id ====================================

	$obj_save->saveAltEmail($altername_email,$_SESSION['ses_admin_id']);
	$obj_save->next_record();
	echo 1;
	
// =================================== Save Altername Email Id ====================================
}
else{
// =================================== Add Altername Email Id ====================================
	$obj_email_check->checkEmail($altername_email);
	if($obj_email_check->num_rows()){
		echo 0;
	}
	else{
		
			$obj_getDtls->checkpass($_SESSION['ses_admin_id']);
			$obj_getDtls->next_record();
			
			// Send Email
			$obj_sendmail->send_confrimation($altername_email,$obj_getDtls->f('fname'));
	
			$obj_add_altemail->add_more_emailid_user($altername_email);
			$_SESSION['duplicate_email'] = "You have added a new email address to your account. A confirmation email has been sent to that address. Please confirm this new email address by clicking on the link in the email.!";
		echo 1;
	}
// =================================== Add Altername Email Id ====================================
}




?>		
  
		  
