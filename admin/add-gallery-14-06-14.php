<?php
// create page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	$objlist = new admin;
	$objmedia = new admin;
	$objevent_media = new admin;
	$obj_media_language = new admin;
	$obj_media_gallery = new admin;
	$event_id_arr=explode('/',$_REQUEST['event_id']);
	$event_id = $event_id_arr[1];
	//echo "submit=".$event_id;
	//echo "admin_id=".$_SESSION['ses_user_id'];
	if(isset($_REQUEST['submit']))
	{
		// post value
		//$social=$_POST['social'];
		$event_id=$_POST['event_id'];
		$set_privacy=$_POST['set_privacy'];
		$language=$_POST['language'];
		$media_name=$_POST['media_name'];
		$caption=addslashes($_POST['caption']);
		$alternate_text=addslashes($_POST['alternate_text']);
		$description=addslashes($_POST['description']);
		$file_name = $_POST['gallery_photo'];
		$file_extn_array =explode('.',$file_name);
		$media_format=$file_extn_array[1];
		// -- add Content --		
		$media_id=$objmedia->add_gallery($_SESSION['ses_user_id'],$file_name,$media_format,$set_privacy);
		$objevent_media->add_gallery_withEvent($media_id,$event_id);
		$obj_media_language->add_media_language($media_id,$language,$media_name,$caption,$alternate_text,$description);
		header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
		?>
		
		<?php
         }
	
	if(isset($_REQUEST['submit_url']))
	 {
		//echo "hello";
		$event_id=$_POST['event_id'];
		//echo $event_id;
		$url=$_POST['url'];
		$set_privacy=$_POST['set_privacy'];
		//echo "u".$url;
		//echo "sp=".$set_privacy;
		//echo "e-id=".$event_id;
		$media_name=$_POST['media_name'];
		$media_format='video';
		$language=$_POST['language'];
		$caption=addslashes($_POST['caption']);
		$alternate_text=addslashes($_POST['alternate_text']);
		$description=addslashes($_POST['description']);
		$media_id=$objmedia->add_gallery($_SESSION['ses_user_id'],$url,$media_format,$set_privacy);
		$objevent_media->add_gallery_withEvent($media_id,$event_id);
		$obj_media_language->add_media_language($media_id,$language,$media_name,$caption,$alternate_text,$description);
		
		header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
		
		}
		
		
		$admin = $_SESSION['ses_user_id'];
		$obj_media_gallery->allGalleryNotInEvent($event_id,$admin);
		$obj_media_gallery->next_record();
		
		if(isset($_REQUEST['check_submit']))
	         {
				$gal_media_arr=$_POST['gallery_media'];
				//print_r($gal_media_arr);
				for($i=0;$i<sizeof($gal_media_arr);$i++)
				 {
					echo "<br/>".$gal_media_arr[$i];	
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

<script language="javascript" type="text/javascript">

//$('#checkAllMedia').click(function () {
//		alert("hi!");
//     $('input:checkbox').prop('checked', this.checked);    
// });

function allMediaCheck(source) {
		alert("alj");
  checkboxes = document.getElementsByName('gallery_media[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

</script>


<script type="text/javascript">

$(function(){
		var btnUpload=$('#me1');
		var mestatus=$('#mestatus1');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadgalleryphoto.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				//On completion clear the status
				mestatus.text('Photo Uploaded Sucessfully!');
				$('#gallery_photo').val(response);
				$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/'+response+'" alt="" />');
				$('#me1').html('');
				
				//On completion clear the status
			}
		});
		
	});



</script>
<script language="javascript" type="text/javascript">
		function check_type(getval)
		    {
			//alert("hi! ");
			var type=getval;
			if (type=="select_gal")
			 {
				$(".fromgallery").show();
				$(".mediaimage").hide();
				$(".mediaurl").hide();
			   }
			else if (type=="select_image")
			  {
				$(".fromgallery").hide();
				$(".mediaurl").hide();
				$(".mediaimage").show();
				//code			
			   }
			else if (type=="select_url")
			{
				$(".fromgallery").hide();
				$(".mediaimage").hide();
				$(".mediaurl").show();
			 }
		    }
		</script>



<style>
	.mediaurl
	  {
		display: none;
           }
	.mediaimage
	  {
		display: none;
	  }
	  .fromgallery
	  {
		display: none;
	  }
</style>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<?php include("../include/analyticstracking.php")?>

</head>

<body class="body1">
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
           <div class="blue_box10"><p>Add gallery</p></div>
           	<?php include("admin_menu/creategallery_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    
    <div class="myevent_box">
		<div>
		<input type="radio" name="type" id="type_gal" value="from_gal"  onclick="check_type('select_gal')">Select from your gallery<br>
		<input type="radio" name="type" id="type_image" value="media_image"  onclick="check_type('select_image')"> upload new media<br>
		<input type="radio" name="type" id="type_url" value="media_url"  onclick="check_type('select_url')"> media url<br>
		</div>
								
		<div class="fromgallery">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
				<tr>
				<td><input type="checkbox" name="gal_media" id="checkAllMedia" onClick="allMediaCheck(this)" value="gal_media"></td>
				<td></td>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">File ::</td>
				<td width="87%">Created Date</td>
				<!--<td width="87%">Uploaded to</td>-->
				</tr>
		    <?php while($row = $obj_media_gallery->next_record())
		      {
				$arr_url=explode('=',$obj_media_gallery->f('media_url'));
				$video_url=$obj_media_gallery->f('media_url');
				$var=videoType($video_url);
				echo "var= ".$var;
		    ?>
				<tr><?php echo $obj_media_gallery->f('m_id'); ?>
				<td><input type="checkbox" name="gallery_media[]" value="gal_media"  id="gal_media"></td>
				<td><?php if($obj_media_gallery->f('media_format')!="video") {?>
            <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/<?php echo $obj_media_gallery->f('media_url'); ?>" alt="" />
				<?php }
				else{?>
				
				<?php  if($var=="youtube") { ?>
					 
				      <!-- <iframe width="150" height="90" src="http://www.youtube.com/watch?v=97VqfrsgyAM"></iframe>-->
				      <iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$obj_media_gallery->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
					   <?php }
					   elseif($var=="vimeo") {  ?>
					   <iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$obj_media_gallery->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					   <?php }
					   elseif($var=="dailymotion") {  
					     $dm_vid_arr=explode('_',end(explode('/',$obj_media_gallery->f('media_url'))));
					     $dm_vid = $dm_vid_arr[0];
					     ?>
					   <iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
					   <?php }?>
				<?php
					}?></td>
				<td><?php echo $obj_media_gallery->f('caption'); ?><br/>
				<?php echo $obj_media_gallery->f('media_format'); ?></td>
				<td><?php echo $obj_media_gallery->f('upload_date'); ?></td>
				</tr>
				
		    <?php		
		      }
                    ?>
				<tr>
				<td>&nbsp;</td>				
				<td><input type="submit" name="check_submit" value="Save" class="createbtn" style="height: 28px;"></td>
				</tr>
		</form>
		</table>
		</div><!-----------that is  for  form gallery--------------------->
		
		<div class="mediaimage"><!-----------that is  for image file upload--------------------->
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
				
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
				<input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language ::</td>
				<td width="87%">
				<select name="language">
				<option value="en_US">English</option>
				<option value="es_MX">Espanol</option>
				</select>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
				<td width="87%">
				<input type="text" name="media_name" id="media_name"/>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
				<td width="87%">
				<input type="text" name="caption" id="caption"/>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
				<td width="87%">
				<textarea name="alternate_text" id="alternate_text" rows="10" cols="50"></textarea>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
				<td width="87%">
				<textarea name="description" id="description" rows="10" cols="50"></textarea>
				</td>
				</tr>
				<tr class="media_image" >
				<td style="font: normal 12px/18px Arial, Helvetica, sans-serif;">Image ::</td>
				<td valign="top">
				<div class="event_ticket">
				<h1>Set gallery image <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>
				<ul style="margin-left: 10px;">
				<li><a href="#" class="here"> 
					    
				<?php if(!$_POST['gallery_photo']){ ?>
				<div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Upload Files</span></span></div><span id="mestatus1"></span>
				<?php } else { ?>
				<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['gallery_photo']; ?>" alt="" />
				<?php }  ?>
				<div class="clear"></div>
				<span id="imgshow"></span>
				<input type="hidden" name="gallery_photo" id="gallery_photo" value="<?php if($_POST['gallery_photo']){ echo $_POST['gallery_photo']; }?>" /></a></li>
				<li>|</li>
				<li><a href="#">Media Library</a></li>
				</ul>
				</div>
		
				</td>
				</tr>
    
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Set privacy ::</td>
				<td width="87%">
				<input type="radio" name="set_privacy" id="set_privacy" value="0" checked="checked"> public<br>
				<input type="radio" name="set_privacy" id="set_privacy" value="1" > private<br>
				</td>
				</tr>
			
							    
				<tr>
				<td>&nbsp;</td>				
				<td><input type="submit" name="submit" value="Save" class="createbtn" style="height: 28px;"></td>
				</tr>
				</form>
				</table>
			       </div><!-----------end of mediaimage-------------------->
		
		<div class="mediaurl"><!-----------that is  for media url--------------------->
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frmurl" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
				<tr class="media_url" >
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Url ::</td>
				<td width="87%">
				<textarea name="url" id="url" rows="5" cols="40"></textarea>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language ::</td>
				<td width="87%">
				<select name="language">
				<option value="en_US">English</option>
				<option value="es_MX">Espanol</option>
				</select>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
				<td width="87%">
				<input type="text" name="media_name" id="media_name"/>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
				<td width="87%">
				<input type="text" name="caption" id="caption"/>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
				<td width="87%">
				<textarea name="alternate_text" id="alternate_text" rows="10" cols="50"></textarea>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
				<td width="87%">
				<textarea name="description" id="description" rows="10" cols="50"></textarea>
				</td>
				</tr>
				<tr>
				<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Set privacy ::</td>
				<td width="87%">
				<input type="radio" name="set_privacy" id="set_privacy" value="0" checked="checked"> public<br>
				<input type="radio" name="set_privacy" id="set_privacy" value="1" > private<br>
				</td>
				</tr>
			
							    
				<tr>
				<td>&nbsp;</td>				
				<td><input type="submit" name="submit_url" value="Save" class="createbtn" style="height: 28px;"></td>
				</tr>
		</form>
		</table>
				
		</div>





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
