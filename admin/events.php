<?php

// home page
session_start();
include('../include/admin_inc.php');
include('../twitteroauth/twitterStatus.php');
include('../facebookapi/facebookStatus.php');
include('../pinterestapi/pinterestStatus.php');

//print_r($_SESSION);

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
$obj_multi = new admin;
$obj_dup_event_master_type = new admin;
$obj_add_eventtype = new admin;
$obj_get_event_id = new admin;
//$objgallerylist_num = new admin;
//$objgallerylist_num->allGalleryByID_count($event_id);
//$num_image_gallery = $objgallerylist_num->num_rows();

$objlist_event_delete=new admin;
$objlist_ticket_delete=new admin;

$obj_event_photo = new admin;

$objCommon = new Common();
$objTwitter = new twitterStatus();
$objFacebook = new facebookStatus();
$objPinterest = new pinterestStatus();

$objLocation = new user;
$objVenueLocation = new user;

$obj_dup_event_master_type->getEventTypeMster();
$chk = "checked='checked'";
$objlist->category_list();
//$objlist_most_used->most_used_category();

$obj_user_venue = new admin;
$obj_user_venue->get_user_venue($_SESSION['ses_user_id']);
$selected_venue = '';
$selected_venue_state = '';
$selected_venue_county = '';
$selected_venue_city = '';
while($obj_user_venue->next_record())
{
    $selected_venue = $obj_user_venue->f('selected_venue');
    $selected_venue_state = $obj_user_venue->f('selected_venue_state');
    $selected_venue_county = $obj_user_venue->f('selected_venue_county');
    $selected_venue_city = $obj_user_venue->f('selected_venue_city');
}


//$unique_id = session_id();


if(isset($_GET['action']) && $_GET['action']=="delete")
{
	$event_id = $_REQUEST['event_id'];
	$objlist->delete_event($event_id);
	$objlist_event_delete->getEventById($event_id);
	$objlist_event_delete->next_record();
	@unlink("../files/event/large/".$objlist_event_delete->f('event_photo'));
	@unlink("../files/event/medium/".$objlist_event_delete->f('event_photo'));
	@unlink("../files/event/thumb/".$objlist_event_delete->f('event_photo'));

	$objlist->delete_event_type($event_id);
	$objlist->delete_event_category($event_id);
	$objlist->delete_event_ticket($event_id);
	$objlist_ticket_delete->getTicketById($event_id);
	while($objlist_ticket_delete->next_record())
	{
		@unlink("../files/ticket/large/".$objlist_ticket_delete->f('ticket_icon'));
		@unlink("../files/ticket/medium/".$objlist_ticket_delete->f('ticket_icon'));
		@unlink("../files/ticket/thumb/".$objlist_ticket_delete->f('ticket_icon'));
         }
	
	$objlist->delete_sub_event($event_id);
	$objlist->delete_sub_event_type($event_id);
	$objlist->delete_sub_event_category($event_id);
	$objlist->delete_sub_event_ticket($event_id);
	header("location: ".$obj_base_path->base_path()."/admin/events");
	exit;
}



if (isset($_POST['addevent']) && $_POST['addevent'] == '1') {
    $finalArray = $_POST['maincat'];

    $event_name_sp = addslashes(str_replace("'", " ", $_POST['event_name_sp']));
    $event_name_en = addslashes(str_replace("'", " ", $_POST['event_name_en']));

    $short_desc_sp = addslashes(str_replace("'", " ", $_POST['short_desc_sp']));
    $short_desc_en = addslashes(str_replace("'", " ", $_POST['short_desc_en']));

    // Check weather short Description is empty
    if ($short_desc_sp == "") {
        $short_desc_sp = substr(trim(strip_tags(addslashes($_POST['page_content_sp']))), 0, 160);
    }

    if ($short_desc_en == "") {
        $short_desc_en = substr(trim(strip_tags(addslashes($_POST['page_content_en']))), 0, 160);
    }

//	if($_POST['event_start_ampm'] == 'PM') {
//            if($_POST['event_hr_st'] == 12) {
//                $event_start_hour=12;
//            } else {
//                $event_start_hour = $_POST['event_hr_st']+12;
//            }
//	} else {
//	    $event_start_hour = $_POST['event_hr_st'];
//	}
        
    $event_start_hour = $_POST['event_hr_st'];    
    $event_start_date_time = $_POST['event_year_st'] . "-" . $_POST['event_month_st'] . "-" . $_POST['event_day_st'] . " " . $event_start_hour . "-" . $_POST['event_min_st'] . "-00";
    if ($event_start_hour < 12) {
        $event_start_ampm = 'AM';  
    } else {
        $event_start_ampm = 'PM';  
    }
//    $event_start_ampm = $_POST['event_start_ampm'];
//    if ($_POST['event_end_ampm'] == 'PM') {
//        if ($_POST['event_hr_end'] == 12) {
//            $event_end_hour = 12;
//        } else {
//            $event_end_hour = $_POST['event_hr_end'] + 12;
//        }
//    } else {
//        $event_end_hour = $_POST['event_hr_end'];
//    }
    $event_end_hour = $_POST['event_hr_end'];
    
    $event_end_date_time = $_POST['event_year_end'] . "-" . $_POST['event_month_end'] . "-" . $_POST['event_day_end'] . " " . $event_end_hour . "-" . $_POST['event_min_end'] . "-00";
//    $event_end_ampm = $_POST['event_end_ampm'];
    
    if ($event_end_hour < 12) {
        $event_end_ampm = 'AM';  
    } else {
        $event_end_ampm = 'PM';  
    }
    
    $venue_state = addslashes($_POST['venue_state']);
    $venue_county = addslashes($_POST['venue_county']);
    $venue_city = addslashes($_POST['venue_city']);
    $venue = addslashes($_POST['venue']);
    $page_content_en = addslashes($_POST['page_content_en']);
    $page_content_sp = addslashes($_POST['page_content_sp']);
    $event_tag = addslashes($_POST['event_tag']);

    $event_day_st = $_POST['event_day_st'];
    $event_year_st = $_POST['event_year_st'];
    $event_month_st = $_POST['event_month_st'];

    $event_year_end = $_POST['event_year_end'];
    $event_month_end = $_POST['event_month_end'];
    $event_day_end = $_POST['event_day_end'];
    //$file_name = $_POST['event_photo'];

    $identical_function = $_POST['identical_function'];
    $recurring = $_POST['recurring'];
    $sub_events = $_POST['sub_events'];


    $Paypal = $_POST['Paypal'];
    $Bank = $_POST['Bank'];
    $Oxxo = $_POST['Oxxo'];
    $Mobile = $_POST['Mobile'];
    $Offline = $_POST['Offline'];

    //$publish_date = $_POST['year_1']."-".$_POST['month_1']."-".$_POST['day_1'];
    if (isset($_POST['saveEvent_x'])) {
        $publish_date = $_POST['multi_event_year1'] . "-" . $_POST['multi_event_month1'] . "-" . $_POST['multi_event_day1'];
    } else {
        $publish_date = $_POST['year_1'] . "-" . $_POST['month_1'] . "-" . $_POST['day_1'];
    }

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
    /* print_r($a1);
      $arr = explode("/",$a1);

      $a = array($arr[2],$arr[0],$arr[1]);
      $r_span_start = implode("-",$a); */

    $r_span_end = $_POST['r_span_end'];
    /* $arr1 = explode("/",$b1);
      $b = array($arr1[2],$arr1[0],$arr1[1]);
      $r_span_end = implode("-",$b); */

    $event_start = $_POST['event_start'];
    $event_end = $_POST['event_end'];
    $all_day = $_POST['all_day'];
    $event_lasts = $_POST['event_lasts'];

    $attendees = $_POST['attendees'];
    $invitation_only = $_POST['invitation_only'];
    $password_protect_check = $_POST['password_protect_check'];
    $pass_protected = $_POST['pass_protected'];

    $privacy = $_POST['privacy'];

    $radio_access = $_POST['radio_access'];
    if ($radio_access == 1) {
        $pay_ticket_fee = $_POST['pay_ticket_fee'];
        $promo_charge = $_POST['promo_charge'];
    } else {
        $pay_ticket_fee = '';
        $promo_charge = '';
    }

    $event_types = $_POST['event_types'];

    $paper_less_mob_ticket = $_POST['paper_less_mob_ticket'];
    $print = $_POST['print'];
    $will_call = $_POST['will_call'];


    if (isset($_POST['saveEvent_x'])) {
        $status = 'saved';
    } else {
        $status = $_POST['status'];
    }

    //$status = $_POST['status'];
    //echo "hii".$publish_date; exit;

    $fetch_temp_tickets_num = $obj_temp_tickets_call->fetch_temp_tickets($_SESSION['unique_id']);
    //echo $_POST['ticket_buy']; exit;

    if (($fetch_temp_tickets_num != 0 && $_POST['ticket_buy'] == 1) || $_POST['ticket_buy'] == 0) {

        // Add Event Tickets
        $obj_add_ticket->addFinalTicket($_SESSION['unique_id']);


        // Delete Temp Event
        $obj_delete->deleteTicket($_SESSION['unique_id']);
    }
    /* else
      {
      $msg="You must add tickets!!!";
      } */

    // Add Event
    //$last_event_id = $obj_add->addEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call);

    $obj_get_event_id->get_event_id($_SESSION['unique_id']);
    $obj_get_event_id->next_record();
    $event_id = $obj_get_event_id->f('event_id');
    //echo "hii".$event_id; exit;


    /*
      try {
      // post to twitter
      $objLocation->getStateCountyByEventID($event_id);
      $objLocation->next_record();
      $objVenueLocation->getVenueLocationByVenueID($venue);
      $objVenueLocation->next_record();

      $urlEventEN = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($event_id, $objLocation, 'en', 'event', $event_name_en);
      $urlEventES = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($event_id, $objLocation, 'es', 'evento', $event_name_sp);

      $twitterTime = substr($event_start_date_time, 0, 10);

      $dateEN = date_create_from_format('Y-m-d', $twitterTime);
      $twitterDateEN = date_format($dateEN, 'd-M');

      setlocale(LC_TIME, 'es_ES');
      $twitterDateES = strftime("%d-%b", strtotime($twitterTime));

      $venueEN = $objVenueLocation->f('venue_name');
      $venueES = $objVenueLocation->f('venue_name_sp');
      $cityName = $objVenueLocation->f('city_name');

      $eventNameEN = $_POST['event_name_en'];
      $eventNameES = $_POST['event_name_sp'];

      $statusTwitterEN = "$eventNameEN, $twitterDateEN, $venueEN, $cityName, visit: $urlEventEN";
      $statusTwitterES = "$eventNameES, $twitterDateES, $venueES, $cityName, visit: $urlEventES";
      //$objTwitter->postStatus($statusTwitterEN);
      //$objTwitter->postStatus($statusTwitterES);

      // Post to facebook
      $statusFacebookEN = [
      'link' => $urlEventEN,
      'message' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
      ];
      $statusFacebookES = [
      'link' => $urlEventES,
      'message' => "$eventNameES, $twitterDateES, $venueES, $cityName",
      ];
      //$objFacebook->postStatus($statusFacebookEN);
      //$objFacebook->postStatus($statusFacebookES);


      // Post to pinterest
      $imagePinterestDefault = $obj_base_path->base_path() . '/images/kpasapp_logo_fb.png';
      $obj_event_photo->getPhotoByEventId($event_id);
      if($obj_event_photo->num_rows()){
      $obj_event_photo->next_record();
      if($obj_event_photo->f('event_photo') != "") {
      $imagePinterestDefault = $obj_base_path->base_path() . '/files/event/large/' . $obj_event_photo->f('event_photo');
      }
      }
      $statusPinterestEN = [
      'url' => $urlEventEN,
      'description' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
      'image' => $imagePinterestDefault
      ];
      $statusPinterestES = [
      'url' => $urlEventES,
      'description' => "$eventNameES, $twitterDateES, $venueES, $cityName",
      'image' => $imagePinterestDefault
      ];

      $objPinterest->postStatus($statusPinterestEN, $venue_county, 'en');
      $objPinterest->postStatus($statusPinterestES, $venue_county, 'es');

      setlocale(LC_TIME, 'en_US');
      } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
     */
    $last_event_id = $obj_add->editSavedEvent($_SESSION['ses_user_id'], $event_name_sp, $event_name_en, $short_desc_sp, $short_desc_en, $event_start_date_time, $event_start_ampm, $event_end_date_time, $event_end_ampm, $venue_state, $venue_county, $venue_city, $venue, $page_content_en, $page_content_sp, $event_tag, $identical_function, $recurring, $sub_events, $Paypal, $Bank, $Oxxo, $Mobile, $Offline, $publish_date, $event_time, $event_time_period, $r_month, $r_month_day, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $r_span_start, $r_span_end, $event_start, $event_end, $all_day, $event_lasts, $attendees, $invitation_only, $password_protect_check, $pass_protected, $radio_access, $pay_ticket_fee, $promo_charge, $paper_less_mob_ticket, $print, $will_call, $status, $privacy, $_SESSION['unique_id']);

    // Add Multiple Events
    $obj_multi->addMultipleEvent($_SESSION['unique_id'], $event_id);

    // Add category Event
    $obj_add_category_by_event->addCategoryByEvent($finalArray, $event_id);

    // Add Event Type

    $obj_add_eventtype->addEventType($event_types, $event_id);

    // Update event Id
    //$obj_edit_ticket->editTicketByEvent($_SESSION['unique_id'],$last_event_id);
    //echo "hii";
    //
	if (isset($_POST['saveEvent_x'])) {
        $_SESSION['msg'] = "Event saved successfully";
    } else {
        $_SESSION['msg'] = "Event created successfully";
    }




    header("Location:" . $obj_base_path->base_path() . "/admin/events");
    exit;
}
/*else
{*/
	$_SESSION['unique_id'] = time();
	$_SESSION['event_id'] = '';
	//$objlist->getEventId($_SESSION['unique_id']);

