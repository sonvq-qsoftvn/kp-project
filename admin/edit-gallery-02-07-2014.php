<?php
// create page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	
	$objmedia_es = new admin;
        $objmedia_en = new admin;
	$obj_media_update_es = new admin;
	$obj_media_update_en = new admin;
        //echo "RM= ".$_REQUEST['media_id'];
	//$media_id_arr=explode('/',$_REQUEST['media_id']);
	$media_id = $_REQUEST['media_id'];
        $event_id = $_REQUEST['event_id'];
        //echo $event_id;
	//echo "submit=".$media_id;
	//echo "admin_id=".$_SESSION['ses_user_id'];
        
        // -- Get All Details about this media --
        $objmedia_es->allGalleryByMediaID_ES($media_id);
        $objmedia_es->next_record();
        $objmedia_en->allGalleryByMediaID_EN($media_id);
        $objmedia_en->next_record();
                
	if(isset($_REQUEST['submit_update']))
	{
		// post value
		//$social=$_POST['social'];
		//$event_id=$_POST['event_id'];
                //echo "updated";
                $event_id = $_POST['event_id'];
               	$set_privacy=$_POST['set_privacy'];
                $media_name_es = addslashes($_POST['media_name_es']);
                $caption_es = addslashes($_POST['caption_es']);
                $alternate_text_es = addslashes($_POST['alternate_text_es']);
                $description_es  = addslashes($_POST['description_es']);
                $media_name_en = addslashes($_POST['media_name_en']);
                $caption_en = addslashes($_POST['caption_en']);
                $alternate_text_en = addslashes($_POST['alternate_text_en']);
                $description_en = addslashes($_POST['description_en']);
                $language_id_es = $_POST['language_id_es'];
                //echo $language_id_es;
                $language_id_en = $_POST['language_id_en'];
               // echo $language_id_en;
               // media_name_es caption_es alternate_text_es description_es media_name_en caption_en alternate_text_en description_en
		
		
            /*update the Spanish  description*/
            $obj_media_update_es->update_media_details($media_id,$language_id_es,$set_privacy,$media_name_es,$caption_es,$alternate_text_es,$description_es);
            /*update the English  description*/
            $obj_media_update_en->update_media_details($media_id,$language_id_en,$set_privacy,$media_name_en,$caption_en,$alternate_text_en,$description_en);
		//header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
                header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
               // die; 
               $updated_msg="Media successfully saved."
		?>
		
		<?php
         }
	
	
?>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Create gallery</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<!-- Ajax File Upload -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
<!-- Ajax File Upload -->


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<?php include("../include/analyticstracking.php")?>

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
           <div class="blue_box10"><p>Edit gallery</p></div>
           	<?php include("admin_menu/editgallery_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    
    <div class="myevent_box">
	<!----------------------------------------->
        
                <div class="mediaimage">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
		<input type="hidden" name="media_id" value="<?php echo $objmedia_en->f('m_id')?>" id="media_id"/>
                <input type="hidden" name="language_id_es" value="<?php echo $objmedia_es->f('language_id')?>" id="language_id_es"/>
		<input type="hidden" name="language_id_en" value="<?php echo $objmedia_en->f('language_id')?>" id="language_id_en"/>
		<tr>
		<td><div id="url_image_show"></div></td>
		</tr>
                <tr><td><div align="center"><?php echo $updated_msg;?></div></td></tr>
                <!---------image And url------------>
                <tr>
		<td>
                 <?php   //echo "url".$objmedia_es->f('media_url');
                    $video_url=$objmedia_es->f('media_url');
                   $var=videoType($video_url);
                   // echo "<br/>var=".$var;?>
                   <?php if($objmedia_es->f('media_format')!="video") {?>
                   <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/<?php echo $objmedia_es->f('media_url'); ?>" alt="" width="150" height="90" />
                   <?php }
                   else{?>
                   <?php  if($var=="youtube") { ?>
                    
                 <!-- <iframe width="150" height="90" src="http://www.youtube.com/watch?v=97VqfrsgyAM"></iframe>-->
                 <iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$objmedia_es->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
                      <?php }
                      elseif($var=="vimeo") { ?>
                      <iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$objmedia_es->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                      <?php }
                      elseif($var=="dailymotion") {
                        $dm_vid_arr=explode('_',end(explode('/',$objmedia_es->f('media_url'))));
                        $dm_vid = $dm_vid_arr[0];
                        ?>
                      <iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
                      <?php }?>
                  <?php }?>  
                </td>
		</tr>
                <!---------image And url------------>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Set privacy ::</td>
		<td width="87%">
		<input type="radio" name="set_privacy" id="set_privacy" value="0" <?php if($objmedia_es->f('set_privacy')=='0') echo "checked";?>> public<br>
		<input type="radio" name="set_privacy" id="set_privacy" value="1"  <?php if($objmedia_es->f('set_privacy')=='1') echo "checked";?>> private<br>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language :: Espanol</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
		<td width="87%">
		<input type="text" name="media_name_es" id="media_name_es" value="<?php echo $objmedia_es->f('media_name')?>" size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
		<td width="87%">
		<input type="text" name="caption_es" id="caption_es"  value="<?php echo $objmedia_es->f('caption')?>"  size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
		<td width="87%">
		<textarea name="alternate_text_es" id="alternate_text_es" rows="2" cols="50"><?php echo $objmedia_es->f('alternative_text')?></textarea>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
		<td width="87%">
		<textarea name="description_es" id="description_es" rows="10" cols="50"><?php echo $objmedia_es->f('description')?></textarea>
		</td>
		</tr>
    <!-------------------For English  Language----------------------------->
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language :: English</td>
		</tr>
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
		<td width="87%">
		<input type="text" name="media_name_en" id="media_name_en" value="<?php echo $objmedia_en->f('media_name')?>"  size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
		<td width="87%">
		<input type="text" name="caption_en" id="caption_en"  value="<?php echo $objmedia_en->f('caption')?>"  size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
		<td width="87%">
		<textarea name="alternate_text_en" id="alternate_text_en" rows="2" cols="50"><?php echo $objmedia_en->f('alternative_text')?></textarea>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
		<td width="87%">
		<textarea name="description_en" id="description_en" rows="10" cols="50"><?php echo $objmedia_en->f('description')?></textarea>
		</td>
		</tr>
                <tr>
                 <td><a href="<?php echo $obj_base_path->base_path()."/admin/gallery-list/event/".$event_id ?>"><input type="button" name="" value="Cancel" class="createbtn" ></a></td>				
		<td><input type="submit" name="submit_update" value="Save & exit" class="createbtn" ></td>
		</tr>
		</form>
		</table>
	       </div>
	<!----------------------------------------->
    <div class="clear"></div>
    </div>
    
    
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

<script type="text/javascript">
<!--
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
