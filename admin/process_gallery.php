<?php
include('../include/admin_inc.php');
$objevent_media = new admin;

$event_id=$_POST['event_id'];
$gal_media_id_arr=$_POST['gallery_media'];
$gal_media_arr=$_POST['gallery_media'];
$media_name_arr=$_POST['media_name'];
$media_url_arr=$_POST['media_url_all'];
$media_caption_arr=$_POST['caption'];
$media_format_arr=$_POST['media_format'];
$set_privacy_arr=$_POST['set_privacy_all'];
$language_arr=$_POST['language_all'];
$alternet_text_arr=$_POST['alternet_text_all'];
$description_arr=$_POST['description_all'];
//print_r($set_privacy_arr);
//print_r($gal_media_arr);
//exit();
for($i=0;$i<sizeof($gal_media_arr);$i++)
{
        
        //echo "<br/><==start>".$gal_media_arr[$i]."<br/>".$media_url_arr[$i]."<br/>".$media_caption_arr[$i]."<br/>".$media_format_arr[$i]."<br/>".$set_privacy_arr[$i]."<br/>".$language_arr[$i]."<br/>".$alternet_text_arr[$i]."<br/>".$description_arr[$i]."<br/>".$gal_media_id_arr[$i]."<br/>".$media_name_arr[$i]."<==end>";

// -- add Content --	
$objevent_media->add_gallery_withEvent($gal_media_id_arr[$i],$event_id);
}
header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);	
?>