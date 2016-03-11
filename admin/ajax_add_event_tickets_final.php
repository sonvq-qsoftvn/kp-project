<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_tickets = new admin;
$obj_edit_tic = new admin;
$obj_final_tickets1 = new admin;


$unique_id = session_id();
$event_id = $_POST['exit_event_id'];
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
	$obj_add->addFinalTicket2($event_id,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id);
}
else
{
	$ticket_id = $_POST['exit_ticket_id'];
	$obj_edit_tic->editFinalTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$ticket_id);
}
//echo '<font color="#FF0000"><strong>Ticket has been created successfully</strong></font>';
?>
<?php
// Show extising tickets
$obj_final_tickets1->allTicketListCount($_POST['exit_event_id']);
if($obj_final_tickets1->num_rows()){
	while($obj_final_tickets1->next_record()){
?>
	<div style="margin:0 0 10px 0; border-bottom: 1px dotted #666;">
        <div>
            <span><?php echo $obj_final_tickets1->f('ticket_name_en');?></span><span> USD <?php echo $obj_final_tickets1->f('price_us');?></span> 
             <span style="margin-right:25px; float:right; cursor:pointer;" onclick="deleteFinal(<?php echo $obj_final_tickets1->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editFinalTicket(<?php echo $obj_final_tickets1->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span>
        </div>
        <div>
            <span><?php echo $obj_final_tickets1->f('ticket_name_sp');?></span> <span> MXP <?php echo $obj_final_tickets1->f('price_mx');?></span> 
            <span style="margin-right:25px; float:right;cursor:pointer;" onclick="deleteFinal(<?php echo $obj_final_tickets1->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editFinalTicket(<?php echo $obj_final_tickets1->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span> 
        </div>
    </div>	
<?php
	}
}
echo '</div>';
?>


