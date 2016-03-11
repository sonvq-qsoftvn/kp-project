<?php
include('include/user_inc.php');

$lang = $_REQUEST['lang'];
$eventname = $_REQUEST['eventname'];
$event_id = $_REQUEST['event_id'];

if($lang=="en")
{
	$page_name = 'event';
}
else
	$page_name = 'evento';


header("location: ".$obj_base_path->base_path()."/".$page_name."/".$event_id."/".$lang."/".$eventname);
exit;
?>
