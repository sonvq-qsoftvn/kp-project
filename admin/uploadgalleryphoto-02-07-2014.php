<?php
error_reporting(1);
include('../include/admin_inc.php');
$obj_thumb = new admin;

$uploaddir = '../files/event/gallery/'; 
$file = $uploaddir ."large/".time().basename($_FILES['uploadfile']['name']); 
$file_name = time().$_FILES['uploadfile']['name']; 
 //echo $file;
 //copy($_FILES['uploadfile']['tmp_name'], $file);
 
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
{ 

$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,180,180);
$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,400,400);

  echo $file_name; 
} else {
	echo "error";
}
exit;
?>
