<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_admin = new admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['field_name']) && !empty($_POST['field_name']) &&
            isset($_POST['ad_id']) && !empty($_POST['ad_id']) &&
            isset($_POST['save_value'])) {
        $obj_admin->saveAdsValues($_POST['ad_id'], $_POST['field_name'], $_POST['save_value']);
    }
}