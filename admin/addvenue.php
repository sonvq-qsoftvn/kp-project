<?php
// home page
session_start();
include('../include/admin_inc.php');

list($today_yr,$today_mon,$today_day) = explode("-",date("Y-m-d"));

//create object
$objlist=new admin;
$obj_subcat=new admin;
$obj_venuestate=new admin;
$obj_venuecounty=new admin;
$obj_venuecity=new admin;
$obj_venue=new admin;
$obj_add=new admin;
$obj_add_category_by_event=new admin;
$objlist_most_used=new admin();
$obj_thumb = new admin;
$obj_add_eventtype = new admin;
$objgetVen = new admin;
$obj_del_cat = new admin;
$obj_update_st_rt = new admin;
$obj_check = new admin;

$obj_dup_event_master_type = new admin;

$objlist->category_list();
$obj_dup_event_master_type->getEventTypeMster();


if(isset($_GET['action']) && $_GET['action']=="delete")
{
	$venue_id = $_REQUEST['venue_id'];
	$objgetVen->get_venue($venue_id);
	$objgetVen->next_record();
	@unlink("../files/venue/large/".$objgetVen->f('venue_image'));
	@unlink("../files/venue/thumb/".$objgetVen->f('venue_image'));
	
	$obj_del_cat->delCatByVenueId($venue_id);
	$obj_del_cat->delvenueTypeByVenueId($venue_id);
	$obj_del_cat->delete_venue($venue_id);
	
	$_SESSION['msg'] = "Venue deleted!";
	header("location: ".$obj_base_path->base_path()."/admin/addvenue");
	exit;
}



if(isset($_POST['addevent']) && $_POST['addevent'] == '1')	
{
	//print_r($_POST);exit;

	$finalArray = $_POST['maincat'];
	$event_types = $_POST['event_types'];
	$publish_date = $_POST['year_1']."-".$_POST['month_1']."-".$_POST['day_1'];
	
	$venue_name_sp = addslashes($_POST['venue_name_sp']);
	$venue_short_add_sp = addslashes($_POST['venue_short_add_sp']);
	$venue_name = addslashes($_POST['venue_name']);
	$venue_short_add_en = addslashes($_POST['venue_short_add_en']);
	$venue_state = addslashes($_POST['venue_state']);
	$venue_county = addslashes($_POST['venue_county']);
	$venue_city = addslashes($_POST['venue_city']);
	$venue_zip = addslashes($_POST['venue_zip']);
	$venue_address = addslashes($_POST['venue_address']);
	$venue_contact_name=addslashes($_POST['venue_contact_name']);
	$venue_head_manager=addslashes($_POST['venue_head_manager']);
	$venue_phone=$_POST['venue_phone'];
	$venue_fax=$_POST['venue_fax'];
	$venue_cell=$_POST['venue_cell'];
	$venue_email=$_POST['venue_email'];
	$venue_url=$_POST['venue_url'];
	$venue_capacity = $_POST['venue_capacity'];
	$venue_map = $_POST['venue_map'];
	$venue_media_gallery = $_POST['venue_media_gallery'];
	$venue_authorize_manager = $_POST['venue_authorize_manager'];
	$allowed_commments = $_POST['allowed_commments'];
	$allowed_share = $_POST['allowed_share'];
	$show_FB_like = $_POST['show_FB_like'];
	$venue_description=addslashes($_POST['venue_description']);
	$venue_description_sp=addslashes($_POST['venue_description_sp']);
	$file_name = $_POST['venue_photo'];
	$tags = addslashes($_POST['tags']);
	$venue_stat = $_POST['venue_stat'];
	
	$venue_us_tell = $_POST['venue_us_tell'];
	$venue_nextel = $_POST['venue_nextel'];
	$venue_fb_page = $_POST['venue_fb_page'];
	$venue_twitter_account = $_POST['venue_twitter_account'];
	
	$lat = $_POST['lat'];
	$long = $_POST['long'];
	
	// Code for sub-description
	if(($venue_short_add_sp=="Breve Descripción" || $venue_short_add_sp=="") && $venue_description_sp!=""){
		$venue_short_add_sp = strip_tags($venue_description_sp);
		$venue_short_add_sp = substr($venue_short_add_sp,0,160);
	}
	if(($venue_short_add_en=="Short Description" || $venue_short_add_en=="") && $venue_description!=""){
		$venue_short_add_en = strip_tags($venue_description);
		$venue_short_add_en = substr($venue_short_add_en,0,160);
	}
		
	
	$privacy = $_POST['privacy_set'];
	if($privacy==0)	{
		$private_privacy = 1;
		$public_privacy = 0;
	}
	else{
		$private_privacy = 0;
		$public_privacy = 1;
	}
	//echo $private_privacy.'a'.$public_privacy;exit;
	
	// check add or edit...
	$obj_check->checkVenue($_SESSION['venue_unique_id']);
	if($obj_check->num_rows()){
		
		$obj_check->next_record();
		$last_event_id = $venue_id = $obj_check->f('venue_id');
		// Edit Venue
		$obj_add->editVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$venue_stat,$venue_id,$venue_us_tell,$venue_nextel,$venue_fb_page,$venue_twitter_account,$_POST['st_rate'],$lat,$long);
		
	}
	else{
					
		// Add Venue
		$last_event_id = $obj_add->addVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$_SESSION['venue_unique_id'],$venue_stat,$venue_us_tell,$venue_nextel,$venue_fb_page,$venue_twitter_account,$_POST['st_rate'],$lat,$long);
	}
	
	// Add category Event
	$obj_add_category_by_event->addCategoryByVenue($finalArray,$last_event_id);
	
	// Add Event Type
	$obj_add_eventtype->addEventType($event_types,$last_event_id);
	
	// Update Standard rates
	if($_POST['st_rate']==1)
	{
		$obj_update_st_rt->updateVenStanRt($_SESSION['venue_unique_id'],$last_event_id);
	}
	

	$_SESSION['venue_del_msg'] = "Venue created successfully";
	header("Location:".$obj_base_path->base_path()."/admin/list_venues.php");
	exit;
	
}
else
{
	$_SESSION['venue_unique_id'] = time();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Post Venue</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!--jquery alert-->
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.alerts.js" type="text/javascript"></script>
<!--jquery alert-->

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js" ></script>

<!-- Ajax File Upload -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
<!-- Ajax File Upload -->


<script type="text/javascript">

function deletevenue(event_id)
{
	var conf = confirm("Are you sure you want to delete this venue?")
	if(conf == true)
    {
       window.location.href="<?php echo $obj_base_path->base_path(); ?>/admin/addvenue.php?venue_id="+event_id+"&action=delete";
    }
    else
    {
       return false;
    }
}

//calendar
$(document).ready(function() {
	$('#multi_event_day1').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
		
		$('#multi_event_month1').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			onSelect: function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
			
		});
		
		$('#multi_event_year1').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
	
});
$(document).ready(function() {
	$('#multi_event_day2').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
		
		$('#multi_event_month2').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			onSelect: function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
			
		});
		
		$('#multi_event_year2').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
				var n=theDate.split("/");
				$("input[name='multi_event_month1']").val(n[0]);
				$("input[name='multi_event_day1']").val(n[1]);
				$("input[name='multi_event_year1']").val(n[2]);

				$("input[name='multi_event_month2']").val(n[0]);
				$("input[name='multi_event_day2']").val(n[1]);
				$("input[name='multi_event_year2']").val(n[2]);
			}
		});
	
});


