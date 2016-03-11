<?php
error_reporting(1);
include('../include/admin_inc.php');
$obj_thumb = new admin;


$add_size= $_REQUEST['ad_size'];
$uploaddir = '../files/event/advertisement/'; 
$file = $uploaddir ."large/".time().basename($_FILES['uploadfile']['name']); 
$file_name = time().$_FILES['uploadfile']['name']; 
 //echo $file;
 //copy($_FILES['uploadfile']['tmp_name'], $file);
 
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
{ 

  if($add_size=='bottom')  
  {
    
        $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,681,142);
       // $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,275,426);
   
  }else if($add_size=='banner'){
      
        $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,275,142);
       // $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,275,426);
      
      
  }else{
      
        $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,275,426);
       // $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,275,426);
      
      
      
      
  }

  echo $file_name; 
} else {
	echo "error";
}
exit;
?>
