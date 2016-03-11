<?php
// home page
session_start();
include('../include/admin_inc.php');

//create object
$objlist=new admin;
$objlist_ticket=new admin;

$objlist_ticket->ticket_info($_GET['ticket_id']);
$objlist_ticket->next_record();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Preview Ticket</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels1.css" rel="stylesheet" type="text/css"/>


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js" ></script>


<script type="text/javascript">
$(document).ready(function(){
$('#image_popup').fancybox();
})
</script>

 </head>

<body class="body1">
<?php include("admin_header.php"); ?>
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
			   <div class="blue_boxh"><p>Preview Ticket</p></div>
			   <div class="blue_boxr">
			   	<ul>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events">Create</a></li>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list">List/edit</a></li>
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
<!---------------------put your div--here-------------------------------------------------- --> 
            
		<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;"><strong><?php echo $msg;?></strong></div>
			
    <!-- Pop Up-->    
    <div style="display:block;">
    <div class="event_popup1" id="show_popup">	
	<!--<div class="event_popup5"><h1>Create a new ticket</h1></div>-->
	
      <div class="clear"></div>
        <form method="post" name="ticket_form" id="ticket_form" enctype="multipart/form-data">
          <input type="hidden" name="photoname" id="photoname" value="" />
          <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
          <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><input type="text" name="ticket_name_en" id="ticket_name_en" value="<?php echo $objlist_ticket->f('ticket_name_en');?>" style="width: 360px;" class="inputbg ticket_common_class" readonly="true" /></td>
           </tr>
           <tr>
             <td><input type="text" name="ticket_name_sp" id="ticket_name_sp" value="<?php echo $objlist_ticket->f('ticket_name_sp');?>" style="width: 360px;" class="inputbg ticket_common_class" readonly="true" /></td>
           </tr>
           <tr>
             <td><textarea name="description_en" id="description_en" class="textareabg ticket_common_class" disabled="disabled"><?php echo $objlist_ticket->f('description_en');?></textarea></td>
           </tr>
           <tr>
             <td><textarea name="description_sp" id="description_sp" class="textareabg ticket_common_class" disabled="disabled"><?php echo $objlist_ticket->f('description_sp');?></textarea></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <th>Price MX pesos</th>
                 <td><input type="text" name="price_mx" id="price_mx" class="inputbg ticket_common_class" readonly="true" value="<?php echo $objlist_ticket->f('price_mx');?>" /></td>
               </tr>
               <tr>
                 <th>Price US dollars</th>
                 <td><input type="text" name="price_us" id="price_us" class="inputbg ticket_common_class" readonly="true" value="<?php echo $objlist_ticket->f('price_us');?>" /></td>
               </tr>
               <tr>
                 <th>Number of Available tickets</th>
                 <td><input type="text" name="ticket_num" id="ticket_num" class="inputbg ticket_common_class" readonly="true" value="<?php echo $objlist_ticket->f('ticket_num');?>"/></td>
               </tr>
               <tr>
                 <th colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <th width="11%">From </th>
                     <td width="42%"><input type="text" name="from_ticket" id="from_ticket" readonly="true" class="inputbg1 ticket_common_class" value="<?php echo date("m/d/Y",$objlist_ticket->f('from_ticket'));?>" /></td>
                     <th width="6%">To</th>
                     <td width="41%"><input type="text" name="to_ticket" id="to_ticket" readonly="true" class="inputbg1 ticket_common_class" value="<?php echo date("m/d/Y",$objlist_ticket->f('to_ticket'));?>" /></td>
                   </tr>
                 </table></th>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="36%"><strong>Early bird discount</strong></td>
                 <td width="22%"><input type="text" name="eairly_dis_percen" id="eairly_dis_percen" readonly="true" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticket->f('eairly_dis_percen');?>" /></td>
                 <td width="17%"><strong>% up to</strong></td>
                 <td width="13%"><input type="text" name="eairly_days" id="eairly_days" readonly="true" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticket->f('eairly_days');?>" /></td>
                 <td width="12%"><p><strong>Days</strong></td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="2"> <strong>before the event</strong></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="36%"><strong>Group Discount</strong></td>
                 <td width="22%"><input type="text" name="group_dis_per" id="group_dis_per" readonly="true" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticket->f('group_dis_per');?>" /></td>
                 <td width="17%"><strong> % over</strong></td>
                 <td width="13%"><input type="text" name="group_dis_days" id="group_dis_days" readonly="true" class="inputbg2 ticket_common_class" value="<?php echo $objlist_ticket->f('group_dis_days');?>" /></td>
                 <td width="12%"><p><strong>Tickets</strong></p></td>
               </tr>
               <tr>
                 <td colspan="5"><strong> Members only</strong><input type="radio" name="members_only" id="members_only1" value="Y" disabled="disabled" <?php if($objlist_ticket->f('members_only') == 'Y') { echo 'checked'; }?> /> Yes&nbsp;&nbsp;<input type="radio" name="members_only" id="members_only2" disabled="disabled" value="N" <?php if($objlist_ticket->f('members_only') == 'N') { echo 'checked'; }?> /> No</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><strong>Ticket Icon</strong></td>
                 <td>
                    <!--<input type="file" name="ticket_icon" id="ticket_icon" />-->
					<?php if($objlist_ticket->f('ticket_icon') != '') { ?>
                        <a href="#showimg" id="image_popup"><img src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/thumb/<?php echo $objlist_ticket->f('ticket_icon')?>" /></a>
				       <div style="display:none;">
							<div id="showimg" style="width:auto; height:auto;">
								<?php if($objlist_ticket->f('ticket_icon')!='') { ?><img src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/large/<?php echo $objlist_ticket->f('ticket_icon')?>" border="0" /><?php } ?>
							</div>						
			            <?php } else { ?>
						<p><font color="#FF0000">No ticket icon found</font></p>
						<?php } ?>
                 </td>
               </tr>
             </table></td>
           </tr>
           <!--<tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><input type="button" name="Submit2" value="Save & Create a new ticket" class="createbtn"  onclick="save_new_popup()"/></td>
                 <td><input type="button" name="Submit2" value="Save & Exit" class="createbtn" onclick="closePopUp()"/></td>
               </tr>
             </table></td>
           </tr>-->       
         </table>
        </form>
	  </div>
    </div>
<div class="clear"></div>
			
<!------------------------------------------------------------------------- -->      	
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
 </div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</script>
<script type="text/javascript">
<!--
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
//-->
</script>
</body>
</html>
