<?php
session_start();
include('../include/admin_inc.php');

//create object
$obj=new event;
$objlist=new event;
$objlist_num = new event;


//create object
$objlist_cat=new event;
$obj_subcat=new event;
$obj_venuestate=new event;
$obj_venuecounty=new event;
$obj_venuecity=new event;
$obj_venue=new event;
$obj_add=new event;
$obj_add_ticket=new event;
$obj_edit_ticket=new event;
$obj_delete=new event;
$obj_add_category_by_event=new event;
$obj_max_subevent = new event;

$obj_thumb = new event;
$obj_temp_tickets = new event;
$obj_temp_tickets_call = new event;
$obj_multi = new event;
$obj_dup_event_master_type = new event;
$obj_add_eventtype = new event;
$obj_get_event_id = new event;
$obj_get_sub_event_id = new event;
$obj_duplicate = new event;
$obj_ticket = new event;
$obj_parent = new event;

$objlistMaintype = new admin;
$objlistMaincat = new admin;

$objdupcat = new admin;
$objduptype = new admin;
$obj_eve_tic = new admin;
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
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js" ></script>

<!-- Ajax File Upload -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
<!-- Ajax File Upload -->
<?php
// Get Parent Event
//$obj_parent->get_event_by_id($_GET['event_id']);
$obj_parent->get_event_id($_SESSION['unique_id']);
$obj_parent->next_record();

// Event ticket parameter Set
$obj_eve_tic->allTicketListCount($obj_parent->f('event_id'));
if($obj_eve_tic->num_rows()){
	$radio_access = 2;
}
else
	$radio_access = 0;
//echo $radio_access."sss";	
 
//Event Date Time
$event_start_date_time = $obj_parent->f('event_start_date_time');
list($start_eve_dt,$start_eve_tm) = explode(" ",$event_start_date_time);
list($st_eve_yr,$st_eve_mn,$st_eve_dy) = explode("-",$start_eve_dt);

// Time
list($st_eve_hr,$st_eve_min,$st_eve_sec) = explode(":",$start_eve_tm);
$st_eve_hr = (int)$st_eve_hr;
$st_eve_min = (int)$st_eve_min;

$event_end_date_time = $obj_parent->f('event_end_date_time');
list($end_eve_dt,$end_eve_tm) = explode(" ",$event_end_date_time);
list($end_eve_yr,$end_eve_mn,$end_eve_dy) = explode("-",$end_eve_dt);

// Get Last Sub_event
$obj_max_subevent->getLastSubEv($obj_parent->f('event_id'));
$obj_max_subevent->next_record();
if($obj_max_subevent->num_rows()){
	//Sub Event Date Time
	$event_start_date_time = $obj_max_subevent->f('event_start_date_time');
	list($start_eve_dt,$start_eve_tm) = explode(" ",$event_start_date_time);
	list($st_eve_yr,$st_eve_mn,$st_eve_dy) = explode("-",$start_eve_dt);
	
	$event_end_date_time = $obj_max_subevent->f('event_end_date_time');
	list($end_eve_dt,$end_eve_tm) = explode(" ",$event_end_date_time);
	list($end_eve_yr,$end_eve_mn,$end_eve_dy) = explode("-",$end_eve_dt);
}


// Getparent Event Types
$objlistMaintype->eventTypeBYEventId($obj_parent->f('event_id'));
$arrTypecat = array();
if($objlistMaintype->num_rows())
{
   while($objlistMaintype->next_record())
   {
	   $arrTypecat[] = $objlistMaintype->f('event_master_type_id');
   }
}

// Get parent Event Categories

$objlistMaincat->categorylistByEvent($obj_parent->f('event_id'));
$arrMaincat = array();
if($objlistMaincat->num_rows())
{
   while($objlistMaincat->next_record())
   {
	   $arrMaincat[] = $objlistMaincat->f('category_id');
   }
}


$obj_dup_event_master_type->getEventTypeMster();
$chk = "checked='checked'";
$objlist_cat->category_list();

