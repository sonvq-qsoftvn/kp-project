<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_tickets = new admin;

$unique_id = $_SESSION['unique_id'];

$obj_temp_tickets->get_temp_tickets($unique_id);
if($obj_temp_tickets->num_rows())
	echo 1;
else
	echo 0;
?>