</script>




<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
     $('#div_city_display').html('<select name="venue_city" class="selectbg12"><option value="">City</option></select>');
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "state_id="+stateid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_county.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid)
{
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "county_id="+countyid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_city.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}

function getVenue(cityid)
{
     data = "city_id="+cityid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_venue.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_venue_display").html(data);
	   }
	 });
}
</script>


<script type="text/javascript" >
	
$(function(){
		var btnUpload=$('#me1');
		var mestatus=$('#mestatus1');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadvenue.php',
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
				$('#venue_photo').val(response);
				$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/venue/thumb/'+response+'" alt="" />');
				$('#me1').html('');
				
			}
		});
		
	});
</script>

<script type="text/javascript">
	function complete(){

		if(checkReg())
		{			
			var dd = document.getElementById("multi_event_day1").value;
			var mm = document.getElementById("multi_event_month1").value;
			var yy = document.getElementById("multi_event_year1").value;
			if(dd == 0 || mm == 0 || yy == 0){
				$("#complete").html('Incorrect Publish Date');
				document.getElementById("multi_event_day1").value = '0';
				document.getElementById("multi_event_month1").value = '0';
				document.getElementById("multi_event_year1").value = '0';
			}
			else
			{
				document.getElementById("day_1").value = document.getElementById("multi_event_day1").value;
				document.getElementById("month_1").value = document.getElementById("multi_event_month1").value;
				document.getElementById("year_1").value = document.getElementById("multi_event_year1").value;
				//alert(document.getElementById("day_1").value);
				$("#complete").html('Venue Published');
				$('#venue_stat').val(2);
				setTimeout('document.getElementById("venue_form").submit()',1000);
			}
		}
	}

function complete1(){
	
	if(checkReg())
	{	
		var dd = document.getElementById("multi_event_day2").value;
		var mm = document.getElementById("multi_event_month2").value;
		var yy = document.getElementById("multi_event_year2").value;
		if(dd == 0 || mm == 0 || yy == 0 || dd == 00 || mm == 00 || yy == 0000){
			$("#complete1").html('Incorrect Publish Date');
			document.getElementById("multi_event_day2").value = '0';
			document.getElementById("multi_event_month2").value = '0';
			document.getElementById("multi_event_year2").value = '0';
		}
		else
		{
			document.getElementById("day_1").value = document.getElementById("multi_event_day2").value;
			document.getElementById("month_1").value = document.getElementById("multi_event_month2").value;
			document.getElementById("year_1").value = document.getElementById("multi_event_year2").value;
			//alert(document.getElementById("day_2").value);
			$('#venue_stat').val(2);
			$("#complete1").html('Venue Published');
			setTimeout('document.getElementById("venue_form").submit()',1000);
		}
	}
}