if($_SESSION['type'] == 'duplicate')
{
	$obj_duplicate->get_sub_event_id($_SESSION['unique_id_subevent']);
	$obj_duplicate->next_record();
	//echo 1;exit;
	
	$event_id = $obj_duplicate->f('event_id');
	$event_name_sp = $obj_duplicate->f('event_name_sp');
	$short_desc_sp = $obj_duplicate->f('event_short_desc_sp');
	$event_name_en = $obj_duplicate->f('event_name_en');
	$short_desc_en = $obj_duplicate->f('event_short_desc_en');
	$arr = explode(" ",$obj_duplicate->f('event_start_date_time'));
	$arr1 = explode("-",$arr[0]);
	$event_day_st = $arr1[2];
	$event_month_st = $arr1[1];
	$event_year_st = $arr1[0];
	$brr = explode(" ",$obj_duplicate->f('event_end_date_time'));
	$brr1 = explode("-",$brr[0]);
	$event_day_end = $brr1[2];
	$event_month_end = $brr1[1];
	$event_year_end = $brr1[0];
	$venue_state = $obj_duplicate->f('event_venue_state');
	$venue_county = $obj_duplicate->f('event_venue_county');
	$venue_city = $obj_duplicate->f('event_venue_city');
	$venue = $obj_duplicate->f('event_venue');
	$page_content_sp = $obj_duplicate->f('event_details_sp');
	$page_content_en = $obj_duplicate->f('event_details_en');
	$public_privacy = $obj_duplicate->f('public_privacy');
	$private_privacy = $obj_duplicate->f('private_privacy');
	$attendees_share = $obj_duplicate->f('attendees_share');
	$attendees_invitation = $obj_duplicate->f('attendees_invitation');
	$password_protect = $obj_duplicate->f('password_protect');
	$password_protect_text = $obj_duplicate->f('password_protect_text');
	
	/*$obj_ticket->get_sub_event_ticket($_SESSION['tid']);
	$obj_ticket->next_record();
	$ticket_name_en = $obj_ticket->f('ticket_name_en');
	$ticket_name_sp = $obj_ticket->f('ticket_name_sp');
	$description_en = $obj_ticket->f('description_en');
	$description_sp = $obj_ticket->f('description_sp');
	$price_mx = $obj_ticket->f('price_mx');
	$price_us = $obj_ticket->f('price_us');
	$ticket_num = $obj_ticket->f('ticket_num');
	$from_ticket = $obj_ticket->f('from_ticket');
	$to_ticket = $obj_ticket->f('to_ticket');
	$eairly_dis_percen = $obj_ticket->f('eairly_dis_percen');
	$eairly_days = $obj_ticket->f('eairly_days');
	$group_dis_per = $obj_ticket->f('group_dis_per');
	$group_dis_days = $obj_ticket->f('group_dis_days');
	$ticket_icon = $obj_ticket->f('ticket_icon');
	$members_only = $obj_ticket->f('members_only');*/
	$_SESSION['type'] = '';
}
else if(isset($_POST['addevent']) && $_POST['addevent'] == '1')	
{
	$obj_get_event_id->get_event_id($_SESSION['unique_id']);
	$obj_get_event_id->next_record();
	$event_id = $obj_get_event_id->f('event_id');
	
	$obj_get_sub_event_id->get_sub_event_id($_SESSION['unique_id_subevent']);
	$obj_get_sub_event_id->next_record();
	$sub_event_id = $obj_get_sub_event_id->f('event_id');
	
	
	$finalArray = $_POST['maincat'];
	$event_name_sp = addslashes($_POST['event_name_sp']);
	$event_name_en = addslashes($_POST['event_name_en']);
	$short_desc_sp = addslashes($_POST['short_desc_sp']);
	$short_desc_en = addslashes($_POST['short_desc_en']);

	// Check weather short Description is empty
	if($short_desc_sp==""){
		$short_desc_sp = substr(trim(strip_tags(addslashes($_POST['page_content_sp']))),0,160);
	}
	
	if($short_desc_en==""){
		$short_desc_en = substr(trim(strip_tags(addslashes($_POST['page_content_en']))),0,160);
	}

	$event_start_hour = $_POST['event_hr_st'];
        
	$event_start_date_time = $_POST['event_year_st']."-".$_POST['event_month_st']."-".$_POST['event_day_st']." ".$event_start_hour."-".$_POST['event_min_st']."-00";
	$event_start_ampm = $_POST['event_start_ampm'];
	
        $event_end_hour = $_POST['event_hr_end'];
        
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
	$Paypal = $_POST['Paypal'];
	$Bank = $_POST['Bank'];
	$Oxxo = $_POST['Oxxo'];
	$Mobile = $_POST['Mobile'];
	$Offline = $_POST['Offline'];
	$publish_date = $_POST['year_1']."-".$_POST['month_1']."-".$_POST['day_1'];
	$event_time = $_POST['event_time'];
	$event_time_period = $_POST['event_time_period'];
	$r_month = $_POST['r_month'];
	$r_month_day = $_POST['r_month_day'];
	$mon = $_POST['Mon'];
	$tue = $_POST['Tue'];
	$wed = $_POST['Wed'];
	$thu = $_POST['Thu'];
	$fri = $_POST['Fri'];
	$sat = $_POST['Sat'];
	$sun = $_POST['Sun'];
	$r_span_start = $_POST['r_span_start'];
	$r_span_end = $_POST['r_span_end'];
	$event_start = $_POST['event_start'];
	$event_end = $_POST['event_end'];
	$all_day = $_POST['all_day'];
	$event_lasts = $_POST['event_lasts'];
	$attendees = $_POST['attendees'];
	$invitation_only = $_POST['invitation_only'];
	$password_protect_check = $_POST['password_protect_check'];
	$pass_protected = $_POST['pass_protected'];
	$radio_access = $_POST['radio_access'];
	if($radio_access == 1){
		$pay_ticket_fee = $_POST['pay_ticket_fee'];
		$promo_charge = $_POST['promo_charge'];
	}
	else
	{
		$pay_ticket_fee = '';
		$promo_charge = '';
	}
	$event_types = $_POST['event_types'];
	$paper_less_mob_ticket = $_POST['paper_less_mob_ticket'];
	$print = $_POST['print'];
	$will_call = $_POST['will_call'];
	$status = $_POST['status'];
	$privacy = $_POST['privacy'];

	
	$obj_add->editSavedSubEvent($_SESSION['ses_user_id'],$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$_SESSION['unique_id_subevent'],$privacy,$event_id);

	if($_POST['close']==1){
	?>
    	<script>
		$(document).ready(function(){
			//alert("tete");
			close();
		})
        </script>
    <?php	exit;
	}
	if($_POST['close']==2){
	
		$obj_duplicate->get_sub_event_id($_SESSION['unique_id_subevent']);
		$obj_duplicate->next_record();
		
		$event_id = $obj_duplicate->f('event_id');
		$event_name_sp = $obj_duplicate->f('event_name_sp');
		$short_desc_sp = $obj_duplicate->f('event_short_desc_sp');
		$event_name_en = $obj_duplicate->f('event_name_en');
		$short_desc_en = $obj_duplicate->f('event_short_desc_en');
		$arr = explode(" ",$obj_duplicate->f('event_start_date_time'));
		$arr1 = explode("-",$arr[0]);
		$event_day_st = $arr1[2];
		$event_month_st = $arr1[1];
		$event_year_st = $arr1[0];
		$brr = explode(" ",$obj_duplicate->f('event_end_date_time'));
		$brr1 = explode("-",$brr[0]);
		$event_day_end = $brr1[2];
		$event_month_end = $brr1[1];
		$event_year_end = $brr1[0];
		$venue_state = $obj_duplicate->f('event_venue_state');
		$venue_county = $obj_duplicate->f('event_venue_county');
		$venue_city = $obj_duplicate->f('event_venue_city');
		$venue = $obj_duplicate->f('event_venue');
		$page_content_sp = $obj_duplicate->f('event_details_sp');
		$page_content_en = $obj_duplicate->f('event_details_en');
		$set_privacy = $obj_duplicate->f('set_privacy');
		$radio_access = $obj_duplicate->f('radio_access');

		$attendees_share = $obj_duplicate->f('attendees_share');
		$attendees_invitation = $obj_duplicate->f('attendees_invitation');
		$password_protect = $obj_duplicate->f('password_protect');
		$password_protect_text = $obj_duplicate->f('password_protect_text');
		
		$_SESSION['unique_id_subevent'] = time();
		
		
		// Getparent Event Types
		$objduptype->sub_event_by_id($event_id);
		$arrTypecat = array();
		if($objduptype->num_rows())
		{
		   while($objduptype->next_record())
		   {
			   $arrTypecat[] = $objduptype->f('event_master_type_id');
		   }
		}
		//echo 1;print_r($arrTypecat);exit;
		
		// Get parent Event Categories
		$objdupcat->catBySubEvent($event_id);
		$arrMaincat = array();
		if($objdupcat->num_rows())
		{
		   while($objdupcat->next_record())
		   {
			   $arrMaincat[] = $objdupcat->f('category_id');
		   }
		}
		
	}
	//$_SESSION['type'] = $_POST['type'];
	$_SESSION['msg'] = " Sub Event created successfully";
	if($_POST['close']==0){
	?>
    <script>
		$(document).ready(function(){
			window.location="";
		})
        </script>
    <?php
	}
	//exit;
}
else
{
	$_SESSION['unique_id_subevent'] = time();
}

//echo $_SESSION['unique_id_subevent'];
?>



<script type="text/javascript">
//calendar
$(document).ready(function() {
    $('#event_date_st, #event_month_st, #event_year_st').bind( "click", function(e) {           
        $(this).siblings('.event_start_datepicker').show().focus().hide();            
    });
    
    $('.event_start_datepicker').datepicker({
        firstDay: 1 ,	
        showButtonPanel: true,
    	onSelect:function(theDate) {
            $('.event_start_datepicker').datepicker('setDate', theDate);
            $('.event_end_datepicker').datepicker('setDate', theDate);  

            var n=theDate.split("/");
            $("input[name='event_month_st']").val(n[0]);
            $("input[name='event_day_st']").val(n[1]);
            $("input[name='event_year_st']").val(n[2]);

            $('#event_month_end').val(n[0]);
            $('#event_date_end').val(n[1]);
            $('#event_year_end').val(n[2]);

            var ticket_to_date = n[1]+"-"+n[0]+"-"+n[2];
            $('#to_ticket').val(ticket_to_date)
        }
    });
	
    $('#event_month_end, #event_date_end, #event_year_end').bind( "click", function(e) {           
        $(this).siblings('.event_end_datepicker').show().focus().hide();            
    });

    $('.event_end_datepicker').datepicker({
        firstDay: 1 ,	
        showButtonPanel: true,
        beforeShow:function (textbox) {
            setTimeout(function () {
                $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
            }, 300);
        },
    	onSelect:function(theDate) {
            $('.event_end_datepicker').datepicker('setDate', theDate); 
            var n=theDate.split("/");
            $("input[name='event_month_end']").val(n[0]);
            $("input[name='event_day_end']").val(n[1]);
            $("input[name='event_year_end']").val(n[2]);
        }
    });
	
});


