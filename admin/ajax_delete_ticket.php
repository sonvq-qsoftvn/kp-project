<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$obj_add = new admin;
$obj_temp_tickets = new admin;
$obj_gettic = new admin;

$unique_id = $_SESSION['unique_id'];
$ticket_id = $_POST['ticket_id'];

// Delete images if any
$obj_gettic->getTempTicketById($ticket_id);
$obj_gettic->next_record();
if($obj_gettic->f('ticket_icon')){
	unlink("../files/ticket/large/".$obj_gettic->f('ticket_icon'));
	unlink("../files/ticket/medium/".$obj_gettic->f('ticket_icon'));
	unlink("../files/ticket/thumb/".$obj_gettic->f('ticket_icon'));
}

$obj_add->delete_temp_ticket($ticket_id);

echo ' <div style=" max-height:95px;">';

 //Fetch records from temp table
if($_REQUEST['event_id']!="")
{
    $event_id = $_REQUEST['event_id'];
	$obj_temp_tickets->get_final_tickets($event_id);
}
else
{
   $event_id = $obj_gettic->f('event_id');
   $obj_temp_tickets->get_final_tickets($event_id);
}

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


