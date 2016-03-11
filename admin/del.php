<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

//print_r($_REQUEST);exit;
$todo = $_REQUEST['todo'];
$id = $_REQUEST['id'];

$obj_delete_venue_cat = new admin;
$obj_del_venue_type = new admin;
$obj_ven = new admin;
$obj_del_ven = new admin;
$obj_del_venue_rate = new admin;

if($todo=="performer")
{
	
	// Del Performer category.
	$obj_delete_venue_cat->delPerCat($id);
	
	// Delete Performer types
	$obj_del_venue_type->delPertypes($id);
	
	// Delete Performer Rate
	$obj_del_venue_rate->del_standard_rates_by_pid($id);
	
	// check for images
	$obj_ven->get_performer_pid($id);
	$obj_ven->next_record();
	if($obj_ven->f('performer_photo')!="")
	{
		unlink("../files/performer/large/".$obj_ven->f('performer_photo'));
		unlink("../files/performer/thumb/".$obj_ven->f('performer_photo'));
	}
	
	
	$obj_del_ven->del_per_by_pid($id);
	
	$_SESSION['per_del_msg'] = "Performer is deleted successfully.";
	header("Location:".$obj_base_path->base_path()."/admin/list_performers.php");
}

?>