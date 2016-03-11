<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$obj_city = new admin;
$obj_venue = new admin;


$num = $_POST['num'];

if($num==1)
{
	$city_id = $_POST['city_id'];
	$obj_city->getCityById($city_id);
	$obj_city->next_record();
	echo '<span style="font-weight:bold; font-size:16px;">'.$obj_city->f('city_name').'</span>,';
}

if($num==2)
{
	$venue_id = $_POST['venue_id'];
	$obj_venue->get_venue($venue_id);
	$obj_venue->next_record();
	echo '<span style="font-weight:bold; font-size:16px;">'.$obj_venue->f('venue_name').'</span>,';
}



?>

