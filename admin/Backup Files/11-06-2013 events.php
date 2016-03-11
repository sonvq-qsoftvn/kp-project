<?php
// home page
session_start();
include('../include/admin_inc.php');

//create object
$objlist=new admin;
$obj_subcat=new admin;
$obj_venuestate=new admin;
$obj_venuecounty=new admin;
$obj_venuecity=new admin;
$obj_venue=new admin;
$obj_add=new admin;
$obj_add_ticket=new admin;
$obj_edit_ticket=new admin;
$obj_delete=new admin;
$obj_add_category_by_event=new admin;
$objlist_most_used=new admin();
$obj_subcat_most_used=new admin();
$obj_thumb = new admin;
$obj_temp_tickets = new admin;

$objlist->category_list();
//$objlist_most_used->most_used_category();

$unique_id = session_id();


if(isset($_POST['addevent']) && $_POST['addevent'] == '1')	
{
	$finalArray = array_merge($_POST['maincat'],$_POST['subcat']);
	
	$event_name_sp = addslashes($_POST['event_name_sp']);
	$event_name_en = addslashes($_POST['event_name_en']);
	$event_start_date_time = $_POST['event_year_st']."-".$_POST['event_month_st']."-".$_POST['event_day_st']." ".$_POST['event_hr_st']."-".$_POST['event_min_st']."-00";
	$event_start_ampm = $_POST['event_start_ampm'];
	$event_end_date_time = $_POST['event_year_end']."-".$_POST['event_month_end']."-".$_POST['event_day_end']." ".$_POST['event_hr_end']."-".$_POST['event_min_end']."-00";
	$event_end_ampm = $_POST['event_end_ampm'];
	$venue_state = addslashes($_POST['venue_state']);
	$venue_city = addslashes($_POST['venue_city']);
	$venue = addslashes($_POST['venue']);
	$page_content_en = addslashes($_POST['page_content_en']);
	$page_content_sp = addslashes($_POST['page_content_sp']);
	$event_tag = addslashes($_POST['event_tag']);;
	
	if($_FILES['event_photo']['name']!="")
	{
		$uploaddir = '../files/event/'; 
		$file = $uploaddir ."large/".time().basename($_FILES['event_photo']['name']); 
		$file_name = time().$_FILES['event_photo']['name'];
		move_uploaded_file($_FILES['event_photo']['tmp_name'],$file);
	    $obj_thumb->create_thumbnail($uploaddir . "large/".$file_name , $uploaddir . "thumb/".$file_name,71,79);
	}
	else
	{
	    $file_name = '';
	}
	

	$last_event_id = $obj_add->addEvent($event_name_sp,$event_name_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name);
	$obj_add_category_by_event->addCategoryByEvent($finalArray,$last_event_id);
	$obj_add_ticket->addFinalTicket($unique_id);
	$obj_edit_ticket->editTicketByEvent($unique_id,$last_event_id);
	$obj_delete->deleteTicket($unique_id);

	$msg = "Event created successfully";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Admin Post Event</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets1/SpryTabbedPanels1.css" rel="stylesheet" type="text/css"/>


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
//calendar
$(document).ready(function() {
	$('#event_month_st').datepicker({
		showButtonPanel: true,
    	onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_st']").val(n[0]);
		$("input[name='event_day_st']").val(n[1]);
		$("input[name='event_year_st']").val(n[2]);
		
		$('#event_month_end').val(n[0]);
		$('#event_date_end').val(n[1]);
		$('#event_year_end').val(n[2]);
		}
	});
	
	$('#event_date_st').datepicker({
		showButtonPanel: true,
    	onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_st']").val(n[0]);
		$("input[name='event_day_st']").val(n[1]);
		$("input[name='event_year_st']").val(n[2]);
		
		$('#event_month_end').val(n[0]);
		$('#event_date_end').val(n[1]);
		$('#event_year_end').val(n[2]);
		}
	});
	
	$('#event_year_st').datepicker({
		showButtonPanel: true,
   		onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_st']").val(n[0]);
		$("input[name='event_day_st']").val(n[1]);
		$("input[name='event_year_st']").val(n[2]);
		
		$('#event_month_end').val(n[0]);
		$('#event_date_end').val(n[1]);
		$('#event_year_end').val(n[2]);
		}
	});
	
	$('#event_month_end').datepicker({
		showButtonPanel: true,
    	onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_end']").val(n[0]);
		$("input[name='event_day_end']").val(n[1]);
		$("input[name='event_year_end']").val(n[2]);
		}
	});
	
	$('#event_date_end').datepicker({
		showButtonPanel: true,
    	onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_end']").val(n[0]);
		$("input[name='event_day_end']").val(n[1]);
		$("input[name='event_year_end']").val(n[2]);
		}
	});
	
	$('#event_year_end').datepicker({
		showButtonPanel: true,
   		onClose:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_end']").val(n[0]);
		$("input[name='event_day_end']").val(n[1]);
		$("input[name='event_year_end']").val(n[2]);
		}
	});
	
	
	
	
});
//add description
$(document).ready(function() {
	 $('#event_name').tipsy({gravity: 'w'});
	$('#event_date_div').tipsy({gravity: 'w'});

	$('#select_venue').tipsy({gravity: 'w'});
	$('#description').tipsy({gravity: 'w'});
	$('#on_sale_date').tipsy({gravity: 'w'});
	$('#sale_close_date').tipsy({gravity: 'w'});
	
	$('#category_id').tipsy({gravity: 'w'});
	$('#age').tipsy({gravity: 'w'});

	$('#event_web_site').tipsy({gravity: 'w'});
	$('#event_image').tipsy({gravity: 'w'});
	$('#icon_image').tipsy({gravity: 'w'});
	$('#print_at_home').tipsy({gravity: 'w'});
	$('#will_call').tipsy({gravity: 'w'});
	$('#donation').tipsy({gravity: 'w'});
	$('#custom_fee').tipsy({gravity: 'w'});
	$('#online_service_fee').tipsy({gravity: 'w'});
	$('#ticket_note').tipsy({gravity: 'w'});
	$('#ticket_transaction_limit').tipsy({gravity: 'w'});
	$('#checkout_time_limit').tipsy({gravity: 'w'});
	$('#private_event').tipsy({gravity: 'w'});
	$('#url_short_name').tipsy({gravity: 'w'});
	
	
});

