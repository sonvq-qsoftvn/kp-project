<?php
include('include/user_inc.php');

if($_POST['acc_type']=="personal")
	$_SESSION['account_type_google'] = 0;
if($_POST['acc_type']=="professional")
	$_SESSION['account_type_google'] = 1;
?>		
  
	  
		  
