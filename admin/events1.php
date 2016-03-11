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
$obj_temp_tickets_call = new admin;
//$test = new admin;

//echo "aa".$a = $test->chkExistSavedcat(2,5);

$objlist->category_list();
//$objlist_most_used->most_used_category();

//$unique_id = session_id();


if(isset($_POST['addevent']) && $_POST['addevent'] == '1')	
{
	
	//$finalArray = array_merge($_POST['maincat'],$_POST['subcat']);
	$finalArray = $_POST['maincat'];
	
	$event_name_sp = addslashes($_POST['event_name_sp']);
	$event_name_en = addslashes($_POST['event_name_en']);
	if($_POST['event_start_ampm'] == 'PM')
	{
	    $event_start_hour = $_POST['event_hr_st']+12;
	}
	else
	{
	    $event_start_hour = $_POST['event_hr_st'];
	}
	$event_start_date_time = $_POST['event_year_st']."-".$_POST['event_month_st']."-".$_POST['event_day_st']." ".$event_start_hour."-".$_POST['event_min_st']."-00";
	$event_start_ampm = $_POST['event_start_ampm'];
	if($_POST['event_end_ampm'] == 'PM')
	{
	    $event_end_hour = $_POST['event_hr_end']+12;
	}
	else
	{
	    $event_end_hour = $_POST['event_hr_end'];
	}
	$event_end_date_time = $_POST['event_year_end']."-".$_POST['event_month_end']."-".$_POST['event_day_end']." ".$event_end_hour."-".$_POST['event_min_end']."-00";
	$event_end_ampm = $_POST['event_end_ampm'];
	$venue_state = addslashes($_POST['venue_state']);
	$venue_county = addslashes($_POST['venue_county']);
	$venue_city = addslashes($_POST['venue_city']);
	$venue = addslashes($_POST['venue']);
	$page_content_en = addslashes($_POST['page_content_en']);
	$page_content_sp = addslashes($_POST['page_content_sp']);
	$event_tag = addslashes($_POST['event_tag']);
	
	$event_day_st=$_POST['event_day_st'];
	$event_year_st=$_POST['event_year_st'];
	$event_month_st=$_POST['event_month_st'];
	
	$event_year_end=$_POST['event_year_end'];
	$event_month_end=$_POST['event_month_end'];
	$event_day_end=$_POST['event_day_end'];
	$file_name = $_POST['event_photo'];
	
	$identical_function = $_POST['identical_function'];
	$recurring = $_POST['recurring'];
	$sub_events = $_POST['sub_events'];
	
	$fetch_temp_tickets_num=$obj_temp_tickets_call->fetch_temp_tickets($_SESSION['unique_id']);
	if(($fetch_temp_tickets_num!=0 && $_POST['ticket_buy']==1) || $_POST['ticket_buy']==0)
	{
		
		/*if($_FILES['event_photo']['name']!="")
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
		}*/
		
		// Add Event
		$last_event_id = $obj_add->addEvent($event_name_sp,$event_name_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events);
		
		// Add category Event
		$obj_add_category_by_event->addCategoryByEvent($finalArray,$last_event_id);
		
		// Add Event Tickets
		$obj_add_ticket->addFinalTicket($_SESSION['unique_id']);
		
		// Update event Id
		$obj_edit_ticket->editTicketByEvent($_SESSION['unique_id'],$last_event_id);
	
		// Delete Temp Event
		$obj_delete->deleteTicket($_SESSION['unique_id']);
	
		$_SESSION['msg'] = "Event created successfully";
		header("Location:".$obj_base_path->base_path()."/admin/events");
		exit;
	}
	else
	{
		$msg="You must add tickets!!!";
	}
	
}
else
{
	$_SESSION['unique_id'] = rand();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Post Event</title>
	
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
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js"></script>
<!-- Ajax File Upload -->


<script type="text/javascript">
//calendar
$(document).ready(function() {
	$('#event_month_st').datepicker({
		firstDay: 1 ,	
		showButtonPanel: true,
    	onSelect:function(theDate) 
		{
			$('#event_date_end').datepicker('option', 'defaultDate', theDate);
			$('#event_month_end').datepicker('option', 'defaultDate', theDate);
			$('#event_year_end').datepicker('option', 'defaultDate', theDate);
			
			var n=theDate.split("/");
			$("input[name='event_month_st']").val(n[0]);
			$("input[name='event_day_st']").val(n[1]);
			$("input[name='event_year_st']").val(n[2]);
			
			$('#event_month_end').val(n[0]);
			$('#event_date_end').val(n[1]);
			$('#event_year_end').val(n[2]);
			
			saveAutoEvent();
		}
	});
	
	$('#event_date_st').datepicker({
		firstDay: 1 ,	   
		showButtonPanel: true,
		onSelect: function(theDate) 
		{
           			
			$('#event_date_end').datepicker('option', 'defaultDate', theDate);
			$('#event_month_end').datepicker('option', 'defaultDate', theDate);	
			$('#event_year_end').datepicker('option', 'defaultDate', theDate);
				
			var n=theDate.split("/");
			$("input[name='event_month_st']").val(n[0]);
			$("input[name='event_day_st']").val(n[1]);
			$("input[name='event_year_st']").val(n[2]);
			
			$('#event_month_end').val(n[0]);
			$('#event_date_end').val(n[1]);
			$('#event_year_end').val(n[2]);
			saveAutoEvent();
        }
		
	});
	
	$('#event_year_st').datepicker({
		firstDay: 1 ,	
		showButtonPanel: true,
   		onSelect:function(theDate) 
		{
				$('#event_date_end').datepicker('option', 'defaultDate', theDate);
				$('#event_month_end').datepicker('option', 'defaultDate', theDate);
				$('#event_year_end').datepicker('option', 'defaultDate', theDate);
				
				var n=theDate.split("/");
				$("input[name='event_month_st']").val(n[0]);
				$("input[name='event_day_st']").val(n[1]);
				$("input[name='event_year_st']").val(n[2]);
				
				$('#event_month_end').val(n[0]);
				$('#event_date_end').val(n[1]);
				$('#event_year_end').val(n[2]);
				saveAutoEvent();
		}
	});
	
	$('#event_month_end').datepicker({
		firstDay: 1 ,	
		showButtonPanel: true,
		beforeShow:function (textbox) 
		{
          setTimeout(function () 
          {
           $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
          }, 300);
        },
    	onSelect:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_end']").val(n[0]);
		$("input[name='event_day_end']").val(n[1]);
		$("input[name='event_year_end']").val(n[2]);
		saveAutoEvent();
		}
	});
	
	$('#event_date_end').datepicker({
		firstDay: 1 ,	
		showButtonPanel: true,
		beforeShow:function (textbox) 
		{
          setTimeout(function () 
          {
           $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
          }, 300);
        },
    	onSelect:function(theDate) 
		{
			var n=theDate.split("/");
			$("input[name='event_month_end']").val(n[0]);
			$("input[name='event_day_end']").val(n[1]);
			$("input[name='event_year_end']").val(n[2]);	
			saveAutoEvent();		
				
		}
	});
	
	
	$('#event_year_end').datepicker({
		firstDay: 1 ,	
		showButtonPanel: true,
		beforeShow:function (textbox) 
		{
          setTimeout(function () 
          {
           $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
          }, 300);
        },
   		onSelect:function(theDate) {
		var n=theDate.split("/");
		$("input[name='event_month_end']").val(n[0]);
		$("input[name='event_day_end']").val(n[1]);
		$("input[name='event_year_end']").val(n[2]);
		saveAutoEvent();
		}
	});
	
	
	
	
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
	if(document.getElementById("ticket_buy2").checked)
	{
		$('#price_payment').hide();
		$('#price_promotion').hide();
	}

}
$(document).ready(function() {
	$("#openPop").fancybox({ 
	 "onComplete": function () {
	 var a = $('#event_date_st').val();
	 var b = $('#event_month_st').val();
	 var c = $('#event_year_st').val();
	 var ticket_end_date = a+"/"+b+"/"+c;
	 if(ticket_end_date == '0/0/0')
	 {
	   var ticket_end_date_display = '';
	 }
	 else
	 {
	   var ticket_end_date_display = ticket_end_date;
	 }
	 $("#to_ticket").val(ticket_end_date_display)
	 },
	'hideOnOverlayClick':false,
    'hideOnContentClick':false
	});
});

function closePopUp()
{
	var checkValue = save_new_popup();
	if(checkValue)
	setTimeout("$('#fancybox-close').trigger('click')",3000);
}
function save_new_popup()
{
	if(!checkticketReg())
	{
		return 0;
	}
	else{
		
		 var ticketVal = $("#ticket_form").serialize();
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_temp_tickets.php",
		  // async: false,
		   cache: false,
		   type: "POST",
		   data: ticketVal,   
		   success: function(data){ 
			 $(".ticket_common_class").val('');
			 $("#imgid").val('');
//			 $("#divticketimage").html('<div id="me2" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon7</span></span></div><span id="mestatus2"></span><br /><span id="imgid">');
			 $('#edit_ticket').val(0);
			 $("#save_create_ticket_display").html(data);
			 
			 // Place the placeholder
			 $("#ticket_name_sp").val("Nombre");
			 $("#ticket_name_en").val("Name");
			 $("#description_sp").val("Descripción");
			 $("#description_en").val("Description");
			 
			$('html, body').animate({scrollTop: $("#show_popup").offset().top}, 2000);
		   }
		 });
		 return 1;
	}
}
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
	   saveAutoEvent();
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
	   saveAutoEvent();
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
	   saveAutoEvent();
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
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/upload_ticket.php',
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
				$('#imgid').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/thumb/'+response+'" />')
				$('#me').html('');
				
				//On completion clear the status
			}
		});
		
	});
	
	
