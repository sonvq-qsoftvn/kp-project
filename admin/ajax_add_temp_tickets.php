<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_tickets = new admin;
$obj_edit_tic = new admin;
$obj_event = new admin;

//print_r($_POST);exit;

// GET EVENT ID 

if($_REQUEST['event_id']!="")
{
   $event_id = $_REQUEST['event_id'];
   
   // 
   
}
else
{
	$obj_event->checkSavedEvent($_SESSION['unique_id']);
	$obj_event->next_record();
	if($obj_event->num_rows())
		$event_id = $obj_event->f('event_id');
		//echo $event_id;
}



$ticket_name_en = addslashes($_POST['ticket_name_en']);
$ticket_name_sp = addslashes($_POST['ticket_name_sp']);
$description_en = addslashes($_POST['description_en']);
$description_sp = addslashes($_POST['description_sp']);
$price_mx = $_POST['price_mx'];
$price_us = $_POST['price_us'];
$ticket_num = $_POST['ticket_num'];
$from_ticket = strtotime($_POST['from_ticket']);
$to_ticket = strtotime($_POST['to_ticket']);
$eairly_dis_percen = $_POST['eairly_dis_percen'];
$eairly_days = $_POST['eairly_days'];
$group_dis_per = $_POST['group_dis_per'];
$group_dis_days = $_POST['group_dis_days'];
$ticket_icon = $_POST['photoname'];
$members_only = $_POST['members_only'];


if($_POST['edit_ticket']==0){
	$obj_add->addTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$_SESSION['unique_id'],$event_id);
}
else
{
	$ticket_id = $_POST['exit_ticket_id'];
	$obj_edit_tic->editTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$_SESSION['unique_id'],$ticket_id);
}
//echo '<font color="#FF0000"><strong>Ticket has been created successfully</strong></font>';

//if($_REQUEST['event_id']!="")
//{
   $obj_temp_tickets->get_final_tickets($event_id);
//}
//else
//{
//   $obj_temp_tickets->get_temp_tickets($event_id);
//}



echo ' <div style=" max-height:95px; over flow:auto;">';
 //Fetch records from temp table
//$obj_temp_tickets->get_temp_tickets($_SESSION['unique_id']);
if($obj_temp_tickets->num_rows()){
	while($obj_temp_tickets->next_record()){
?>
<div id="save_create_ticket_display" class="event_ticketbox">
    <ul>
        <li><?php echo $obj_temp_tickets->f('ticket_name_sp');?></li>
        <li><?php echo $obj_temp_tickets->f('ticket_name_en');?></li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_mx'),2);?> MXP </li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_us'),2);?> USD </li>
        <li style="margin-right: 0;">
            <span class="tic_edit">
                <span style="cursor:pointer;" onclick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit </span>
                <span style="cursor:pointer;" onclick="deleteTemp('<?php echo $obj_temp_tickets->f('ticket_id') ?>','<?php echo $event_id;?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete </span>
            </span>
        </li>
    </ul>
</div>
    
 <?php
	}
}
echo '</div>';

 ?>