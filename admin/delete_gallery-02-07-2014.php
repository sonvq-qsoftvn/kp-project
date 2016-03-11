<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

//print_r($_REQUEST);
//exit;

$media_id = $_REQUEST['id'];
$event_id = $_REQUEST['event_id'];
//echo $media_id;
//echo $event_id;
$obj_gallery = new admin;
$obj_delete_media_all = new admin;
$obj_media_admin = new admin;
$obj_del_media_event = new admin;

$obj_gallery->allMediaByID($media_id);
$obj_gallery->next_record();

//$obj_media_admin->

//if($obj_gallery->f('admin_id')==$_SESSION['ses_user_id'])
 // {
//if($obj_media_admin)
//$obj_delete_media_all->deleteMedia($media_id);
//		//$pic=$obj_gallery->f('media_url');
//		//echo $pic;
//		//check for images
//	if($obj_gallery->f('media_url')!="")
//	{
//	    //echo "hello Unlink";
//	    //echo "pic= ".$pic;
//		unlink("../files/event/gallery/large/".$obj_gallery->f('media_url'));
//		unlink("../files/event/gallery/medium/".$obj_gallery->f('media_url'));
//		unlink("../files/event/gallery/thumb/".$obj_gallery->f('media_url'));
//	}
//	$_SESSION['media_del_msg'] = "Media is deleted successfully.";
//	header("Location:".$obj_base_path->base_path()."/admin/gallery-list/event/$event_id");
//  }
//else
   //{
	$obj_del_media_event->deleteMediaEvent($media_id,$event_id);
	$_SESSION['media_del_msg'] = "Media is deleted successfully.";
	header("Location:".$obj_base_path->base_path()."/admin/gallery-list/event/$event_id");
  // }



?>