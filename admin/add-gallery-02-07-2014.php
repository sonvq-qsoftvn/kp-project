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
	$objEventDetails = new admin;
	
	$event_id_arr=explode('/',$_REQUEST['event_id']);
	$event_id = $event_id_arr[1];
	//echo "submit=".$event_id;
	//echo "admin_id=".$_SESSION['ses_user_id'];
	if(isset($_REQUEST['submit'])) /*save for media image*/
	{
		
		$event_id=$_POST['event_id'];
		$set_privacy=$_POST['set_privacy'];
		$language=$_POST['language'];
		$media_name=addslashes($_POST['media_name']);
		$caption=addslashes($_POST['caption']);
		$alternate_text=addslashes($_POST['alternate_text']);
		$description=addslashes($_POST['description']);
		$media_id=$_POST['media_id'];
		//$file_name = $_POST['gallery_photo'];
		//$file_extn_array =explode('.',$file_name);
		//$media_format=$file_extn_array[1];
		// -- add Content --		
		//$objmedia->update_media_gallery($set_privacy,$media_id);
		$obj_media_language->add_media_language($media_id,$language,$media_name,$caption,$alternate_text,$description);
		header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
		?>
		
		<?php
         }
	
	if(isset($_REQUEST['submit_url']))  /*save for media url*/
	 {
		//echo "hello";
		$event_id=$_POST['event_id'];
		//echo $event_id;
		$url=$_POST['url'];
		$set_privacy=$_POST['set_privacy'];
		//echo "u".$url;
		//echo "sp=".$set_privacy;
		//echo "e-id=".$event_id;
		$media_id=$_POST['vid_media_id'];
		$media_name=addslashes($_POST['media_name']);
		//$media_format='video';
		$language=$_POST['language'];
		$caption=addslashes($_POST['caption']);
		$alternate_text=addslashes($_POST['alternate_text']);
		$description=addslashes($_POST['description']);
		
		//$objmedia->update_media_gallery($set_privacy,$media_id);
		$obj_media_language->add_media_language($media_id,$language,$media_name,$caption,$alternate_text,$description);
		header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
				
		}
		
		
		$admin = $_SESSION['ses_user_id'];
		$obj_media_gallery->allGalleryNotInEvent($event_id,$admin);
		//$obj_media_gallery->next_record();
		
		if(isset($_REQUEST['check_submit'])) /*save for other multiple  media */
	         {
				$event_id=$_POST['event_id'];
				$gal_media_id_arr=$_POST['gallery_media'];
				$gal_media_arr=$_POST['gallery_media'];
				$media_name_arr=$_POST['media_name'];
				$media_url_arr=$_POST['media_url_all'];
				$media_caption_arr=$_POST['caption'];
				$media_format_arr=$_POST['media_format'];
				$set_privacy_arr=$_POST['set_privacy_all'];
				$language_arr=$_POST['language_all'];
				$alternet_text_arr=$_POST['alternet_text_all'];
				$description_arr=$_POST['description_all'];
				//print_r($set_privacy_arr);
				for($i=0;$i<sizeof($gal_media_arr);$i++)
				 {
					
					//echo "<br/><==start>".$gal_media_arr[$i]."<br/>".$media_url_arr[$i]."<br/>".$media_caption_arr[$i]."<br/>".$media_format_arr[$i]."<br/>".$set_privacy_arr[$i]."<br/>".$language_arr[$i]."<br/>".$alternet_text_arr[$i]."<br/>".$description_arr[$i]."<br/>".$gal_media_id_arr[$i]."<br/>".$media_name_arr[$i]."<==end>";
				
				// -- add Content --	
				$objevent_media->add_gallery_withEvent($gal_media_id_arr[$i],$event_id);
				header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);	
					
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
function allMediaCheck(source) {
		//alert("alj");
  checkboxes = document.getElementsByName('gallery_media[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

</script>

<script language="javascript" type="text/javascript">
function show_upload_media(resval)
{
var getvalue=resval;
if(getvalue=='select_image')
{
$("#url").val("");
$(".fromgallery").hide();		
$("#for_upload_url").hide();
$("#for_upload_image").show();
$("#radio_all").hide();
}
else
{
$('#gallery_photo').val("");		
$(".fromgallery").hide();
$("#for_upload_image").hide();
$("#for_upload_url").show();
$("#radio_all").hide();
}
}
</script>
<script language="javascript" type="text/javascript">
function ajaxSaveUploadMedia(event_id)
{
		var gal_photo=$('#gallery_photo').val();
		//alert("hi= "+$('#gallery_photo').val());
		var ext_image_arr=gal_photo.split(".");
		var ext_image=ext_image_arr[1];
		//alert("ext_image="+ext_image);
		var url_media=$("#url").val();
		//alert(url_media);
		
		if (gal_photo!="" || url_media!="") {
				//code		
		
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_image_submit.php",
		   cache: false,
		   type: "POST",
		   data: 'image_gallery='+gal_photo+'&image_ext='+ext_image+'&url_media='+url_media+'&event_id='+event_id,   
		   success: function(data){
			   //alert(data);
			   var res = data.split("||");
			   //alert("media_id= "+res[0]+"url= "+res[1]+"vid_type= "+res[2]);
			   if(res[0]!=""){
				//$('#alrdy_svd_evnt1').trigger('click');
				//alert("success");
				
				$("#for_upload_image").hide();		
				$("#for_upload_url").hide();
				$("#media_id").val(res[0]);
				$("#vid_media_id").val(res[0]);
				
				$("#cancel_image_media").click(function(){
						//alert("hi");
						cancel_media(res[0]);
						});
				$("#cancel_url_media").click(function(){
						//alert("hi");
						cancel_media(res[0]);
						});
				//$("#url_image_show").val(res[1]);
				//alert("again_res check"+res[2]);
				 if (res[2].trim()=="image")
				   {
				   //alert("image has");
				   $(".mediaurl").hide();
				   $(".mediaimage").show();
				   $("#url_image_show").html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/'+res[1]+'"/>');
				   		
				   }
				 else
				  {
				  //alert("image not");
				  $(".mediaimage").hide();
				  $(".mediaurl").show();
				  $("#url_video_show").html(res[1]);
				  }
				
				
				$("#radio_all").hide();
			   }
			   else
			   {
		  	 	alert("Somthing is not right here.");
			   }
		   }
		 });
		}
		else
		{
		  alert("please upload image");		
		}
		
}
</script>

<script type="text/javascript">
function next_lang()
{
//alert(document.getElementById("media_id").value);
var media_id=$("#media_id").val();
//alert("m_id= "+media_id);
var event_id=$("#eid_nl").val();
//alert("e_id= "+event_id);
var set_privacy=$("#set_privacy:checked").val();
var language=$("#language").val();
var media_name=$("#media_name").val();
var caption=$("#caption").val();
var alternate_text=$("#alternate_text").val();
var description=$("#description").val();
//alert("des= "+description);
$.ajax({ 
url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_for_next_language.php",
cache: false,
type: "POST",
data: 'set_privacy='+set_privacy+'&language='+language+'&media_name='+media_name+'&caption='+caption+'&alternate_text='+alternate_text+'&description='+description+'&media_id='+media_id+'&event_id='+event_id,   
success: function(data){
//alert(data);
var res = data.split("||");
//alert("r0="+res[0]);
//alert("r1="+res[1]);
//alert("r2="+res[2]);
var lang=res[1].trim();
//alert("l= "+lang);
if (data!="") // "1"."||".$set_privacy."||".$language;
{
//alert("enter");
//change the field value after next language  clicking
$("#set_privacy:checked").val(res[0]);
$("#language").val(lang);
//alert($("#language").val());
$("#media_name").val("");
$("#caption").val("");
$("#alternate_text").val("");
$("#description").val("");
$("#nxt_but").hide();
$("#saveNdExit").show();
}
else
{
alert("not enter");
}
}
});
}
</script>

<!----Next language media url------>
<script type="text/javascript">
function next_lang()
{
//alert(document.getElementById("media_id").value);
var media_id=$("#media_id").val();
//alert("m_id= "+media_id);
var event_id=$("#eid_nl").val();
//alert("e_id= "+event_id);
var set_privacy=$("#set_privacy:checked").val();
var language=$("#language").val();
var media_name=$("#media_name").val();
var caption=$("#caption").val();
var alternate_text=$("#alternate_text").val();
var description=$("#description").val();
//alert("des= "+description);
$.ajax({ 
url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_for_next_language.php",
cache: false,
type: "POST",
data: 'set_privacy='+set_privacy+'&language='+language+'&media_name='+media_name+'&caption='+caption+'&alternate_text='+alternate_text+'&description='+description+'&media_id='+media_id+'&event_id='+event_id,   
success: function(data){
//alert(data);
var res = data.split("||");
//alert("r0="+res[0]);
//alert("r1="+res[1]);
//alert("r2="+res[2]);
var lang=res[1].trim();
//alert("l= "+lang);
if (data!="") // "1"."||".$set_privacy."||".$language;
{
//alert("enter");
//change the field value after next language  clicking
$("#set_privacy:checked").val(res[0]);
$("#language").val(lang);
//alert($("#language").val());
$("#media_name").val("");
$("#caption").val("");
$("#alternate_text").val("");
$("#description").val("");
$("#nxt_but").hide();
$("#saveNdExit").show();
}
else
{
alert("not enter");
}
}
});
}
</script>
<!----Next language media image End------>


<!----Next language media url------>


<script type="text/javascript">
function next_lang_url()
{
//alert(document.getElementById("media_id").value);
var media_id=$("#vid_media_id").val();
//alert("m_id= "+media_id);
var event_id=$("#eid_nl").val();
//alert("e_id= "+event_id);
var set_privacy=$("#set_privacy_url:checked").val();
var language=$("#language_url").val();
var media_name=$("#media_name_url").val();
var caption=$("#caption_url").val();
var alternate_text=$("#alternate_text_url").val();
var description=$("#description_url").val();
//alert("des= "+description);
$.ajax({ 
url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_for_next_language.php",
cache: false,
type: "POST",
data: 'set_privacy='+set_privacy+'&language='+language+'&media_name='+media_name+'&caption='+caption+'&alternate_text='+alternate_text+'&description='+description+'&media_id='+media_id+'&event_id='+event_id,   
success: function(data){
//alert(data);
var res = data.split("||");
//alert("r0="+res[0]);
//alert("r1="+res[1]);
//alert("r2="+res[2]);
var lang=res[1].trim();
//alert("l= "+lang);
if (data!="") // "1"."||".$set_privacy."||".$language;
{
//alert("enter");
//change the field value after next language  clicking
$("#set_privacy_url:checked").val(res[0]);
$("#language_url").val(lang);
//alert($("#language_url").val());
$("#media_name_url").val("");
$("#caption_url").val("");
$("#alternate_text_url").val("");
$("#description_url").val("");
$("#nxt_but_url").hide();
$("#saveNdExit_url").show();
}
else
{
alert("not enter");
}
}
});
}
</script>

<!----Next language media url End------>
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
mestatus.html('Your file is being uploaded - please wait');
},
onComplete: function(file, response){
//On completion clear the status
mestatus.text('Photo Uploaded Sucessfully!');
$('#gallery_photo').val(response);
$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/'+response+'" alt="" />');
$('#me1').html('');
$('#up_image_next').trigger('click');
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
$("#for_upload_url").hide();
$("#for_upload_image").hide();
}

}
</script>

         <!---cancel media Ajax------->
		<script type="text/javascript">
		function cancel_media(media_id)
		{
			//alert("again");	
		$.ajax({ 
		url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_cancel_media.php",
		cache: false,
		type: "POST",
		data: 'media_id='+media_id,   
		success: function(data){
		//alert(data);
		window.location = '<?php echo $obj_base_path->base_path()?>/admin/gallery-list/event/<?php echo $event_id ?>'
		}
		});		
		}
		</script>
       <!---cancel media Ajax end------->

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
#saveNdExit
{
display: none;
}
#saveNdExit_url
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
           <div class="blue_box10"><p>Add Media</p></div>
           	<?php include("admin_menu/creategallery_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        <!------------------Event Details------------------------->
	<div>
		<?php $objEventDetails->event_details_byID($event_id);
		$objEventDetails->next_record();
		//event_name   Event_Start_DateTime   Event_Venue   Event_City
		echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
		?>
	</div>
	<!------------------Event Details End------------------------->
    
    <div class="myevent_box">
		<div id="radio_all">
		<input type="radio" name="type" id="type_gal" value="from_gal"  onclick="check_type('select_gal')">Select from your gallery<br>
		<!--<input type="radio" name="type" id="type_image" value="media_image"  onclick="check_type('select_image')"> upload new media<br>
		<input type="radio" name="type" id="type_url" value="media_url"  onclick="check_type('select_url')"> media url<br>-->
		<input type="radio" name="type" id="type_image" value="media_image"  onclick="show_upload_media('select_image')"> upload new media<br>
		<input type="radio" name="type" id="type_url" value="media_url"  onclick="show_upload_media('select_url')"> media url<br>
		</div>
								
		<div class="fromgallery">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
		<?php //$num = $obj_media_gallery->num_rows();
		//if($num >1) {
				//?>
		
				<tr>
				<td><input type="checkbox" name="gal_media" id="checkAllMedia" onClick="allMediaCheck(this)" value="gal_media"></td>
				<td></td>
				<td width="80%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><strong>File </strong></td>
				<td width="20%"><strong>Creation Date</strong></td>
				<!--<td width="87%">Uploaded to</td>-->
				</tr>
			<?php// } else { echo "<div style='color:red;'>No Media Found.</div>" ;}?> <!---if  record is there -->	
			
			
		    <?php while($row = $obj_media_gallery->next_record())
		      {
				$arr_url=explode('=',$obj_media_gallery->f('media_url'));
				$video_url=$obj_media_gallery->f('media_url');
				$var=videoType($video_url);
				//echo "var= ".$var;
		    ?>
				<tr>
				
				<td><input type="checkbox" name="gallery_media[]" value="<?php echo $obj_media_gallery->f('m_id'); ?>"  id="gal_media"></td>
				<td><?php if($obj_media_gallery->f('media_format')!="video") {?>
            <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url'); ?>"/><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/thumb/<?php echo $obj_media_gallery->f('media_url'); ?>" alt="" />
				<?php }
				else{?>
				
				<?php  if($var=="youtube") { ?>
					 
				      <!-- <iframe width="150" height="90" src="http://www.youtube.com/watch?v=97VqfrsgyAM"></iframe>-->
				      <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>" /><iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$obj_media_gallery->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
					   <?php }
					   elseif($var=="vimeo") {  ?>
					   <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>"/><iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$obj_media_gallery->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					   <?php }
					   elseif($var=="dailymotion") {  
					     $dm_vid_arr=explode('_',end(explode('/',$obj_media_gallery->f('media_url'))));
					     $dm_vid = $dm_vid_arr[0];
					     ?>
					   <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>"/><iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
					   <?php }?>
				<?php
					}?></td>
				<td><input type="hidden" name="media_name[]" value="<?php echo $obj_media_gallery->f('media_name'); ?>"/><?php echo  $obj_media_gallery->f('media_name'); ?>&nbsp
				<input type="hidden" name="media_format[]" value="<?php echo $obj_media_gallery->f('media_format'); ?>"/><?php echo $obj_media_gallery->f('media_format'); ?></td>
				<td><?php echo $obj_media_gallery->f('upload_date'); ?></td>
		<input type="hidden" name="caption[]" value="<?php echo $obj_media_gallery->f('caption'); ?>"/>
                <input type="hidden" name="set_privacy_all[]" value="<?php echo $obj_media_gallery->f('set_privacy'); ?>"/>
                <input type="hidden" name="language_all[]" value="<?php echo $obj_media_gallery->f('language_id'); ?>"/>
                <input type="hidden" name="alternet_text_all[]" value="<?php echo $obj_media_gallery->f('alternative_text'); ?>"/>
                <input type="hidden" name="description_all[]" value="<?php echo $obj_media_gallery->f('description'); ?>"/>
              
				</tr>
				<tr>
				   <td>&nbsp;</td>
		                </tr>
				
		    <?php		
		      }
                   // if($num >1) {?>
				<tr>
				<td>&nbsp;</td>				
				<td><input type="submit" name="check_submit" value="Save & exit" class="createbtn" style="height: 28px;"></td>
				</tr>
				<?php// }?>
		</form>
		</table>
		</div><!-----------that is  for  form gallery--------------------->
		
		
		<!-----------that is  for image file upload--------------------->
		<div id="for_upload_image" style="display: none">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
		
		<tr>
		<!--<td style="font: normal 12px/18px Arial, Helvetica, sans-serif;">Image ::</td>-->
		<td valign="top">
		<div class="event_ticket">
		<!--<h1>Set gallery image <img src="<?php //echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>-->
		<p>Upload Files</p>
		<ul style="margin-left: 10px;">
		<li><a href="#" class="here"> 
			    
		<?php if(!$_POST['gallery_photo']){ ?>
		
		<div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Select file from your computer</span></span></div><span id="mestatus1"></span>
		<?php } else { ?>
		<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['gallery_photo']; ?>" alt="" />
		<?php }  ?>
		<div class="clear"></div>
		<span id="imgshow"></span>
		<input type="hidden" name="gallery_photo" id="gallery_photo" value="<?php if($_POST['gallery_photo']){ echo $_POST['gallery_photo']; }?>" /></a></li>
		<!--<li>|</li>
		<li><a href="#">Media Library</a></li>-->
		</ul>
		</div>

		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>				
		<td><input type="button" name="submit" value="Next >>" class="createbtn" onclick="ajaxSaveUploadMedia(<?php echo $event_id;?>)" style="height: 28px; display: none;" id="up_image_next"></td>
		</tr>
		</form>
		</table>		
		</div><!------first  time  show hide media  image--->
		
		<div class="mediaimage">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
		<input type="hidden" name="media_id" value="" id="media_id"/>
		<tr>
		<td><div id="url_image_show"></div></td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Set privacy ::</td>
		<td width="87%">
		<input type="radio" name="set_privacy" id="set_privacy" value="0" > public<br>
		<input type="radio" name="set_privacy" id="set_privacy" value="1" checked="checked"> private<br>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language ::</td>
		<td width="87%">
		<select name="language" id="language">
		<option value="es_MX">Espanol</option>
		<option value="en_US">English</option>
		
		</select>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
		<td width="87%">
		<input type="text" name="media_name" id="media_name" size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
		<td width="87%">
		<input type="text" name="caption" id="caption" size="52"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
		<td width="87%">
		<textarea name="alternate_text" id="alternate_text" rows="2" cols="50"></textarea>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
		<td width="87%">
		<textarea name="description" id="description" rows="10" cols="50"></textarea>
		</td>
		</tr>
		
					    
		<tr>
		<td><input type="button" name="" value="Next language" class="createbtn" onclick="next_lang()" id="nxt_but"></td>
		<td>&nbsp</td>
		<td><input type="button" name="cancel" id="cancel_image_media" value="Cancel" class="createbtn"></td>
		<td>&nbsp</td>
		<td><input type="submit" name="submit" value="Save & exit" class="createbtn" id="saveNdExit"></td>
		</tr>
		</form>
		</table>
	       </div><!-----------end of mediaimage-------------------->
			       
		<!-----------that is  for media url--------------------->
		<div id="for_upload_url" style="display: none">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frmurl" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<!--<input type="hidden" name="event_id" value="<?php //echo $event_id;?>"/>-->
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Url ::</td>
		<td width="87%">
		<textarea name="url" id="url" rows="5" cols="40"></textarea>
		</td>
		</tr>		
		<tr>
		<td>&nbsp;</td>				
		<td><input type="button" name="buttonsave" value="Next >>" class="createbtn" onclick="ajaxSaveUploadMedia(<?php echo $event_id;?>)" style="height: 28px;"></td>
		</tr>
		</form>
		</table>	
		</div>
		<!------first  time  show hide media  URL--->
		
		<!------for next language media  URL--->
		<div class="mediaurl">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frmurl" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
		<input type="hidden" name="vid_media_id" value="" id="vid_media_id"/>
		<tr class="media_url" >
		<td>
		<div id="url_video_show"></div>		
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Set privacy ::</td>
		<td width="87%">
		<input type="radio" name="set_privacy" id="set_privacy_url" value="0" > public<br>
		<input type="radio" name="set_privacy" id="set_privacy_url" value="1" checked="checked"> private<br>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language ::</td>
		<td width="87%">
		<select name="language" id="language_url">
		<option value="es_MX">Espanol</option>
		<option value="en_US">English</option>
		</select>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Media Name ::</td>
		<td width="87%">
		<input type="text" name="media_name" id="media_name_url"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Caption ::</td>
		<td width="87%">
		<input type="text" name="caption" id="caption_url"/>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Alternative Text ::</td>
		<td width="87%">
		<textarea name="alternate_text" id="alternate_text_url" rows="2" cols="50"></textarea>
		</td>
		</tr>
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Description ::</td>
		<td width="87%">
		<textarea name="description" id="description_url" rows="10" cols="50"></textarea>
		</td>
		</tr>
		<tr>
		<td><input type="button" name="cancel" id="cancel_url_media" value="Cancel" class="createbtn"  ></td>
		<td>&nbsp</td>
		<td><input type="button" name="" value="Next language" class="createbtn"  onclick="next_lang_url()" id="nxt_but_url"></td>
		<td>&nbsp</td>
		<td><input type="submit" name="submit_url" value="Save & exit" class="createbtn"  id="saveNdExit_url"></td>
		</tr>
		</form>
		</table>
		</div>
		<!------ END for next language media  URL--->





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
