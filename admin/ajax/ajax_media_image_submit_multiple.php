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

$obj_media = new admin;
$objevent_media = new admin;
$objMedia = new admin;

$image_gallery = $_POST['image_gallery'];
//$image_ext=$_POST['image_ext'];
$event_id = $_POST['event_id'];
$url_media = $_POST['url_media'];
$media_format = "video";

//echo $image_gallery;
//echo $image_ext;
//echo $event_id;
//echo $url_media;
/* Checking the file type */
function videoType($video_url) {
    if (strpos($video_url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($video_url, 'vimeo') > 0) {
        return 'vimeo';
    } elseif (strpos($video_url, 'dailymotion') > 0) {
        return 'dailymotion';
    } else {
        return 'image';
    }
}

/* Checking the file type */

$arrayResult = [];
if ($image_gallery != "" && $url_media == "") {
    
    $array_gallery = explode(',', $image_gallery);
    
    if (count($array_gallery) > 0) {
        if (count($array_gallery) == 1) {
            $arrayResult['type'] = 'single';
        } else {
            $arrayResult['type'] = 'multiple';    
        }
        
        $arrayResult['data'] = [];
        foreach($array_gallery as $singleFile) {
            
            $image_ext_arr = explode('.', $singleFile);
            $image_ext = $image_ext_arr[1];
            
            $media_id = $obj_media->add_gallery($_SESSION['ses_user_id'], $singleFile, $image_ext);
            $objevent_media->add_gallery_withEvent($media_id, $event_id);
            $objMedia->allMediaByID($media_id);
            $objMedia->next_record();
            $url = $objMedia->f('media_url');
            $video_type = videoType($url);
            if (count($array_gallery) == 1) {
                $arrayResult['data'] = $media_id . "||" . $url . "||" . $video_type;   
            } else {
                $arrayResult['data'][] = $media_id . "||" . $url . "||" . $video_type;      
            }
        }
        echo json_encode($arrayResult);
    }    
} else {

    $arrayResult['type'] = 'single';
    
        
    $media_id = $obj_media->add_gallery($_SESSION['ses_user_id'], $url_media, $media_format);
    $objevent_media->add_gallery_withEvent($media_id, $event_id);
    $objMedia->allMediaByID($media_id);
    $objMedia->next_record();
    $url = $objMedia->f('media_url');
//echo "A_med= ".$media_id;
//echo "A_url= ".$url;
    $video_type = videoType($url);

    if ($video_type == "youtube") {

        $thumb_video = '<iframe width="150" height="90" src="//www.youtube.com/embed/' . end(explode("=", $objMedia->f("media_url"))) . '" frameborder="0" allowfullscreen></iframe>';
    } elseif ($video_type == "vimeo") {
        $thumb_video = '<iframe src="//player.vimeo.com/video/' . end(explode("/", $objMedia->f("media_url"))) . '" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    } elseif ($video_type == "dailymotion") {
        $dm_vid_arr = explode('_', end(explode('/', $objMedia->f('media_url'))));
        $dm_vid = $dm_vid_arr[0];

        $thumb_video = '<iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/' . $dm_vid . '" allowfullscreen></iframe>';
    }

    $arrayResult['data'] = $media_id . "||" . $thumb_video . "||" . $video_type;
    echo json_encode($arrayResult);
}
?>		


