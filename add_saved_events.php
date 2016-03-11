<?php
include('include/user_inc.php');

$obj_activate = new user;

$event_id = $_REQUEST['event_id'];
$start = $_REQUEST['start'];
$end = $_REQUEST['end'];

$obj_activate->add_saved_events_by_user($event_id,$start,$end);
$obj_activate->next_record();

header("Location:".$obj_base_path->base_path()."/savedevents");
exit;
	
?>		
  
	  
		  