</script>

<script type="text/javascript">


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
		
		 var ticketVal = {"ticket_name_en":$('#ticket_name_en').val(),"ticket_name_sp":$('#ticket_name_sp').val(),"description_en":$('#description_en').val(),"description_sp":$('#description_sp').val(),"price_mx":$('#price_mx').val(),"price_us":$('#price_us').val(),"ticket_num":$('#ticket_num').val(),"from_ticket":$('#from_ticket').val(),"to_ticket":$('#to_ticket').val(),"eairly_dis_percen":$('#eairly_dis_percen').val(),"eairly_days":$('#eairly_days').val(),"group_dis_per":$('#group_dis_per').val(),"group_dis_days":$('#group_dis_days').val(),"photoname":$('#photoname').val(),"members_only":$('input:radio[name=members_only]:checked').val(),"edit_ticket":$('#edit_ticket').val(),"exit_ticket_id":$('#exit_ticket_id').val()}
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_temp_sub_event_tickets.php",
		  // async: false,
		   cache: false,
		   type: "POST",
		   data: ticketVal,   
		   success: function(data){ 
			 $(".ticket_common_class").val('');
			 $("#imgid").html('');
//			 $("#divticketimage").html('<div id="me2" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon7</span></span></div><span id="mestatus2"></span><br /><span id="imgid">');
			 $('#edit_ticket').val(0);
			 $("#save_create_ticket_display").html(data);
			 
			 // Place the placeholder
			 $("#ticket_name_sp").val("Nombre");
			 $("#ticket_name_en").val("Name");
			 $("#description_sp").val("Descripción");
			 $("#description_en").val("Description");
		 	$('#ticket_num').css("border", "1px solid #CCCCCC");
			 
			 $("#price_mx").val("");
			 $("#price_us").val("");
			 $("#ticket_num").val("");
			 $("#from_ticket").val("");
			 $("#to_ticket").val("");
			 $("#eairly_dis_percen").val("");
			 $("#eairly_days").val("");
			 $("#group_dis_per").val("");
			 $("#group_dis_days").val("");
			 $("#photoname").val(""); 
			 document.getElementById("members_only1").checked = true ;

			$('html, body').animate({scrollTop: $(".event_ticketbg").offset().top}, 2000);
		   }
		 });
		 return 1;
	}
}
</script>

<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
    var firstOptionCity = $("#venue_city option:first").html();
     var firstOptionVenue = $("#venue option:first").html();
     $('#div_city_display').html('<select name="venue_city" id="venue_city" class="selectbg12"><option value="">' + firstOptionCity + '</option></select>');
     $('#div_venue_display').html('<select name="venue" id="venue" class="selectbg12"><option value="">' + firstOptionVenue + '</option></select>');
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
    var firstOptionVenue = $("#venue option:first").html();
     $('#div_venue_display').html('<select name="venue" id="venue" class="selectbg12"><option value="">' + firstOptionVenue + '</option></select>');
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
				
				//On completion clear the status
			}
		});
		
	});


function changeTime(starttime)
{
    var endtime = parseInt(starttime)+2;
    if (endtime > 23) {
       endtime = 23;
    }
    $('#event_hr_end').val(endtime);
   
   if (starttime < 12) {
       $('#event_start_ampm').val('AM');
    } else {
       $('#event_start_ampm').val('PM');
    }
   
    if (endtime < 12) {
       $('#event_end_ampm').val('AM');
    } else {
        $('#event_end_ampm').val('PM');
    }
}
</script>

<script type="text/javascript">
function status(type){
	//alert(type);
	$("#status").val(type);
}

function saveAutoEvent()
{
	//  check something is written in event page..
	//alert("aaaaaaaaaaaaaaaa");
	//var ev = $('#event_name_sp').val();
	//alert(ev);
		$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_subevent.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: $("#event_form").serialize(),   
	   success: function(data){ 
	     //alert(data);
	   }
	 });
}


function deleteTemp(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_del_sub_tickets.php",
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
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_edit_subevent_ticket.php",
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
	if($("#event_name_sp").val()=="" || $("#event_name_sp").val()=="Nombre")
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

function check_box(){
	
	var fields = $("input[class='category_1']").serializeArray(); 
    if (fields.length == 0) 
    { 
        alert('No Categories Selected!'); 
        // cancel submit
        return false;
    } 
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
<script language="javascript" type="text/javascript">
function deleteSubEvent(sub_event_id,parent_id)
{
	//alert(sub_event_id+"/"+parent_id);return false;
     data = "sub_event_id="+sub_event_id+"&parent_id="+parent_id; 
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_delete_sub_event.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_subevent_list").html(data);
	   }
	 });
}
function EditSubEvent(sub_event_id,parent_id)
{
	alert(sub_event_id+"//"+parent_id);
	
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
.lang_name{
	background: #FFFFFF; float: right; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 13px 0 0; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;
}
.lang_name_eng{
background: #FFFFFF; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 0 0 13px; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;
}
.ticektfee{
 margin: 10px; display:inline-block; width: 105px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
 } 
 .ticketfee1{
	 margin: 0 10px; display:inline-block; width: 105px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
 }
.show_spanish{
	background: #FFFFFF; float: right; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 13px 0 0; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;
}
.show_english{
	background: #FFFFFF; color: #FF0000; border: 1px solid #CCCCCC; margin: 8px 0 0 13px; padding:2px; font: bold 22px/22px Arial, Helvetica, sans-serif; display: inline-block;
}
.membershipClass{
margin: 0 10px; display:inline-block; width: 105px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
        }
.rad_button{
padding:0; margin:0 0 0 5px; line-height: 15px;
}

#public_content{
    float: right; width:486px; margin: -29px 0 0 0;
    }
	
#private_content{
    float: right; width:486px; margin: -29px 0 0 0; display:none;
    }
.tic_edit{
    margin: 0; display:inline-block; float: right; width: 114px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
    }	
.state{
width:150px !important; height: 20px; float:left; margin: 2px 0;
}
	
</style>

<script type="text/javascript">
//Edit the counter/limiter value as your wish
var count = "160";   //Example: var count = "175";
function limiter(){

	var tex = document.event_form.short_desc_sp.value;
	var len = tex.length;
	if(len > count){
			tex = tex.substring(0,count);
			document.event_form.short_desc_sp.value =tex;
			return false;
	}
	document.event_form.limit.value = count-len;
}

var count1 = "160";   //Example: var count = "175";
function limiter1(){
	var tex = document.event_form.short_desc_en.value;
	var len = tex.length;
	if(len > count1){
			tex = tex.substring(0,count1);
			document.event_form.short_desc_en.value =tex;
			return false;
	}
	document.event_form.limit1.value = count1-len;
}

