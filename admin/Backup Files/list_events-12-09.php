<?php
include('../include/admin_inc.php');

//create object
$objlist = new admin;
$objlist_num = new admin;
$obj_delete = new admin;
$obj_change = new admin;
$obj_venuestate = new admin;
$obj_change = new admin;
$obj_change = new admin;
$obj_change = new admin;

$show_pastevent = 1;

//===============CODE FOR CHANGE STATUS===================//
if(isset($_GET['status']))	
{
	$obj_change->changeEventStatus($_GET['id'],$_GET['status']);
	$msg = "Event status changed successfully";
}


//===============CODE FOR DELETE===================//
if(isset($_GET['action']) && $_GET['action'] == "delete")	
{
	$obj_delete->deleteEvent($_GET['id']);
	$obj_delete->deleteCategoryByEvent($_GET['id']);
	$obj_delete->deleteTicketByEvent($_GET['id']);
	$msg = "Event deleted successfully";
}
?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<?php
// Serach 
$items = 20;
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

$target=$obj_base_path->base_path()."/admin/list_events.php";	
if(isset($_POST['listEvent']) && $_POST['listEvent'] == '1')	
{
	$venue_state = $_POST['venue_state'];
	$venue_county = $_POST['venue_county'];
	$venue_city = $_POST['venue_city'];
	$venue = $_POST['venue'];
	$show_pastevent = $_POST['show_pastevent'];
	if($show_pastevent=="")
		$show_pastevent = 0;
	
	$objlist->allEventList($limit,$venue_state,$venue_county,$venue_city,$venue,$show_pastevent);
	$objlist_num->allEventListCount($venue_state,$venue_county,$venue_city,$venue,$show_pastevent);
?>
<script type="text/javascript">
$(document).ready(function(){
getCounty('<?php echo $_POST['venue_state'];?>','<?php echo $_POST['venue_county'];?>');
getCity('<?php echo $_POST['venue_county'];?>','<?php echo $_POST['venue_city'];?>');
getVenue('<?php echo $_POST['venue_city'];?>','<?php echo $_POST['venue'];?>');
});
</script>
<?php	
}
else{
		
//event list
$objlist->allEventList($limit,'','','','',1);
$objlist_num->allEventListCount('','','','',1);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Event List</title>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
</style>

<script language="javascript">
function del(eID)
{
	if(confirm("Are you sure you want to delete this event?"))
	{
		location.href="list_events.php?action=delete&id="+eID;
	}
	
}
</script>
<script language="javascript" type="text/javascript">
function getCounty(stateid,venue_county)
{
     $('#div_city_display').html('<select name="venue_city" class="selectbg12"><option value="">City</option></select>');
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "state_id="+stateid+"&venue_county="+venue_county;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_county_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid,venue_city)
{
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "county_id="+countyid+"&venue_city_list="+venue_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_city_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}

function getVenue(cityid,ven)
{
     data = "city_id="+cityid+"&ven="+ven;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_venue_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_venue_display").html(data);
	   }
	 });
}
</script>

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
           		<div class="blue_box10"><p>My events</p></div>
			      <?php include("admin_menu/createevent_menu.php");?>
			   </div> 
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
         <form method="post" action="" enctype="multipart/form-data" name="listing" id="listing">
         <input type="hidden" name="listEvent" id="listEvent" value="1" /> 
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
            <tr>
                <td width="24%">
                <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value,'');">
                    <option value="">State</option>
                    <?php
                  $obj_venuestate->getVenueState();
                  while($row = $obj_venuestate->next_record())
                  {
                  ?>
                    <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($venue_state==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                    <?php echo $obj_venuestate->f('state_name');?></option>
                    <?php
                  }
                  ?>
              </select>
      			</td>
                <td width="24%"><div id="div_county_display">
                      <select name="venue_county" class="selectbg12">
                      <option value="">County</option>
                      </select>
		  		</div></td>
                <td width="23%" >
                <div id="div_city_display">
                  <select name="venue_city" class="selectbg12">
                  <option value="">City</option>
                  </select>
		  		</div></td>
                <td width="29%" >
                <div id="div_venue_display">
                  <select name="venue" id="venue" class="selectbg12">
                  <option value="">Venue</option>
                  </select>
		  		</div></td>
                <td width="24%"> <div class="input_box" style="margin: 0px 0 2px 0; float: right;">
                <input type="image" src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png"  style="border:0px;"  />
                	<!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png" border="0" onclick="showCal()" style="vertical-align: top;" />--></div></td>
            </tr>
         </table>
	 		<div class="event_header"><strong>Show past events &nbsp;<?php //echo $show_pastevent;?> 
            	<input type="checkbox" name="show_pastevent" id="show_pastevent" value="1" <?php if($show_pastevent == 1){?> checked="checked" <?php } ?> /></strong>
            </div>
         </form>
		
	 <div class="myevent_box">
	   <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
            <tr>
                <td width="18%" class="top_txt">Event</td>
                <td width="15%" class="top_txt">Date & Time</td>
                <td width="15%" class="top_txt">Venue</td>
                <td width="11%" class="top_txt">City</td>
                <td width="9%" class="top_txt">County</td>
                <td width="14%" class="top_txt center">Status</td>
                <td width="18%" class="top_txt">Manage</td>
            </tr>
	        <?php
			
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
					
					list($event_date,$event_time) = explode(" ",$objlist->f('event_start_date_time'));
					list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
					list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);
		?>
      <tr>
        <td><?php echo stripslashes($objlist->f('event_name_en'));?></td>
        <td><?php echo $ev_day."/".$ev_mon."/".$ev_year." - ".$ev_hr.":".$ev_min." ".$objlist->f('event_start_ampm');?></td>
        <td><?php echo $objlist->f('venue_name');?></td>
        <td style="padding: 5px 0;"><?php echo $objlist->f('city_name');?></td>
        <td><?php echo $objlist->f('county_name');?></td>
        
        <td style="text-align: left; padding: 5px 0;">
         <?php if($objlist->f('public_privacy')==1)  echo "Private"; else echo "Public";?> /   <?php if($objlist->f('status')=="publish")  echo "Published"; else if($objlist->f('status')=="saved") echo "saved"; else echo "draft";?>
		 <?php if($objlist->f('identical_function')==1)  echo " / Multi-function"; else if($objlist->f('recurring')==1) echo " / Recurring"; else if($objlist->f('sub_events')==1) echo " / Program";
		 ?>
       </td>
        
        <td style="padding: 5px;">
        	<span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-event/<?php echo $objlist->f('event_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
        	<span style="margin:0;font-weight:bold;">
            	<a href="<?php echo $obj_base_path->base_path(); ?>/admin/duplicate-event/<?php echo $objlist->f('event_id');?>">Duplicate</a>
            </span>
            <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objlist->f('event_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
            <span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objlist->f('event_id');?>" target="_blank" style="color:#000;">Preview</a></span>
           <!-- <span style="margin:0 10px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-tickets/<?php echo stripslashes($objlist->f('event_id'));?>">View Tickets</a></span>-->
        </td>
      </tr>
  <?php } ?>
         <tr><td colspan="7" align="center"><?php $p->show();?></td></tr>
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Event Found</font></td></tr>
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
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>