</script>

<script type="text/javascript">
function openTicket()
{
	if(document.getElementById("ticket_buy1").checked)
	{
		$('#openPop').trigger("click");
		$('#price_payment').show();
		$('#price_promotion').show();
	}

}
$(document).ready(function() {
	$("#openPop").fancybox({ 
	'hideOnOverlayClick':false,
    'hideOnContentClick':false
	});
});

function closePopUp()
{
	//setTimeout("save_new_popup()",3000);
	save_new_popup()
	setTimeout("$('#fancybox-close').trigger('click')",3000);
}
function save_new_popup()
{
	 var ticketVal = $("#ticket_form").serialize();
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_temp_tickets.php",
	  // async: false,
	   cache: false,
	   type: "POST",
	   data: ticketVal,   
	   success: function(data){ 
	     $(".ticket_common_class").val('');
	     $("#save_create_ticket_display").html(data);
		//$('html, body').animate({scrollTop: $("#cust_scoring_saved").offset().top}, 2000);
	   }
	 });
}
</script>


<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
     $('#div_city_display').html('<select name="venue_city" class="selectbg1"><option value="">City</option></select>');
     $('#div_venue_display').html('<select name="venue" class="selectbg1"><option value="">Venue</option></select>');
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
     $('#div_venue_display').html('<select name="venue" class="selectbg1"><option value="">Venue</option></select>');
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
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: 'uploadPhoto.php',
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
				$('#photoname').val(response);
				
				
				
				
				//On completion clear the status
				//files.html('');
				//Add uploaded file to list
