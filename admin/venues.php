<?php
// venues list
include('../include/admin_inc.php');

$objlist=new admin;	
$objlist_num=new admin;	
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
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/javascript.js"></script>

<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->

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
					<div class="coupons">Venues</div>
				</div>
                 <div class="clear"></div>
				 <div class="custom_box2">
				 <div class="guide_box" >
				<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" class="organization" id="help_box">
					  <tr>
						<td><img src="<?php //echo $obj_base_path->base_path(); ?>/images/icon_img.png" border="0" alt="" style="padding:20px 20px 0px 10px;" ></td>
						<td class="guide_heading">Event Guide</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td><p style="padding-left:0; padding-top: 0; margin-top: -5px;">Use Ticket Hype to help manage events of all types and sizes. Whether its general admission, reserved assign-seating, multi-day, or an event series, we've given you the ability to create and control every aspect of your ticket sales. Return to this section at any time to update your event details or the status of inventory in real-time.</p></td>
					  </tr>
					</table>-->
					<form name="frm" action="" method="post">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="orga_bot">
				  <tr>
					<td width="50"><img src="<?php echo $obj_base_path->base_path(); ?>/images/setting_icon.png" border="0" alt="" style="padding:7px 0 7px 20px;"></td>
					<td width="600"><input name="add_btn" type="button" value="+ Add Venue" class="btn_add" onclick="add_venue_function();"></td>
					
				  </tr>
				</table>
				</form>
				 </div>
				 <div class="clear"></div>
                <div class="guide_box2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id">
				  <tr>
					<td width="32" style="padding:0 0 0 20px;">ID</td>
					<td width="200">Venue</td>
					<td width="120">Manage</td>
					<td width="50">Type</td>
				  </tr>
				</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
	 <?php
			
			$objlist->list_venue($organization_id);
			$objlist_num->event_list_num($admin_id);
			$num = $objlist_num->num_rows();						
		    while($row = $objlist->next_record())
				{			
		?>
  <tr>
 
   
    <td width="32" style="padding: 5px 0 0 20px;"><?php echo $objlist->f('venue_id')?></td>
	
    <td width="200" style="padding:5px 0 0 0;"><?php echo $objlist->f('venue_name');?><br />
		  <?php echo $objlist->f('venue_address');?> <?php echo $objlist->f('venue_city');?> <?php echo $objlist->f('venue_state');?>
		  </td>
	<td width="120" style="padding:5px 0 0 0;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/pen.png" border="0" alt="" style="padding:8px 3px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/venue/<?php echo $objlist->f('venue_id');?>/edit">Edit</a>
          </td>
	<td width="50">
	<?php if($objlist->f('venue_type')=="2")
	{
	echo "General Admission";
	}elseif($objlist->f('venue_type')=="3"){
	echo "Seated";
	}elseif($objlist->f('venue_type')==""){
	echo "none";
	} ?>
	</td>
    
  </tr>
  <?php }?>		

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

function add_venue_function(){
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/venue";
}

<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
