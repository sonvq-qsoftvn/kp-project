<?php

session_start();
include("../../class/db_mysql.inc");
include("../../class/admin_class.php");
include("../../class/event_class.php");
include("../../class/duplicate_event_class.php");
include("../../class/merchant_admin_class.php");

$obj_base_path = new DB_Sql;
include("../../include/session_admin.inc.php");

$objmedia = new admin;

$obj_media_language = new admin;
$obj_language = new admin;

$event_id = $_POST['event_id'];
$set_privacy = $_POST['set_privacy'];
$language = $_POST['language'];
$media_name = $_POST['media_name'];
$caption = addslashes($_POST['caption']);
$alternate_text = addslashes($_POST['alternate_text']);
$description = addslashes($_POST['description']);
$media_id = $_POST['media_id'];

if (strpos($media_id, ',') !== false) {
    // upload multiple image
    $media_id_arr = explode(',', $media_id);
    if(count($media_id_arr) > 0) {
        foreach ($media_id_arr as $singleId) {
            $obj_language->getlangMediabyId($singleId);
            $num = $obj_language->num_rows();

            if ($num < 1) /* is this media on language table checking */ {
                $objmedia->update_media_gallery($set_privacy, $singleId);
                $obj_media_language->add_media_language($singleId, $language, $media_name, $caption, $alternate_text, $description);
                if ($language == 'es_MX') {
                    $lang = 'en_US';
                } else {
                    $lang = 'es_MX';
                }                
            } 
        }
        echo $set_privacy . "||" . $lang;
    }
} else {
    $obj_language->getlangMediabyId($media_id);
    $num = $obj_language->num_rows();

    if ($num < 1) /* is this media on language table checking */ {
        $objmedia->update_media_gallery($set_privacy, $media_id);
        $obj_media_language->add_media_language($media_id, $language, $media_name, $caption, $alternate_text, $description);
        if ($language == 'es_MX') {
            $lang = 'en_US';
        } else {
            $lang = 'es_MX';
        }
        echo $set_privacy . "||" . $lang;
    }    
}


?>		


