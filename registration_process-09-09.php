<?php
include('include/user_inc.php');

$obj_adduser = new user;
$obj_sendmail = new user;

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$country_id = $_POST['country_id'];
$country_code = $_POST['country_code'];
$rem_password = $_POST['password'];
$password = md5($_POST['password']);
$account_type = $_POST['account_type'];

$user_id = $obj_adduser->register_user($fname,$lname,$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type);

//send email
$obj_sendmail->merchant_login_mail($rem_password,$email,$user_id);			

$_SESSION['user_msg'] = "Please check your email.An activation link is sent to your email. Click link to activate your account.";


?>		
  

	  
		  