function setmultivenue()
{
	$('#multi_venue').val($('#venue').val());
	saveAutoEvent();
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
           <div class="blue_box10"><p><?= AD_MY_EVENTS ?></p></div>
           	<?php include("admin_menu/createevent_menu.php");?>
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
	 <input type="hidden" name="status" id="status" value="draft" />
 	 <input type="hidden" name="addevent" id="addevent" value="1" />
	 <!--<input type="hidden" name="event_id" id="event_id" value="<?php echo $obj_parent->f('event_id');?>" />-->
	 <input type="hidden" name="event_id" id="event_id" value="<?php echo $obj_parent->f('event_id');?>" />
	 <input type="hidden" name="type" id="type" value="" />
     <input type="hidden" name="close" id="close" value="0"   />
    <div class="myevent_box">
	
    <div class="myevent_left">
    
    <div style="text-align:center;margin-bottom: 20px;margin-top: 20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
	<tr><td colspan="7" align="center" style="padding-top:10px;"><strong><font color="#0094A4"><?= AD_SET_PROGRAM_FOR ?></font></strong></td></tr>
	<?php 
	$obj->fetchEventById($obj_parent->f('event_id'));
    $obj->next_record();
	?>
	<tr>
		<td width="20%" class="top_txt"><?= AD_EVENT ?></td>
		<td width="20%" class="top_txt"><?= AD_CITY ?></td>
		<td width="20%" class="top_txt"><?= AD_VENUE ?></td>
		<td width="20%" class="top_txt"><?= AD_START_DATE ?></td>
		<td width="20%" class="top_txt"><?= AD_END_DATE ?></td>
	</tr>
	<tr>
		<td width="20%"><?php echo stripslashes($obj->f('event_name_en'));?></td>
		<td width="20%"><?php echo $obj->f('city_name');?></td>
		<td width="20%"><?php echo $obj->f('venue_name');?></td>
		<td width="20%"><?php echo $obj->f('event_start_date_time');?></td>
		<td width="20%"><?php echo $obj->f('event_end_date_time');?></td>
	</tr>
	</table>
	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2" id="div_subevent_list">
	<tr>
		<td width="15%" class="top_txt"><?= AD_EVENT ?></td>
		<td width="15%" class="top_txt"><?= AD_VENUE ?></td>
		<td width="16%" class="top_txt"><?= AD_EVENT_DATE ?></td>
		<td width="19%" class="top_txt"><?= AD_START_END_TIME ?></td>
		<td width="5%" class="top_txt"><?= AD_EDIT ?></td>
		<td width="10%" class="top_txt"><?= AD_DUPLICATE ?></td>
		<td width="10%" class="top_txt"><?= AD_DELETE ?></td>
	</tr>
	<?php
	$objlist->allSubEventList($obj_parent->f('event_id'));
    $objlist_num->allSubEventListCount($obj_parent->f('event_id'));
	$num = $objlist_num->num_rows(); 
	$loop=1;
	if($num>0)
	{
		while($row = $objlist->next_record())
		{
?>
	<tr>
	    <td width="15%"><?php echo stripslashes($objlist->f('event_name_en'));?></td>
		<!--<td width="15%"><?php echo $objlist->f('city_name');?></td>-->
		<td width="18%"><?php echo $objlist->f('venue_name');?></td>
		<td width="12%"><?php list($event_date1,$event_time1) = explode(" ",$objlist->f('event_start_date_time')); echo date("d/m/Y",strtotime($event_date1));?></td>
		<td width="19%"><?php echo date("H:i",strtotime($objlist->f('event_start_date_time')))." - ".date("H:i",strtotime($objlist->f('event_end_date_time')));?></td>
		<td width="5%">
        	<a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_sub_events_edit.php?sub_event_id=<?php echo $objlist->f('event_id')?>&event_id=<?php echo $obj_parent->f('event_id');?>&mode=1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a>
            <?php /*?><a href="javascript:void(0);" onclick="EditSubEvent('<?php echo $objlist->f('event_id')?>','<?php echo $obj_parent->f('event_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a><?php */?>
        </td>
		<td width="10%"><img src="<?php echo $obj_base_path->base_path(); ?>/images/Screenshot.png" alt="" width="20" height="16" onclick="return complete1();" /></td>
		<td width="10%"><a href="javascript:void(0);" onclick="deleteSubEvent('<?php echo $objlist->f('event_id')?>','<?php echo $obj_parent->f('event_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></td>
	</tr>
	    <?php
		}
	}
	else
	{
	?>
	<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000"><?= AD_NO_SUBEVENT ?></font></td></tr>
	<?php
	}
	?>
	</table>
    </div>
	
	<div style="text-align:center;margin-bottom: 20px;margin-top: 20px;">
	<h2><?= AD_CREATE ?>/<?= AD_EDIT ?> <?= AD_SHOW ?> - <?= AD_SUB_EVENT ?></h2>
	</div>
	
	<div class="event_name8">
        <div style="float: left; position: absolute; margin: 0 0 0 303px;">
            <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/>
        </div>
        <div style="float: left; margin: 0 auto;">
            <span class="lang_name">SP</span>
            <br/>
            <span class="event_fieldbg8">
                <input type="text" name="event_name_sp" id="event_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($event_name_sp!=""){echo $event_name_sp;}else{echo "Nombre";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') {this.value=this.defaultValue}else{saveAutoEvent();}"/>
            </span>	
        </div>

        <div style="float: right; margin: 0 auto;">	
            <span  class="lang_name_eng">EN</span><br/>
            <span class="event_fieldbg8">
                <input type="text" name="event_name_en" id="event_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($event_name_en!=""){echo $event_name_en;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value==''){this.value=this.defaultValue}else{saveAutoEvent();}"/>
            </span>	
        </div>
    </div>
    
    <div class="clear"></div>
    <div class="event_date">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><h1 style="padding: 35px 0 0 10px;"><?=AD_DATE;?></h1></td>
      <td><h1 style="padding: 35px 0 0 10px;"><?=AD_STARTS;?></h1></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong><?= AD_YEAR_FORMAT ?></strong></td>
        </tr>
        <tr>
            <?php 
                $start_day = "";
                if ($st_eve_dy != "" && $st_eve_mn != "" && $st_eve_yr != "") {
                    $start_day = $st_eve_mn . '/' . $st_eve_dy . '/' . $st_eve_yr;
                }
            ?>
            <td style="position: relative">
                <input type="text" <?php if ($start_day != "") { echo "value='$start_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_day_st" id="event_date_st" value="<?php if($st_eve_dy!=""){echo $st_eve_dy;}else{echo 00;}?>"  class="textbg_grey"  style="width: 30px;" />
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" <?php if ($start_day != "") { echo "value='$start_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_month_st" id="event_month_st" value="<?php if($st_eve_mn!=""){echo $st_eve_mn;}else{echo 00;}?>" class="textbg_grey"  style="width: 30px;" />
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" <?php if ($start_day != "") { echo "value='$start_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_year_st" id="event_year_st"  value="<?php if($st_eve_yr!=""){echo $st_eve_yr;}else{echo 0000;}?>" class="textbg_grey"  style="width: 40px;" />
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="padding: 9px 0;">
                <select name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onChange="changeTime(this.value);">
                    <?php echo $st_eve_hr;
                        for($i=0; $i<24; $i++) {
                    ?>
                        <option value="<?php echo $i; ?>" <?PHP if($i==19) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                    <?php }?>
                </select>
            </td>
          <td style="padding: 9px 0;">/</td>
          <td style="padding: 9px 0;"><select name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=00; $j<60; $j = $j + 5) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>
                      
                </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
            <td style="padding: 9px 0; visibility: hidden">
                <select name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;" onchange="saveAutoEvent();">
                    <option value="AM">AM</option>
                    <option value="PM" selected="selected">PM</option>
                </select>
            </td>
          <td style="padding: 9px 0;"></td>
        </tr>
      </table></td>
      <td><h1 style="padding: 35px 0 0 10px;"><?=AD_ENDS;?></h1></td>
      <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong><?= AD_YEAR_FORMAT ?></strong></td>
        </tr>
        <tr>
            <?php 
                $end_day = "";
                if ($end_eve_dy != "" && $end_eve_mn!="" && $end_eve_yr!="") {
                    $end_day = $end_eve_mn . '/' . $end_eve_dy . '/' . $end_eve_yr;
                }
            ?>
            <td style="position: relative">
                <input type="text" <?php if ($end_day != "") { echo "value='$end_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
                <input type="text" name="event_day_end" id="event_date_end" value="<?php if($end_eve_dy!=""){echo $end_eve_dy;}else{echo 00;}?>" class="textbg_grey" style="width: 30px;"/>
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" <?php if ($end_day != "") { echo "value='$end_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
                <input type="text" name="event_month_end" id="event_month_end" value="<?php if($end_eve_mn!=""){echo $end_eve_mn;}else{echo 00;}?>"  class="textbg_grey" style="width: 30px;"/>
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" <?php if ($end_day != "") { echo "value='$end_day'"; } ?> style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
                <input type="text" name="event_year_end" id="event_year_end" value="<?php if($end_eve_yr!=""){echo $end_eve_yr;}else{echo 0000;}?>"  class="textbg_grey" style="width: 40px;"/>
            </td>
        </tr>
        <tr>
            <td style="padding: 9px 0;">
                <select name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                    <?php 
                      for($i=0; $i<24; $i++) {
                    ?>
                        <option value="<?php echo $i; ?>" <?PHP if($i==21) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                    <?php }?>
                </select>
            </td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=0; $j<60; $j = $j + 5) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
            <td style="padding: 9px 0; visibility: hidden">
                <select name="event_end_ampm" class="selectbg" id="event_end_ampm" title="Please select event miniute" style="width:50px;float:left;" onchange="saveAutoEvent();">
                    <option value="AM">AM</option>
                    <option value="PM" selected="selected">PM</option>
                </select>
            </td>
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
      <td width="12%"><h1><?=AD_VENUE?></h1></td>
      <td width="22%">
	  <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value);" onblur="saveAutoEvent();">
        <option value=""><?=AD_STATE?></option>
        <?php
      $obj_venuestate->getVenueState();
      while($row = $obj_venuestate->next_record())
      {
      ?>
        <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj_parent->f('event_venue_state')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
		<?php echo $obj_venuestate->f('state_name');?></option>
        <?php
      }
      ?>
      </select></td>
      <td width="22%">
		  <div id="div_county_display">
		  <select name="venue_county" id="venue_county" class="selectbg12" id="venue_county" onchange="getCity(this.value); saveAutoEvent()">
		  <option value=""><?=AD_COUNTY?></option>
		  <?php
		        $obj_getcounty = new admin;
			    $obj_getcounty->getCountyNameByState($obj_parent->f('event_venue_state'));
				while($obj_getcounty->next_record())
				{
				?>
				<option value=<?php echo $obj_getcounty->f("id")?> <?php if($obj_parent->f('event_venue_county')==$obj_getcounty->f('id')){?> selected="selected"<?php }?> >
				<?php echo $obj_getcounty->f('county_name')?></option>
				<?php
				}
		  ?>
		  </select>
		  </div>
	  </td>          
      <td width="22%">
		  <div id="div_city_display">
		  <select name="venue_city" id="venue_city" class="selectbg12" onchange="getVenue(this.value); saveAutoEvent();">
		  <option value=""><?=AD_CITY?></option>
		   <?php
		        $obj_getcity = new admin;
			    $obj_getcity->getCityNameByCounty($obj_parent->f('event_venue_county'));
                while($obj_getcity->next_record())
				{
				?>
				<option value=<?php echo $obj_getcity->f("id")?> <?php if($obj_parent->f('event_venue_city')==$obj_getcity->f('id')){?> selected="selected"<?php }?>>
				<?php echo $obj_getcity->f('city_name')?></option>
				<?php
				}
		  ?>
		  </select>
		  </div>
	  </td>
      <td width="22%">
		  <div id="div_venue_display">
		  <select name="venue" id="venue" class="selectbg12" onchange="saveAutoEvent();">
		  <option value=""><?=AD_VENUE?></option>
		   <?php
		        $obj_getvenue = new admin;
			    $obj_getvenue->getVenueNameByCity($obj_parent->f('event_venue_city'));
                while($obj_getvenue->next_record())
				{
				?>
				<option value=<?php echo $obj_getvenue->f("venue_id")?> <?php if($obj_parent->f('event_venue')==$obj_getvenue->f('venue_id')){?> selected="selected"<?php }?> >
				<?php echo $obj_getvenue->f('venue_name')?></option>
				<?php
				}
		  ?>
		  </select>
		  </div>
	  </td>
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
   <?php /*?> <textarea name="page_content_sp" cols="35" rows="10"><?php if($msg!="" && $page_content_sp!=""){echo $page_content_sp;}?></textarea><?php */?>
    <?php 
	include_once($obj_base_path->base_path()."/ckeditor/ckeditor.php");
       $CKeditor = new CKeditor();
       $CKeditor->BasePath = 'ckeditor/';
       $CKeditor->editor('page_content_sp');
	?>
    </div>
    <div class="TabbedPanelsContent2">
    <?php /*?><textarea name="page_content_en" cols="35" rows="10"><?php if($msg!="" && $page_content_en!=""){echo $page_content_en;}?></textarea><?php */?>
     <?php 
	//include($obj_base_path->base_path()."/ckeditor/ckeditor.php");
       $CKeditor = new CKeditor();
       $CKeditor->BasePath = 'ckeditor/';
       $CKeditor->editor('page_content_en');
	?>
    </div> 
    </div>
    </div>
    </div>	

    <div class="clear"></div>
    
    <div class="event_name8">
        <div style="float: left; margin: 0 auto;">
            <span class="event_fieldbg8">
                Meta descripci&#243;n para redes sociales
                <textarea name="short_desc_sp" id="short_desc_sp" class="event_field" style="width: 290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();" onkeyup="limiter();">
                    <?php if ($short_desc_sp) { echo $short_desc_sp; } ?>
                </textarea>
                <script type="text/javascript">
                    document.write("<input type=text name=limit size=4 readonly value="+count+">");
                </script>
            </span>
        </div>

        <div style="float: right; margin: 0 auto;">	
            <span class="event_fieldbg8">
                Meta description for social networks
                <textarea name="short_desc_en" id="short_desc_en" class="event_field" style="width: 290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();" onkeyup="limiter1();">
                    <?php if ($short_desc_en) { echo $short_desc_en; } ?>
                </textarea>
                <script type="text/javascript">
                    document.write("<input type=text name=limit1 size=4 readonly value="+count1+">");
                </script>
            </span>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <script type="text/javascript">
	function privacy_policy(){

		if($('input:radio[name=privacy]:checked').val()==0)
		{
			$('#public_content').show();
			$('#private_content').hide();
		}
		else
		{
			$('#private_content').show();
			$('#public_content').hide();
		}
	}
	</script>
   
    <div class="clear"></div>
    <div class="event_ticket" style="background:none;">
		<h1><?= AD_SET_PRIVACY ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>	
		<span style="float: left;">
        	<p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="0"  onclick="privacy_policy(); saveAutoEvent();" checked="checked" /> <?= AD_PUBLIC ?></p>	
			<p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="1" onclick="privacy_policy(); saveAutoEvent();" <?php if($set_privacy == 1){echo "checked";}?> /> <?= AD_PRIVATE ?></p>
         </span>
		<span id="public_content" <?php if($set_privacy == 0){?>style="display:block;"<?php }else{ ?>style="display:none;"<?php }?>><?= AD_EVENT_PUBLIC_OPTION ?></span>
		<span id="private_content" <?php if($set_privacy == 1){?>style="display:block;"<?php }?> >
          <table width="100%" border="1">
              <tr>
                <td><?= AD_EVENT_PRIVATE_OPTION ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="attendees" id="attendees" value="1" onclick="saveAutoEvent();" <?php if($attendees_share == 1){echo "checked";}?>  />&nbsp; <?= AD_PRIVATE_CHECK_ONE ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="invitation_only" id="invitation_only" value="1" onclick="saveAutoEvent();" <?php if($attendees_invitation == 1){echo "checked";}?> />&nbsp; <?= AD_PRIVATE_CHECK_TWO ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="password_protect_check" id="password_protect_check" value="1" onclick="saveAutoEvent();" <?php if($password_protect == 1){echo "checked";}?> />&nbsp; <?= AD_PRIVATE_CHECK_THREE ?> &nbsp; 
                	<input type="text" name="pass_protected" id="pass_protected" onclick="saveAutoEvent();" value="<?php echo $password_protect_text;?>"  /></td>
              </tr>
            </table>
       	</span>
	</div>
    
	<div class="clear"></div>
	<div class="event_ticket">
	<h1><?= AD_SET_FEATURE_IMAGE_TITLE ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>
	<ul style="margin-left: 10px;">
        <li><a href="#" class="here"> 
            <div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><?= AD_UPLOAD_FILES?></span></span></div><span id="mestatus1"></span>
            <?php  if($_POST['event_photo']){  ?>
            <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['event_photo']; ?>" alt="" />
            <?php }  ?>
          <span id="imgshow"></span>
          <input type="hidden" name="event_photo" id="event_photo" value="<?php if($_POST['event_photo']){ echo $_POST['event_photo']; }?>" /></a></li>
        <li>|</li>
        <li><a href="#"><?= AD_MEDIA_LIBERY ?></a></li>
	</ul>
	</div>
	<div class="clear"></div>
	<script type="text/javascript">
	
	
	function common_check()
	{
		if($("#event_name_sp").val()=="" || $("#event_name_sp").val()=="Nombre")
		{
			alert("Please Enter Event name.");
			$("#event_name_sp").focus();
			return false;
		}
		if($("#event_name_en").val()=="" || $("#event_name_en").val()=="Name")
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
		
		var fields = $("input[class='category_1']").serializeArray(); 
		if (fields.length == 0) 
		{ 
			alert('No Categories Selected!'); 
			// cancel submit
			return false;
		}
		return true;
	}
	
	function complete(){
		
		if(!common_check()){
			return false;
		}
		
		$("#status").val('publish');
		$("#event_form").submit();
		
	}

	function save_exit(){
		if(!common_check()){
			return false;
		}
		$("#close").val(1);
		$("#status").val('publish');
		setTimeout('$("#event_form").submit()',1000);
	}
	
	function discard_save(){

		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_discard_sub_event.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: $("#event_form").serialize(),   
		   success: function(data){ 
			 setTimeout('close()',2000);
		   }
		 });
		
	}
	


	function complete1(){
		
		if(!common_check()){
			return false;
		}
		$("#close").val(2);
		
		$("#status").val('publish');
		//$("#type").val('duplicate');
		$("#event_form").submit();
	}



	function showticketingsection(){

		if($('input:radio[name=radio_access]:checked').val()==1)
		{
			$('#all_access').hide();
			$('.payment_resarvation').show();
			$('#ticket_area').show();
			$('#pay_option').show();
		}
		else if($('input:radio[name=radio_access]:checked').val()==2){
			$('#all_access').hide();
			$('.payment_resarvation').hide();
			$('#pay_option').hide();
			$('#ticket_area').hide();
		}
		else
		{
			$('#all_access').show();
			$('.payment_resarvation').hide();
			$('#ticket_area').hide();
			$('#pay_option').hide();
		}
	}
	<?php if($radio_access==0){?>
	$(document).ready(function(){
		$('#all_access').show();
	});
	<?php } ?>
	</script>
	<div class="clear"></div>
	<div class="event_ticketbg">
	<div class="event_ticket2">
    <div><h1><?= AD_TICKETING_RESERVATIONS ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1></div>
    <div class="clear"></div>
    <div>
     <ul>
        <li><input name="radio_access" type="radio" value="1" <?php if($radio_access==1){?> checked="checked"<?php } ?> onclick="showticketingsection(); saveAutoEvent();"  /><strong><?= AD_TICKETING_RESERVATIONS_OP_ONE ?></strong></li>
		<li><input name="radio_access" type="radio" value="2" <?php if($radio_access==2){?> checked="checked"<?php } ?> onclick="showticketingsection(); saveAutoEvent();"/><strong><?= AD_TICKETING_RESERVATIONS_OP_THREE ?></strong></li>
        <li><input name="radio_access" type="radio" value="0" <?php if($radio_access==0){ echo 'checked="checked"'; } ?> onclick="showticketingsection(); saveAutoEvent();"  /><strong><?= AD_TICKETING_RESERVATIONS_OP_TWO ?></strong></li>
		<li id="all_access" style="display:none;">
            <?= AD_ALL_ACCESS_NOTICE ?>
		</li>
		
        <li class="payment_resarvation" style="margin-left:10px;display:none;"><?= AD_PRICE_INCLUDES_FEE ?>
        	<span class="ticektfee">
            	<input name="pay_ticket_fee" type="radio" value="1" checked="checked" style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?> 
                <input name="pay_ticket_fee" type="radio" value="0" style="margin: 5px;" onclick="saveAutoEvent();"/> <?= AD_NO_OPTION ?>  
            </span>
        </li>
        <li class="payment_resarvation" style="margin: 0 0 0 10px;display:none;"><?= AD_PRICE_INCLUDES_CHARGES ?>
        	<span class="ticketfee1" style="margin:0 34px;">
                <input name="promo_charge" type="radio" value="1" checked="checked" style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?>  
                <input name="promo_charge" type="radio" value="0" style="margin:5px;" onclick="saveAutoEvent();"/> <?= AD_NO_OPTION ?>  
            </span>
        </li>
	 </ul>
	</div>
    </div>
    
    <div id="ticket_area" style="display:none;">
       <div class="event_ticket2">
            <div><h2><?= AD_CER_TICKET ?><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" width="31" height="28" border="0"/></h2></div>
            <div class="clear"></div>
            <div id="save_create_ticket_display" class="event_ticketbox" style="border:0px solid red;">&nbsp;</div>
        </div>
       <div class="clear"></div>

      <input type="hidden" name="photoname" id="photoname" value="" />
      <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
      <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
       <div class="event_name8">
        <div style="float: left; position: absolute; margin: 0 0 0 303px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/></div>
        <div style="float: left; margin: 0 auto;">
        	<span class="show_spanish">SP</span><br/>
         	<span class="event_fieldbg8">
        	<input type="text" name="ticket_name_sp" id="ticket_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($ticket_name_sp!=""){echo $ticket_name_sp;}else{echo "Nombre";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
         	</span>	
        <br/>
        	<span class="event_fieldbg8">
            	<textarea name="description_sp" id="description_sp" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"><?php echo $description_sp;?></textarea>
            </span>
        </div>
        <div style="float: right; margin: 0 auto;">	
        	<span class="show_english">EN</span><br/>
        	<span class="event_fieldbg8"><input type="text" name="ticket_name_en" id="ticket_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($ticket_name_en!=""){echo $ticket_name_en;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
        	</span>	<br/>
       		<span class="event_fieldbg8"><textarea name="description_en" id="description_en" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"><?php echo $description_en;?></textarea></span>
        </div>
        </div>
       <div class="clear"></div>
       <div class="event_date8">
       
        <div class="event_date9">
        	Precio MX pesos <input type="text" name="price_mx" id="price_mx" onblur="checDecimal('price_mx','shw_price_mx')" value="<?php echo $price_mx;?>"  /> 
            Price Dollars <input type="text" name="price_us" id="price_us" onblur="checDecimal('price_us','shw_price_us')" value="<?php echo $price_us;?>"  />
        </div>	
        <div class="event_date9">
        	<?= AD_NUMBER_AVAILABLE_SEATS ?> <input type="text" name="ticket_num" id="ticket_num" style="width: 64px;" value="<?php echo $ticket_num;?>"/> 
        	<?= AD_FROM ?> <input type="text" name="from_ticket" id="from_ticket" value="<?php echo $from_ticket;?>" /> 
            <?= AD_TO ?> <input type="text" name="to_ticket" id="to_ticket" value="<?php echo $to_ticket;?>" />
        </div>	
        <div class="event_date9">
        	<?= AD_EARLY_BIRD_DISCOUNT ?> <input type="text" name="eairly_dis_percen" id="eairly_dis_percen" value="<?php echo $eairly_dis_percen;?>" /> 
        	% <?= AD_UP_TO ?> <input type="text" name="eairly_days" id="eairly_days" style="width: 64px;" value="<?php echo $eairly_days;?>"/> <?= AD_DAYS_BEFORE_EVENT ?>
        </div>
        <div class="event_date9">
        	<?= AD_GROUP_DISCOUNT ?> <input type="text" name="group_dis_per" id="group_dis_per" value="<?php echo $group_dis_per;?>" /> 
            % <?= AD_OVER ?> <input type="text" name="group_dis_days" id="group_dis_days" style="width: 64px;"  value="<?php echo $group_dis_days;?>"/> <?= AD_TICKETS ?>
        </div>
        <div class="event_date9"><?= AD_MEMBERSHIP_ONLY ?>
        	<span class="membershipClass">
            	<input name="members_only" id="members_only1" type="radio" value="1" style="margin: 5px;" /><?= AD_YES_OPTION ?>  
                <input name="members_only" id="members_only2" type="radio" value="1" checked="checked"  style="margin: 5px;" /> <?= AD_NO_OPTION ?>  
            </span>
        </div>
        <div class="event_date9"><?= AD_TICKET_ICON ?> - 
        	<div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><?= AD_UPLOAD_YOUR_TICKET_ICON ?></span></span></div><span id="mestatus"></span><br /><span id="imgid"></span>
        </div>
            
        <div style="float: right; width:370px; margin: 0 auto;">
        	<input type="button" name="Submit2" value="<?= AD_SAVE_CREATE_TICKET ?>" class="event_save" onclick="save_new_popup()" style="cursor:pointer;" />
            <input type="button" name="Submit2" value="<?= AD_SAVE_EXIT ?>" class="event_save" onClick="closePopUp()" style="cursor:pointer;" /></div>
        </div>

    </div>
    
	</div>	
	<div class="clar"></div>
    
	<div class="event_ticket" style="background: none; width: 702px; border: 0; margin: 0 auto 0 10px;">
     <div class="event_ticketl" id="pay_option" style="display:none; margin:0px;">
		<h1><?= AD_PAYMENT_SETTING ?></h1>
        <div style="width: 180px; float: left; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_PAYMENTS ?> </h2>
                <li><input type="checkbox" name="Paypal" value="1" onclick="saveAutoEvent();"/>  <?= AD_PAYPAL_CC ?></li>
                <li><input type="checkbox" name="Bank" value="1" onclick="saveAutoEvent();"/>  <?= AD_BANK_DEPOSITE ?></li>
                <li><input type="checkbox" name="Oxxo" value="1" onclick="saveAutoEvent();"/>  <?= AD_OXXO_PAYMENT ?></li>
                <li><input type="checkbox" name="Mobile" value="1" onclick="saveAutoEvent();"/>  <?= AD_MOBILE_PAYMENT ?></li>
                <li><input type="checkbox" name="Offline" value="1" onclick="saveAutoEvent();"/>  <?= AD_OFFLINE_PAYMENT ?></li>
            </ul>
        </div>
        <div style="width: 200px; float: right; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_DELIVERY ?> </h2>
                <li><input type="checkbox" name="paper_less_mob_ticket" value="1" onclick="saveAutoEvent();"/>  <?= AD_PAPERLESS_MB_TICKET ?></li>
                <li><input type="checkbox" name="print" value="1" onclick="saveAutoEvent();"/>  <?= AD_PRINT ?></li>
                <li><input type="checkbox" name="will_call" value="1" onclick="saveAutoEvent();"/>  <?= AD_WILL_CALL?></li>
            </ul>
        </div>
	</div>
	 <div class="event_ticketr" style="margin: 0 auto 0 11px; width: auto; padding-right: 15px;">
        <h1>
        <input type="submit" name="publish" value="<?= AD_SAVE_CREATE_SUBEVENT ?>" onclick="return complete();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
        <input type="button" name="publish" value="<?= AD_SAVE_DUPLICATE_SUBEVENT ?>" onclick="return complete1();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
        <input type="button" name="publish" value="<?= AD_SAVE_AND_EXIT ?>" onclick="return save_exit();" class="event_save" style="padding:0px; height: auto; cursor:pointer;" /><br />
        <input type="button" name="publish" value="<?= AD_DISCARD_AND_EXIT ?>" onclick="return discard_save();" class="event_save" style="padding:0px; height:auto;cursor:pointer;" /><br />
        </h1>
	  	<div class="clear"></div>
	</div>
	<div class="clear"></div>
	</div>
	<div class="clear"></div>	
    </div>
    
    <div class="myevent_right">
        <div class="event_ticketr" style="width: 276px; margin: 8px auto; float: none;">
        <h1>
            <input type="button" name="publish" value="<?= AD_SAVE_CREATE_SUBEVENT ?>" onclick="return complete();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
            <input type="button" name="publish" value="<?= AD_SAVE_DUPLICATE_SUBEVENT ?>" onclick="return complete1();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
            <input type="button" name="publish" value="<?= AD_SAVE_AND_EXIT ?>" onclick="return save_exit();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
            <input type="button" name="publish" value="<?= AD_DISCARD_AND_EXIT ?>" onclick="return discard_save();" class="event_save" style="padding:0px; height: auto;cursor:pointer;" /><br />
        </h1>
	  	<div class="clear"></div>
