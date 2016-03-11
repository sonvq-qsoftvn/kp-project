<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_ticket = new admin;

$unique_id = $_SESSION['unique_id'];
$ticket_id = $_POST['ticket_id'];

$obj_ticket->getTempTicketById_final($ticket_id);
$obj_ticket->next_record();

$arr = array('ticket_name_en' => $obj_ticket->f('ticket_name_en'), 'ticket_name_sp' => $obj_ticket->f('ticket_name_sp'),'description_en' => $obj_ticket->f('description_en'),'description_sp' => $obj_ticket->f('description_sp'),'price_mx' => $obj_ticket->f('price_mx'),'price_us' => $obj_ticket->f('price_us'),'ticket_num' => $obj_ticket->f('ticket_num'),'from_ticket' => date("d-m-Y",$obj_ticket->f('from_ticket')),'to_ticket' => date("d-m-Y",$obj_ticket->f('to_ticket')),'eairly_dis_percen' => $obj_ticket->f('eairly_dis_percen'),'eairly_days' => $obj_ticket->f('eairly_days'),'group_dis_per' => $obj_ticket->f('group_dis_per'),'group_dis_days' => $obj_ticket->f('group_dis_days'),'members_only' => $obj_ticket->f('members_only'));

echo json_encode($arr);

?>
   
 


