<?php
//index page
include('include/user_inc.php');

//create object
$objSettings=new user;
$objEvent=new user;
$objEventpic=new user;
$objEventpic1=new user;
$obj_venue=new user;
$obj_min_ticket_cost=new user;
$objEvent_num=new user;
$objEventcal=new user;
$objnum_ticket=new user;

$objEventCounty = new user;
$objEventtags = new user;
$objEventparentcategory = new user;
$objEventsubcategory = new user;
$objEventCity = new user;
$objEventVenue = new user;

$objSettings->adminSettings();
$objSettings->next_record();


if($_REQUEST['start_date']){
	$start_date = $_REQUEST['start_date'];
	$start_format_date = explode("-",$_REQUEST['start_date']);
	$start_val_date = $start_format_date[2]."/".$start_format_date[1]."/".$start_format_date[0];
}
if($_REQUEST['end_date']){
	$end_date = $_REQUEST['end_date'];
	$end_format_date = explode("-",$_REQUEST['end_date']);
	$end_val_date = $end_format_date[2]."/".$end_format_date[1]."/".$end_format_date[0];
	
}


// Fetch All Image Pic
$objEventpic->allEventPicture();
$objEventpic1->allEventPicture();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Index</title>	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="styles