//}
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
<meta name="p:domain_verify" content="3016db54dbfcb20339ca2c7c3c9b5fc3"/>

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
   var day_name=new Array(7);
	day_name[1]="Mon";
	day_name[2]="Tue";
	day_name[3]="Wed";
	day_name[4]="Thu";
	day_name[5]="Fri";
	day_name[6]="Sat";
	day_name[0]="Sun";
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

//calendar
$(document).ready(function() {
        $('#event_date_st, #event_month_st, #event_year_st').bind( "click", function(e) {           
            $(this).siblings('.event_start_datepicker').show().focus().hide();            
        });
	
	$('.event_start_datepicker').datepicker({
            firstDay: 1 ,	   
            showButtonPanel: true,
            beforeShow:function (textbox) {
                setTimeout(function () {
                    $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
                }, 300);
            },
            onSelect: function(theDate) {
                $('.event_start_datepicker').datepicker('setDate', theDate);
                $('.event_end_datepicker').datepicker('setDate', theDate);   

                $('#multi_event_day_start').datepicker('option', 'defaultDate', theDate);
                $('#multi_event_month_start').datepicker('option', 'defaultDate', theDate);
                $('#multi_event_year_start').datepicker('option', 'defaultDate', theDate);

                $('#multi_event_day_end').datepicker('option', 'defaultDate', theDate);
                $('#multi_event_month_end').datepicker('option', 'defaultDate', theDate);
                $('#multi_event_year_end').datepicker('option', 'defaultDate', theDate);
			
                var n = theDate.split("/");
                $("input[name='event_month_st']").val(n[0]);
                $("input[name='event_day_st']").val(n[1]);
                $("input[name='event_year_st']").val(n[2]);

                $('#event_month_end').val(n[0]);
                $('#event_date_end').val(n[1]);
                $('#event_year_end').val(n[2]);
                var ticket_to_date = n[1]+"-"+n[0]+"-"+n[2];
                $('#to_ticket').val(ticket_to_date);

                // For Span Start Date
                var r_span_start = n[2]+"-"+n[0]+"-"+n[1];
                $('#r_span_start').val(r_span_start);

                var next_year = parseInt(n[2]) + 1;
                var r_span_end = next_year+"-"+n[0]+"-"+n[1];
                $('#r_span_end').val(r_span_end);

                // +============= For multi-function: +=====================
                // For Start Date
                $('#multi_event_month_start').val(n[0]);
                $('#multi_event_day_start').val(n[1]);
                $('#multi_event_year_start').val(n[2]);

                // For End Date
                $('#multi_event_month_end').val(n[0]);
                $('#multi_event_day_end').val(n[1]);
                $('#multi_event_year_end').val(n[2]);

                // Set Parent Date
                var dt = new Date(n[0]+" "+n[1]+" , "+n[2]);
                var month_no = parseInt(n[0])-1;
                
                $('#showEveDate').html('<span style="font-weight:bold; font-size:16px;">'+day_name[dt.getDay()]+'</span><span style="font-weight:bold;color:#0094A4;font-size:16px;">'+monthNames[month_no]+'</span><span style="font-weight:bold; font-size:16px;color:#0094A4">'+n[1]+'</span>');
                $('#showEvehr').html('<span style="font-weight:bold; font-size:16px;padding:0px;color:#0094A4;">7</span>');
                $('#showEvemin').html('<span style="font-weight:bold; font-size:16px;padding:0px;color:#0094A4;"> : 00 </span>');	
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

$(document).ready(function() {
	var today = new Date();
	var dd = today.getDate();
	var mon = today.getMonth()+1;
	var year = today.getFullYear();
	 
	 $('#multi_event_day1').val(dd);
	 $('#multi_event_month1').val(mon);
	 $('#multi_event_year1').val(year);
	 
	 $('#multi_event_day2').val(dd);
	 $('#multi_event_month2').val(mon);
	 $('#multi_event_year2').val(year);
});

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
		$('#loader').show();
		 var ticketVal = {"ticket_name_en":$('#ticket_name_en').val(),"ticket_name_sp":$('#ticket_name_sp').val(),"description_en":$('#description_en').val(),"description_sp":$('#description_sp').val(),"price_mx":$('#price_mx').val(),"price_us":$('#price_us').val(),"ticket_num":$('#ticket_num').val(),"from_ticket":$('#from_ticket').val(),"to_ticket":$('#to_ticket').val(),"eairly_dis_percen":$('#eairly_dis_percen').val(),"eairly_days":$('#eairly_days').val(),"group_dis_per":$('#group_dis_per').val(),"group_dis_days":$('#group_dis_days').val(),"photoname":$('#photoname').val(),"members_only":$('input:radio[name=members_only]:checked').val(),"edit_ticket":$('#edit_ticket').val(),"exit_ticket_id":$('#exit_ticket_id').val()}
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_temp_tickets.php",
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
			 $("#from_ticket").val('<?php echo date("d-m-Y");?>');
			 $("#to_ticket").val($('#event_date_st').val()+"-"+$('#event_month_st').val()+"-"+$('#event_year_st').val());
			 $("#eairly_dis_percen").val("");
			 $("#eairly_days").val("");
			 $("#group_dis_per").val("");
			 $("#group_dis_days").val("");
			 $("#photoname").val(""); 
			 document.getElementById("members_only2").checked = true ;

			$('html, body').animate({scrollTop: $(".event_ticketbg").offset().top}, 2000);
			$('#loader').hide();
		   }
		 });
		 return 1;
	}
}
</script>

<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
	// For Multiple Function ......... 	
		getCounty_multi(stateid,'');
		$('#multi_venue_state').val(stateid);
	// For Multiple Function ......... 	
		
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
	 saveAutoEvent();
}

function getCity(countyid)
{
	// For Multiple Function ......... 	
		getCity_multi(countyid,'');
		$('#venue_county_multi').val(countyid);
	// For Multiple Function ......... 	
		
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
	 saveAutoEvent();
}

function getVenue(cityid)
{
	// For Multiple Function ......... 	
		getVenue_multi(cityid,'');
		$('#multi_venue_city').val(cityid);
	// For Multiple Function ......... 	
		
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
	 saveAutoEvent();
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
	
	
//$(function(){
//		var btnUpload=$('#me1');
//		var mestatus=$('#mestatus1');
//		var files=$('#files');
//		new AjaxUpload(btnUpload, {
//			action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadPhotoEdit.php',
//			name: 'uploadfile',
//			onSubmit: function(file, ext){
//				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
//                    // extension is not allowed 
//					mestatus.text('Only JPG, PNG or GIF files are allowed');
//					return false;
//				}
//				mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
//			},
//			onComplete: function(file, response){
//				//On completion clear the status
//				mestatus.text('Photo Uploaded Sucessfully!');
//				$('#event_photo').val(response);
//				$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/'+response+'" alt="" />');
//				$('#me1').html('');
//				
//				//On completion clear the status
//			}
//		});
//		
//	});

function changeTimeMultiple (starttime) {
    if (starttime < 12) {
        $('#multi_event_start_ampm').val('AM');
    } else {
        $('#multi_event_start_ampm').val('PM');
    }
}
function changeTime(starttime)
{	
    var endtime = parseInt(starttime)+2;
    if (endtime > 23) {
       endtime = 23;
    }
    $('#event_hr_end').val(endtime);
   
// +============= For multi-function: +=====================

    // For Start Date
    $('#multi_event_hr_start').val(parseInt(starttime));

    // For End Date
    $('#multi_event_hr_end').val(parseInt(endtime));

    $('#showEvehr').html('<span style="font-weight:bold; font-size:16px;padding:0px;color:#0094A4;">'+starttime+'</span>');

// +============= For multi-function: +=====================
   
    if (starttime < 12) {
       $('#event_start_ampm').val('AM');
       $('#multi_event_start_ampm').val('AM');
    } else {
       $('#event_start_ampm').val('PM');
       $('#multi_event_start_ampm').val('PM');
    }
   
    if (endtime < 12) {
       $('#event_end_ampm').val('AM');
    } else {
        $('#event_end_ampm').val('PM');
    }
}
function changeminTime(starttime)
{

    $('#showEvemin').html('<span style="font-weight:bold; font-size:16px;padding:0px;color:#0094A4;"> : '+starttime+'</span>');
}
//function changeAMPM(starttime)
//{
//    $('#showEveampm').html('<span style="font-weight:bold; font-size:16px;padding:0px;color:#0094A4;"> - '+starttime+'</span>');
//}


</script>

<script type="text/javascript">
function status(type){
	//alert(type);
	$("#status").val(type);
}

function saveAutoEvent()
{
	//alert("save auto");
	var event_des_en = CKEDITOR.instances['page_content_en'].getData();
	var event_des_sp = CKEDITOR.instances['page_content_sp'].getData();

	sendData = $("#event_form").serialize();
	
	//  check something is written in event page..
	  $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_event.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: sendData+"&event_des_en="+encodeURIComponent(event_des_en)+"&event_des_sp="+encodeURIComponent(event_des_sp),   
	   success: function(data){
		//alert(data);
	   $("#display_preview").html('<a href="<?php echo $obj_base_path->base_path(); ?>/event/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
	   $("#display_preview2").html('<a href="<?php echo $obj_base_path->base_path(); ?>/event/'+data+'" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>');
	   
	   $("#display_save").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" onclick="saveEvent();" style="cursor:pointer;" />');
	   $("#display_save2").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" onclick="saveEvent();" style="cursor:pointer;" />');
	   
	   $("#display_delete").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deleteEvent('+data+');" style="cursor:pointer;" />');
	   $("#display_delete2").html('<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deleteEvent('+data+');" style="cursor:pointer;" />');
	   
	   $("#media_image").val(data.replace(" ", ""));
	   //return data;
	   
	   }
	 });
}

function saveEvent()
{
	var event_des_en = CKEDITOR.instances['page_content_en'].getData();
	var event_des_sp = CKEDITOR.instances['page_content_sp'].getData();

	sendData = $("#event_form").serialize();
	  $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_event_final.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: sendData+"&event_des_en="+encodeURIComponent(event_des_en)+"&event_des_sp="+encodeURIComponent(event_des_sp),   
	   success: function(data){ 
	   document.getElementById('savemsg').innerHTML = 'Event saved successfully';
	   }
	 });
}


function saveAutoEventIdentical()
{
	//  check something is written in event page..
	 var ticketVal = {"multi_event_day":$('#multi_event_day').val(),"multi_event_month":$('#multi_event_month').val(),"multi_event_year":$('#multi_event_year').val(),"multi_event_hr":$('#multi_event_hr').val(),"multi_event_min":$('#multi_event_min').val(),"multi_event_start_ampm":$('#multi_event_start_ampm').val(),"multi_venue_state":$('#multi_venue_state').val(),"venue_county_multi":$('#venue_county_multi').val(),"multi_venue_city":$('#multi_venue_city').val(),"multi_venue":$('#multi_venue').val(),"edit_multi_event":$('#edit_multi_event').val(),"exit_multi_event":$('#exit_multi_event').val()}
		$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_event_identical.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: ticketVal,   
	   success: function(data){ 
	     //alert(data);
	   }
	 });
}



function deleteTemp(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $('#loader').show();
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_delete_ticket.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
		 $('#loader').hide();
	   }
	 });
}