//				if(response==="success"){
//					$('<li></li>').appendTo('#files').html('<img src="images/webinfopedia_'+file+'" alt="" height="120" width="130" /><br />').addClass('success');
//				} else{
//					$('<li></li>').appendTo('#files').text(file).addClass('error');
//				}
			}
		});
		
	});
	
	
	function changeTime(starttime)
	{
	   var endtime = parseInt(starttime)+2;
	   $('#event_hr_end').val(endtime);
	   
	   if(starttime == '11' || starttime == '12')
	   {
          $('#event_hr_end').val(endtime);
		  $('#event_end_ampm').val('AM');
	   }
	   else
	   {
		  $('#event_hr_end').val(endtime);
		  //$('#event_end_ampm').val('PM');
	   }
	}
</script>

<script type="text/javascript">


function callAjax()
{
	//alert('cal');
}

window.setInterval(function(){
  /// call your function here
  callAjax()
}, 2000);
//setTimeout('callAjax()',2000);


function deleteTemp(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_delete_ticket.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
	   }
	 });
}

function editTempTicket(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_edit_ticket.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   dataType: 'json',
	   data: data,   
	   success: function(data){ 
	   
		// Fill the Text field
	  // alert(data['ticket_name_en']);
	   $('#ticket_name_en').val(data['ticket_name_en']);
	   $('#ticket_name_sp').val(data['ticket_name_sp']);
	   $('#description_en').val(data['description_en']);
	   $('#description_sp').val(data['description_sp']);
	   $('#price_mx').val(data['price_mx']);
	   $('#price_us').val(data['price_us']);
	   $('#ticket_num').val(data['ticket_num']);
	   $('#from_ticket').val(data['from_ticket']);
	   $('#to_ticket').val(data['to_ticket']);
	   $('#eairly_dis_percen').val(data['eairly_dis_percen']);
	   $('#eairly_days').val(data['eairly_days']);
	   $('#group_dis_per').val(data['group_dis_per']);
	   $('#group_dis_days').val(data['group_dis_days']);
	   
	   if(data['members_only']=="Y")
		  document.getElementById("members_only1").checked = true ;
	   else
			document.getElementById("members_only2").checked = true ;
	   
	   $('#edit_ticket').val(1);
	   $('#exit_ticket_id').val(ticket_id);
	   //End Fill the Text field
	   
	   //save_new_popup();
	   }
	 });
}

</script>
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
			   <div class="blue_boxh"><p>Create Event</p></div>
			   <div class="blue_boxr">
			   <ul>
			   <li><a href="#" class="here">Create</a></li>
			   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_events.php">List/edit</a></li>
			   <li><a href="#">Promote</a></li>	
			   <li><a href="#">View bookings</a></li>
			   <li><a href="#">Reports</a></li>						   
			   </ul>
			   </div>
			   </div> 
			 <div class="clear"></div>
            </div>	
		   </div>
		 </div>
