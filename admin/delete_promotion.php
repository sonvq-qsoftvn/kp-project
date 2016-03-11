<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$obj_promo = new admin;


$social_id = $_REQUEST['id'];
$event_id = $_REQUEST['event_id'];

/*-----------delete social from all table--------------------*/
$obj_promo->delete_promo($social_id,$event_id);
//$_SESSION['media_del_msg'] = "Social is deleted successfully.";

header("Location:".$obj_base_path->base_path()."/admin/add-promotion/event/$event_id");
exit();
?>