function editTempTicket(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $('#loader').show();
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
	   
	   if(data['members_only']=="1")
		  document.getElementById("members_only1").checked = true ;
	   else
			document.getElementById("members_only2").checked = true ;
	   
	   $('#edit_ticket').val(1);
	   $('#exit_ticket_id').val(ticket_id);
	   //End Fill the Text field
	   
	   //save_new_popup();
	   $('#loader').hide();
	   }
	 });
}


$(document).ready(function() {
	$('#from_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
	$('#to_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
})


function showMulEveName()
{
	 $('#showEventJS').html($('#event_name_en').val()+", ");
	 saveAutoEvent();
}

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

    // Get the modal
    var modal = document.getElementById('myModal');
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-model")[0];
    var done = document.getElementsByClassName("close-model-done")[0];

    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        // submit the form
        $('form#event_form').submit();
    }
    
    done.onclick = function() {
        modal.style.display = "none";
        $('form#event_form').submit();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            $('form#event_form').submit();
        }
    }
    
    $('.share-in-en').bind("click", function(e) {
        var win = window.open('<?php echo $obj_base_path->base_path(); ?>/en/event/' + $("#media_image").val() + '/', '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }    
    });
    
    $('.share-in-es').bind("click", function(e) {
        var win = window.open('<?php echo $obj_base_path->base_path(); ?>/es/evento/' + $("#media_image").val() + '/', '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
    });            
    
	return false;
}

function check_box(){
	//alert("hii"); return false;
	/*var fields = $("input[class='check']").serializeArray(); 
    if (fields.length == 0) 
    { 
        alert('No Event Type Selected!'); 
        // cancel submit
        return false;
    } */
    /*else 
    { 
        alert(fields.length + " items selected");
		return false; 
    }*/
	
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


function deleteEvent(event_id)
{
	var conf = confirm("Are you sure you want to delete this event?")
	if(conf == true)
    {
       window.location.href="<?php echo $obj_base_path->base_path(); ?>/admin/events.php?event_id="+event_id+"&action=delete";
    }
    else
    {
       return false;
    }
}


function func_type(){
	//alert("");
	var r = confirm("Please upgrade to professional profile.");
	if(r === true)
	{
			<?php
			$_SESSION['return'] = 'true';
			?>
			window.location = "<?php echo $obj_base_path->base_path()?>/professional_userprofile";
			return false;
			
	}
	//else
	//{
	//		<?php		
	//		//$_SESSION['usernm'] = $obj_head->f('username');
	//		//$_SESSION['ses_user_id'] = $obj_head->f('admin_id');
	//		//$_SESSION['ses_organization_id'] = $obj_head->f('organization_id');
	//		//$_SESSION['ses_admin_seller_type'] = $obj_head->f('seller_type');
	//		?>
	//		window.location = "<?php echo $obj_base_path->base_path()?>/admin/events";
	//		return false;
	//}
}

</script>

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
<?php include("../include/analyticstracking.php")?>

<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close-model {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-model:hover,
.close-model:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 20px 16px;
    background-color: #168AAC;
    color: white;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 23px;
    line-height: 30px;
}
.model-header h2 {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 23px;
    line-height: 50px;
}

.modal-body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    padding: 20px 16px;
}

.modal-footer {
    padding: 20px 16px;
    background-color: #168AAC;
    color: white;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    line-height: 20px;
    font-weight: normal;
}
.model-link a {
    padding: 10px 16px;
    display: inline-block;
    text-decoration: none;
    background: none repeat scroll 0 0 #168AAC;
    color: #fff;
}
.model-link a:hover {
    color: orange;
}

.model-link-first {
    display: inline-block;
    width: 15%;
}
.model-link {
    width: 20%;
    margin-top: 25px;
    margin-right: 10px;
    display: inline-block;
    text-align: center;
}

@media screen and (max-width: 675px) {
    .model-link-first {
        display: block;
        width: 50%;
    }
    .model-link-first { 
        margin-top: 15px; 
    }
    .model-link {
        width: auto;
        margin-top: 10px;        
    }
}
/*@media screen and (max-width: 509px) {
    .model-link-first { 
        margin-top: 15px; 
        display: block;
        width: 50%;
    }
    .model-link {
        display: block;
        margin-top: 10px;     
        width: 50%;    
        text-align: left;
    }
}*/
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
           <div class="blue_box10"><p><?= AD_MY_EVENTS ?></p></div>
           	<?php include("admin_menu/createevent_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><span id="savemsg"><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></span>
		
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
    <div class="myevent_box">
    <div class="myevent_left">
	<div class="event_name8">
    <div style="float: left; position: absolute; margin: 0 0 0 303px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/></div>
    <div style="float: left; margin: 0 auto;">
	<span class="lang_name">SP</span>
    <br/>
    <span class="event_fieldbg8">
		<input type="text" name="event_name_sp" id="event_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Nombre";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') {this.value=this.defaultValue}else{saveAutoEvent();}"/>
	</span>	
	<br/>
	</div>
    
	<div style="float: right; margin: 0 auto;">	
	<span  class="lang_name_eng">EN</span><br/>
    <span class="event_fieldbg8">
	<input type="text" name="event_name_en" id="event_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_en!=""){echo $event_name_en;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value==''){this.value=this.defaultValue}else{ showMulEveName();}"/>
	</span>	
	<br/>
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
            <td style="position: relative">
                <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_day_st" id="event_date_st" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo 00;}?>"  class="textbg_grey"  style="width: 30px;" />              
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_month_st" id="event_month_st" value="<?php if($msg!="" && $event_month_st!=""){echo $event_month_st;}else{echo 00;}?>" class="textbg_grey"  style="width: 30px;" />
            </td>
            <td>/</td>
            <td style="position: relative">
                <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_start_datepicker"/>
                <input type="text" name="event_year_st" id="event_year_st"  value="<?php if($msg!="" && $event_year_st!=""){echo $event_year_st;}else{echo 0000;}?>" class="textbg_grey"  style="width: 40px;" />
            </td>
            <td></td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onChange="changeTime(this.value);">
            <?php 
                  for($i=0; $i<24; $i++) {
                  ?>
            <option value="<?php echo $i; ?>" <?PHP if($i==19) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
            <?php }?>
          </select></td>
          <td style="padding: 9px 0;">/</td>
          <td style="padding: 9px 0;"><select name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;"  onChange="changeminTime(this.value);">
                  <?php 
                  for($j=0; $j<60; $j = $j + 5) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==0) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>

                </select></td>
            <td style="padding: 9px 0;">&nbsp;</td>
            <td style="padding: 9px 0; visibility: hidden">
                <select name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;" onchange="changeAMPM(this.value);">
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
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>YYYY</strong></td>
        </tr>
        <tr>
          <td style="position: relative">
              <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
              <input type="text" name="event_day_end" id="event_date_end" value="<?php if($msg!="" && $event_day_end!=""){echo $event_day_end;}else{echo 00;}?>" class="textbg_grey" style="width: 30px;"/>
          </td>
          <td>/</td>
          <td style="position: relative">
              <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
              <input type="text" name="event_month_end" id="event_month_end" value="<?php if($msg!="" && $event_month_end!=""){echo $event_month_end;}else{echo 00;}?>"  class="textbg_grey" style="width: 30px;"/>
          </td>
          <td>/</td>
          <td style="position: relative">
              <input type="text" style="display: none; width: 30px; position: absolute;" class="textbg_grey event_end_datepicker"/>
              <input type="text" name="event_year_end" id="event_year_end" value="<?php if($msg!="" && $event_year_end!=""){echo $event_year_end;}else{echo 0000;}?>"  class="textbg_grey" style="width: 40px;"/>
          </td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                  <?php 
                  for($i=0; $i<24; $i++) {
                  ?>
                  <option value="<?php echo $i; ?>" <?PHP if($i==21) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=0; $j<60; $j = $j + 5) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==0) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                  <?php }?>
                </select></td>
            <td style="padding: 9px 0; visibility: hidden">/</td>
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
	  <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value);">
        <option value=""><?=AD_STATE?></option>
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
		  <select id="venue_county" name="venue_county" class="selectbg12" onchange="saveAutoEvent();">
		  <option value=""><?=AD_COUNTY?></option>
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
		  <select name="venue_city" id="venue_city" class="selectbg12">
		  <option value=""><?=AD_CITY?></option>
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
		  <select name="venue" id="venue" class="selectbg12" onchange="setmultivenue();">
		  <option value=""><?=AD_VENUE?></option>
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
	//include_once($obj_base_path->base_path()."/ckeditor/ckeditor.php");
       $CKeditor = new CKeditor();
       $CKeditor->BasePath = 'ckeditor/';
       $CKeditor->editor('page_content_en');
	?>
    </div> 
    </div>
    </div>
    </div>	
    
    <!-- Short Description -->
    <div class="event_name8">
        <div style="float: left; margin: 0 auto;">
            <span class="event_fieldbg8">
                Meta descripci&#243;n para redes sociales
                <textarea name="short_desc_sp" id="short_desc_sp" class="event_field" style="width: 290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();" onkeyup="limiter()"></textarea>
                <script type="text/javascript">
                    document.write("<input type=text name=limit size=4 readonly value="+count+">");
                </script>
            </span>
        </div>
        <div style="float: right; margin: 0 auto;">	
            <span class="event_fieldbg8">
                Meta description for social networks
                <textarea name="short_desc_en" id="short_desc_en" class="event_field" style="width: 290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();"  onkeyup="limiter1()"></textarea>
                <script type="text/javascript">
                    document.write("<input type=text name=limit1 size=4 readonly value="+count1+">");
                </script>
            </span>
        </div>
    </div>
    <!-- End Description -->
    
    <script type="text/javascript">
	function showmultifunction(){
		if($('input:radio[name=identical_function]:checked').val()==1)
		{
			$('#multi_fun_details').show();
		}
		else
		{
			$('#multi_fun_details').hide();
		}
	}
	function showrecurringfunction(){
		if($('input:radio[name=recurring]:checked').val()==1)
		{
			$('#recurring_details').show();
		}
		else
		{
			$('#recurring_details').hide();
		}
	}

	//calendar
	$(document).ready(function() {
		$('#multi_event_day_start').datepicker({
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
				$('#multi_event_day_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_start').datepicker('option', 'defaultDate', theDate);
					
				var n=theDate.split("/");
				$("input[name='multi_event_month_start']").val(n[0]);
				$("input[name='multi_event_day_start']").val(n[1]);
				$("input[name='multi_event_year_start']").val(n[2]);

				var currentDate = new Date(theDate);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				var n1=theDate.split("/");
				
				$("input[name='multi_event_month_end']").val(n1[0]);
				$("input[name='multi_event_day_end']").val(n1[1]);
				$("input[name='multi_event_year_end']").val(n1[2]);
			}
		});
		
		$('#multi_event_month_start').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			beforeShow:function (textbox) 
			{
			  setTimeout(function () 
			  {
			   $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
			  }, 300);
			},
			onSelect: function(theDate) 
			{
				var n=theDate.split("/");
				$('#multi_event_day_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_start').datepicker('option', 'defaultDate', theDate);
					
				$("input[name='multi_event_month_start']").val(n[0]);
				$("input[name='multi_event_day_start']").val(n[1]);
				$("input[name='multi_event_year_start']").val(n[2]);

				var currentDate = new Date(theDate);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				var n1=theDate.split("/");
				
				$("input[name='multi_event_month_end']").val(n1[0]);
				$("input[name='multi_event_day_end']").val(n1[1]);
				$("input[name='multi_event_year_end']").val(n1[2]);
			}
			
		});
		
		$('#multi_event_year_start').datepicker({
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
				$('#multi_event_day_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_start').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_start').datepicker('option', 'defaultDate', theDate);
					
				var n=theDate.split("/");
				$("input[name='multi_event_month_start']").val(n[0]);
				$("input[name='multi_event_day_start']").val(n[1]);
				$("input[name='multi_event_year_start']").val(n[2]);

				var currentDate = new Date(theDate);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				var n1=theDate.split("/");
				
				$("input[name='multi_event_month_end']").val(n1[0]);
				$("input[name='multi_event_day_end']").val(n1[1]);
				$("input[name='multi_event_year_end']").val(n1[2]);
			}
		});
		
		$('#multi_event_day_end').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			beforeShow:function (textbox) 
			{
				var mul_st_dt = $("input[name='multi_event_month_start']").val()+"/"+$("input[name='multi_event_day_start']").val()+"/"+$("input[name='multi_event_year_start']").val();
				
				var currentDate = new Date(mul_st_dt);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				
				var n=mul_st_dt.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
				
				  setTimeout(function () 
				  {
				   $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
				  }, 300);

			},
			onSelect:function(theDate) 
			{
				$('#multi_event_day_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_end').datepicker('option', 'defaultDate', theDate);
					
				var n=theDate.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
			}
		});
		
		$('#multi_event_month_end').datepicker({
			firstDay: 1 ,	   
			showButtonPanel: true,
			beforeShow:function (textbox) 
			{
				var mul_st_dt = $("input[name='multi_event_month_start']").val()+"/"+$("input[name='multi_event_day_start']").val()+"/"+$("input[name='multi_event_year_start']").val();
				
				var currentDate = new Date(mul_st_dt);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				
				var n=mul_st_dt.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
				
				  setTimeout(function () 
				  {
				   $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
				  }, 300);

			},

			onSelect: function(theDate) 
			{
				$('#multi_event_day_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_end').datepicker('option', 'defaultDate', theDate);
					
				var n=theDate.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
			}
			
		});
		
		$('#multi_event_year_end').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			beforeShow:function (textbox) 
			{
				var mul_st_dt = $("input[name='multi_event_month_start']").val()+"/"+$("input[name='multi_event_day_start']").val()+"/"+$("input[name='multi_event_year_start']").val();
				
				var currentDate = new Date(mul_st_dt);
				var valueofcurrentDate = currentDate.valueOf();
				var newDate = new Date(valueofcurrentDate);
				
				$("#multi_event_month_end").datepicker("option", "minDate", newDate);
				$("#multi_event_day_end").datepicker("option", "minDate", newDate);
				$("#multi_event_year_end").datepicker("option", "minDate", newDate);
				
				var n=mul_st_dt.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
				
				  setTimeout(function () 
				  {
				   $("#ui-datepicker-div td.ui-datepicker-today a.ui-state-highlight").removeClass('ui-state-highlight');		     
				  }, 300);

			},
			onSelect:function(theDate) 
			{
				$('#multi_event_day_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_month_end').datepicker('option', 'defaultDate', theDate);
				$('#multi_event_year_end').datepicker('option', 'defaultDate', theDate);
					
				var n=theDate.split("/");
				$("input[name='multi_event_month_end']").val(n[0]);
				$("input[name='multi_event_day_end']").val(n[1]);
				$("input[name='multi_event_year_end']").val(n[2]);
			}
		});
		
		
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
		
		
		$('#r_span_start').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
			

		$('#r_span_end').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
		
});

