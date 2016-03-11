<?php
session_start();

include('../include/admin_inc.php');
$obj_add = new event;
$obj_tic = new event;
$objlist = new event;

$unique_id = $_SESSION['unique_id_subevent'];

$obj_add->get_sub_event_id($unique_id);
$obj_add->next_record();
if($obj_add->f('event_photo')){
	@unlink("../files/event/large/".$obj_add->f('event_photo'));
	@unlink("../files/event/medium/".$obj_add->f('event_photo'));
	@unlink("../files/event/thumb/".$obj_add->f('event_photo'));
}

$obj_tic->getSub_ticket($obj_add->f('event_id'));
$obj_tic->next_record();
if($obj_add->f('event_photo')){
	@unlink("../files/ticket/large/".$obj_tic->f('ticket_icon'));
	@unlink("../files/ticket/medium/".$obj_tic->f('ticket_icon'));
	@unlink("../files/ticket/thumb/".$obj_tic->f('ticket_icon'));
}

$objlist->delete_sub_event($obj_add->f('event_id'));
$objlist->delete_sub_event_type($obj_add->f('event_id'));
$objlist->delete_sub_event_category($obj_add->f('event_id'));
$objlist->delete_sub_event_ticket($obj_add->f('event_id'));

?>