<!---------------------put your div--here-------------------------------------------------- --> 
            
		<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000"><strong><?php echo $msg;?></strong></div>
		<form method="post" name="event_form" id="event_form" enctype="multipart/form-data">
		<input type="hidden" name="addevent" id="addevent" value="1" />
		<div class="myevent_box">
	<div class="myevent_left">
	<div class="event_name">
	<div style="float: left; margin: 0 auto;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe.jpg" alt="" width="56" height="58" border="0"/></div>
	<div style="float: right; margin: 0 auto;">
    	<span class="event_fieldbg"><span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding: 4px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">SP</span><input type="text" name="event_name_sp" style="width: 550px; margin:10px 0;" class="event_field" value="Nombre del evento" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue"/></span><br/>
        <span class="event_fieldbg"><span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding: 4px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">EN</span><input type="text" name="event_name_en" class="event_field" value="Event Name" style="width: 546px; margin:10px 0;" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue" /></span>
	  </div>
	</div>
	<div class="clear"></div>
	<div class="event_date">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><h1>Event date - <span>Start</span></h1></td>
          <td>&nbsp;</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span style="color:#FF0000;">DD</span><br /><input type="text" name="event_month_st" id="event_month_st" class="textbg_grey" value="00" style="width: 30px;"/></td>
              <td>/</td>
              <td>MM<br /><input type="text" name="event_day_st" id="event_date_st"  class="textbg_grey" value="00" style="width: 30px;"/></td>
              <td>/</td>
              <td>YY<br /><input type="text" name="event_year_st" id="event_year_st"  class="textbg_grey" value="0000" style="width: 40px;"/><span style="font-size:8px;">MM/DD/YYYY</span></td>
            </tr>
            <tr>
              <td><select name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onchange="changeTime(this.value);">
					  <?php 
                      for($i=0; $i<13; $i++) {
                      ?>
                      <option value="<?php echo $i; ?>" <?PHP if($i==7) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                      <?php }?>
                    </select></td>
              <td>/</td>
              <td><select name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;">
					  <?php 
                      for($j=00; $j<60; $j++) {
                      ?>
                      <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                      <?php }?>
						  
                    </select></td>
              <td>/</td>
              <td><select name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                      <option value="AM">AM</option>
					  <option value="PM" selected="selected">PM</option>
                    </select></td>
              <td></td>
            </tr>
          </table></td>
          <td><span>End</span></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input type="text" name="event_month_end" id="event_month_end" value="00" class="textbg_grey" style="width: 30px;"/></td>
              <td>/</td>
              <td><input type="text" name="event_day_end" id="event_date_end" value="00" class="textbg_grey" style="width: 30px;"/></td>
              <td>/</td>
              <td><input type="text" name="event_year_end" id="event_year_end" value="0000" class="textbg_grey" style="width: 40px;"/></td>
            </tr>
            <tr>
              <td><select name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
					  <?php 
                      for($i=0; $i<13; $i++) {
                      ?>
                      <option value="<?php echo $i; ?>" <?PHP if($i==9) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                      <?php }?>
                    </select></td>
              <td>/</td>
              <td><select name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
					  <?php 
                      for($j=0; $j<60; $j++) {
                      ?>
                      <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                      <?php }?>
                    </select></td>
              <td>/</td>
              <td><select name="event_end_ampm" class="selectbg" id="event_end_ampm" title="Please select event miniute" style="width:50px;float:left;">
                      <option value="AM">AM</option>
					  <option value="PM" selected="selected">PM</option>
                    </select></td>
              <td></td>
              
            </tr>
          </table></td>
        </tr>
      </table>
	</div>
	<div class="clear"></div>
	<div class="event_date">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%"><h1>Venue</h1></td>
          <td width="20%">
		  <select name="venue_state" class="selectbg1" onchange="getCounty(this.value);">
		  <option value="">State</option>
		  <?php
		  $obj_venuestate->getVenueState();
		  while($row = $obj_venuestate->next_record())
		  {
		  ?>
		  <option value="<?php echo $obj_venuestate->f('id');?>"><?php echo $obj_venuestate->f('state_name');?></option>
		  <?php
		  }
		  ?>
		  </select></td>
          <td width="20%"><div id="div_county_display">
		  <select name="venue_county" class="selectbg1">
		  <option value="">County</option>
		  </select></div></td>          
		  <td width="20%"><div id="div_city_display">
		  <select name="venue_city" class="selectbg1">
		  <option value="">City</option>
		  </select></div></td>
		  <td width="20%"><div id="div_venue_display">
		  <select name="venue" class="selectbg1">
		  <option value="">Venue</option>
		  </select></div></td>
        </tr>
      </table>	  
	</div>	
	<div class="clear"></div>
	<div class="event_date" style="float: right; width: 700px;">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
          <td width="79%"><p style="text-align: right; padding-right: 13px;">This event has several identical functions</p></td>
          <td width="21%">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; width: 150px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="several_fun_event" type="radio" value="1"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="several_fun_event" type="radio" value="0" checked="checked"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p style="text-align: right; padding-right: 13px;">This event repeats (is recurring)</p></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC; width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="recurring_event" type="radio" value="1"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="recurring_event" type="radio" value="0" checked="checked"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p style="text-align: right; padding-right: 13px;">This event has a program of different shows or sub-events</p></td>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC;  width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="multi_days_event" type="radio" value="1"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="multi_days_event" type="radio" value="0" checked="checked"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
      </table>
	</div>
	<div class="clear"></div>    
	<div class="event_date">
	<div id="TabbedPanels2" class="TabbedPanels2">
	<ul class="TabbedPanelsTabGroup2">