<script type="text/javascript">
function showSubCat(category_id)
{
	/*$('#sub_cat'+category_id).show();
	$('#shwsubcatview'+category_id).hide();
	$('#hdsubcatview'+category_id).show();*/
	$('#sub_cat'+category_id).toggle();
	$('#shwsubcatview'+category_id).toggle();
	$('#hdsubcatview'+category_id).toggle();
}
function hideSubCat(category_id)
{
	/*$('#sub_cat'+category_id).hide();
	$('#hdsubcatview'+category_id).hide();
	$('#shwsubcatview'+category_id).show();*/
	$('#sub_cat'+category_id).hide();
	$('#hdsubcatview'+category_id).hide();
	$('#shwsubcatview'+category_id).show();
}
function checkCat(category_id)
{
	$('#maincat'+category_id).attr("checked",true);
}

</script>
    <div style="width: 280px; float: none; margin: 0 auto;">
    	<div class="inevent_right">
            <ul>
                <li><h1><?= AD_TYPE_OF_EVENTS ?></h1></li>	
            </ul>
            <ul>
                <li style="padding-left: 8px;"><strong><?= AD_SELECT_ALL_THAT_APPLY ?></strong></li>
                <?php
					if($obj_dup_event_master_type->num_rows()){
						while($obj_dup_event_master_type->next_record()){
				?>
                <li style="padding-left: 8px;"><input type="checkbox" name="event_types[]" id="event_types<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" value="<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" <?php if(in_array($obj_dup_event_master_type->f('event_master_type_id'),$arrTypecat)) { echo 'checked'; }?>  class="check" onclick="saveAutoEvent();" /> 
                    <?php $eventTypeName = $_SESSION['langAdminSelected'] == 'en' ? 'event_types' : 'event_types_' . $_SESSION['langAdminSelected']; echo $obj_dup_event_master_type->f($eventTypeName);?>
                </li>
                
                <?php
						}
					}
				?>
            </ul>	
        </div>
    	<div class="clear"></div>
		<div class="inevent_right">
            <ul>
                <li><h1><?= AD_CATEGORIES_AND_SUB ?>:</h1></li>	
            </ul>
            <ul>
                <li style="padding-left: 10px;"><strong><?= AD_CATEGORY_AND_SUB ?></strong></li>
                <li style="padding-left: 10px;"><strong><?= AD_MUST_SELECT_CATEGORY_MSG ?></strong></li>	
            </ul>	
			<div>
                <ul>
                 <?php
					if($objlist_cat->num_rows()){
						while($objlist_cat->next_record()){
						$obj_subcat->category_sub_list($objlist_cat->f('category_id'));
						if(in_array($objlist_cat->f('category_id'),$arrMaincat)) {
					?>
					<script language="javascript">
					$(document).ready(function(){
					showSubCat(<?php echo $objlist_cat->f('category_id');?>);
					})
					</script>
					<?php } ?>

                    <li style="padding-left: 8px;">
                    	<input type="checkbox" name="maincat[]" id="maincat<?php echo $objlist_cat->f('category_id');?>" value="<?php echo $objlist_cat->f('category_id');?>" class="category_1" onclick="showSubCat(<?php echo $objlist_cat->f('category_id');?>); saveAutoEvent();" <?php if(in_array($objlist_cat->f('category_id'),$arrMaincat)) { echo 'checked'; }?> />
                            <?php $categoryName = $_SESSION['langAdminSelected'] == 'en' ? 'category_name' : 'category_name_' . $_SESSION['langAdminSelected']; echo $objlist_cat->f($categoryName); if($obj_subcat->num_rows()){?> 			  
                        <span id="shwsubcatview<?php echo $objlist_cat->f('category_id');?>" style="cursor:pointer;" onclick="showSubCat(<?php echo $objlist_cat->f('category_id');?>)">( + )</span> 
                  		<span id="hdsubcatview<?php echo $objlist_cat->f('category_id');?>" style="cursor:pointer;display:none;" onclick="hideSubCat(<?php echo $objlist_cat->f('category_id');?>)">( - )</span> <?php } ?>
                  
                        <ul style="margin-left:30px;display:none;" id="sub_cat<?php echo $objlist_cat->f('category_id');?>">
                    <?php
						if($obj_subcat->num_rows()){
							while($obj_subcat->next_record()){
					 ?>
                        
                            <li style="padding-left:8px;"><input onclick="checkCat(<?php echo $objlist_cat->f('category_id');?>)" type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" onblur="saveAutoEvent();" <?php if(in_array($obj_subcat->f('category_id'),$arrMaincat)) { echo 'checked'; }?> /><?php echo $obj_subcat->f($categoryName);?></li>
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
        <div id="TabbedPanels1" class="TabbedPanels">
            <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">&nbsp;</div>
        </div>
        </div>
    </div>
    
	<div class="clear"></div>
	<div class="eventag_box">
		<div><h1><?= AD_EVENTS_TAGS ?></h1></div>
		<div class="clear"></div>
		<div><input type="text" name="event_tag" id="event_tag" value="<?php echo $event_tag;?>" class="textbg_add"/> <input type="button" name="save" value="<?= AD_BUTTON_ADD ?>" class="btn_add" onblur="saveAutoEvent();" /></div>
		<div class="clear"></div>
		<div><span><?= AD_SEPARATE_TAGS ?></span></div>
		<div class="clear"></div>
		<!--<div><a href="#">Choose from the most used tags</a></div>-->
	</div>
    </div>	
    <div class="clear"></div>
    </div>
    </div>
    <div style="float:right;"><!--<input type="submit" name="save" value="Save" class="login_btn" onclick="return check_box();" />--></div>
    </form>	

    
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

<script>
	function check(val){
		//alert(val);
		if(val == 'Daily'){
			$(".all").hide();
			$("#day").show();
		}
		if(val == 'Weekly'){
			$(".all").hide();
			$("#week").show();
			$("#week1").show();
		}
		if(val == 'Monthly'){
			$(".all").hide();
			$("#month1").show();
			$("#month").show();
		}
		if(val == 'Yearly'){
			$(".all").hide();
			$("#year").show();
		}
	}
    
        
    var decodeHtml = function (html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }
    
    var updateShortDescriptionText = function() {
        if($('textarea#short_desc_sp').val().trim() == "") {                                   
            var event_des_sp = CKEDITOR.instances['page_content_sp'].getData();
            if (event_des_sp != "") {
                // Remove strip tag
                event_des_sp = event_des_sp.replace(/<\/?[^>]+(>|$)/g, "");

                // Remove html entities
                event_des_sp = decodeHtml(event_des_sp);
                
                // Remove line break
                event_des_sp = event_des_sp.trim();

                $('textarea#short_desc_sp').val(event_des_sp.substring(0, 160));
                limiter();
            }
        }

        if($('textarea#short_desc_en').val().trim() == "") {                                   
            var event_des_en = CKEDITOR.instances['page_content_en'].getData();
            if (event_des_en != "") {
                // Remove strip tag
                event_des_en = event_des_en.replace(/<\/?[^>]+(>|$)/g, "");	
                
                // Remove html entities
                event_des_en = decodeHtml(event_des_en);
                
                // Remove line break
                event_des_en = event_des_en.trim();

                $('textarea#short_desc_en').val(event_des_en.substring(0, 160));
                limiter1();
            }
        }  
    }
    
    $(document).ready(function() {
        var pageSpEditor = CKEDITOR.instances['page_content_sp'];
        
        var pageEnEditor = CKEDITOR.instances['page_content_en'];

        pageSpEditor.on("blur", function(e) {
            if ($(document.activeElement).get(0).tagName.toLowerCase() != "iframe") {
                updateShortDescriptionText();      
            }
        });
        
        pageEnEditor.on("blur", function(e) {
            if ($(document.activeElement).get(0).tagName.toLowerCase() != "iframe") {
                updateShortDescriptionText();    
            }
        });
       
    });
    
</script>  
</body>
</html>
