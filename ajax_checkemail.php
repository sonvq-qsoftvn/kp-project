<?php
include('include/user_inc.php');

$obj_checkEmail = new user;
$email = $_POST['email'];
$obj_checkEmail->checkEmail($email);
echo $obj_checkEmail->num_rows();

?>		
  
	  
		  
