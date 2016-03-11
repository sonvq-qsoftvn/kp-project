<?php
	session_start();
	include("../../class/db_mysql.inc");
	include("../../class/admin_class.php");
	include("../../class/event_class.php");
	include("../../class/duplicate_event_class.php");
	
	$obj_base_path = new DB_Sql;
	include("../../include/session_admin.inc.php");

$obj_add = new admin;
$obj_gettic = new admin;
$obj_temp_tickets = new event;


$ticket_id = $_POST['ticket_id'];
$sub_event_id = $_POST['sub_event_id'];

// Delete images if any
$obj_gettic->getSubeventTicketById($ticket_id);
$obj_gettic->next_record();
if($obj_gettic->f('ticket_icon')){
	unlink("../files/ticket/large/".$obj_gettic->f('ticket_icon'));
	unlink("../files/ticket/medium/".$obj_gettic->f('ticket_icon'));
	unlink("../files/ticket/thumb/".$obj_gettic->f('ticket_icon'));
}

$obj_add->del_sub_tickets($ticket_id);


 //Fetch records from temp table
$obj_temp_tickets->getSub_ticket($sub_event_id);
if($obj_temp_tickets->num_rows()){
	while($obj_temp_tickets->next_record()){
?>
<div class="event_ticketbox" style="border-bottom:1px solid #CCC;">
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

 ?>

