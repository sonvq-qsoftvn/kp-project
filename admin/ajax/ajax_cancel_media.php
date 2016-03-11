<?php
session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");
include("../../class/merchant_admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

//print_r($_POST);exit;

//$objmedia = new admin;
$obj_gallery = new admin;
$obj_media_language = new admin;
$obj_delete_media_language = new admin;
$obj_delete_media = new admin;
$obj_delete_media_event = new admin;

$media_id=$_POST['media_id'];
$obj_gallery->allMediaByID($media_id);
$obj_gallery->next_record();

$obj_media_language->getlangMediabyId($media_id);
$num=$obj_media_language->num_rows();

if($num<=1) /*is this media on language table checking*/
{

if($obj_gallery->f('media_url')!="")
	{
	    echo "hello Unlink";
            $pic=$obj_gallery->f('media_url');
	   echo "pic= ".$pic;
		unlink("../../files/event/large/".$obj_gallery->f('media_url'));
                unlink("../../files/event/medium/".$obj_gallery->f('media_url'));
		unlink("../../files/event/thumb/".$obj_gallery->f('media_url'));
	}
$obj_delete_media_language->delete_lang($media_id);
$obj_delete_media->delete_media($media_id);
$obj_delete_media_event->delete_media_event($media_id);
}



?>		
  
		  