function getCounty_multi(stateid,venue_county_multi)
{
     $('#div_city_display_multi').html('<select name="multi_venue_city" class="state selectbg12"><option value="">City</option></select>');
     $('#div_venue_display_multi').html('<select name="multi_venue" class="state selectbg12"><option value="">Venue</option></select>');
	 data = "state_id="+stateid+"&venue_county_multi="+venue_county_multi;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_county_multi.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display_multi").html(data);
	   }
	 });
}

function getCity_multi(countyid,multi_venue_city)
{
     $('#div_venue_display_multi').html('<select name="multi_venue" class="state selectbg12"><option value="">Venue</option></select>');
	 data = "county_id="+countyid+"&multi_venue_city="+multi_venue_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_city_multi.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display_multi").html(data);
	   }
	 });
}

function getVenue_multi(cityid,multi_venue)
{
     data = "city_id="+cityid+"&multi_venue="+multi_venue;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_venue_multi.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_venue_display_multi").html(data);
	   }
	 });
}


function delete_multipleEvents(temp_multi_event_id,event_id)
{
	 data = "temp_multi_event_id="+temp_multi_event_id+"&event_id="+event_id;
	 $('#loader1').show();
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_delete_multi_events.php",
	   //async: false,
	   cache: false,
	   type: "POST",
	   //dataType: 'json',
	   data: data,   
	   success: function(data){ 
			
		// Fill the Text field
	  // alert(data['ticket_name_en']);
	     $('#edit_multi_event').val(0);
		 $('#exit_multi_event').val(0);
		 $("#show_multi_events").html(data);
		 
		 
		/* $("#multi_event_day_start").val("00");
		 $("#multi_event_month_start").val("00");
		 $("#multi_event_year_start").val("0000");
		 $("#multi_event_hr_start").val("00");
		 $("#multi_event_min_start").val("00");
		 $("#multi_event_day_end").val("00");
		 $("#multi_event_month_end").val("00");
		 $("#multi_event_year_end").val("0000");
		 $("#multi_event_hr_end").val("00");
		 $("#multi_event_min_end").val("00");
		 //$("#multi_event_hr").val("7");
		 $('#multi_venue_state').val("");
		 $('#venue_county_multi').val("");
		 $('#multi_venue_city').val("");
		 $('#multi_venue').val("");*/
		 $('#loader1').hide();
	   }
	 });
}


function save_multiple()
{
	if(!checkmultipleevent())
	{
		return 0;
	}
	else{
		$('#loader1').show();
		 var ticketVal = {"multi_event_day_start":$('#multi_event_day_start').val(),"multi_event_month_start":$('#multi_event_month_start').val(),"multi_event_year_start":$('#multi_event_year_start').val(),"multi_event_hr_start":$('#multi_event_hr_start').val(),"multi_event_min_start":$('#multi_event_min_start').val(),"multi_event_start_ampm":$('#multi_event_start_ampm').val(),"multi_event_day_end":$('#multi_event_day_end').val(),"multi_event_month_end":$('#multi_event_month_end').val(),"multi_event_year_end":$('#multi_event_year_end').val(),"multi_event_hr_end":$('#multi_event_hr_end').val(),"multi_event_min_end":$('#multi_event_min_end').val(),"multi_event_end_ampm":$('#multi_event_end_ampm').val(),"multi_venue_state":$('#multi_venue_state').val(),"venue_county_multi":$('#venue_county_multi').val(),"multi_venue_city":$('#multi_venue_city').val(),"multi_venue":$('#multi_venue').val(),"edit_multi_event":$('#edit_multi_event').val(),"exit_multi_event":$('#exit_multi_event').val(),"event_hr_st":$('#event_hr_st').val(),"event_min_st":$('#event_min_st').val(),"event_start_ampm":$('#event_start_ampm').val(),"event_hr_end":$('#event_hr_end').val(),"event_min_end":$('#event_min_end').val(),"event_end_ampm":$('#event_end_ampm').val(),"event_date_st":$('#event_date_st').val(),"event_month_st":$('#event_month_st').val(),"event_year_st":$('#event_year_st').val(),"event_date_end":$('#event_date_end').val(),"event_month_end":$('#event_month_end').val(),"event_year_end":$('#event_year_end').val()}
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_temp_multievent.php",
		  // async: false,
		   cache: false,
		   type: "POST",
		   data: ticketVal,   
		   success: function(data){ 

			 $('#edit_multi_event').val(0);
			 $('#exit_multi_event').val(0);
			 $("#show_multi_events").html(data);			 
			 
			 /*$("#multi_event_day_start").val("00");
			 $("#multi_event_month_start").val("00");
			 $("#multi_event_year_start").val("0000");
			 $("#multi_event_hr_start").val("7");
			 $("#multi_event_min_start").val("00");
			 
			 $("#multi_event_day_end").val("00");
			 $("#multi_event_month_end").val("00");
			 $("#multi_event_year_end").val("0000");
			 $("#multi_event_hr_end").val("9");
			 $("#multi_event_min_end").val("00");
			 $("#multi_event_hr").val("7");
			 $('#multi_venue_state').val("");
		     $('#venue_county_multi').val("");
		     $('#multi_venue_city').val("");
		     $('#multi_venue').val("");*/

			// $('#div_state_display_multi').html('<select name="multi_venue_state" class="state selectbg12"><option value="">State</option></select>');
			/* $('#div_county_display_multi').html('<select name="venue_county_multi" class="state selectbg12"><option value="">County</option></select>');
			 $('#div_city_display_multi').html('<select name="multi_venue_city" class="state selectbg12"><option value="">City</option></select>');
			 $('#div_venue_display_multi').html('<select name="multi_venue" class="state selectbg12"><option value="">Venue</option></select>');*/
			 $('#loader1').hide();
		   }
		 });
		 return 1;
	}
}
function edit_multipleEvents(temp_multi_event_id)
{
	 data = "temp_multi_event_id="+temp_multi_event_id;
	 $('#loader1').show();
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_edit_multi_events.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   dataType: 'json',
	   data: data,   
	   success: function(data){ 
	   
	   show_hr_val_start = parseInt(data['multi_tm_hr_start']);
			
	   show_hr_val_end = parseInt(data['multi_tm_hr_end']);
			
	  /* getCounty_multi(data['multi_venue_state'],data['venue_county_multi']);
	   getCity_multi(data['venue_county_multi'],data['multi_venue_city']);
	   getVenue_multi(data['multi_venue_city'],data['multi_venue'])*/
			
		// Fill the Text field
	  // alert(data['ticket_name_en']);
	   $('#multi_event_day_start').val(data['multi_day_start']);
	   $('#multi_event_month_start').val(data['milti_mon_start']);
	   $('#multi_event_year_start').val(data['multi_year_start']);
	   $('#multi_event_hr_start').val(show_hr_val_start);
	   $('#multi_event_min_start').val(parseInt(data['multi_tm_min_start']));
	   $('#multi_event_start_ampm').val(data['event_start_ampm']);
	   $('#multi_event_day_end').val(data['multi_day_end']);
	   $('#multi_event_month_end').val(data['milti_mon_end']);
	   $('#multi_event_year_end').val(data['multi_year_end']);
	   $('#multi_event_hr_end').val(show_hr_val_end);
	   $('#multi_event_min_end').val(parseInt(data['multi_tm_min_end']));
	   $('#multi_event_end_ampm').val(data['event_end_ampm']);
	   /*$('#multi_venue_state').val(data['multi_venue_state']);
	   $('#venue_county_multi').val(data['venue_county_multi']);
	   $('#multi_venue_city').val(data['multi_venue_city']);
	   $('#multi_venue').val(data['multi_venue']);*/
	   
	   
	   $('#edit_multi_event').val(1);
	   $('#exit_multi_event').val(temp_multi_event_id);
	   $('#loader1').hide();
	   }
	 });
}

function checkmultipleevent(){
	var error = 0;
	var day_start = document.getElementById('multi_event_day_start').value;
	if(day_start == 0){
		$("#multi_event_day_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_day_start").css("border","1px solid E1E1E1");
	}
	var month_start = document.getElementById('multi_event_month_start').value;
	if(month_start == 0){
		$("#multi_event_month_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_month_start").css("border","1px solid E1E1E1");
	}
	var year_start = document.getElementById('multi_event_year_start').value;
	if(year_start == 0){
		$("#multi_event_year_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_year_start").css("border","1px solid E1E1E1");
	}
	
	var hr_start = document.getElementById('multi_event_hr_start').value;
	if(hr_start == 0){
		$("#multi_event_hr_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_hr_start").css("border","1px solid E1E1E1");
	}
	
/*var day_end = document.getElementById('multi_event_day_end').value;
	if(day_end == 0){
		$("#multi_event_day_end").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_day_end").css("border","1px solid E1E1E1");
	}
	var month_end = document.getElementById('multi_event_month_end').value;
	if(month_end == 0){
		$("#multi_event_month_end").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_month_end").css("border","1px solid E1E1E1");
	}
	var year_end = document.getElementById('multi_event_year_end').value;
	if(year_end == 0){
		$("#multi_event_year_end").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_year_end").css("border","1px solid E1E1E1");
	}
	
	var hr_end = document.getElementById('multi_event_hr_end').value;
	if(hr_end == 0){
		$("#multi_event_hr_end").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_hr_end").css("border","1px solid E1E1E1");
	}*/
	
	/*var state = document.getElementById('multi_venue_state').value;
	if(state == 0){
		$("#multi_venue_state").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue_state").css("border","1px solid E1E1E1");
	}
	
	var country = document.getElementById('venue_county_multi').value;
	if(country == 0){
		$("#venue_county_multi").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#venue_county_multi").css("border","1px solid E1E1E1");
	}
	
	var city = document.getElementById('multi_venue_city').value;
	if(city == 0){
		$("#multi_venue_city").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue_city").css("border","1px solid E1E1E1");
	}
	
	var venue = document.getElementById('multi_venue').value;
	if(venue == 0){
		$("#multi_venue").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue").css("border","1px solid E1E1E1");
	}*/
	
	if(error == 1){
		return false;
	}
	else
	{
		return true;
	}
}