</script>
<script type="text/javascript">

function checkReg()
{
	$('#err_venue_sp').html('');
	$('#err_city').html('');
	$('#err_add').html('');
	$('#err_contact_name').html('');
	$('#err_phone').html('');
	$('#err_cell').html('');
	$('#err_mail').html('');
	
	$('#err_lat').html('');
	$('#err_long').html('');
	
	<?php 
		if($_SESSION['ses_user_id']==1)
		{
	?>
			return true;
	<?php	}
	?>
	
	
	/*alert($("#venue_name").val());
	if($("#venue_name").val()=="" || $("#venue_name").val()=="Name")
	{
		$('#err_venue_name').alert("Please Enter Venue name.");
		$("#venue_name").focus();
		return false;
	}*/
	if($("#venue_name_sp").val()=="" || $("#venue_name_sp").val()=="Nombre")
	{
		$('#err_venue_sp').html("Please Enter Venue name.");
		$("#venue_name_sp").focus();
		return false;
	}
	if($("#venue_city").val()=="")
	{
		$('#err_city').html("Please Enter City.");
		$("#venue_city").focus();
		return false;
	}
	if($("#venue_address").val()=="" || $("#venue_address").val()=="*Address")
	{
		$('#err_add').html("Please Add Address.");
		$("#venue_address").focus();
		return false;	
	}
	if($("#venue_contact_name").val()=="")
	{
		$('#err_contact_name').html("Please Enter Contact Name.");
		$("#venue_contact_name").focus();
		return false;
	}
	/*if($("#venue_phone").val()=="")
	{
		$('#err_phone').html("Please Enter Phone.");
		$("#venue_phone").focus();
		return false;
	}
	if($("#venue_cell").val()=="")
	{
		$('#err_cell').html("Please Enter Cell Number.");
		$("#venue_cell").focus();
		return false;
	}*/
	if($("#venue_email").val()=="")
	{
		$('#err_mail').html("Please Enter Email.");
		$("#venue_email").focus();
		return false;
	}
	if($("#venue_email").val()!="")
	{
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

		if(!pattern.test($('#venue_email').val()))
		{
			$('#err_mail').html("Invalid e-mail address!");
			$('#venue_email').focus();
			return false;
		}
	}
	var fields = $("input[class='category_1']").serializeArray(); 
    if (fields.length == 0) 
    { 
        alert('No Categories Selected!'); 
        // cancel submit
        return false;
    } 

	 return true;
}

</script>

<script type="text/javascript">
	function privacy_policy(){
		if($('input:radio[name=privacy]:checked').val()==1)
		{
			$('#public_content').show();
			$('#private_content').hide();
			$('#privacy_set').val($('input:radio[name=privacy]:checked').val());
		}
		else
		{
			$('#private_content').show();
			$('#public_content').hide();
			$('#privacy_set').val($('input:radio[name=privacy]:checked').val());
		}
	}
	function standard_rates(){
		if($('input:radio[name=st_rate]:checked').val()==1)
		{
			$('#performance_rate').show();
		}
		else
		{
			$('#performance_rate').hide();
		}
	}
	
	</script>



<script type="text/javascript">
function showSubCat(category_id)
{
	$('#sub_cat'+category_id).show();
	$('#shwsubcatview'+category_id).hide();
	$('#hdsubcatview'+category_id).show();
}
function hideSubCat(category_id)
{
	$('#sub_cat'+category_id).hide();
	$('#hdsubcatview'+category_id).hide();
	$('#shwsubcatview'+category_id).show();
}
function checkCat(category_id)
{
	$('#maincat'+category_id).attr("checked",true);
}
function check_box(){

	var ven_des_en = CKEDITOR.instances['venue_description'].getData();
	var ven_des_sp = CKEDITOR.instances['venue_description_sp'].getData();

	var fields = $("input[class='category_1']").serializeArray(); 
	
	<?php 
		if($_SESSION['ses_user_id']==1)
		{
	?>
			
		$('#venue_stat').val(1);
		sendData = $("#venue_form").serialize();

		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_saved_venue.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: sendData+"&ven_des_en="+ven_des_en+"&ven_des_sp="+ven_des_sp,   
		   success: function(data){ 
			 //alert(data);
			  $("#display_preview").html('<a href="<?php echo $obj_base_path->base_path(); ?>/venue/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
			  $("#display_preview2").html('<a href="<?php echo $obj_base_path->base_path(); ?>/venue/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
			  
			  $("#display_delete").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deletevenue('+data+');" />');
	   		$("#display_delete2").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deletevenue('+data+');" />');

			  
			 $("#showupdate").html("Venue Saved.");
			 setTimeout('$("#showupdate").html("")',2000);
		   }
		 });
		 return false;
	
	<?php	
	}
	?>
	
	
    if (fields.length == 0) 
    { 
        alert('No Categories Selected!'); 
        // cancel submit
        return false;
    } 
	else
	{
		$('#venue_stat').val(1);
		sendData = $("#venue_form").serialize();

		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_saved_venue.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: sendData+"&ven_des_en="+ven_des_en+"&ven_des_sp="+ven_des_sp,   
		   success: function(data){ 
			 //alert(data);
			  $("#display_preview").html('<a href="<?php echo $obj_base_path->base_path(); ?>/venue/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
			  $("#display_preview2").html('<a href="<?php echo $obj_base_path->base_path(); ?>/venue/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
			  
			  $("#display_delete").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deletevenue('+data+');" />');
	   		$("#display_delete2").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deletevenue('+data+');" />');

			  
			 $("#showupdate").html("Venue Saved.");
			 setTimeout('$("#showupdate").html("")',2000);
		   }
		 });
		//document.getElementById("venue_form").submit();
	}
}
</script>

