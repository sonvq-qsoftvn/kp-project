<?php
include('include/user_inc.php');

$obj_activate = new user;

$event_id = $_POST['event_id'];

$obj_activate->checkedSavedUserEvent($event_id);
$obj_activate->next_record();
if($obj_activate->num_rows()>0)
	echo 1;
else
	echo 0;
	
?>		
  
	  
		  
