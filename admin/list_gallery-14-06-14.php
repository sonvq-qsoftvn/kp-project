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
$objEventDetails = new admin;
$objgallerylist = new admin;
$objgallerylist_num = new admin;
//$event_id=$_REQUEST['event_id'];
echo "e_id=".$event_id;
$event_id_arr=explode('/',$_REQUEST['event_id']);
$event_id = $event_id_arr[1];
echo "e=".$event_id;
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


$objgallerylist->allGalleryByID($event_id,$limit);
$objgallerylist_num->allGalleryByID_count($event_id);

$num = $objgallerylist_num->num_rows();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Event List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
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
	if(confirm("Are you sure you want to delete this Event?"))
	{
		location.href="list_events.php?action=delete&id="+eID;
	}
	
}
</script>
<!--<script language="javascript" type="text/javascript">
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
</script>-->

<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>
<?php
        function videoType($video_url) {
		if (strpos($video_url, 'youtube') > 0) {
		    return 'youtube';
		} elseif (strpos($video_url, 'vimeo') > 0) {
		    return 'vimeo';
		} elseif (strpos($video_url, 'dailymotion') > 0) {
		    return 'dailymotion';
		} else {
		    return 'image';
		}
	}
	?>    
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
           		<div class="blue_box10"><p>Event gallery</p></div>
			      <?php include("admin_menu/creategallery_menu.php");?>
			   </div>
			   
			   
			    
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
			<div>	
			<?php $objEventDetails->event_details_byID($event_id);
			$objEventDetails->next_record();
			//event_name   Event_Start_DateTime   Event_Venue   Event_City
			echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
			?>
			<span style="margin-left:318px;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/<?php echo $event_id?>" <?php if($page_set=="add-gallery" || basename($_SERVER['PHP_SELF'])=="edit_gallery.php") {?> class="here" <?php } ?>>Add media</a></span></div>
			
         <input type="hidden" name="listEvent" id="listEvent" value="1" /> 
        	
		 <div class="myevent_box">		 
	 	
			<?php
		 if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");		
		?>	
			<div style="width: 150px; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
			<?php
			}
		 ?>
			</div>		
          
	 <div class="clear"></div>		
	 <div class="myevent_box">
	   <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
			<td width="25%" class="top_txt">Thumbnail</td>
			<td width="30%" class="top_txt">Media Name</td>
			<td width="30%" class="top_txt">Url</td>
			<td width="5%" class="top_txt">Manage</td>
			<!--<td width="5%" class="top_txt">Delete</td>
			<td width="5%" class="top_txt">priview</td>-->
			
			</tr>
	        <?php

			if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");			
				while($row = $objgallerylist->next_record())
				{
					
					//list($event_date,$event_time) = explode(" ",$objgallerylist->f('event_start_date_time'));
					//list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
					//list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);
		
		$arr_url=explode('=',$objgallerylist->f('media_url'));
		$video_url=$objgallerylist->f('media_url');
		//echo "y-a=".$arr_url[0] ;
		//echo "y-a1=".$arr_url[1] ;
		
		?>
      <tr>
       <td>
	<?php $var=videoType($video_url);
	 //echo "<br/>var=".$var;?>
	<?php if($objgallerylist->f('media_format')!="video") {?>
	<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/<?php echo $objgallerylist->f('media_url'); ?>" alt="" />
	<?php }
	else{?>
	<?php  if($var=="youtube") { ?>
	 
      <!-- <iframe width="150" height="90" src="http://www.youtube.com/watch?v=97VqfrsgyAM"></iframe>-->
      <iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$objgallerylist->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
           <?php }
	   elseif($var=="vimeo") { ?>
	   <iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$objgallerylist->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	   <?php }
	   elseif($var=="dailymotion") {
	     $dm_vid_arr=explode('_',end(explode('/',$objgallerylist->f('media_url'))));
	     $dm_vid = $dm_vid_arr[0];
	     ?>
	   <iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
	   <?php }?>
       <?php }?>
<!--<iframe src="//vimeo.com/channels/staffpicks/end(explode('/',$objgallerylist->f('media_url')))" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
-->	   
         
       </td>
       <td><?php echo $objgallerylist->f('media_name');?></td>
       <td><a href="<?php echo $objgallerylist->f('media_url');?>" target=_blank><?php echo $objgallerylist->f('media_url');?></a></td>
        <td style="padding: 5px;">
	<span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-gallery/<?php echo $objgallerylist->f('m_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
	
        <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objgallerylist->f('m_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
        <span style="margin:0;"><a href="#<?php //echo $obj_base_path->base_path(); ?>/event/<?php //echo $objgallerylist->f('m_id');?>" target="_blank" style="color:#000;">Preview</a></span>
           
        </td>
       
      </tr>
  <?php } ?>
         <td colspan="7" align="left"><div style="width: 150px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Media Found</font></td></tr>
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