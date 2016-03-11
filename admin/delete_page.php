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
$obj_delete_venue_cat->delPage($venue_id);

$obj_ven->getPageDetails($venue_id);
$obj_ven->next_record();
if($obj_ven->f('photo')!="")
{
	unlink("../files/event/large/".$obj_ven->f('photo'));
	unlink("../files/event/thumb/".$obj_ven->f('photo'));
}


$obj_del_ven->delete_venue($venue_id);

$_SESSION['page_del_msg'] = "Page is deleted successfully.";
header("Location:".$obj_base_path->base_path()."/admin/list_page.php?err=1");

?>