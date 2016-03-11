<?php
include('../include/admin_inc.php');

//create object
$objlist = new admin;
$objlist_num = new admin;
$obj_delete = new admin;
$objticket_by_id = new admin;
$obj_event = new admin;

$event_id = $_GET['event_id'];

// Event
$obj_event->eventVenue($_GET['event_id']);
$obj_event->next_record();

					
list($event_date,$event_time) = explode(" ",$obj_event->f('event_start_date_time'));
list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);



//===============CODE FOR DELETE===================//


if(isset($_GET['action']) && $_GET['action'] == "delete")	
{
	$obj_delete->deleteFinalTicket($_GET['id']);
	$_SESSION['msg'] = "Ticket deleted successfully";
	header("Location:".$obj_base_path->base_path()."/admin/list-tickets/".$_GET['event_id']);
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Page</title>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script language="javascript">
function del(tID,eId)
{
	if(confirm("Are you sure you want to delete this ticket?"))
	{
		location.href="<?php echo $obj_base_path->base_path();?>/admin/list_tickets.php?action=delete&id="+tID+"&event_id="+eId;
	}
	
}
</script>

<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
</head>


<body class="body1"><?php include("admin_header.php");?>
<div id="maindiv">	
 <div class="clear"></div>
  <div class="body_bg">
    <div class="clear"></div>
    
    <div class="container">
    <?php include("admin_header_menu.php");?>
     <div class="clear"></div>		
    <!--start body-->
     <div id="body">
        <div class="body2"> 
           <div class="clear"></div>
           <div class="blue_box1">
           <div class="blue_boxh">
           		<ul>
                	<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list">Events</a></li>
                    <li><a href="#">Tickets</a></li>
                </ul>
          <!-- <p>Tickets</p>-->
          </div>
           <div class="blue_boxr">
             <ul>
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-tickets/<?php echo $event_id;?>">Create</a></li>
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-tickets/<?php echo $event_id;?>" class="here">List/edit</a></li>
               <li><a href="#">Promote</a></li>	
               <li><a href="#">View bookings</a></li>
               <li><a href="#">Reports</a></li>						   
             </ul>
           </div>
           </div> 
         <div class="clear"></div>
        </div>	
     </div>
    </div>
    
    <div class="myevent_box">
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000"><strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
    <div class="myevent_left" style="width:100% !important;">
    <div class="guide_box2">
     	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
          <tr>
            <td width="31%"><?php echo $obj_event->f('event_name_en')?></td>
            <td width="17%"><?php echo $ev_day."-".$ev_mon."-".$ev_year." - ".$ev_hr.":".$ev_min." ".$objlist->f('event_start_ampm');?></td>
            <td width="37%"><?php echo $obj_event->f('venue_name')?></td>
            <td width="15%"><?php if($obj_event->f('event_status')=="Y"){?><font color="#006600">Active</font><?php } else { ?><font color="#FF0000">Inactive</font> <?php } ?></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
          <tr>
            <td class="top_txt">Ticket Name</td>
            <td class="top_txt">Available Tickets</td>
            <td class="top_txt">Price in USD</td>
            <td class="top_txt">Price in MXP</td>
            <td class="top_txt">From Date</td>
            <td class="top_txt">To Date</td>
            <td class="top_txt">Manage</td>
          </tr>
        <?php
        $items = 10;
        $page = 1;
                
        if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
        {
            $limit = " LIMIT ".(($page-1)*$items).",$items";
            $i = $items*($page-1)+1;
        }
        else
        {
            $limit = " LIMIT $items";
            $i = 1;
        }
        
        $target=$obj_base_path->base_path()."/admin/list_tickets.php?event_id=".$_GET['event_id'];			
        //$target=$obj_base_path->base_path()."/admin/list-tickets/".$_GET['event_id']."&";			

        $objlist->allTicketList($event_id,$limit);
        $objlist_num->allTicketListCount($event_id);
        $num = $objlist_num->num_rows();
        $loop=1;
        
        if($num>0)
        {
            $p = new pagination;
            $p->Items($num);
            $p->limit($items);
            $p->target($target);
            $p->currentPage($page);
            $p->calculate();
            $p->changeClass("pagination");			
            while($row = $objlist->next_record())
            {
    ?>
  <tr>
    <td><?php echo stripslashes($objlist->f('ticket_name_en'));?></td>
    <td><?php echo stripslashes($objlist->f('ticket_num'));?></td>
    <td><?php echo stripslashes($objlist->f('price_us'));?></td>
    <td><?php echo stripslashes($objlist->f('price_mx'));?></td>
    <td><?php echo date("d/m/Y",$objlist->f('from_ticket'));?></td>
    <td><?php echo date("d/m/Y",$objlist->f('to_ticket'));?></td>
    <td><span style="margin:0 10px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_ticket.php?id=<?php echo $objlist->f('ticket_id');?>&event_id=<?php echo $_GET['event_id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
    <span style="margin:0 10px 0 0;"><a href="javascript:void(0);" onclick="del('<?php echo $objlist->f('ticket_id');?>','<?php echo $event_id;?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
    <span style="margin:0 30px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/preview-ticket/<?php echo $objlist->f('ticket_id');?>" style="color:#000;">Preview</a></span></td>
  </tr>
<?php } ?>
     <tr><td colspan="7" align="center"><?php $p->show();?></td></tr>
     <?php
        }
        else
        {
    ?>
    <tr>
      <td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Ticket Found</font></td></tr>
    <?php
        }
    ?>
</table>
    </div>	
    <div class="clear"></div>
	</div>
	</div>
 <div class="clear"></div>
</div>
    
    

<div class="clear"></div>
    <?php include("admin_footer.php");?>
</div>
</body>
</html>
