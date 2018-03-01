<?php

error_reporting(1);
include('../include/admin_inc.php');
$obj_thumb = new admin;

$uploaddir = '../files/event/';

$arrayResult = [];
//var_dump($_FILES['uploadfile']);die;
if (count($_FILES['uploadfile']) > 0) {
    if (count($_FILES['uploadfile']['name'] > 0)) {
        foreach ($_FILES['uploadfile']['name'] as $key => $nameValue) {
            $file = $uploaddir . "large/" . time() . str_replace(' ', '_', basename($_FILES['uploadfile']['name'][$key]));
            $file_name = time() . str_replace(' ', '_', $_FILES['uploadfile']['name'][$key]);        

            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'][$key], $file)) {

                $obj_thumb->create_thumbnail($uploaddir . "large/" . $file_name, $uploaddir . "thumb/" . $file_name, 180, 180);
                $obj_thumb->create_thumbnail($uploaddir . "large/" . $file_name, $uploaddir . "medium/" . $file_name, 400, 400);

                $arrayResult[] = $file_name;            

            }
        }
    }
}
echo (json_encode($arrayResult));
exit;
?>
