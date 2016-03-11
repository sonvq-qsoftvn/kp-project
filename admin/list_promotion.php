<?php
include('../include/admin_inc.php');

//create object

$objEventDetails = new admin;
$objsociallist = new admin;
$objsociallist_num = new admin;

$event_id=$_REQUEST['event_id'];
//echo "e_id=".$event_id;
//echo "hello";

?>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>


<?php
// Serach 
$items = 30;
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


$objsociallist->allPromotionByEventID($event_id,$limit);
$objsociallist_num->allPromotionByEventIDCount($event_id);

$num = $objsociallist_num->num_rows();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Promotion List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
	.add_media{
		width: auto;
		height: 34px;
		background: #00f;
		margin: 0;
		display: inline-block;
	
	}
	.add_media a{
		font-size: 18px;
		line-height: 34px;
		font-weight:normal;
		color: #fff;
		text-align: center;
		padding:0 12px;
		margin: 0;
		display: block;
		text-decoration: none;
		cursor: pointer;
	}
</style>
<script language="javascript">
function feature_image_save(e_id)
{
	//alert("HI!");
	var media_id=$('input[name=feature_img]:checked').val();
	var event_id=e_id;
	//alert("m_id= "+media_id);
	//alert("e_id= "+event_id);
	$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_saved_feature_image.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: "media_id="+media_id+"&event_id="+event_id, 
	   success: function(data){ 
	    // alert(data);
	     if(data!="")
	      {
		window.location = "<?php echo $obj_base_path->base_path();?>/admin/edit-event/"+e_id;
	      }
	   }
	 });
}
</script>
<script language="javascript">
function del(gID)
{
	if(confirm("Are you sure you want to delete this Gallery?"))
	{
		//alert("hohooh");
		window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete_gallery.php?id="+gID+"&event_id="+<?php echo $event_id ?>;
	}
	
}
</script>


<?php include("../include/analyticstracking.php")?>
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
           		<div class="blue_box10"><p>Event Promotion</p></div>
			      <?php include("admin_menu/createpromotion_menu.php");?>
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
			<span class="add_media"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-promotion/event/<?php echo $event_id?>" >add social network</a></span></div>
			
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
			<td width="40%" class="top_txt">Social Page Url</td>
			<td width="20%" class="top_txt">Social Type</td>
			<td width="20%" class="top_txt">Social Language</td>
			<td width="20%" class="top_txt">Manage</td>
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
				//$j=1;
			    while($row = $objsociallist->next_record())
			     {
			     ?>
		
		
		<tr>
		<!--<td>&nbsp</td>-->
		<td><a href="<?php echo $objsociallist->f('social_url');?>" target=_blank><?php echo $objsociallist->f('social_url');?></a></td>
		<td><?php echo $objsociallist->f('social_type');?></td>
		<td><?php echo $objsociallist->f('social_lang');?></td>
		<!--<td align="center"></td>-->
		<td style="padding: 5px;">
		<!----Edit And  Delete START------>
		<span style="margin:0;"><?php if($objsociallist->f('admin_id')==$_SESSION['ses_user_id']){?><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $event_id?>/edit-promotion/<?php echo $objsociallist->f('sc_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />Edit</a><?php }?></span>
	
       <!-- <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php //echo $objsociallist->f('sc_id');?>');"><img src="<?php //echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>-->
	 <!----Edit And  Delete END------>
       </td>
       </tr>
    
 
  <?php // $j++;
  } //while  end ?>
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