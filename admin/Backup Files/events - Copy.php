<?php
error_reporting(0);
// event list
include('../include/admin_inc.php');

$objlist=new admin;	
$objlist_num=new admin;
$obj_ticket=new admin;
$obj_venue=new admin;
//session value
$admin_id=$_SESSION['ses_user_id'];
$organization_id=$_SESSION['ses_organization_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our site</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/javascript.js"></script>
</head>
<body>
<!--start maincontainer-->
	
	<div id="maincontainer">
	
	  <?php include("header.php");?>
		<!--start body-->
		<section id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <?php include("top_menu.php");?>                  
                
				<?php include("sidebar.php");  ?>
				 			                             	
               <div id="coupon_admin" style="margin: 4px 10px;">
			  <div class="custom_box">
              	<div class="step">
					<div class="coupons">All Events</div>
				</div>
                 <div class="clear"></div>
				 <div class="custom_box2">
				 <div class="guide_box" >
				 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="organization" id="help_box">
					  <tr>
						<td><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_img.png" border="0" alt="" style="padding:20px 20px 0px 10px;" ></td>
						<td class="guide_heading">Event Guide</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td><p style="padding-left:0; padding-top: 0; margin-top: -5px;">Use Ticket Hype to help manage events of all types and sizes. Whether its general admission, reserved assign-seating, multi-day, or an event series, we've given you the ability to create and control every aspect of your ticket sales. Return to this section at any time to update your event details or the status of inventory in real-time.</p></td>
					  </tr>
					</table>
					<form name="frm" action="" method="post">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="orga_bot">
                          <tr>
                            <td width="50"><img src="<?php echo $obj_base_path->base_path(); ?>/images/setting_icon.png" border="0" alt="" style="padding:7px 0 7px 20px;"></td>
                            <td width="600"><input name="add_btn" type="button" value="+ Add Events" class="btn_add" onclick="add_button_function();"></td>
                            <!--<td width="600"><a href="<?php //echo $obj_base_path->base_path(); ?>/admin/event"><img src="<?php //echo $obj_base_path->base_path(); ?>/images/add_event.gif" alt="" width="100" height="25" border="0" style="padding:5px 0 0 5px" /></a></td>-->
                            <td align="right" style="padding:4px 0 0 0"><input type="text" name="keyword" class="keyword_text"  onfocus="javascript:if(this.value=='Keyword') {this.value='';}" onblur="javascript:if(this.value=='') {this.value='Keyword'}" value="<?php if ($_REQUEST['keyword']) echo $_REQUEST['keyword']; else { ?>Keyword<?php }?>"/></td>
                            <td align="right" style="padding:4px 0 0 0"><input type="submit" name="Submit2" class="search_btn" value=""/></td>
                            
                            
                            
                          </tr>
                        </table>
					</form>
				 </div>
				 <div class="clear"></div>
                <div class="guide_box2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id">
				  <tr>
					<td width="32" style="padding:0 0 0 20px;">ID</td>
					<td width="200">Event</td>
					<td width="166">Date & Time</td>
					<td width="50">Tickets</td>
					<td width="120">Manage</td>
					<td width="50">Status</td>
				  </tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
	 		<?php
			$items = 25;
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
			
			//if search
			if($_REQUEST['keyword']){
				$keyword=$_REQUEST['keyword'];
				$target=$obj_base_path->base_path()."/admin/events/".$keyword;
			}
			else
			$target=$obj_base_path->base_path()."/admin/events";			
			//event list
			$objlist->event_list_withSearch($organization_id,$keyword,$limit);
			$objlist_num->event_list_withSearch_num($organization_id,$keyword);
			$num = $objlist_num->num_rows();
			
			if($num>0)
			{
				
				$p = new pagination_search;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				//$p->urlFriendly("/");
				$p->calculate();
				$p->changeClass("pagination");			
				while($row = $objlist->next_record())
				{
				//total sold ticket
				$obj_ticket->event_total_sold_ticket($objlist->f('event_id'));
				$obj_ticket->next_record();
				//get venue
				$obj_venue->getVenueById($objlist->f('venue'),$objlist->f('organization_id'));
				$obj_venue->next_record();
			?>
				<tr>
		<td width="32" style="padding: 5px 0 0 20px;"><?php echo $objlist->f('event_id');?></td>
		
		<td width="200" style="padding:5px 0 0 0;"><a style="color:#666666;" href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $objlist->f('event_id');?>"><b><?php echo $objlist->f('event_name');?></b><br/><?php echo $obj_venue->f('venue_name'); ?> (<?php echo $obj_venue->f('venue_city'); ?> <?php echo $obj_venue->f('venue_state'); ?>)</a></td>
		<td width="166" style="padding:5px 0 0 0;"><?php echo date('D M j, Y \a\t g:i a',strtotime($objlist->f('event_date'))); ?></td>
		<td width="50" style="padding:5px 0 0 0;"><?php echo $obj_ticket->f('total_sold_event'); ?> / <?php echo $objlist->f('inventory_capacity');?></td>
		<td width="120" style="padding:5px 0 0 0;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/pen.png" border="0" alt="" style="padding:8px 3px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $objlist->f('event_id');?>/step/1">Edit</a>
			  <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $objlist->f('event_id');?>/ads">Ads Image</a></td>
			  
		<td width="50" style="padding:15px 0 0 0;"><?php if($objlist->f('event_launch')==1) { ?>
			  <img src="<?php echo $obj_base_path->base_path(); ?>/images/green_icon.png" title="live" alt="" width="14" height="15" />
			  <?php }else {?>
			  <img src="<?php echo $obj_base_path->base_path(); ?>/images/yellow_icon.png" title="offline" alt="" width="16" height="17" />
			  <?php }?>
		</td>
	  </tr>
	 	 	<?php }?>
  					  
               <tr><td colspan="6" align="center" ><?php $p->show();?></td></tr>
 		 	<?php
			}
			else
			{
		?>
			<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
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
            </div>
		  </section>		
		<!--end body-->			
	  <div class="clear"></div>
	</div>
<!--end maincontainer-->

<?php include("footer.php"); ?>


<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
