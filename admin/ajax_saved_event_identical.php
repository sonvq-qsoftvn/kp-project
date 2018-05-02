<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_mulEve = new admin;
$obj_edit_tic = new admin;
$obj_check_saved = new admin;
//print_r($_POST);exit;

$event_start_hour = $_POST['multi_event_hr'];

$event_start_date_time = $_POST['multi_event_year']."-".$_POST['multi_event_month']."-".$_POST['multi_event_day']." ".$event_start_hour."-".$_POST['multi_event_min']."-00";
$event_start_ampm = $_POST['multi_event_start_ampm'];
$multi_venue_state = $_POST['multi_venue_state'];
$venue_county_multi = $_POST['venue_county_multi'];
$multi_venue_city = $_POST['multi_venue_city'];
$multi_venue = $_POST['multi_venue'];
//echo $_SESSION['unique_id']; exit; 
	$obj_check_saved->checkSavedEventIdentical($_SESSION['unique_id']);
	//echo $obj_check_saved->num_rows();
	if($obj_check_saved->num_rows())
	{
		//echo "Hiii";
		$obj_edit_tic->SavededitTempMultiEvent($event_start_date_time,$event_start_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$_SESSION['unique_id'],$multi_event_id);
	}
	else
	{
		
		$obj_add->SavedaddTempMultiEvent($event_start_date_time,$event_start_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$_SESSION['unique_id']);
	}

 ?>