<script type="text/javascript">
//Edit the counter/limiter value as your wish
var count = "160";   //Example: var count = "175";
function limiter(){

	var tex = document.venue_form.venue_short_add_sp.value;
	var len = tex.length;
	if(len > count){
			tex = tex.substring(0,count);
			document.venue_form.venue_short_add_sp.value =tex;
			return false;
	}
	document.venue_form.limit.value = count-len;
}

var count1 = "160";   //Example: var count = "175";
function limiter1(){
	var tex = document.venue_form.venue_short_add_en.value;
	var len = tex.length;
	if(len > count1){
			tex = tex.substring(0,count1);
			document.venue_form.venue_short_add_en.value =tex;
			return false;
	}
	document.venue_form.limit1.value = count1-len;
}

var count_tic_en = "160";   //Example: var count = "175";
function limiter_tic_en(){
	var tex = document.venue_form.description_en.value;
	var len = tex.length;
	if(len > count1){
			tex = tex.substring(0,count_tic_en);
			document.venue_form.description_en.value =tex;
			return false;
	}
	document.venue_form.limit_tic_en.value = count_tic_en-len;
}
var count_tic_sp = "160";   //Example: var count = "175";
function limiter_tic_sp(){
	var tex = document.venue_form.description_sp.value;
	var len = tex.length;
	if(len > count1){
			tex = tex.substring(0,count_tic_sp);
			document.venue_form.description_sp.value =tex;
			return false;
	}
	document.venue_form.limit_tic_sp.value = count_tic_sp-len;
}


function setmultivenue()
{
	$('#multi_venue').val($('#venue').val());
	saveAutoEvent();
}

</script>

<script>

function delStandVen(venue_rates_id)
{
	 data = "venue_rates_id="+venue_rates_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_del_rates_venue.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
	   }
	 });
}
function edit_rates(venue_rates_id)
{
	 data = "venue_rates_id="+venue_rates_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_edit_standard_rates_venue.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   dataType: 'json',
	   data: data,   
	   success: function(data){ 
	   
		// Fill the Text field
	   $('#rate_name_en').val(data['rate_name_en']);
	   $('#rate_name_sp').val(data['rate_name_sp']);
	   $('#description_en').val(data['description_en']);
	   $('#description_sp').val(data['description_sp']);
	   $('#price_mx').val(data['price_mx']);
	   $('#price_us').val(data['price_us']);

	   
	   $('#edit_rate').val(1);
	   $('#exit_rate_id').val(venue_rates_id);

	   }
	 });
}


function closePopUp()
{
	var checkValue = save_new_popup();
}
function save_new_popup()
{
	if(!checkticketReg())
	{
		return 0;
	}
	else{
		
		 var ticketVal = $("#venue_form").serialize();
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_add_standard_rates_venue.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: ticketVal,   
		   success: function(data){ 

			 $("#imgid").val('');

			 $('#edit_rate').val(0);
			 $("#save_create_ticket_display").html(data);
			 
			 // Place the placeholder
			 $("#rate_name_sp").val("Nombre");
			 $("#rate_name_en").val("Name");
			 $("#description_sp").val("");
			 $("#description_en").val("");
			 $("#price_mx").val("0");
			 $("#price_us").val("0");

			 count_tic_sp = 160;
			 $('#limit_tic_sp').val(160);
			 count_tic_en = 160;
			 $('#limit_tic_en').val(160);
			 
			//$('html, body').animate({scrollTop: $("#show_popup").offset().top}, 2000);
		   }
		 });
		 return 1;
	}
}

function checkticketReg()
{
	$('#price_mx').css("border", "1px solid #CCCCCC");
	$('#rate_name_en').css("border", "1px solid #CCCCCC");
	$('#rate_name_sp').css("border", "1px solid #CCCCCC");
	$('#price_us').css("border", "1px solid #CCCCCC");


	 if($('#rate_name_sp').val()=="" || $('#rate_name_sp').val()=="Nombre")
	{
		$('#rate_name_sp').css("border", "1px solid #FF0000");
		$('#rate_name_sp').focus();
		return false;
	}
	else if($('#rate_name_en').val()=="" || $('#rate_name_en').val()=="Name")
	{
		$('#rate_name_en').css("border", "1px solid #FF0000");
		$('#rate_name_en').focus();
		return false;
	}
	
	else if($('#price_mx').val()=="")
	{
		$('#price_mx').css("border", "1px solid #FF0000");
		$('#price_mx').focus();
		return false;
	}
	else if($('#price_us').val()=="")
	{
		$('#price_us').css("border", "1px solid #FF0000");
		$('#price_us').focus();
		return false;
	}
	
	return true;
}

	
function checkInt(var_name,show_err)
{
	var regexp = /^\d+$/;
	
	if(!regexp.test($('#'+var_name).val()))
	{
		$('#'+var_name).val(0);
		$('#'+var_name).focus();
		$('#'+show_err).html("Please Insert Numeric Value");
	}
	else
	{
		$('#'+show_err).html("");
	}
	
}
function checDecimal(var_name,show_err)
{
	var regexp = /^\d+(?:\.\d+)?$/;
	var num = 0.00;

	if(!regexp.test($('#'+var_name).val()))
	{
		$('#'+var_name).val(num.toFixed(2));
		$('#'+var_name).focus();
		$('#'+show_err).html("Please Insert Numeric Value");
	}
	else
	{
		$('#'+show_err).html("");
	}
	
}

