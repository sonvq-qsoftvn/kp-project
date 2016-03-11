<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_getcity = new user;
$countyId = $_POST['country_id'];

$obj_getcity->countries_byid($countyId);
$obj_getcity->next_record();
echo $obj_getcity->f('phonecode');
?>		
	  
		  
