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
//echo "e_id=".$event_id;
$event_id_arr=explode('/',$_REQUEST['event_id']);
$event_id = $event_id_arr[1];
//echo "e=".$event_id;

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

function feature_image_save_without_redirect(e_id)
{
	var media_id=$('input[name=feature_img]:checked').val();
	var event_id=e_id;
	$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_saved_feature_image.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: "media_id="+media_id+"&event_id="+event_id, 
	   success: function(data){ 

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
           		<div class="blue_box_title">
                    <p><?= AD_FEATURE_IMAGE_AND_GALLERY ?></p>
                </div>
			      <?php include("admin_menu/creategallery_menu.php");?>
			   </div>
			   
			   
			    
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
			<div>	
                <p>
                    <?php 
                        $objEventDetails->event_details_byID($event_id);
                        $objEventDetails->next_record();			
                        //event_name   Event_Start_DateTime   Event_Venue   Event_City
                        echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time'))).", ".date("g:i",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
                    ?>
                </p>
                <span class="add_media"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/<?php echo $event_id?>" <?php if($page_set=="add-gallery") {?> class="here" <?php } ?>><?= AD_ADD_MEDIA ?></a></span> &nbsp;&nbsp;&nbsp;<span class="add_media" onclick="feature_image_save(<?php echo $event_id?>)"><a href="#"><?= AD_SAVE_EXIT ?></a></span>
            </div>
			
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
        <?php if ($num >= 1): ?>
            <div class="notify-message">
               <p><?= AD_SELECT_FEATURE_IMAGE ?></p>
               <p><?= AD_CAN_EDIT_METADATA_IMAGE ?></p>
            </div>
        <?php endif; ?>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
			<td width="15%" class="top_txt"><?= AD_THUMBNAIL ?></td>
			<td width="25%" class="top_txt"><?= AD_MEDIA_NAME ?></td>
			<td width="21%" class="top_txt"><?= AD_URL ?></td>
			<td width="15%" class="top_txt"><?= AD_FEATURE_IMAGE ?></td>
			<td width="12%" class="top_txt"><?= AD_MANAGE ?></td>
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
				$j=1;
				while($row = $objgallerylist->next_record())
				{
					
					//list($event_date,$event_time) = explode(" ",$objgallerylist->f('event_start_date_time'));
					//list($ev_year,$ev_mon,$ev_day) = explode("-",$event_date);
					//list($ev_hr,$ev_min,$ev_sec) = explode(":",$event_time);
		
		//$arr_url=explode('=',$objgallerylist->f('media_url'));
		$video_url=$objgallerylist->f('media_url');
		//echo "y-a=".$arr_url[0] ;
		//echo "y-a1=".$arr_url[1] ;
		
		?>
      <tr>
       <td>
	<?php $var=videoType($video_url);
	 //echo "<br/>var=".$var;?>
	<?php if($objgallerylist->f('media_format')!="video") {?>
	<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $objgallerylist->f('media_url'); ?>" alt="" width="150" height="90" />
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
       <td><a href="<?php echo $objgallerylist->f('event_id');?>" target=_blank><?php echo $objgallerylist->f('media_url');?></a></td>
       <td align="center"><input type="radio" class="radio-feature-img" name="feature_img"  id="feature_img<?php  echo $objgallerylist->f('m_id'); ?>" value="<?php  echo $objgallerylist->f('m_id'); ?>" <?php if($objgallerylist->f('feature_image')=='1') {echo "checked";}?>/></td>
        <td style="padding: 5px;">
		
	<span style="margin:0;"><?php if($objgallerylist->f('admin_id')==$_SESSION['ses_user_id']){?><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $event_id?>/edit-gallery/<?php echo $objgallerylist->f('m_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a><?php }?></span>
	
        <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objgallerylist->f('m_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
	
	<?php if($objgallerylist->f('media_format')!="video") {?>
	<a href="#feature_image<?php echo $j;?>" id="feature<?php echo $j;?>"><?= AD_PREVIEW ?></a>
        <?php }
	else {?>
       <a href="#feature_url<?php echo $j;?>" id="feature<?php echo $j;?>"><?= AD_PREVIEW ?></a>
          <?php }?>
	    <div style="display:none;">
		<div style="width:auto;height:auto; background:#FFF; padding:10px;" id="feature_image<?php echo $j;?>">
                <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objgallerylist->f('media_url');?>"  border="0"  />   
                                    </div>
	    </div>
	    
	     <div style="display:none;">
		
                                  	<div style="width:auto;height:auto; background:#FFF; padding:10px;" id="feature_url<?php echo $j;?>">
                                    	      <object width="560" height="315"><param name="movie" value="//www.youtube.com/v/opj24KnzrWo?version=3&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//www.youtube.com/v/<?php echo end(explode('=',$objgallerylist->f('media_url')));?>?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>
                                    </div>
                                  </div>
        </td>
       
      </tr>
      <!---------------Fancy  box  start---------------------->
	<script type="text/javascript">
		$(document).ready(function() {
            $('#feature<?php echo $j;?>').fancybox({
                openEffect  : 'none',
                closeEffect : 'none'
            });
            
            if (!$("input[name='feature_img']:checked").val()) {
                setTimeout(function(){
                    $("input[name='feature_img']:first").attr('checked', true);
                    feature_image_save_without_redirect(<?php echo $event_id; ?>);
                }, 100);
                
            }
            else {
               // One of the radio buttons is checked!
               // event already has its featured image, do nothing
            }

        })
		</script>
<!----------------Fancy box end--------------------->
 
  <?php  $j++;
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