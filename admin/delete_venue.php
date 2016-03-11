<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

//print_r($_REQUEST);exit;

$obj_delete_venue_cat = new admin;
$obj_del_venue_type = new admin;
$obj_ven = new admin;
$obj_del_ven = new admin;
$obj_del_venue_rate = new admin;

$venue_id = $_REQUEST['venue_id'];

// Del Venue category.
$obj_delete_venue_cat->delCatByVenueId($venue_id);

// Delete Venue types
$obj_del_venue_type->delvenueTypeByVenueId($venue_id);

// Delete Venue Rate
$obj_del_venue_rate->delvenuerate($venue_id);

// check for images
$obj_ven->getVenueDetails($venue_id);
$obj_ven->next_record();
if($obj_ven->f('venue_image')!="")
{
	unlink("../files/venue/large/".$obj_ven->f('venue_image'));
	unlink("../files/venue/thumb/".$obj_ven->f('venue_image'));
}


$obj_del_ven->delete_venue($venue_id);

$_SESSION['venue_del_msg'] = "Venue is deleted successfully.";
header("Location:".$obj_base_path->base_path()."/admin/list_venues.php");

?>