<?php
include('include/user_inc.php');

$obj_activate = new user;
$obj_getadmin = new user;
$user_id = $_REQUEST['user_id'];

$obj_activate->activateUser($user_id);
$obj_activate->next_record();

$obj_getadmin->getAdminById($user_id);
$obj_getadmin->next_record();

$_SESSION['admin_email'] = $obj_getadmin->f('email');
$_SESSION['name'] = $obj_getadmin->f('fname')." ". $obj_getadmin->f('lname');
$_SESSION['ses_admin_id'] = $obj_getadmin->f('admin_id');
$_SESSION['login_mode'] = 'site';
$_SESSION['activate_lang_change'] = 1;

if($obj_getadmin->f('account_type')==1){
	header("Location:".$obj_base_path->base_path()."/professional_userprofile");
	exit;
}
else{
	header("Location:".$obj_base_path->base_path()."/userprofile");
	exit;
}

?>		
  
	  
		  
