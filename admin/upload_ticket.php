<?php
error_reporting(1);
include('../include/admin_inc.php');
$obj_thumb = new admin;
$obj_ticket = new admin;

$uploaddir = '../files/ticket/';

if(isset($_POST['id']) && $_POST['id'] == '1')	
{

$id = $_REQUEST['id'];

// fetch image name
$obj_ticket->ticketById($id);
$obj_ticket->next_record();

@unlink($uploaddir."large/".$obj_ticket->f('ticket_icon'));
@unlink($uploaddir."thumb/".$obj_ticket->f('ticket_icon'));
}

$file = $uploaddir ."large/".time().basename($_FILES['uploadfile']['name']); 
$file_name = time().$_FILES['uploadfile']['name']; 
 
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 

$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,71,78);
$obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "medium/".$file_name,94,120);

  echo $file_name; 
} else {
	echo "error";
}
exit;
?>