</script>
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
           <div class="blue_box10"><p>My venues</p></div>
           	<?php include("admin_menu/venue_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;" id="showupdate">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
        <strong><?php echo $msg;?>		
		</strong></div>	
	<?php
	}?>	
		
    <form action="" method="post" name="venue_form" id="venue_form" enctype="multipart/form-data" onSubmit="return checkReg()">
    <input type="hidden" name="addevent" id="addevent" value="1" />
    <input type="hidden" name="venue_photo" id="venue_photo" value="" />
    <input type="hidden" name="privacy_set" id="privacy_set" value="1" />
    <input type="hidden" name="venue_stat" id="venue_stat" value="1" />
    <div class="myevent_box">
    <div class="myevent_left">
		<div class="event_name8">
            <div style="float:left; position: absolute; margin: 0 0 0 303px;">
                <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/>
            </div>
            <div style="float: left; margin: 0 auto;">
                <span class="show_spanish">SP</span><br/>
                <span class="event_fieldbg8">
                    <input type="text" name="venue_name_sp" id="venue_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="<?php echo "Nombre";?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/><div id="err_venue_sp" style="color:red;"></div>
                </span>	
                <br/>
                <span class="event_fieldbg8">
                	 <textarea name="venue_short_add_sp" id="venue_short_add_sp" class="event_field" style="width: 290px; margin: 5px 0; padding:3px 5px; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="limiter()">Breve Descripción</textarea>
			<script type="text/javascript">
            document.write("<input type=text name=limit size=4 readonly value="+count+">");
            </script>
                    
                </span>
            </div>
            <div style="float: right; margin: 0 auto;">	
                <span class="show_english">EN</span><br/>
                <span class="event_fieldbg8">
                    <input type="text" name="venue_name" id="venue_name" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"  value="Name" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/><div id="err_venue_name" style="color:red;"></div>
                </span>	
                <br/>
                <span class="event_fieldbg8">
                    <textarea name="venue_short_add_en" id="venue_short_add_en" class="event_field" style="width: 290px; margin: 5px 0; padding:3px 5px; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="limiter1()">Short Description</textarea>
				<script type="text/javascript">
                    document.write("<input type=text name=limit1 size=4 readonly value="+count1+">");
                </script>
                </span>
            </div>
    	</div>
        <div class="clear"></div>
        <div class="event_date">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>      
          <td width="22%" style="padding-left: 12px;">
          <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value);">
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
          </select></td>
          <td width="22%">
              <div id="div_county_display">
              <select name="venue_county" class="selectbg12">
              <option value="">County</option>
              <?php
              if($msg!="")
              {
                    $obj_getcounty = new admin;
                    $obj_getcounty->getCountyNameByState($venue_state);
                    while($obj_getcounty->next_record())
                    {
                    ?>
                    <option value=<?php echo $obj_getcounty->f("id")?> <?php if($venue_county==$obj_getcounty->f('id')){?> selected="selected"<?php }?> >
                    <?php echo $obj_getcounty->f('county_name')?></option>
                    <?php
                    }
              }
              ?>
              </select>
              </div>	  </td>          
          <td width="22%">
              <div id="div_city_display">
              <select name="venue_city" id="venue_city" class="selectbg12">
              <option value="">City</option>
               <?php
              if($msg!="")
              {
                    $obj_getcity = new admin;
                    $obj_getcity->getCityNameByCounty($venue_county);
                    while($obj_getcity->next_record())
                    {
                    ?>
                    <option value=<?php echo $obj_getcity->f("id")?> <?php if($venue_city==$obj_getcity->f('id')){?> selected="selected"<?php }?>>
                    <?php echo $obj_getcity->f('city_name')?></option>
                    <?php
                    }
              }
              ?>
              </select>
              </div><div id="err_city" style="color:red;"></div>
              </td>
              <td><input type="text" name="venue_zip" id="venue_zip" value="Zipcode" class="textbg_grey" style="width: 190px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" /></td>
          </tr>
        </table>	  
        </div>	
        <div class="clear"></div>
        <div style="margin: 8px 0 0 19px;">
            <span class="event_fieldbg8">
                <textarea name="venue_address" id="venue_address" class="event_field" style="width: 290px;margin: 5px 0; padding:3px 5px;height:60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">*Address</textarea>
            </span><div id="err_add" style="color:red;">&nbsp;</div>
        </div>
        <div class="clear"></div>
        <div style="margin: 8px 0 0 19px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="padding: 4px;"><strong>Lattitude*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="lat" id="lat" class="textbg_grey" style="width: 130px;"/>
                  <div id="err_lat" style="color:red;"></div></td>
                </tr>
		<tr>
                  <td style="padding: 4px;"><strong>Longitude*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="long" id="long" class="textbg_grey" style="width: 130px;"/>
                  <div id="err_long" style="color:red;"></div></td>
                </tr>
		
		<tr>
                  <td style="padding: 4px;"><strong>Contact name*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_contact_name" id="venue_contact_name" class="textbg_grey" style="width: 130px;"/>
                  <div id="err_contact_name" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Head Manager</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_head_manager" id="venue_head_manager" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Phone</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_phone" id="venue_phone" value="" class="textbg_grey" style="width: 130px;"/><div id="err_phone" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Fax</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_fax" id="venue_fax" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Cell</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_cell" id="venue_cell" value="" class="textbg_grey" style="width: 130px;"/><div id="err_cell" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>US tel</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_us_tell" id="venue_us_tell" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Nextel</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_nextel" id="venue_nextel" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>email*</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_email" id="venue_email" value="" class="textbg_grey" style="width: 130px;"/><div id="err_mail" style="color:red;"></div></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>URL</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_url" id="venue_url" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Facebook Page</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_fb_page" id="venue_fb_page" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Twitter account</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_twitter_account" id="venue_twitter_account" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;">&nbsp;</td>
                  <td style="padding: 4px;">&nbsp;</td>
                </tr>
              </table></td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="padding: 4px;"><strong>Capacity</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_capacity" id="venue_capacity" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Map</strong></td>
                 <td style="padding: 4px;"><input type="text" name="venue_map" id="venue_map" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Media Gallery</strong></td>
                  <td style="padding: 4px;"><input type="text" name="venue_media_gallery" id="venue_media_gallery" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Authorized managers</strong></td>
                 <td style="padding: 4px;"><input type="text" name="venue_authorize_manager" id="venue_authorize_manager" value="" class="textbg_grey" style="width: 130px;"/></td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Allow Comments </strong></td>
                  <td style="padding: 4px;">
                    <input name="allowed_commments" id="allowed_commments1" type="radio" value="1" checked="checked"/> Yes 
                    <input name="allowed_commments" id="allowed_commments2" type="radio" value="0"/> No 
                  </td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Allow Share</strong></td>
                  <td style="padding: 4px;">
                    <input name="allowed_share" id="allowed_share1" type="radio" value="1" checked="checked"/> Yes 
                    <input name="allowed_share" id="allowed_share2" type="radio" value="0"/> No 
                  </td>
                </tr>
                <tr>
                  <td style="padding: 4px;"><strong>Show FB Like</strong></td>
                  <td style="padding: 4px;">
                    <input name="show_FB_like" id="show_FB_like1" type="radio" value="1" checked="checked"/> Yes 
                    <input name="show_FB_like" id="show_FB_like2" type="radio" value="0"/> No 
                  </td>
                </tr>
                <tr>
                  <td style="padding: 4px;">&nbsp;</td>
                  <td style="padding: 4px;">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
        </div>
        <div class="clear"></div>    
        <div class="event_date">
            <div id="TabbedPanels2" class="TabbedPanels2">
                <ul class="TabbedPanelsTabGroup2">
                    <li class="TabbedPanelsTab2" tabindex="1">Espanol</li>  
                    <li class="TabbedPanelsTab2" tabindex="0">English</li> 
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0" style="float: right; margin: 0 10px 0 0;"/>	 
                </ul>
                <div class="TabbedPanelsContentGroup2">
                    <div class="TabbedPanelsContent2">
                        <?php
						  include($obj_base_path->base_path()."/ckeditor/ckeditor.php");
							$CKeditor = new CKeditor();
							$CKeditor->BasePath = 'ckeditor/';
							$CKeditor->editor('venue_description_sp');
						?>
                    </div>
                    <div class="TabbedPanelsContent2" style="">
                        <!--<textarea name="venue_description" id="venue_description" cols="35" rows="10"></textarea>-->
                         <?php
							$CKeditor = new CKeditor();
							$CKeditor->BasePath = 'ckeditor/';
							$CKeditor->editor('venue_description');
                         ?>
                    </div> 
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="event_ticket">
            <h1>Set feature image <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>
            <ul style="margin-left: 10px;">
                <li><div id="me1" class="styleall" style="cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Upload Files</span></span></div><span id="mestatus1"></span><div class="clear"></div><div id="imgshow"></div></li>
                <li>|</li>
                <li><a href="#">Media Libery</a></li>
            </ul>
        </div>		
        <div class="clear"></div>
        <div class="event_ticket" style="background:none;">
            <h1>Set Privacy <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>	
            <span style="float: left;">
                <p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="1" checked="checked" onclick="privacy_policy()" /> Public</p>	
                <p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="0" onclick="privacy_policy()" /> Private</p>
             </span>
            <span id="public_content">This venue is public and will be listed in our venue directory and submited to search engines</span>
            <span id="private_content">This venue is private and will not be listed in our venue directory and submited to search engines</span>
        </div>
        <div class="event_ticket" style="background:none;">
            <h2><input type="radio" name="st_rate" id="st_rate1" value="1" onclick="standard_rates();" />Venue has standard rates (?) </h2>	
            <h2><input type="radio" name="st_rate" id="st_rate2" value="0" checked="checked" onclick="standard_rates();" />Venue has no standard rates (?) </h2>	
        </div>
        
        <div id="performance_rate" style="display:none;">
       		<div class="event_ticket2">
               <div><h2>Set standard venue rates <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" width="31" height="28" border="0"/></h2></div>
                <div class="clear"></div>
                <div id="save_create_ticket_display" class="event_ticketbox" style="border:0px solid red;">&nbsp;</div>
        	</div>
       		<div class="clear"></div>

              <input type="hidden" name="edit_rate" id="edit_rate" value="0" />
              <input type="hidden" name="exit_rate_id" id="exit_rate_id" value="0" />
           <div class="event_name8">
            <div style="float: left; position: absolute; margin: 0 0 0 303px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/></div>
            <div style="float: left; margin: 0 auto;">
                <span class="show_spanish">SP</span><br/>
                <span class="event_fieldbg8">
                <input type="text" name="rate_name_sp" id="rate_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="Nombre" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if(this.value=='') this.value=this.defaultValue"/>
                </span>	
            <br/>
                <span class="event_fieldbg8">
                    <textarea name="description_sp" id="description_sp" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="limiter_tic_sp()">Breve descripción</textarea>
            <script type="text/javascript">
            	document.write("<input type=text name=limit_tic_sp id='limit_tic_sp' size=4 readonly value="+count_tic_sp+">");
            </script>
                </span>
            </div>
            <div style="float: right; margin: 0 auto;">	
                <span class="show_english">EN</span><br/>
                <span class="event_fieldbg8"><input type="text" name="rate_name_en" id="rate_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
                </span>	<br/>
                <span class="event_fieldbg8"><textarea name="description_en" id="description_en" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="limiter_tic_en()">Short description</textarea>
            <script type="text/javascript">
            	document.write("<input type=text name='limit_tic_en' id='limit_tic_en' size=4 readonly value="+count_tic_en+">");
            </script>
			</span>
            </div>
            </div>
           <div class="clear"></div>
           <div class="event_date8">
    
            <div class="event_date9">
                Precio MX pesos <input type="text" name="price_mx" id="price_mx" onblur="checDecimal('price_mx','shw_price_mx')"  /> 
                Price Dollars <input type="text" name="price_us" id="price_us" onblur="checDecimal('price_us','shw_price_us')"  />
            </div>	
            <div style="float: right; width: 367px; margin: 0 auto;">
                <input type="button" name="Submit2" value="Save & Create a new rate" class="event_save" onclick="save_new_popup()" style="cursor:pointer;" />
                <input type="button" name="Submit2" value="Save & Exit" class="event_save" onClick="closePopUp()" style="cursor:pointer;"/></div>
            </div>
    	</div>
    
        <div class="event_ticket" style="background: none; width: 702px; border: 0;margin: 0 auto 0 10px;">    
            <div class="event_ticketr" style="float: right; margin-right: 24px;">
                <h1>
                    <span id="display_delete"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" style="cursor:pointer;" /></span>
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save Venue" style="cursor:pointer;" onclick="return check_box();"/>
                    <span id="display_preview2"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0"/></span>
                </h1>
                <div style="margin:2px 0 2px 40px; font-weight:bold;">Save your work regularly</div>
                <div style="margin:2px 0 2px 30px;font-weight:bold;">Publish when you are done</div>
                <div class="clear"></div>
                <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
                    <input type="button" name="publish" value="Publish" onclick="complete();" class="pub" />
			 		<table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
                        <tr>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_day1" id="multi_event_day1" value="<?php echo $today_day;?>"  class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="day_1" id="day_1" value="" />
                          </td>
                          <td style="text-align: center;">/</td>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_month1" id="multi_event_month1" value="<?php echo $today_mon;?>" class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="month_1" id="month_1" value="" />
                          </td>
                          <td style="text-align: center;">/</td>
                          <td style="text-align:left;">
                            <input type="text" name="multi_event_year1" id="multi_event_year1"  value="<?php echo $today_yr;?>" class="textbg_grey"  style="width: 40px;"/>
                            <input type="hidden" name="year_1" id="year_1" value="" />
                          </td>
                        </tr>
                        <tr>
                            <td colspan="5"><div id="complete" style="color:#920125;"></div></td>
                        </tr>
                    </table>
                </div>
            </div>
        <div class="clear"></div>
        </div>
        <div class="clear"></div>	
    </div>
    
    <div class="myevent_right">
        <div class="event_ticketr" style="width: 276px; margin: 8px auto; float: none;">
            <h1>
            	<span id="display_delete2"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" style="cursor:pointer;" /> </span>
            	<img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save Venue" style="cursor:pointer;" onclick="return check_box();"/> 
                <span id="display_preview"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></span>
            </h1>
           <div style="margin:2px 0 2px 40px; font-weight:bold;">Save your work regularly</div>
           <div style="margin:2px 0 2px 30px;font-weight:bold;">Publish when you are done</div>

        
        <div class="clear"></div>
        <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
            <input type="button" name="publish" value="Publish" onclick="complete1();"  class="pub" />
            <table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
                <tr>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_day2" id="multi_event_day2" value="<?php echo $today_day;?>"  class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="day_2" id="day_2" value="<?php echo 00;?>" />
                  </td>
                  <td style="text-align: center;">/</td>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_month2" id="multi_event_month2" value="<?php echo $today_mon;?>" class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="month_2" id="month_2" value="<?php echo 00;?>" />
                  </td>
                  <td style="text-align: center;">/</td>
                  <td style="text-align:left;">
                    <input type="text" name="multi_event_year2" id="multi_event_year2"  value="<?php echo $today_yr;?>" class="textbg_grey"  style="width: 40px;"/>
                    <input type="hidden" name="year_2" id="year_2" value="<?php echo 0000;?>" />
                  </td>
                </tr>
                <tr>
                    <td colspan="5"><div id="complete1" style="color:#920125;"></div></td>
                </tr>
            </table>
        </div>
	</div>
	<div class="clear"></div>
    <div style="width: 280px; float: none; margin: 0 auto;">
    	
		<div class="inevent_right">
            <ul>
            	<li><h1>Types of Events for this venue:</h1></li>	
            </ul>
            <ul>
                <li style="padding-left: 8px;"><strong>Select all that apply (optional)</strong></li>
                <?php
					if($obj_dup_event_master_type->num_rows()){
						while($obj_dup_event_master_type->next_record()){
				?>
                <li style="padding-left: 8px;"><input type="checkbox" name="event_types[]" id="event_types<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" value="<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" /> <?php echo $obj_dup_event_master_type->f('event_types');?></li>
                
                <?php
						}
					}
				?>
            </ul>	
		</div>
    	<div class="clear"></div>
		<div class="inevent_right">
            <ul>
                <li><h1>Categories and sub-categories</h1></li>	
            </ul>
            <ul>
                <li style="padding-left: 10px;"><strong>Select all event categories suitable for this venue</strong></li>
                <li style="padding-left: 10px;"><strong>You must select at least 1 category</strong></li>	
            </ul>	
            <div>
             <ul>
                 <?php
                    if($objlist->num_rows()){
                        while($objlist->next_record()){
                        $obj_subcat->category_sub_list($objlist->f('category_id'));
                    ?>
                    <li style="padding-left: 8px;">
                        <input type="checkbox" name="maincat[]" id="maincat<?php echo $objlist->f('category_id');?>" value="<?php echo $objlist->f('category_id');?>" <?php if(in_array($objlist->f('category_id'),$allEventCat)){?> checked="checked" <?php } ?> class="category_1"/><?php echo $objlist->f('category_name'); if($obj_subcat->num_rows()){?> 			  
                        <span id="shwsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;" onclick="showSubCat(<?php echo $objlist->f('category_id');?>)">( + )</span> 
                        <span id="hdsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;display:none;" onclick="hideSubCat(<?php echo $objlist->f('category_id');?>)">( - )</span> <?php } ?>
                  
                        <ul style="margin-left:30px;display:none;" id="sub_cat<?php echo $objlist->f('category_id');?>">
                    <?php
                        if($obj_subcat->num_rows()){
                            while($obj_subcat->next_record()){
                                if(in_array($obj_subcat->f('category_id'),$allEventCat)){
                                ?>
                                <script>
                                        $(document).ready(function(){
                                        showSubCat(<?php echo $objlist->f('category_id');?>)
                                    })
                                </script>
                                <?php	}          	
                     ?>
                        
                            <li style="padding-left:8px;"><input onclick="checkCat(<?php echo $objlist->f('category_id');?>)" type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" <?php if(in_array($obj_subcat->f('category_id'),$allEventCat)){?> checked="checked" <?php } ?>/><?php echo $obj_subcat->f('category_name');?></li>
                         <?php
                                }
                            }
                        ?></ul>	
                    </li>
                     <?php
                        }
                    }
                    ?>
             </ul>
            </div>	
		</div>	
		<div class="clear"></div>	
    </div>
	<div class="clear"></div>
	<div class="eventag_box">
        <div><h1>Venue Tags</h1></div>
        <div class="clear"></div>
        	<div><input type="text" name="tags" id="tags" class="textbg_add"/> <!--<input type="submit" name="save" value="Add" class="btn_add" />--></div>
        <div class="clear"></div>
        	<div><span>Separate tags with commas</span></div>
        <div class="clear"></div>
	</div>
    </div>	
    <div class="clear"></div>
    </div>
    <?php /*?><div style="float:right;"><input type="submit" name="save" value="Save" class="login_btn" onclick="return check_box();" /></div><?php */?>
    </form>	
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

<script type="text/javascript">
<!--
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
