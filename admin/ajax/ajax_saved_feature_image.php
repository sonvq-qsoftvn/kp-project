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
$obj_feature_image = new admin;
$obj_event_feature_image = new admin;
$obj_is_feature_image = new admin;
$obj_set_event_photo = new admin;

$media_id=$_POST['media_id'];
$event_id=$_POST['event_id'];

$obj_feature_image->update_feature_image($event_id);
$obj_feature_image->next_record();

$obj_event_feature_image->set_feature_image($media_id,$event_id);
$obj_event_feature_image->next_record();

$obj_is_feature_image->getFeatureImage($media_id,$event_id);
$obj_is_feature_image->next_record();

if($obj_is_feature_image->num_rows())
{
    $feature_image = $obj_is_feature_image->f('media_url');
    //echo "FIMAGE= ".$feature_image;
    $obj_set_event_photo->update_event_photo($feature_image,$event_id);
}

echo "updated";

?>		
  
		  
