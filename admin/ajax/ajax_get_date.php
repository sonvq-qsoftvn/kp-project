<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");
include("../../class/merchant_admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");


$objAd = new admin;

$ad_size = $_POST['ad_size'];
$ad_position = $_POST['ad_position'];
$ad_id = $_POST['edit_ad_id'];
$ad_start_date= date('Y-m-d',strtotime($_POST['start_date']));
//echo "1s= ".$ad_start_date;
$ad_form_date= $_POST['end_date'];
//echo "1e= ".$ad_form_date;

$last_duration_date_time = strtotime($ad_start_date) + $ad_form_date*(60*60*24);
//echo "LDD= ".$last_duration_date_time;
$end_date = date('Y-m-d',$last_duration_date_time);
//echo "d2= ". $end_date;

//echo "echo=".$ad_size."".$ad_position;
if($ad_id!="")
    $objAd->getAdbyPosSizeEdit($ad_size,$ad_position,$ad_start_date,$end_date,$ad_id);
else {
    $objAd->getAdbyPosSize($ad_size,$ad_position,$ad_start_date,$end_date);
}
$objAd->next_record();
$num=$objAd->num_rows();
if($num>0)
{
  echo "1";  
}
else
{
    echo "0";
}



?>		
	  
		  
