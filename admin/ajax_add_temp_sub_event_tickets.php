<?php
session_start();
include('../include/admin_inc.php');

$obj_add = new event;
$obj_temp_tickets = new event;
$obj_edit_tic = new event;
$obj_get_event_id = new event;
$objsub = new event;

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

// parents Details
$obj_get_event_id->get_event_id($_SESSION['unique_id']);
$obj_get_event_id->next_record();
$parent_event_id = $obj_get_event_id->f('event_id');

// Sub-event Details
$objsub->get_sub_event_id($_SESSION['unique_id_subevent']);
$objsub->next_record();
$sub_event_id = $objsub->f('event_id');


if($_POST['edit_ticket']==0){
	$obj_add->addsub_event_final_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$_SESSION['unique_id_subevent'],$parent_event_id,$sub_event_id);
}
else
{
	$ticket_id = $_POST['exit_ticket_id'];
	$obj_edit_tic->editsub_event_final_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$_SESSION['unique_id_subevent'],$ticket_id);
}
//echo '<font color="#FF0000"><strong>Ticket has been created successfully</strong></font>';

echo ' <div style=" max-height:95px; over flow:auto;">';
 //Fetch records from temp table
$obj_temp_tickets->getSubEventTicket($_SESSION['unique_id_subevent']);
if($obj_temp_tickets->num_rows()){
	while($obj_temp_tickets->next_record()){
?>
<div id="save_create_ticket_display" class="event_ticketbox" style="border-bottom:1px solid #999;">
    <ul>
        <li><?php echo $obj_temp_tickets->f('ticket_name_sp');?></li>
        <li><?php echo $obj_temp_tickets->f('ticket_name_en');?></li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_mx'),2);?> MXP </li>
        <li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_us'),2);?> USD </li>
        <li style="margin-right: 0;">
            <span class="tic_edit">
                <span style="cursor:pointer;" onclick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Edit </span>
                <span style="cursor:pointer;" onclick="deleteTemp(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> Delete </span>
            </span>
        </li>
    </ul>
</div>
    
 <?php
	}
}
echo '</div>';

 ?>