function subEvent() 
{
	saveAutoEvent();
	//alert(<?php echo $_SESSION['unique_id'];?>);
	window.open("<?php echo $obj_base_path->base_path(); ?>/admin/sub_events");
}
function setstartTime()
{
	var event_start = $('#event_start').val();
	if(event_start!="")
	{
		var start_time = event_start.split(" ");
		var set_time = start_time[0].split(":");
		$('#event_hr_st').val(parseInt(set_time[0]));
		$('#event_min_st').val(set_time[1]);
		$('#event_start_ampm').val(start_time[1]);
	}
}
function setendTime()
{
	var event_end = $('#event_end').val();
	if(event_end!="")
	{
		var start_time = event_end.split(" ");
		var set_time = start_time[0].split(":");
		$('#event_hr_end').val(parseInt(set_time[0]));
		$('#event_min_end').val(set_time[1]);
		$('#event_end_ampm').val(start_time[1]);
	}
}
function displayEvent(num)
{
	if(num==1)
	{
		 data = "city_id="+$('#venue_city').val()+"&num="+num;
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/show_value.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: data,   
		   success: function(data){ 
			   $('#showCityName').html(data);
		   }
		 });
	}
	/*if(num==2)
	{
		setmultivenue();
		 data = "venue_id="+$('#venue').val()+"&num="+num;
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/show_value.php",
		   async: false,
		   cache: false,
		   type: "POST",
		   data: data,   
		   success: function(data){ 
			   $('#showVenueName').html(data);
		   }
		 });
	}*/	
	saveAutoEvent();
}

function media_library()
{
    //alert('hi!');
    saveAutoEvent();
    var e_id=$("#media_image").val();
    //alert("m= "+e_id);

        window.location="<?php echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/"+e_id;
    return false;
	
}

