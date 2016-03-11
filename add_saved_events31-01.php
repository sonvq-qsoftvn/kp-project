<?php
include('include/user_inc.php');

$obj_activate = new user;

$event_id = $_REQUEST['event_id'];

$obj_activate->add_saved_events_by_user($event_id);
$obj_activate->next_record();

header("Location:".$obj_base_path->base_path()."/savedevents");
exit;
	
?>		
  
	  
		  
