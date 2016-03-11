<?php
session_start();

include('../include/admin_inc.php');

$obj_delete_meta= new admin;
$meta_id = $_REQUEST['id'];


	$obj_delete_meta->deletemeta($meta_id);
	$_SESSION['media_del_msg'] = "meta is deleted successfully.";
	header("Location:".$obj_base_path->base_path()."/admin/meta_list");




?>
