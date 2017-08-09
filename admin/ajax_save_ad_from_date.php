<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');
$obj_media_update_en = new admin;
$obj_admin = new admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['field_name']) && !empty($_POST['field_name']) &&
            isset($_POST['ad_id']) && !empty($_POST['ad_id']) &&
            isset($_POST['save_value'])) {
        
        $obj_media_update_en->featch_ad_data_by_en_id($_POST['ad_id']);
        $obj_media_update_en->next_record();
        
        $strto_time_from_date_edit = strtotime($obj_media_update_en->f('From_date'));
        $strto_time_duration_date_edit = strtotime($obj_media_update_en->f('duration'));

        $total_duration_date = ($strto_time_duration_date_edit - $strto_time_from_date_edit) / (60 * 60 * 24);

        $strto_time_from = strtotime($_POST['save_value']);
        $last_duration_date_time = $strto_time_from + ($strto_time_duration_date_edit - $strto_time_from_date_edit);
        $strto_time_from_duration_date = date('Y-m-d', $last_duration_date_time);
    
        //var_dump($_POST['ad_id'], $_POST['field_name'], $_POST['save_value'], $strto_time_from_duration_date);die;
        $obj_admin->saveAdsValues($_POST['ad_id'], $_POST['field_name'], $_POST['save_value']);
        $obj_admin->saveAdsValues($_POST['ad_id'], 'duration', $strto_time_from_duration_date);
        
        echo $strto_time_from_duration_date;
    }
}