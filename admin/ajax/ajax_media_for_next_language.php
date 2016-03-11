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

$objmedia = new admin;
//$objevent_media = new admin;
$obj_media_language = new admin;
$obj_language = new admin;

$event_id=$_POST['event_id'];
$set_privacy=$_POST['set_privacy'];
$language=$_POST['language'];
$media_name=$_POST['media_name'];
$caption=addslashes($_POST['caption']);
$alternate_text=addslashes($_POST['alternate_text']);
$description=addslashes($_POST['description']);
$media_id=$_POST['media_id'];


$obj_language->getlangMediabyId($media_id);
$num=$obj_language->num_rows();

if($num<1) /*is this media on language table checking*/
{
$objmedia->update_media_gallery($set_privacy,$media_id);
$obj_media_language->add_media_language($media_id,$language,$media_name,$caption,$alternate_text,$description);
  if($language=='es_MX'){$lang='en_US';}else{$lang='es_MX';}
echo $set_privacy."||".$lang;
}
//else
//{
//  echo "2";  
//}

                

//if($image_gallery!="" && $url_media=="")
//{
//$media_id=$obj_media->add_gallery($_SESSION['ses_user_id'],$image_gallery,$image_ext);
//$objevent_media->add_gallery_withEvent($media_id,$event_id);
//echo $media_id;
//}
//else
//{
//
//$media_id=$obj_media->add_gallery($_SESSION['ses_user_id'],$url_media,$media_format);
//$objevent_media->add_gallery_withEvent($media_id,$event_id);
//echo $media_id;
//}



?>		
  
		  
