<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_delete_ticket = new admin;
$obj_final_tickets = new admin;

$unique_id = $_SESSION['unique_id'];
$arr = explode('_',$_POST['ticket_id']);
$ticket_id=$arr[0];
$event_id=$arr[1];

$obj_delete_ticket->delete_final_ticket($ticket_id);

echo '<div style=" max-height:95px;overflow:auto;">';
 //Fetch records from temp table
$obj_final_tickets->allTicketListCount($event_id);
if($obj_final_tickets->num_rows()){
	while($obj_final_tickets->next_record()){
?>
    <div style="margin:0 0 10px 0; border-bottom: 1px dotted #666;">
        <div>
            <span><?php echo $obj_final_tickets->f('ticket_name_en');?></span><span> USD <?php echo $obj_final_tickets->f('price_us');?></span> 
             <span style="margin-right:25px; float:right; cursor:pointer;" onclick="deleteFinal(<?php echo $obj_final_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editFinalTicket(<?php echo $obj_final_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span>
        </div>
        <div>
            <span><?php echo $obj_final_tickets->f('ticket_name_sp');?></span> <span> MXP <?php echo $obj_final_tickets->f('price_mx');?></span> 
            <span style="margin-right:25px; float:right;cursor:pointer;" onclick="deleteFinal(<?php echo $obj_final_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editFinalTicket(<?php echo $obj_final_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span> 
        </div>
    </div>
 <?php
	}
}
echo '</div>';
 ?>


