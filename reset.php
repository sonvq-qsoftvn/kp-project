<?php
include('include/user_inc.php');

$obj_reset = new user;
$obj_getadmin = new user;
$user_id = $_REQUEST['user_id'];

$obj_reset->activateUser($user_id);
$obj_reset->next_record();

$obj_getadmin->getAdminById($user_id);
$obj_getadmin->next_record();

$_SESSION['admin_email'] = $obj_getadmin->f('email');
$_SESSION['name'] = $obj_getadmin->f('fname')." ". $obj_getadmin->f('lname');
$_SESSION['ses_admin_id'] = $obj_getadmin->f('admin_id');
$_SESSION['login_mode'] = 'site';

header("Location:".$obj_base_path->base_path()."/resetpassword");
	
?>	