$(function(){
		var btnUpload=$('#me1');
		var mestatus=$('#mestatus1');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadPhotoEdit.php',
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
				$('#event_photo').val(response);
				$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/'+response+'" alt="" />');
				$('#me1').html('');
				saveAutoEvent();
				
				//On completion clear the status
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


function saveAutoEvent()
{
	//  check something is written in event page..
	
		$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_event.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: $("#event_form").serialize(),   
	   success: function(data){ 
	     //alert(data);
	   }
	 });
}

/*window.setInterval(function(){
saveAutoEvent()
}, 5000);*/



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


$(document).ready(function() {
	$('#from_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
	$('#to_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
})
</script>


<script type="text/javascript">

function checkReg()
{
	if($("#event_name_sp").val()=="" || $("#event_name_sp").val()=="Nombre del evento")
	{
		alert("Please Enter Event name.");
		$("#event_name_sp").focus();
		return false;
	}
	if($("#event_name_en").val()=="" || $("#event_name_en").val()=="Event Name")
	{
		alert("Please Enter Event name.");
		$("#event_name_en").focus();
		return false;
	}
	if($("#event_date_st").val()=="" || $("#event_date_st").val()=="0")
	{
		alert("Please Enter Event Date.");
		$("#event_date_st").focus();
		return false;
	}
	if($("#venue").val()=="")
	{
		alert("Please Choose Venue.");
		$("#venue").focus();
		return false;
	}
	
	 return true;
}
function checkticketReg()
{
	$('#shw_num_avail').html("");
	$('#sp_name_err').html("");
	$('#en_name_err').html("");
	$('#shw_frm_ticket').html("");
	$('#shw_to_ticket').html("");
	
	
	if($('#ticket_name_sp').val()=="" || $('#ticket_name_sp').val()=="Nombre")
	{
		$('#ticket_name_sp').css("border", "1px solid #FF0000");
		$('#sp_name_err').html("Please Insert name of tickets in Spanish.");
		$('#ticket_name_sp').focus();
		return false;
	}
	else if($('#ticket_name_en').val()=="" || $('#ticket_name_en').val()=="Name")
	{
		$('#ticket_name_en').css("border", "1px solid #FF0000");
		$('#en_name_err').html("Please Insert name of tickets in English.");
		$('#ticket_name_en').focus();
		return false;
	}
	else if($('#ticket_num').val()=="" || $('#ticket_num').val()=="0")
	{
		$('#ticket_num').css("border", "1px solid #FF0000");
		$('#shw_num_avail').html("Please Insert number of tickets.");
		$('#ticket_num').focus();
		return false;
	}
	else if($('#from_ticket').val()=="")
	{
		$('#from_ticket').css("border", "1px solid #FF0000");
		//$('#shw_frm_ticket').html("Please Insert From Date.");
		$('#from_ticket').focus();
		return false;
	}
	else if($('#to_ticket').val()=="")
	{
		$('#to_ticket').css("border", "1px solid #FF0000");
		//$('#shw_to_ticket').html("Please Insert To Date.");
		$('#to_ticket').focus();
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

<style>
.event_popup1 td {
	padding: 5px;
	line-height: 22px;
}
.event_popup1 th {
	padding: 5px 15px;
}
textarea.textareabg {
	margin: 0;
}
form table {
	padding: 0;
	margin: 0 auto;
}
input.createbtn {
	padding: 0 20px;
	margin: 10px 0 0 0;
}
p {
	margin: 0;
}
</style>

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
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events" class="here">Create</a></li>
               <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list">List/edit</a></li>
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
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
        <strong><?php echo $msg;?>		
		</strong></div>	
	<?php
	}?>	
		
    <form action="" method="post" name="event_form" id="event_form" enctype="multipart/form-data" onSubmit="return checkReg()">
    <input type="hidden" name="addevent" id="addevent" value="1" />
    <div class="myevent_box">
    <div class="myevent_left">
    <div class="event_name">
    <div style="float: left; margin: 0 auto;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe.jpg" alt="" width="56" height="58" border="0"/></div>
    <div style="float: right; margin: 0 auto;">
    <span class="event_fieldbg">
	
	<span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">SP</span>
	<input type="text" name="event_name_sp" id="event_name_sp" style="width: 550px; margin:10px 0;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Nombre del evento";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="saveAutoEvent()"/>
	</span>
	<br/>
    <span class="event_fieldbg"><span style="background: #FFFFFF; color: #FF0000; margin: 8px 0 0 0; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;">EN</span>
	<input type="text" name="event_name_en" id="event_name_en" class="event_field" value="<?php if($msg!="" && $event_name_en!=""){echo $event_name_en;}else{echo "Event Name";}?>" style="width: 546px; margin:10px 0;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" onkeyup="saveAutoEvent()"/>
	</span>
	
    </div>
    </div>
    <div class="clear"></div>
    <div class="event_date">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><h1 style="padding: 35px 0 0 10px;">Date</h1></td>
      <td><h1 style="padding: 35px 0 0 10px;">Starts</h1></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>YYYY</strong></td>
        </tr>
        <tr>
          <td><input type="text" name="event_day_st" id="event_date_st" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo 00;}?>"  class="textbg_grey"  style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_month_st" id="event_month_st" value="<?php if($msg!="" && $event_month_st!=""){echo $event_month_st;}else{echo 00;}?>" class="textbg_grey"  style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_year_st" id="event_year_st"  value="<?php if($msg!="" && $event_year_st!=""){echo $event_year_st;}else{echo 0000;}?>" class="textbg_grey"  style="width: 40px;"/></td>
          <td></td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onChange="changeTime(this.value);">
            <?php 
                  for($i=0; $i<13; $i++) {
                  ?>
            <option value="<?php echo $i; ?>" <?PHP if($i==7) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
            <?php }?>
          </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
          <td style="padding: 9px 0;"><select name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=00; $j<60; $j++) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>
                      
                </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
          <td style="padding: 9px 0;"><select name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                  <option value="AM">AM</option>
                  <option value="PM" selected="selected">PM</option>
                </select></td>
          <td style="padding: 9px 0;"></td>
        </tr>
      </table></td>
      <td><h1 style="padding: 35px 0 0 10px;">Ends</h1></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 20px 0 0 0;">
        <tr>
          <td><input type="text" name="event_day_end" id="event_date_end" value="<?php if($msg!="" && $event_day_end!=""){echo $event_day_end;}else{echo 00;}?>" class="textbg_grey" style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_month_end" id="event_month_end" value="<?php if($msg!="" && $event_month_end!=""){echo $event_month_end;}else{echo 00;}?>"  class="textbg_grey" style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_year_end" id="event_year_end" value="<?php if($msg!="" && $event_year_end!=""){echo $event_year_end;}else{echo 0000;}?>"  class="textbg_grey" style="width: 40px;"/></td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                  <?php 
                  for($i=0; $i<13; $i++) {
                  ?>
                  <option value="<?php echo $i; ?>" <?PHP if($i==9) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=0; $j<60; $j++) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_end_ampm" class="selectbg" id="event_end_ampm" title="Please select event miniute" style="width:50px;float:left;">
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
      <td width="12%"><h1>Venue</h1></td>
      <td width="22%">
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
		  </div>
	  </td>          
      <td width="22%">
		  <div id="div_city_display">
		  <select name="venue_city" class="selectbg12">
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
		  </div>
	  </td>
      <td width="22%">
		  <div id="div_venue_display">
		  <select name="venue" id="venue" class="selectbg12">
		  <option value="">Venue</option>
		   <?php
		  if($msg!="")
		  {
		        $obj_getvenue = new admin;
			    $obj_getvenue->getVenueNameByCity($venue_city);
                while($obj_getvenue->next_record())
				{
				?>
				<option value=<?php echo $obj_getvenue->f("venue_id")?> <?php if($venue==$obj_getvenue->f('venue_id')){?> selected="selected"<?php }?> >
				<?php echo $obj_getvenue->f('venue_name')?></option>
				<?php
				}
		  }
		  ?>
		  </select>
		  </div>
	  </td>
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
          <td width="3%" align="center" valign="middle" style="padding: 4px;">
		  <input name="identical_function" type="radio" value="1" <?php  if($msg!="" && $_POST['identical_function']==1){?> checked="checked"<?php }?>/>
		  </td>
          <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
          <td width="4%" align="center" valign="middle" style="padding: 4px;">
		  <input name="identical_function" type="radio" value="0" <?php  if($msg!="" && $_POST['identical_function']==0){?> checked="checked"<?php }?>/>
		  </td>
          <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><p style="text-align: right; padding-right: 13px;">This event repeats (is recurring)</p></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC; width: 150px; background: #f5f5f5; height: 30px;">
        <tr>
          <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="recurring" type="radio" value="1" <?php  if($msg!="" && $_POST['recurring']==1){?> checked="checked"<?php }?>/></td>
          <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
          <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="recurring" type="radio" value="0" <?php  if($msg!="" && $_POST['recurring']==0){?> checked="checked"<?php }?>/></td>
          <td width="87%" align="center" valign="middle" style="padding: 4px;">No</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><p style="text-align: right; padding-right: 13px;">This event has a program of different shows or sub-events</p></td>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC;  width: 150px; background: #f5f5f5; height: 30px;">
        <tr>
          <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="1" <?php  if($msg!="" && $_POST['sub_events']==1){?> checked="checked"<?php }?>/></td>
          <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
          <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="0"  <?php  if($msg!="" && $_POST['sub_events']==0){?> checked="checked"<?php }?>/></td>
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
        <li class="TabbedPanelsTab2" tabindex="1">Espanol</li>  
        <li class="TabbedPanelsTab2" tabindex="0">English</li> 
        <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0" style="float: right; margin: 0 10px 0 0;"/>	 
    </ul>
    <div class="TabbedPanelsContentGroup2">
    <div class="TabbedPanelsContent2">
    <textarea name="page_content_sp" cols="35" rows="10" onkeyup="saveAutoEvent()"><?php if($msg!="" && $page_content_sp!=""){echo $page_content_sp;}?></textarea>
     <?php
     /* $ckeditor = new CKEditor();
      $ckeditor->basePath = '../ckeditor/';
      $ckfinder = new CKFinder();
      $ckfinder->BasePath = '../ckfinder/'; // Note: BasePath property in CKFinder class starts with capital letter
      $ckfinder->SetupCKEditorObject($ckeditor);
      $ckeditor->replaceAll();*/
    
     ?>
    </div>
    <div class="TabbedPanelsContent2">
    <textarea name="page_content_en" cols="35" rows="10" onkeyup="saveAutoEvent()"><?php if($msg!="" && $page_content_en!=""){echo $page_content_en;}?></textarea>
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
      <td width="65%">
      <?php if(!$_POST['event_photo']){ ?>
      	<div id="me1" class="styleall" style=" cursor:pointer; border:0px solid red; width:270px;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Event Thumbnail</span></span></div><span id="mestatus1"></span>
        <?php } else { ?>
        <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['event_photo']; ?>" alt="" />
		<?php }  ?>
      <span id="imgshow"></span>
      <input type="hidden" name="event_photo" id="event_photo" value="<?php if($_POST['event_photo']){ echo $_POST['event_photo']; }?>" /></td>
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
          <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="ticket_buy" id="ticket_buy1" type="radio" value="1" <?php if($_POST['ticket_buy']==1){?> checked="checked"<?php } ?> onClick="openTicket()"/></td>
          <td width="6%" align="center" valign="middle" style="padding: 4px;">Yes</td>
          <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="ticket_buy" id="ticket_buy2" type="radio" value="0" <?php if($_POST['ticket_buy']==0 || !isset($_POST['ticket_buy'])){?> checked="checked"<?php } ?> onClick="openTicket()"/></td>
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
    <li style=" color:#000;"><input type="checkbox" name="maincat[]" value="<?php echo $objlist->f('category_id');?>" onclick="saveAutoEvent()"/><?php echo $objlist->f('category_name');?>
    
        <?php
            $obj_subcat->category_sub_list($objlist->f('category_id'));
            if($obj_subcat->num_rows()){
                while($obj_subcat->next_record()){
         ?>
        <ul>
            <li style="margin: 0 0 0 10px; color:#000;"><input type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" onclick="saveAutoEvent()"/><?php echo $obj_subcat->f('category_name');?></li>
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
    <div class="event_popup1" id="show_popup" style="width:650px;">	
    <div class="event_popup5"  style="width:650px;"><h1>Ticket management form</h1></div>
    
    <div id="save_create_ticket_display" style="padding-left:10px;">
    <div style=" max-height:95px; overflow:auto;">
    <?php
     //Fetch records from temp table
    $obj_temp_tickets->get_temp_tickets($_SESSION['unique_id']);
    if($obj_temp_tickets->num_rows()){
        while($obj_temp_tickets->next_record()){
    ?>
           <div style="margin:0 0 10px 0; border-bottom: 1px dotted #666;">
            <div>
                <span><?php echo $obj_temp_tickets->f('ticket_name_en');?></span><span> USD <?php echo $obj_temp_tickets->f('price_us');?></span> 
                <span style="margin-right:25px; float:right; cursor:pointer;" onClick="deleteTemp(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onClick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span>
            </div>
            <div>
                <span><?php echo $obj_temp_tickets->f('ticket_name_sp');?></span> <span> MXP <?php echo $obj_temp_tickets->f('price_mx');?></span> 
                <span style="margin-right:25px; float:right;cursor:pointer;" onClick="deleteTemp(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onClick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span> 
            </div>
        </div>
    
     <?php
        }
    }
     ?>
     </div>
    </div>
    
    <div class="clear"></div>
    <form method="post" name="ticket_form" id="ticket_form" enctype="multipart/form-data" onsubmit="return checkticketReg()">
      <input type="hidden" name="photoname" id="photoname" value="" />
      <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
      <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #bbb; margin: 15px auto 0 auto;">
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><input type="text" name="ticket_name_sp" id="ticket_name_sp" value="Nombre" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" class="inputbg ticket_common_class" />
         <div style="color:red; margin:0 4px;" id="sp_name_err"></div>
         </td>
       </tr>
       <tr>
         <td>
            <div style="width: 184px; float: left;"><span class="tit">EN</span></div><input type="text" name="ticket_name_en" id="ticket_name_en" value="Name" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" class="inputbg ticket_common_class" />
         <div style="color:red; margin:0 4px;" id="en_name_err"></div>
            </td>
       </tr>
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><textarea name="description_sp" id="description_sp" class="textareabg ticket_common_class" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Descripción</textarea></td>
       </tr>
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">EN</span></div><textarea name="description_en" id="description_en" class="textareabg ticket_common_class" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Description</textarea></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <th style=" width: 149px;">Price MX pesos</th>
             <td><input type="text" name="price_mx" id="price_mx" class="inputbg ticket_common_class" onblur="checDecimal('price_mx','shw_price_mx')"  /><span style="color:red; margin:0 4px;" id="shw_price_mx">&nbsp;</span></td>
           </tr>
           <tr>
             <th>Price US dollars</th>
             <td><input type="text" name="price_us" id="price_us" class="inputbg ticket_common_class" onblur="checDecimal('price_us','shw_price_us')" /><span style="color:red; margin:0 4px;" id="shw_price_us">&nbsp;</span></td>
           </tr>
           <tr>
             <th>Number of Available tickets </th>
             <td><input type="text" name="ticket_num" id="ticket_num" class="inputbg ticket_common_class" onblur="checkInt('ticket_num','shw_num_avail')" /><span style="color:red; margin:0 4px;" id="shw_num_avail">&nbsp;</span></td>
           </tr>
           <tr>
             <th colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <th width="24%">From </th>
                 <td width="28%"><input type="text" name="from_ticket" id="from_ticket" class="inputbg1 ticket_common_class"  /><span style="color:red; margin:0 4px;" id="shw_frm_ticket">&nbsp;</span></td>
                 <th width="6%">To</th>
                 <td width="30%"><input type="text" name="to_ticket" id="to_ticket" class="inputbg1 ticket_common_class"  /><span style="color:red; margin:0 4px;" id="shw_to_ticket">&nbsp;</span></td>
               </tr>
             </table></th>
             </tr>
         </table></td>
       </tr>
       
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="25%"  style="text-align:right;padding: 5px 15px;"><strong>Early bird discount</strong></td>
             <td width="12%"><input type="text" name="eairly_dis_percen" id="eairly_dis_percen" class="inputbg2 ticket_common_class" /></td>
             <td width="10%"><strong>% up to</strong></td>
             <td width="12%"><input type="text" name="eairly_days" id="eairly_days" class="inputbg2 ticket_common_class" /></td>
             <td width="30%"><p><strong>Days before the event</strong></td>
           </tr>
           
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="25%"  style="text-align:right;padding: 5px 15px;"><strong>Group Discount</strong></td>
             <td width="12%"><input type="text" name="group_dis_per" id="group_dis_per" class="inputbg2 ticket_common_class" /></td>
             <td width="10%"><strong> % over</strong></td>
             <td width="12%"><input type="text" name="group_dis_days" id="group_dis_days" class="inputbg2 ticket_common_class" /></td>
             <td width="30%"><p><strong>Tickets</strong></p></td>
           </tr>
           <tr>
             <td colspan="5"><div style="float:left; margin:0 20px;width:135px;font-weight:bold; text-align:right;">Members only</div><input type="radio" name="members_only" id="members_only1" value="Y" /> Yes&nbsp;&nbsp;<input type="radio" name="members_only" id="members_only2" value="N" /> No</td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="27%" style="text-align:right;padding: 5px 15px;"><strong>Ticket Icon</strong></td>
             <td>
             	<div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon</span></span></div><span id="mestatus"></span><br /><span id="imgid"></span>
             </td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><input type="button" name="Submit2" value="Save & Create a new ticket" class="createbtn"  onclick="save_new_popup()"/></td>
             <td><input type="button" name="Submit2" value="Save & Exit" class="createbtn" onClick="closePopUp()"/></td>
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
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