<!--	<li class="TabbedPanelsTab2" tabindex="3">Text</li>
	<li class="TabbedPanelsTab2" tabindex="2">Visual</li>-->
	<li class="TabbedPanelsTab2" tabindex="1">English</li>  
	<li class="TabbedPanelsTab2" tabindex="0">Espanol</li> 
	<img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0" style="float: right; margin: 0 10px 0 0;"/>	 
	</ul>
	<div class="TabbedPanelsContentGroup2">
	<div class="TabbedPanelsContent2">
	    <textarea name="page_content_en" cols="35" rows="10"></textarea>
		 <?php
          $ckeditor = new CKEditor();
          $ckeditor->basePath = '../ckeditor/';
          $ckfinder = new CKFinder();
          $ckfinder->BasePath = '../ckfinder/'; // Note: BasePath property in CKFinder class starts with capital letter
          $ckfinder->SetupCKEditorObject($ckeditor);
          $ckeditor->replaceAll();
    
         ?>
    </div>
	<div class="TabbedPanelsContent2">
		<textarea name="page_content_sp" cols="35" rows="10"></textarea>
		 <?php
          $ckeditor2 = new CKEditor2();
          $ckeditor2->basePath = '../ckeditor/';
          $ckfinder2 = new CKFinder();
          $ckfinder2->BasePath = '../ckfinder/'; // Note: BasePath property in CKFinder class starts with capital letter
          $ckfinder2->SetupCKEditorObject($ckeditor2);
          $ckeditor2->replaceAll();
         ?>
        </div> 
	</div>
	</div>
    </div>	
    <div class="clear"></div>
	<div class="event_date">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="35%"><h1>Photo</h1></td>
          <td width="65%"><input type="file" name="event_photo" id="event_photo" /></td>
        </tr>
      </table>
	</div>
	<div class="clear"></div>
	<div class="event_date">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="55%"><h1>Enable ticketing for this event<br/><span style="font-size: 20px;">Set tickets, fees & charges</span></h1><a href="#show_popup" id="openPop">&nbsp;</a></td>
          <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; width: 150px; border: 1px solid #CCCCCC; background: #f5f5f5; height:30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="ticket_buy" id="ticket_buy1" type="radio" value="" onclick="openTicket()"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="ticket_buy" id="ticket_buy2" type="radio" value="radiobutton"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
        <tr id="price_payment" style="display:none;">
          <td><p>Price includes payment & Ticketing fee</p></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC; width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="pay_tick_fee" type="radio" value="1" checked="checked"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="pay_tick_fee" type="radio" value="0"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
        <tr id="price_promotion" style="display:none;">
          <td><p>Price includes promotion charges</p></td>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC;  width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="pro_charge" type="radio" value="1" checked="checked"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="pro_charge" type="radio" value="0"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:10px;">You can have multiple and single tickets, where certain tickets become avavilable under certain conditions, e.g early booking, group discounts, maximum bookings per ticket, etc.<br /> Basic Html is allowed in ticket labels and descriptions. </td>
         
        </tr>
      </table>
	</div>
	<div class="clear"></div>
	<div class="event_ticket">
	<div><h1>Payment & Delivery setting</h1></div>
	<div class="clear"></div>
	<div>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td style="text-align:left;"><h2>Allowed Payments</h2></td>
          <td style="text-align:left;"><h2>Allowed Delivery</h2></td>
        </tr>
        <tr>
          <td style="text-align:left;">Paypal/Credit card<br/>Bank Deposit<br/>Costco Payment<br/>Mobile Payment</td>
          <td style="text-align:left;">Paperless QR moble ticket<br/>Print<br/>Will Call</td>
        </tr>
      </table>
	</div>
	</div>
		<div class="clear"></div>
	<div class="event_ticket">
	<div>
	  <h1>Promotion setting</h1>
	</div>
	<div class="clear"></div>
	<div>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="text-align:left;">Spotlight event<br/>Hot event<br/>Promoted event<br/>highlighted event</td>
        </tr>
      </table>
	</div>
	</div>
	<div class="clear"></div>
	<div class="event_ticket">
	<div><h1>Event gallery</h1></div>
	<div class="clear"></div>
	<div>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="text-align:left;">Add media (pictures or video) from your media gallery, your computer, Youtube,Flickr, slideshare</td>
        </tr>
      </table>
	</div>
	</div>	
	</div>
	<div class="myevent_right">
	<!--<div class="inevent_right">
	<ul>
	<li><h1>Publish</h1></li>
	<li style="padding: 4px 0 4px 14px;"><input name="" type="button" class="save_draft" value="Save Draft"/></li>
	<li style="padding: 4px 0 4px 14px;">Status: <strong>Draft</strong> <a href="#">Edit</a></li>
	<li style="padding: 4px 0 4px 14px;"><a href="#">Move to Trash</a><span style="float:right; margin: 0 19px 0 auto; padding: 0;"><input name="" type="button" class="puplish_draft" value="Save Draft"/></span></li>
	</ul>
	</div>
	<div class="clear"></div>-->
	<div class="inevent_right">
	<ul>
	<li><h1>Event Tags</h1></li>
	<li style="padding: 4px 0 4px 14px;"><input name="event_tag" id="event_tag" type="text" class="textfield_add" value="" /><!--<input name="" type="button" class="save_draft" value="Add"/>--></li>
	<!--<li style="padding: 4px 0 4px 14px;">Status: <strong>Draft</strong> <a href="#">Edit</a></li>
	<li style="padding: 4px 0 4px 14px;"><a href="#">Choose from the most used tags</a></li>-->
	</ul>
	</div>
	<div class="clear"></div>
	<div style="width: 280px; float: none; margin: 0 auto;">
	<div class="inevent_right">
	<ul>
	<li><h1>Event Categories</h1></li>	
	</ul>
	</div>
	<div class="clear"></div>
	<div id="TabbedPanels1" class="TabbedPanels">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">All Event Categories</li> 
            <li class="TabbedPanelsTab" tabindex="0"> Most Used</li> 
        </ul>
	<div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
        <ul>
        <?php
        if($objlist->num_rows()){
            while($objlist->next_record()){
        ?>
        <li style=" color:#000;"><input type="checkbox" name="maincat[]" id="maincat" value="<?php echo $objlist->f('category_id');?>"/><?php echo $objlist->f('category_name');?>
        
            <?php
                $obj_subcat->category_sub_list($objlist->f('category_id'));
                if($obj_subcat->num_rows()){
                    while($obj_subcat->next_record()){
             ?>
            <ul>
                <li style="margin: 0 0 0 10px; color:#000;"><input type="checkbox" id="subcat" name="subcat[]" value="<?php echo $obj_subcat->f('category_id');?>"/><?php echo $obj_subcat->f('category_name');?></li>
            </ul>
            <?php
                    }
                }
            ?>
        </li>
        <?php
            }
        }
        ?>
        </ul>
        </div>
        <div class="TabbedPanelsContent">test</div>
	</div>
	</div>
	</div>
	</div>
	<div class="clear"></div>
	</div>
	<div style="float:right;"><input type="submit" name="save" value="Save" class="login_btn" /></div>
	</form>	
    <!-- Pop Up-->    
    <div style="display:none;">
    <div class="event_popup1" id="show_popup">	
	<div class="event_popup5"><h1>Create a new ticket</h1></div>

    <div id="save_create_ticket_display" style="padding-left:10px;">
    <div style=" max-height:95px; overflow:auto;">
    <?php
    	 //Fetch records from temp table
        $obj_temp_tickets->get_temp_tickets($unique_id);
        if($obj_temp_tickets->num_rows()){
            while($obj_temp_tickets->next_record()){
        ?>
               <div style="margin:0 0 10px 0; border-bottom: 1px dotted #666;">
                <div>
                    <span><?php echo $obj_temp_tickets->f('ticket_name_en');?></span><span> USD <?php echo $obj_temp_tickets->f('price_us');?></span> 
                    <span style="margin-right:25px; float:right; cursor:pointer;" onclick="deleteTemp(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span>
                </div>
                <div>
                    <span><?php echo $obj_temp_tickets->f('ticket_name_sp');?></span> <span> MXP <?php echo $obj_temp_tickets->f('price_mx');?></span> 
                    <span style="margin-right:25px; float:right;cursor:pointer;" onclick="deleteTemp(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onclick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span> 
                </div>
            </div>

         <?php
            }
        }
         ?>
         </div>
    </div>
	
      <div class="clear"></div>
        <form method="post" name="ticket_form" id="ticket_form" enctype="multipart/form-data">
          <input type="hidden" name="photoname" id="photoname" value="" />
          <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
          <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><input type="text" name="ticket_name_en" id="ticket_name_en" class="event_field ticket_common_class" value="Name" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" /></td>
           </tr>
           <tr>
             <td><input type="text" name="ticket_name_sp" id="ticket_name_sp" class="event_field ticket_common_class" value="Nombre" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" /></td>
           </tr>
           <tr>
             <td><textarea name="description_en" id="description_en" class="textareabg ticket_common_class" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue">Description</textarea></td>
           </tr>
           <tr>
             <td><textarea name="description_sp" id="description_sp" class="textareabg ticket_common_class" onclick="if(this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue">Descripción</textarea></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <th>Price MX pesos</th>
                 <td><input type="text" name="price_mx" id="price_mx" class="inputbg ticket_common_class" /></td>
               </tr>
               <tr>
                 <th>Price US dollars</th>
                 <td><input type="text" name="price_us" id="price_us" class="inputbg ticket_common_class" /></td>
               </tr>
               <tr>
                 <th>Number of Available tickets</th>
                 <td><input type="text" name="ticket_num" id="ticket_num" class="inputbg ticket_common_class" /></td>
               </tr>
               <tr>
                 <th colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <th width="11%">From </th>
                     <td width="42%"><input type="text" name="from_ticket" id="from_ticket" class="inputbg1 ticket_common_class" /></td>
                     <th width="6%">To</th>
                     <td width="41%"><input type="text" name="to_ticket" id="to_ticket" class="inputbg1 ticket_common_class" /></td>
                   </tr>
                 </table></th>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="36%"><strong>Early bird discount</strong></td>
                 <td width="22%"><input type="text" name="eairly_dis_percen" id="eairly_dis_percen" class="inputbg2 ticket_common_class" /></td>
                 <td width="17%"><strong>% up to</strong></td>
                 <td width="13%"><input type="text" name="eairly_days" id="eairly_days" class="inputbg2 ticket_common_class" /></td>
                 <td width="12%"><p><strong>Days</strong></td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="2"> <strong>before the event</strong></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="36%"><strong>Group Discount</strong></td>
                 <td width="22%"><input type="text" name="group_dis_per" id="group_dis_per" class="inputbg2 ticket_common_class" /></td>
                 <td width="17%"><strong> % over</strong></td>
                 <td width="13%"><input type="text" name="group_dis_days" id="group_dis_days" class="inputbg2 ticket_common_class" /></td>
                 <td width="12%"><p><strong>Tickets</strong></p></td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="3"><strong> Members only</strong><input type="radio" name="members_only" id="members_only1" value="Y" /> Yes&nbsp;&nbsp;<input type="radio" name="members_only" id="members_only2" checked="checked" value="N" /> No</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td>TICKET ICON </td>
                 <td>
                    <!--<input type="file" name="ticket_icon" id="ticket_icon" />-->
                        <div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon</span></span></div><span id="mestatus" ></span>
                 </td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><input type="button" name="Submit2" value="Save & Create a new ticket" class="createbtn"  onclick="save_new_popup()"/></td>
                 <td><input type="button" name="Submit2" value="Save & Exit" class="createbtn" onclick="closePopUp()"/></td>
               </tr>
             </table></td>
           </tr>       
         </table>
        </form>
	  </div>
    </div>
<div class="clear"></div>
			
<!------------------------------------------------------------------------- -->      	
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
 </div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</script>
<script type="text/javascript">
<!--
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
//-->
</script>
</body>
</html>