</script>
    <div class="clear"></div>
    <div class="event_date" style="float: right; width: 700px;">
  	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
    	<tr>
          <td width="79%">
              <p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/>
                    <?= AD_EVENT_TYPE_ONE ?>
              </p>
          </td>
          <td width="21%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; width: 150px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;">
              <input name="identical_function" type="radio" onclick="showmultifunction(); saveAutoEvent();" value="1" <?php  if($msg!="" && $_POST['identical_function']==1){?> checked="checked"<?php }?>/>		  </td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;"><?= AD_YES_OPTION ?></td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;">
              <input name="identical_function" type="radio"  onclick="showmultifunction(); saveAutoEvent();" value="0" <?php  if($msg!="" && $_POST['identical_function']==0){ echo $chk; } echo $chk;?>/>		  </td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;"><?= AD_NO_OPTION ?></td>
            </tr>
          </table></td>
        </tr>
	 	<tr style="display:none;" id="multi_fun_details">
     	 <td colspan="2">
            <div class="event_ticketl2">
            <img id="loader1" src="<?php echo $obj_base_path->base_path(); ?>/images/loader.gif" alt="" width="67" height="75" border="0" style="display:none;"/>
            <div style="">
                <span id="showEventJS" style="font-weight: bold;font-size:16px; padding: 0; margin: 5px 0 0 10px;width: 231px; display: inline-block;"></span>
                
                <span id="showEveDate" style="padding:0; margin: 0;"></span>
                <span id="showEvedash" style="padding:0;color:#0094A4; font-weight:bold;"> - </span>
                <span id="showEvehr" style="padding:0px;color:#0094A4;"></span><span style="padding:0;" id="showEvemin"></span><span style="padding:0 !important;" id="showEveampm"></span>
            </div>
            <div id="show_multi_events"  style="margin: 0 auto 5px auto;"></div>
             <div class="clear"></div>
            <div><h1 style="color:#000000;"><?= AD_ADD_ANOTHER_FUNC ?></h1></div>
            <div class="date_left">
                <input type="hidden" name="edit_multi_event" id="edit_multi_event" value="0" />
                <input type="hidden" name="exit_multi_event" id="exit_multi_event" value="0" />
                <span id="showVenueName"></span>
                <span id="showCityName"></span>
               <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="46%" style="text-align:left;"><h1 style="padding: 51px 0 0 8px; margin:0; text-align: left;"><?= AD_DATE ?> <?=AD_STARTS?></h1></td>
                  <td width="70%">
                  <table align="right" border="0" cellspacing="0" cellpadding="0" style="margin: 17px 0;">
                     <tr>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
                        <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
                        <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
                        <td style="color:#FF0000; padding: 0 0 0 13px;"><strong><?= AD_YEAR_FORMAT ?></strong></td>
                    </tr> 
                    <tr>
                      <td style="text-align:left; padding: 0;">
                        <input type="text" name="multi_event_day_start" id="multi_event_day_start" value="<?php echo 00;?>"  class="textbg_grey"  style="width: 40px;"/>
                      </td>
                      <td style="text-align: center; padding: 0 0 0 9px;">/</td>
                      <td style="text-align:left;">
                        <input type="text" name="multi_event_month_start" id="multi_event_month_start" value="<?php echo 00;?>" class="textbg_grey"  style="width: 40px;"/>
                      </td>
                      <td style="text-align: center; padding: 0;">/</td>
                      <td style="text-align:left; padding: 0;">
                        <input type="text" name="multi_event_year_start" id="multi_event_year_start"  value="<?php echo 0000;?>" class="textbg_grey"  style="width: 40px;"/>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; text-align:left;">
                        <select name="multi_event_hr_start" onchange="changeTimeMultiple(this.value);" class="selectbg" id="multi_event_hr_start" title="Please select event hour" style="width:50px;float:left;">
                        <?php 
                              for($i=0; $i<24; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>" <?PHP if($i==19) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                        <?php }?>
                      </select></td>
                      <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                      <td style="padding: 3px 0 0 0;">
                            <select name="multi_event_min_start" class="selectbg" id="multi_event_min_start" title="Please select event miniute" style="width:50px;float:left;">
                              <?php 
                              for($j=00; $j<60; $j = $j + 5) {
                              ?>
                              <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                              <?php }?>
                                  
                            </select></td>
                        <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                            <td style="padding: 3px 0; text-align:left; visibility: hidden">
                                <select name="multi_event_start_ampm" class="selectbg" id="multi_event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                                    <option value="AM">AM</option>
                                    <option value="PM" selected="selected">PM</option>
                                </select>
                            </td>
                        </tr>
                  </table>
                  </td>
                 </tr>
                </table>
                </div>
                <!--<div class="date_right">
                <table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" style="margin: 20px auto 0 auto;">
                <tr>
                  <td width="46%" style="text-align:left;"><h1 style="padding: 31px 12px 0 0; margin:0; text-align: right;">Ends</h1></td>
                  <td width="94%"><table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" style="margin: 17px 0;">      
                    <tr>
                      <td style="text-align:left; padding: 0;">
                        <input type="text" name="multi_event_day_end" id="multi_event_day_end" value="<?php echo 00;?>"  class="textbg_grey"  style="width: 40px;"/>
                      </td>
                      <td style="text-align: center; padding: 0 0 0 9px;">/</td>
                      <td style="text-align:left;">
                        <input type="text" name="multi_event_month_end" id="multi_event_month_end" value="<?php echo 00;?>" class="textbg_grey"  style="width: 40px;"/>
                      </td>
                      <td style="text-align: center; padding: 0;">/</td>
                      <td style="text-align:left; padding: 0;">
                        <input type="text" name="multi_event_year_end" id="multi_event_year_end"  value="<?php echo 0000;?>" class="textbg_grey"  style="width: 40px;"/>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; text-align:left;">
                        <select name="multi_event_hr_end" class="selectbg" id="multi_event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                        <?php 
                              for($i=0; $i<23; $i++) {
                              ?>
                        <option value="<?php echo $i; ?>" <?PHP if($i==21) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                        <?php }?>
                      </select></td>
                      <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                      <td style="padding: 3px 0 0 0;">
                            <select name="multi_event_min_end" class="selectbg" id="multi_event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                              <?php 
                              for($j=00; $j<60; $j++) {
                              ?>
                              <option value="<?php echo $j; ?>" <?PHP if($j==00) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                              <?php }?>
                                  
                            </select></td>
                      <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                      <td style="padding: 3px 0; text-align:left;"><select name="multi_event_end_ampm" class="selectbg" id="multi_event_end_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                              <option value="AM">AM</option>
                              <option value="PM" selected="selected">PM</option>
                            </select></td>
                      </tr>
                  </table></td>
                 </tr>
                </table>
		</div>-->
                </div>                     
             <div class="clear"></div>
                 <input type="hidden" name="multi_venue_state" id="multi_venue_state" value="" />
                 <input type="hidden" name="venue_county_multi" id="venue_county_multi" value="" />
                 <input type="hidden" name="multi_venue_city" id="multi_venue_city" value="" />
                 <input type="hidden" name="multi_venue" id="multi_venue" value="" />
		 <input type="hidden" name="media_image" id="media_image" value="" />
		 
            <?php /*?><div class="event_date">
              <table align="left" width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                     <td width="6%" style="text-align:right;"><h1 style="padding: 3px 0 0 10px; margin:0; text-align:right;">Venue</h1></td>
                    <td width="95%" style="padding: 0;">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><div id="div_state_display_multi">
                            <select name="multi_venue_state" class="state selectbg" id="multi_venue_state" onChange="getCounty_multi(this.value,'');">
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
                          </select></div></td>
                          <td>
                          <div id="div_county_display_multi">
                              <select name="venue_county_multi" id="venue_county_multi" class="state selectbg12">
                              <option value="">County</option>
                              <?php
                                    $obj_getcounty = new admin;
                                    $obj_getcounty->getCountyNameByState($venue_state);
                                    while($obj_getcounty->next_record())
                                    {
                                    ?>
                                    <option value=<?php echo $obj_getcounty->f("id")?> <?php if($venue_county==$obj_getcounty->f('id')){?> selected="selected"<?php }?> >
                                    <?php echo $obj_getcounty->f('county_name')?></option>
                                    <?php
                                    }
                              ?>
                              </select>
                              </div></td>
                          <td>
                          <div id="div_city_display_multi">
                              <select name="multi_venue_city" id="multi_venue_city" class="state selectbg12">
                              <option value="">City</option>
                               <?php
                              if($msg!="")
                              {
                                    $obj_getcity_multi = new admin;
                                    $obj_getcity_multi->getCityNameByCounty($venue_county);
                                    while($obj_getcity_multi->next_record())
                                    {
                                    ?>
                                    <option value=<?php echo $obj_getcity_multi->f("id")?> <?php if($venue_city==$obj_getcity_multi->f('id')){?> selected="selected"<?php }?>>
                                    <?php echo $obj_getcity_multi->f('city_name')?></option>
                                    <?php
                                    }
                              }
                              ?>
                              </select>
                              </div></td>
                          <td>
                          <div id="div_venue_display_multi">
                              <select name="multi_venue" id="multi_venue" class="state selectbg12">
                              <option value="">Venue</option>
                               <?php
                              if($msg!="")
                              {
                                    $obj_getvenue_multi = new admin;
                                    $obj_getvenue_multi->getVenueNameByCity($venue_city);
                                    while($obj_getvenue_multi->next_record())
                                    {
                                    ?>
                                    <option value=<?php echo $obj_getvenue_multi->f("venue_id")?> <?php if($venue==$obj_getvenue_multi->f('venue_id')){?> selected="selected"<?php }?> >
                                    <?php echo $obj_getvenue_multi->f('venue_name')?></option>
                                    <?php
                                    }
                              }
                              ?>
                              </select>
                           </div></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
            </div><?php */?>
            <div class="clear"></div>
            <div style="width:403px; margin: 0 auto; float: right;">
                <input class="event_save" type="button" value="<?= AD_SAVE_CREATE_FUNC ?>" onclick="save_multiple()" name="Submit_multi" style="float: left; margin: 10px 0 10px 8px; cursor:pointer;">
                <input class="event_save" type="button" value="<?= AD_SAVE_EXIT ?>" onclick="save_multiple()" name="Submit" style="float: right; margin: 10px 8px 10px 0;cursor:pointer;">
            </div>

         </td>
        </tr>
    	<tr>
          <td>
            <p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/> 
                <?= AD_EVENT_TYPE_TWO ?>
            </p>
          </td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC; width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;">
              	<input name="recurring" type="radio" onclick="showrecurringfunction(); saveAutoEvent();" value="1" <?php  if($msg!="" && $_POST['recurring']==1){?> checked="checked"<?php }?> onfocus="saveAutoEvent();"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;">
                  <?= AD_YES_OPTION ?>
              </td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;">
              	<input name="recurring" type="radio" onclick="showrecurringfunction(); saveAutoEvent();" value="0" <?php  if($msg!="" && $_POST['recurring']==0){ echo $chk; } echo $chk;?> onfocus="saveAutoEvent();"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;">
                  <?= AD_NO_OPTION ?>
              </td>
            </tr>
          </table></td>
        </tr>	
		<tr>
      <td id="recurring_details" colspan="2" style="display: none;">
		<div class="event_ticketl" style="float:right;">
			<div><p style="border-bottom: 1px solid #ccc; overflow: hidden; font-size: 16px;"><?= AD_RECURRENCES ?></p></div>
			<div>
	<ul>
	<li><?= AD_EVENT_REPEAT ?></li>
	<li><select name="event_time" class="selectbg" id="event_time" title="" style="width:70px;float:left; margin: 8px 0; height: 20px;" onchange="check(this.value);" onblur="saveAutoEvent();">
                  <option value=""><?= AD_SELECT ?></option>
				  <option value="Daily"><?= AD_DAILY ?></option>
				  <option value="Weekly"><?= AD_WEEKLY ?></option>
				  <option value="Monthly"><?= AD_MONTHLY ?></option>
				  <option value="Yearly"><?= AD_YEARLY ?></option>
                </select></li>
	<li><?= AD_EVERY ?></li>
	<li><input type="text" name="event_time_period" id="event_time_period" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo 01;}?>"  class="textbg_grey"  style="width: 40px;" onblur="saveAutoEvent();"/></li>
	<li id="week" class="all" style="display:none;"><?= AD_EVERY_OPTION_ONE ?></li>
	<li id="day" class="all" style="display:none;"><?= AD_EVERY_OPTION_TWO ?></li>
	<li id="month1" class="all" style="display:none;"><?= AD_EVERY_OPTION_THREE ?></li>
	<li id="year" class="all" style="display:none;"><?= AD_EVERY_OPTION_FOUR ?></li>
	</ul>
	</div>
	<div class="clear"></div>
	<div style="display:none;" id="week1" class="all">
        <ul>
            <li><input type="checkbox" name="Mon" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_MON ?></li>
            <li><input type="checkbox" name="Tue" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_TUE ?></li>
            <li><input type="checkbox" name="Wed" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_WED ?></li>
            <li><input type="checkbox" name="Thu" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_THU ?></li>
            <li><input type="checkbox" name="Fri" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_FRI ?></li>
            <li><input type="checkbox" name="Sat" value="1" style="padding:0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_SAT ?></li>
            <li><input type="checkbox" name="Sun" value="1" style="padding: 0; margin: 0;" onclick="saveAutoEvent();"/></li>
            <li><?= AD_DAY_SUN ?></li>
        </ul>
	</div>
	
	<div style="display:none;" id="month" class="all">
		<ul>
			<li>
				<select name="r_month" class="selectbg" id="r_month" title="" style="width:70px;float:left; margin: 8px 0; height: 20px;" onchange="saveAutoEvent();">
                  <option value=""><?= AD_SELECT ?></option>
				  <option value="First"><?= AD_FIRST ?></option>
				  <option value="Second"><?= AD_SECOND ?></option>
				  <option value="Third"><?= AD_THIRD ?></option>
				  <option value="Fourth"><?= AD_FOURTH ?></option>
				  <option value="Last"><?= AD_LAST ?></option>
                </select>
			</li>
			<li>
				<select name="r_month_day" class="selectbg" id="r_month_day" title="" style="width:70px;float:left; margin: 8px 0; height: 20px;" onchange="saveAutoEvent();">
                  <option value=""><?= AD_SELECT ?></option>
				  <option value="Monday"><?= AD_DAY_MONDAY ?></option>
				  <option value="Tuesday"><?= AD_DAY_TUESDAY ?></option>
				  <option value="Wednesday"><?= AD_DAY_WEDNESDAY ?></option>
				  <option value="Thursday"><?= AD_DAY_THURSDAY ?></option>
				  <option value="Friday"><?= AD_DAY_FRIDAY ?></option>
				  <option value="Saturday"><?= AD_DAY_SATURDAY ?></option>
				  <option value="Sunday"><?= AD_DAY_SUNDAY ?></option>
                </select>
			</li>
			<li><?= AD_OF_EACH_MONTH ?></li>
		</ul>
	</div>
	
			<div class="clear"></div>
			<div>
	<ul>	
	<li><?= AD_RECURRENCES_SPAN ?></li>
	<li><input type="text" name="r_span_start" id="r_span_start" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo date('Y-m-d');}?>"  class="textbg_grey"  style="width: 70px;" onclick="saveAutoEvent();"/></li>
	<li><?= AD_TO ?></li>
	<li><input type="text" name="r_span_end" id="r_span_end" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo date('Y-m-d');}?>"  class="textbg_grey"  style="width: 70px;" onclick="saveAutoEvent();"/></li>
	</ul>
	</div>
		<div class="clear"></div>
          <div>
            <ul>	
                <li><!--<input type="text" name="event_day_st" id="event_date_st" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo 00;}?>"  class="textbg_grey"  style="width: 50px;"/>-->
                <input type="hidden" id="event_start" name="event_start" />
                <?php /*?><select name="event_start" id="event_start" onchange="setstartTime();saveAutoEvent();">
                    <option value="12:00 AM">12:00 AM</option>
                    <option value="12:15 AM">12:15 AM</option>
                    <option value="12:30 AM">12:30 AM</option>
                    <option value="12:45 AM">12:45 AM</option>
                    <option value="01:00 AM">01:00 AM</option>
                    <option value="01:15 AM">01:15 AM</option>
                    <option value="01:30 AM">01:30 AM</option>
                    <option value="01:45 AM">01:45 AM</option>
                    <option value="02:00 AM">02:00 AM</option>
                    <option value="02:15 AM">02:15 AM</option>
                    <option value="02:30 AM">02:30 AM</option>
                    <option value="02:45 AM">02:45 AM</option>
                    <option value="03:00 AM">03:00 AM</option>
                    <option value="03:15 AM">03:15 AM</option>
                    <option value="03:30 AM">03:30 AM</option>
                    <option value="03:45 AM">03:45 AM</option>
                    <option value="04:00 AM">04:00 AM</option>
                    <option value="04:15 AM">04:15 AM</option>
                    <option value="04:30 AM">04:30 AM</option>
                    <option value="04:45 AM">04:45 AM</option>
                    <option value="05:00 AM">05:00 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="06:00 AM">06:00 AM</option>
                    <option value="06:15 AM">06:15 AM</option>
                    <option value="06:30 AM">06:30 AM</option>
                    <option value="06:45 AM">06:45 AM</option>
                    <option value="07:00 AM">07:00 AM</option>
                    <option value="07:15 AM">07:15 AM</option>
                    <option value="07:30 AM">07:30 AM</option>
                    <option value="07:45 AM">07:45 AM</option>
                    <option value="08:00 AM">08:00 AM</option>
                    <option value="08:15 AM">08:15 AM</option>
                    <option value="08:30 AM">08:30 AM</option>
                    <option value="08:45 AM">08:45 AM</option>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="09:15 AM">09:15 AM</option>
                    <option value="09:30 AM">09:30 AM</option>
                    <option value="09:45 AM">09:45 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="10:15 AM">10:15 AM</option>
                    <option value="10:30 AM">10:30 AM</option>
                    <option value="10:45 AM">10:45 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="11:15 AM">11:15 AM</option>
                    <option value="11:30 AM">11:30 AM</option>
                    <option value="11:45 AM">11:45 AM</option>
                    <option value="12:00 PM">12:00 PM</option>
                    <option value="12:15 PM">12:15 PM</option>
                    <option value="12:30 PM">12:30 PM</option>
                    <option value="12:45 PM">12:45 PM</option>
                    <option value="01:00 PM">01:00 PM</option>
                    <option value="01:15 PM">01:15 PM</option>
                    <option value="01:30 PM">01:30 PM</option>
                    <option value="01:45 PM">01:45 PM</option>
                    <option value="02:00 PM">02:00 PM</option>
                    <option value="02:15 PM">02:15 PM</option>
                    <option value="02:30 PM">02:30 PM</option>
                    <option value="02:45 PM">02:45 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="03:15 PM">03:15 PM</option>
                    <option value="03:30 PM">03:30 PM</option>
                    <option value="03:45 PM">03:45 PM</option>
                    <option value="04:00 PM">04:00 PM</option>
                    <option value="04:15 PM">04:15 PM</option>
                    <option value="04:30 PM">04:30 PM</option>
                    <option value="04:45 PM">04:45 PM</option>
                    <option value="05:00 PM">05:00 PM</option>
                    <option value="05:15 PM">05:15 PM</option>
                    <option value="05:30 PM">05:30 PM</option>
                    <option value="05:45 PM">05:45 PM</option>
                    <option value="06:00 PM">06:00 PM</option>
                    <option value="06:15 PM">06:15 PM</option>
                    <option value="06:30 PM">06:30 PM</option>
                    <option value="06:45 PM">06:45 PM</option>
                    <option value="07:00 PM">07:00 PM</option>
                    <option value="07:15 PM">07:15 PM</option>
                    <option value="07:30 PM">07:30 PM</option>
                    <option value="07:45 PM">07:45 PM</option>
                    <option value="08:00 PM">08:00 PM</option>
                    <option value="08:00 PM">08:00 PM</option>
                    <option value="08:30 PM">08:30 PM</option>
                    <option value="08:45 PM">08:45 PM</option>
                    <option value="09:00 PM">09:00 PM</option>
                    <option value="09:15 PM">09:15 PM</option>
                    <option value="09:30 PM">09:30 PM</option>
                    <option value="09:45 PM">09:45 PM</option>
                    <option value="10:00 PM">10:00 PM</option>
                    <option value="10:15 PM">10:15 PM</option>
                    <option value="10:30 PM">10:30 PM</option>
                    <option value="10:45 PM">10:45 PM</option>
                    <option value="11:00 PM">11:00 PM</option>
                    <option value="11:15 PM">11:15 PM</option>
                    <option value="11:30 PM">11:30 PM</option>
                </select><?php */?>
                </li>
                <li>
                <input type="hidden" id="event_end" name="event_end" />
                <?php /*?><select name="event_end" id="event_end" onchange="setendTime();saveAutoEvent();">
                    <option value="12:00 AM">12:00 AM</option>
                    <option value="12:15 AM">12:15 AM</option>
                    <option value="12:30 AM">12:30 AM</option>
                    <option value="12:45 AM">12:45 AM</option>
                    <option value="01:00 AM">01:00 AM</option>
                    <option value="01:15 AM">01:15 AM</option>
                    <option value="01:30 AM">01:30 AM</option>
                    <option value="01:45 AM">01:45 AM</option>
                    <option value="02:00 AM">02:00 AM</option>
                    <option value="02:15 AM">02:15 AM</option>
                    <option value="02:30 AM">02:30 AM</option>
                    <option value="02:45 AM">02:45 AM</option>
                    <option value="03:00 AM">03:00 AM</option>
                    <option value="03:15 AM">03:15 AM</option>
                    <option value="03:30 AM">03:30 AM</option>
                    <option value="03:45 AM">03:45 AM</option>
                    <option value="04:00 AM">04:00 AM</option>
                    <option value="04:15 AM">04:15 AM</option>
                    <option value="04:30 AM">04:30 AM</option>
                    <option value="04:45 AM">04:45 AM</option>
                    <option value="05:00 AM">05:00 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="05:15 AM">05:15 AM</option>
                    <option value="06:00 AM">06:00 AM</option>
                    <option value="06:15 AM">06:15 AM</option>
                    <option value="06:30 AM">06:30 AM</option>
                    <option value="06:45 AM">06:45 AM</option>
                    <option value="07:00 AM">07:00 AM</option>
                    <option value="07:15 AM">07:15 AM</option>
                    <option value="07:30 AM">07:30 AM</option>
                    <option value="07:45 AM">07:45 AM</option>
                    <option value="08:00 AM">08:00 AM</option>
                    <option value="08:15 AM">08:15 AM</option>
                    <option value="08:30 AM">08:30 AM</option>
                    <option value="08:45 AM">08:45 AM</option>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="09:15 AM">09:15 AM</option>
                    <option value="09:30 AM">09:30 AM</option>
                    <option value="09:45 AM">09:45 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="10:15 AM">10:15 AM</option>
                    <option value="10:30 AM">10:30 AM</option>
                    <option value="10:45 AM">10:45 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="11:15 AM">11:15 AM</option>
                    <option value="11:30 AM">11:30 AM</option>
                    <option value="11:45 AM">11:45 AM</option>
                    <option value="12:00 PM">12:00 PM</option>
                    <option value="12:15 PM">12:15 PM</option>
                    <option value="12:30 PM">12:30 PM</option>
                    <option value="12:45 PM">12:45 PM</option>
                    <option value="01:00 PM">01:00 PM</option>
                    <option value="01:15 PM">01:15 PM</option>
                    <option value="01:30 PM">01:30 PM</option>
                    <option value="01:45 PM">01:45 PM</option>
                    <option value="02:00 PM">02:00 PM</option>
                    <option value="02:15 PM">02:15 PM</option>
                    <option value="02:30 PM">02:30 PM</option>
                    <option value="02:45 PM">02:45 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="03:15 PM">03:15 PM</option>
                    <option value="03:30 PM">03:30 PM</option>
                    <option value="03:45 PM">03:45 PM</option>
                    <option value="04:00 PM">04:00 PM</option>
                    <option value="04:15 PM">04:15 PM</option>
                    <option value="04:30 PM">04:30 PM</option>
                    <option value="04:45 PM">04:45 PM</option>
                    <option value="05:00 PM">05:00 PM</option>
                    <option value="05:15 PM">05:15 PM</option>
                    <option value="05:30 PM">05:30 PM</option>
                    <option value="05:45 PM">05:45 PM</option>
                    <option value="06:00 PM">06:00 PM</option>
                    <option value="06:15 PM">06:15 PM</option>
                    <option value="06:30 PM">06:30 PM</option>
                    <option value="06:45 PM">06:45 PM</option>
                    <option value="07:00 PM">07:00 PM</option>
                    <option value="07:15 PM">07:15 PM</option>
                    <option value="07:30 PM">07:30 PM</option>
                    <option value="07:45 PM">07:45 PM</option>
                    <option value="08:00 PM">08:00 PM</option>
                    <option value="08:00 PM">08:00 PM</option>
                    <option value="08:30 PM">08:30 PM</option>
                    <option value="08:45 PM">08:45 PM</option>
                    <option value="09:00 PM">09:00 PM</option>
                    <option value="09:15 PM">09:15 PM</option>
                    <option value="09:30 PM">09:30 PM</option>
                    <option value="09:45 PM">09:45 PM</option>
                    <option value="10:00 PM">10:00 PM</option>
                    <option value="10:15 PM">10:15 PM</option>
                    <option value="10:30 PM">10:30 PM</option>
                    <option value="10:45 PM">10:45 PM</option>
                    <option value="11:00 PM">11:00 PM</option>
                    <option value="11:15 PM">11:15 PM</option>
                    <option value="11:30 PM">11:30 PM</option>
                </select><?php */?>
    
                </li>
                <li><input type="hidden" id="all_day" name="all_day" value="1" /></li>
            </ul>
          </div>
		<div class="clear"></div>
           <!-- <div>
                <ul>
                    <li>Each event lasts</li>
                    <li><input type="text" name="event_lasts" id="event_lasts" value="<?php if($msg!="" && $event_day_st!=""){echo $event_day_st;}else{echo 01;}?>"  class="textbg_grey"  style="width: 110px;" onclick="saveAutoEvent();"/></li>
                    <li>day(s)</li>
                </ul>
            </div>-->
			<div class="clear"></div>
		</div>
     </td>
     </tr>	
   		<tr>
            <td>
                <p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/> 
                    <?= AD_EVENT_TYPE_THREE ?>
                </p>
            </td>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC;  width: 150px; background: #f5f5f5; height: 30px;">
        <tr>
          <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="1" <?php  if($msg!="" && $_POST['sub_events']==1){?> checked="checked"<?php }?> onclick="subEvent();"/></td>
          <td width="6%" align="center" valign="middle" style="padding: 4px;">
              <?= AD_YES_OPTION ?>
          </td>
          <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="0" checked="checked" onclick="saveAutoEvent();"/></td>
          <td width="87%" align="center" valign="middle" style="padding: 4px;">
              <?= AD_NO_OPTION ?>
          </td>
        </tr>
      </table></td>
    </tr>
      </table>
    </div>
    <script type="text/javascript">
	function privacy_policy(){

		//if($('input:radio[name=privacy]:checked').val()==1)
		if(document.getElementById('public_privacy').checked == true)
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
		<?php
		//echo $obj_admin->f('account_type').'admin';
		if($obj_admin->f('account_type') == 2){?>
		<span style="float: left;">
        	<p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="0" checked="checked" onclick="privacy_policy(); saveAutoEvent();" /> <?= AD_PUBLIC ?></p>	
			<p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="1" onclick="privacy_policy(); saveAutoEvent();" /> <?= AD_PRIVATE ?></p>
		</span>
		<?php }
		else
		{ ?>
		<span style="float: left;">
			<?php if($obj_admin->f('account_type') == 1 && $obj_admin->f('prof_complete') == 1){?>
        	<p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="0" checked onclick="privacy_policy(); saveAutoEvent();" /> <?= AD_PUBLIC ?></p>
			<?php
			}
			else
			{
			?>
		<p class="rad_button"><img style="margin-left: 2px; margin-top: 7px;" src="<?php echo $obj_base_path->base_path(); ?>/images/radio.png" alt="" border="0" onclick="func_type();"/> <?= AD_PUBLIC ?></p>	
			<?php
			}
			?>
			<p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="1" onclick="privacy_policy(); saveAutoEvent();" <?php if($obj_admin->f('account_type') == 0 || ($obj_admin->f('account_type') == 1 && $obj_admin->f('prof_complete') == 0)){ echo "checked";} ?> /> <?= AD_PRIVATE ?></p>
			</span>
		<?php
		}
		?>
		<span id="public_content"><?= AD_EVENT_PUBLIC_OPTION ?></span>
		<span id="private_content">
            <table width="100%" border="1">
              <tr>
                <td><?= AD_EVENT_PRIVATE_OPTION ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="attendees" id="attendees" value="1" onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_ONE ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="invitation_only" id="invitation_only" value="1" onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_TWO ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="password_protect_check" id="password_protect_check" value="1" onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_THREE ?> &nbsp; 
                	<input type="text" name="pass_protected" id="pass_protected" onclick="saveAutoEvent();"  /></td>
              </tr>
            </table>

        	</span>
	</div>
    
	<div class="clear"></div>
	<div class="event_ticket">
	<h1><a href="javascript:media_library()" onclick=""><?= AD_SET_FEATURE_IMAGE_TITLE ?><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></a></h1>
	    <span><?= AD_SET_FEATURE_IMAGE_DESC ?></span>
	<!--<ul style="margin-left: 10px;">
        <li><a href="#" class="here"> 
		
		<?php // if(!$_POST['event_photo']){ ?>
            <div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Upload Files</span></span></div><span id="mestatus1"></span>
            <?php //} else { ?>
            <img src="<?php// echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php// echo $_POST['event_photo']; ?>" alt="" />
            <?php// }  ?>
            <div class="clear"></div>
          <span id="imgshow"></span>
          <input type="hidden" name="event_photo" id="event_photo" value="<?php //if($_POST['event_photo']){ echo $_POST['event_photo']; }?>" /></a></li>
        <li>|</li>
        <li><a href="#"  target="_blank" onclick="media_library()">Media Library</a></li>
	</ul> -->
	</div>
	<div class="clear"></div>
	<script type="text/javascript">
	function complete(topValue){		       
        
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
		
		$("#status").val('publish');
        
        var selected_venue = $("#venue").val();
        var selected_venue_state = $("#venue_state").val();
        var selected_venue_county = $("#venue_county").val();
        var selected_venue_city = $("#venue_city").val();
            
        $.ajax({ 
            url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_save_venue_info.php",
            async: false,
            cache: false,
            type: "POST",
            data: {
                selected_venue: selected_venue, 
                selected_venue_state: selected_venue_state,
                selected_venue_county: selected_venue_county,
                selected_venue_city: selected_venue_city,
                user_id: "<?php echo $_SESSION['ses_user_id']; ?>"
            },
            success: function(data){
                
            }
        });
        
//        if(typeof(Storage) !== "undefined") {
//            localStorage.selected_venue = $("#venue").val();
//            localStorage.selected_venue_state = $("#venue_state").val();
//            localStorage.selected_venue_county = $("#venue_county").val();
//            localStorage.selected_venue_city = $("#venue_city").val();            
//        }
    
		if(topValue==1){
			document.getElementById("day_1").value = document.getElementById("multi_event_day1").value;
			document.getElementById("month_1").value = document.getElementById("multi_event_month1").value;
			document.getElementById("year_1").value = document.getElementById("multi_event_year1").value;
			document.getElementById("day_2").value = document.getElementById("multi_event_day1").value;
			document.getElementById("month_2").value = document.getElementById("multi_event_month1").value;
			document.getElementById("year_2").value = document.getElementById("multi_event_year1").value;
			
			$("#complete1").html('Event Published');
		}
		else{
			document.getElementById("day_1").value = document.getElementById("multi_event_day2").value;
			document.getElementById("month_1").value = document.getElementById("multi_event_month2").value;
			document.getElementById("year_1").value = document.getElementById("multi_event_year2").value;
			document.getElementById("day_2").value = document.getElementById("multi_event_day2").value;
			document.getElementById("month_2").value = document.getElementById("multi_event_month2").value;
			document.getElementById("year_2").value = document.getElementById("multi_event_year2").value;
			$("#complete").html('Event Published');
		}
		

//        var event_des_en = CKEDITOR.instances['page_content_en'].getData();
//        var event_des_sp = CKEDITOR.instances['page_content_sp'].getData();
//
//        sendData = $("#event_form").serialize();
//    
//		 $.ajax({ 
//            url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_publish_event.php",
//            async: false,
//            cache: false,
//            type: "POST",
//            data: sendData+"&event_des_en="+encodeURIComponent(event_des_en)+"&event_des_sp="+encodeURIComponent(event_des_sp),   
//            success: function(data){
//            }
//        });
		
		//alert(document.getElementById("day_1").value);
		return true;
	}
	
	function showticketingsection(){

		if($('input:radio[name=radio_access]:checked').val()==1)
		{
			$('#all_access').hide();
            console.log($('#event_name_sp').val());
            console.log($('#ticket_name_sp').val());
            
                         
            if ($('#event_name_sp').val() == 'Nombre' || $('#event_name_sp').val() == "") {

                $('#ticket_name_sp').val('Entrada General');
            } else {

                var ticket_name_sp = 'Entrada General - ' +  $('#event_name_sp').val();

                $('#ticket_name_sp').val(ticket_name_sp);
            }
            
            
            if ($('#event_name_en').val() == 'Name' || $('#event_name_en').val() == "") {
                $('#ticket_name_en').val('General Entry');
            } else {
                var ticket_name_en = 'General Entry - ' +  $('#event_name_en').val();
                $('#ticket_name_en').val(ticket_name_en);
            }
                        
			$('.payment_resarvation').show();
			$('#ticket_area').show();
		}
		else
		{
			$('.payment_resarvation').hide();
			$('#ticket_area').hide();
			$('#all_access').show();
		}
	}

	</script>
	<div class="clear"></div>
	<div class="event_ticketbg">
	<div class="event_ticket2">
    <div><h1><?= AD_TICKETING_RESERVATIONS ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1></div>
    <div class="clear"></div>
    <div>
     <ul>
        <li><input name="radio_access" type="radio" value="1" onclick="showticketingsection(); saveAutoEvent();"  /><strong><?= AD_TICKETING_RESERVATIONS_OP_ONE ?></strong></li>
        <li><input name="radio_access" type="radio" value="0" onclick="showticketingsection(); saveAutoEvent();" checked="checked"  /><strong><?= AD_TICKETING_RESERVATIONS_OP_TWO ?></strong></li>
		<li id="all_access" style="display:none;">
		<?= AD_ALL_ACCESS_NOTICE ?>
		</li>
		
        <li class="payment_resarvation" style="margin-left:10px;display:none;"><?= AD_PRICE_INCLUDES_FEE ?>
        	<span class="ticektfee">
            	<input name="pay_ticket_fee" type="radio" value="1" checked="checked" style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?> 
                <input name="pay_ticket_fee" type="radio" value="0" style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_NO_OPTION ?> 
            </span>
        </li>
        <li class="payment_resarvation" style="margin: 0 0 0 10px;display:none;"><?= AD_PRICE_INCLUDES_CHARGES ?>
        	<span class="ticketfee1" style="margin:0 34px;">
                <input name="promo_charge" type="radio" value="1" checked="checked" style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?> 
                <input name="promo_charge" type="radio" value="0" style="margin:5px;" onclick="saveAutoEvent();"/><?= AD_NO_OPTION ?>  
            </span>
        </li>
	 </ul>
	</div>
    </div>
    
    <div id="ticket_area" style="display:none;">
       <div class="event_ticket2">
            <div><h2><?= AD_CER_TICKET ?><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" width="31" height="28" border="0"/></h2></div>
            <div class="clear"></div>
            <div id="save_create_ticket_display" class="event_ticketbox">&nbsp;</div>
        </div>
       <div class="clear"></div>

      <input type="hidden" name="photoname" id="photoname" value="" />
      <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
      <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
       <div class="event_name8">
        <div style="float: left; position: absolute; margin: 0 0 0 303px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/>
        <img id="loader" src="<?php echo $obj_base_path->base_path(); ?>/images/loader.gif" alt="" width="67" height="75" border="0" style="display:none;"/></div>
        <div style="float: left; margin: 0 auto;">
        	<span class="show_spanish">SP</span><br/>
         	<span class="event_fieldbg8">
        	<input type="text" name="ticket_name_sp" id="ticket_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Nombre";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
         	</span>	
        <br/>
        	<span class="event_fieldbg8">
            	<textarea name="description_sp" id="description_sp" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Breve descripci&#243;n</textarea>
            </span>
        </div>
        <div style="float: right; margin: 0 auto;">	
        	<span class="show_english">EN</span><br/>
        	<span class="event_fieldbg8"><input type="text" name="ticket_name_en" id="ticket_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_en!=""){echo $event_name_en;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
        	</span>	<br/>
       		<span class="event_fieldbg8"><textarea name="description_en" id="description_en" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Short description</textarea></span>
        </div>
        </div>
       <div class="clear"></div>
       <div class="event_date8">
       
        <div class="event_date9">
        	Precio MX pesos <input type="text" name="price_mx" id="price_mx" onblur="checDecimal('price_mx','shw_price_mx')"  /> 
            Price Dollars <input type="text" name="price_us" id="price_us" onblur="checDecimal('price_us','shw_price_us')"  />
        </div>	
        <div class="event_date9">
        	<?= AD_NUMBER_AVAILABLE_SEATS ?> <input type="text" name="ticket_num" id="ticket_num" style="width: 64px;" /> 
        	<?= AD_FROM ?> <input type="text" name="from_ticket" id="from_ticket" value="<?php echo date("d-m-Y");?>"  /> 
            <?= AD_TO ?> <input type="text" name="to_ticket" id="to_ticket"  />
        </div>	
        <div class="event_date9">
        	<?= AD_EARLY_BIRD_DISCOUNT ?> <input type="text" name="eairly_dis_percen" id="eairly_dis_percen"  /> 
        	% <?= AD_UP_TO ?> <input type="text" name="eairly_days" id="eairly_days" style="width: 64px;" /> <?= AD_DAYS_BEFORE_EVENT ?>
        </div>
        <div class="event_date9">
        	<?= AD_GROUP_DISCOUNT ?> <input type="text" name="group_dis_per" id="group_dis_per"  /> 
            % <?= AD_OVER ?> <input type="text" name="group_dis_days" id="group_dis_days" style="width: 64px;" /> <?= AD_TICKETS ?>
        </div>
        <div class="event_date9"><?= AD_MEMBERSHIP_ONLY ?>
        	<span class="membershipClass">
            	<input name="members_only" id="members_only1" type="radio" value="1" style="margin: 5px;" /><?= AD_YES_OPTION ?> 
                <input name="members_only" id="members_only2" type="radio" value="0" checked="checked" style="margin: 5px;" /><?= AD_NO_OPTION ?>
            </span>
        </div>
        <div class="event_date9"><?= AD_TICKET_ICON ?> - 
        	<div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><?= AD_UPLOAD_YOUR_TICKET_ICON ?></span></span></div><span id="mestatus"></span><br /><span id="imgid"></span>
        </div>
            
        <div style="float: right; width: 370px; margin: 0 auto;">
        	<input type="button" name="Submit2" value="<?= AD_SAVE_CREATE_TICKET ?>" class="event_save" onclick="save_new_popup()" style="cursor:pointer;" />
            <input type="button" name="Submit2" value="<?= AD_SAVE_EXIT ?>" class="event_save" onClick="closePopUp()" style="cursor:pointer;"/></div>
        </div>

    </div>
    
	</div>	
	<div class="clar"></div>
    
	<div class="event_ticket" style="background: none; width: 702px; border: 0; margin: 0 auto 0 10px;">
     <div class="event_ticketl" style="visibility: hidden;">
		<h1><?= AD_PAYMENT_SETTING ?></h1>
        <div style="width: 180px; float: left; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_PAYMENTS ?></h2>
                <li><input type="checkbox" name="Paypal" value="1" onclick="saveAutoEvent();"/>  <?= AD_PAYPAL_CC ?></li>
                <li><input type="checkbox" name="Bank" value="1" onclick="saveAutoEvent();"/>  <?= AD_BANK_DEPOSITE ?></li>
                <li><input type="checkbox" name="Oxxo" value="1" onclick="saveAutoEvent();"/>  <?= AD_OXXO_PAYMENT ?></li>
                <li><input type="checkbox" name="Mobile" value="1" onclick="saveAutoEvent();"/>  <?= AD_MOBILE_PAYMENT ?></li>
                <li><input type="checkbox" name="Offline" value="1" onclick="saveAutoEvent();"/>  <?= AD_OFFLINE_PAYMENT ?></li>
            </ul>
        </div>
        <div style="width: 200px; float: right; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_DELIVERY ?> <!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/>--></h2>
                <li><input type="checkbox" name="paper_less_mob_ticket" value="1" onclick="saveAutoEvent();"/>  <?= AD_PAPERLESS_MB_TICKET ?></li>
                <li><input type="checkbox" name="print" value="1" onclick="saveAutoEvent();"/>  <?= AD_PRINT ?></li>
                <li><input type="checkbox" name="will_call" value="1" onclick="saveAutoEvent();"/>  <?= AD_WILL_CALL?></li>
            </ul>
        </div>
	</div>
	 <div class="event_ticketr">
        <h1>
            <span id="display_delete2"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" /></span>
            <span id="display_save2"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save" /></span>
            <span id="display_preview2"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></span>
        </h1>
           <div style="font-weight:bold; text-align: center"><?= AD_SAVE_YOUR_WORK ?></div>
           <div style="font-weight:bold; text-align: center"><?= AD_PUBLISH_WHEN_DONE ?></div>
           <div class="clear"></div>
        <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
			<input type="submit" name="publish" value="<?= AD_PUBLISH ?>" onclick="return complete(0);" class="pub" />
			 <table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
				<tr>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_day1" id="multi_event_day1" value="<?php echo 00;?>"  class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="day_1" id="day_1" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_month1" id="multi_event_month1" value="<?php echo 00;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="month_1" id="month_1" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_year1" id="multi_event_year1"  value="<?php echo 0000;?>" class="textbg_grey"  style="width: 40px;"/>
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
                <span id="display_delete"><img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" /></span>
                <span id="display_save"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" /></span>
                <span id="display_preview"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></span>
            </h1>
	  	   <div style="font-weight:bold; text-align: center"><?= AD_SAVE_YOUR_WORK ?></div>
           <div style="font-weight:bold; text-align: center"><?= AD_PUBLISH_WHEN_DONE ?></div>
           <div class="clear"></div>
		<div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">

			<input type="submit" name="publish" value="<?= AD_PUBLISH ?>" onclick="return complete(1);" class="pub" />
            
			<table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
				<tr>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_day2" id="multi_event_day2" value="<?php echo 00;?>"  class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="day_2" id="day_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_month2" id="multi_event_month2" value="<?php echo 00;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="month_2" id="month_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_year2" id="multi_event_year2"  value="<?php echo 0000;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="year_2" id="year_2" value="" />
				  </td>
				</tr>
				<tr>
					<td colspan="5"><div id="complete1" style="color:#920125;"></div></td>
				</tr>
			</table>
			</div>
            
            <div style="margin:2px 0 2px 5px; font-weight:bold;"><?= AD_AGREE_TERM ?></div>
            <div style="margin:2px 0 2px 18px; font-weight:bold;" ><a href="" style=" color:#6193c3;"><?= AD_TERM_CONDITIONS ?></a></div>
            
	<div class="clear">&nbsp;</div>
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
                <li style="padding-left: 8px;">
                    <input type="checkbox" name="event_types[]" id="event_types<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" value="<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" class="check" onclick="saveAutoEvent();" /> 
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
					if($objlist->num_rows()){
						while($objlist->next_record()){
						$obj_subcat->category_sub_list($objlist->f('category_id'));
					?>
                    <li style="padding-left: 8px;">
                    	<input type="checkbox" name="maincat[]" id="maincat<?php echo $objlist->f('category_id');?>" value="<?php echo $objlist->f('category_id');?>" class="category_1" onclick="showSubCat(<?php echo $objlist->f('category_id');?>); saveAutoEvent();" />
                        <?php $categoryName = $_SESSION['langAdminSelected'] == 'en' ? 'category_name' : 'category_name_' . $_SESSION['langAdminSelected']; echo $objlist->f($categoryName); if($obj_subcat->num_rows()){?> 			  
                        <span id="shwsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;" onclick="showSubCat(<?php echo $objlist->f('category_id');?>)">( + )</span> 
                  		<span id="hdsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;display:none;" onclick="hideSubCat(<?php echo $objlist->f('category_id');?>)">( - )</span> <?php } ?>
                  
                        <ul style="margin-left:30px;display:none;" id="sub_cat<?php echo $objlist->f('category_id');?>">
                    <?php
						if($obj_subcat->num_rows()){
							while($obj_subcat->next_record()){
					 ?>
                        
                            <li style="padding-left:8px;">
                                <input onclick="checkCat(<?php echo $objlist->f('category_id');?>)" type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" onblur="saveAutoEvent();"/>
                                <?php echo $obj_subcat->f($categoryName);?>
                            </li>
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
		<div><input type="text" name="event_tag" id="event_tag" class="textbg_add"/> <input type="button" name="save" value="<?= AD_BUTTON_ADD ?>" class="btn_add" onblur="saveAutoEvent();" /></div>
		<div class="clear"></div>
		<div><span><?= AD_SEPARATE_TAGS ?></span></div>
		<div class="clear"></div>
		<div><a href="#"><?= AD_CHOOSE_TAGS ?></a></div>
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
       
       setTimeout(function(){ 
//            if(typeof(Storage) !== "undefined") {
//                if (localStorage.selected_venue_state) {
//                    $("#venue_state").val(localStorage.selected_venue_state);
//                    getCounty(localStorage.selected_venue_state);
//                    
//                    if (localStorage.selected_venue_county) {
//                        setTimeout(function(){
//                            $("#venue_county").val(localStorage.selected_venue_county);
//                            getCity(localStorage.selected_venue_county);
//                            if (localStorage.selected_venue_city) {
//                                setTimeout(function(){
//                                    $("#venue_city").val(localStorage.selected_venue_city);
//                                    getVenue(localStorage.selected_venue_city);
//                                    if (localStorage.selected_venue) {
//                                        setTimeout(function(){
//                                            $("#venue").val(localStorage.selected_venue);
//                                        }, 1000);
//                                    }
//                                }, 1000);
//                            }
//                        }, 1000);
//                    }                    
//                }            
//            }
            var my_selected_venue_state = "<?php echo isset($selected_venue_state) ? $selected_venue_state : ''; ?>";
            if (my_selected_venue_state) {
                $("#venue_state").val(my_selected_venue_state);
                getCounty(my_selected_venue_state);

                var my_selected_venue_county = "<?php echo isset($selected_venue_county) ? $selected_venue_county : ''; ?>";
                if (my_selected_venue_county) {
                    setTimeout(function(){
                        $("#venue_county").val(my_selected_venue_county);
                        getCity(my_selected_venue_county);
                        
                        var my_selected_venue_city = "<?php echo isset($selected_venue_city) ? $selected_venue_city : ''; ?>";
                        if (my_selected_venue_city) {
                            setTimeout(function(){
                                $("#venue_city").val(my_selected_venue_city);
                                getVenue(my_selected_venue_city);
                                
                                var my_selected_venue = "<?php echo isset($selected_venue) ? $selected_venue : ''; ?>";
                                if (my_selected_venue) {
                                    setTimeout(function(){
                                        $("#venue").val(my_selected_venue);
                                    }, 1000);
                                }
                            }, 1000);
                        }
                    }, 1000);
                }                    
            }            
       }, 1000);
       
        // Get the modal
//        var modal = document.getElementById('myModal');
//        modal.style.display = "block";
    });
</script>  
 
 <!-- The Modal -->
 <div id="myModal" class="modal">

     <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-model">&times;</span>
            <h3><?= AD_POPUP_TITLE ?></h3>
        </div>
        <div class="modal-body">
            <p><?= AD_POPUP_CONTENT ?></p>
            <h3 class="model-link-first"><?= AD_SHARE_IN ?></h3>
            <h3 class="model-link"><a class="share-in-en"><?= AD_ENGLISH_BTN ?></a></h3>
            <h3 class="model-link"><a class="share-in-es"><?= AD_SPANISH_BTN ?></a></h3>
            <h3 class="model-link"><a class="close-model-done"><?= AD_DONE ?></a></h3>
        </div>
        <div class="modal-footer">    
            <h4><?= AD_POPUP_FOOTER ?></h4>            
        </div>
    </div>

 </div>

</body>
</html>
