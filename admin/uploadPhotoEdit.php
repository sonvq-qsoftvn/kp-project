<?php
error_reporting(1);
include('../include/admin_inc.php');
$obj_thumb = new admin;

$uploaddir = '../files/event/'; 
$file = $uploaddir ."large/".time().str_replace(' ', '_',basename($_FILES['uploadfile']['name'])); 
$file_name = time().str_replace(' ', '_',$_FILES['uploadfile']['name']); 
 //echo $file;
 //copy($_FILES['uploadfile']['tmp_name'], $file);
 
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
{ 

$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,71,78);
$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,400,400);

  echo $file_name; 
} else {
	echo "error";
}
exit;
?>
