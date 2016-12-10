<?php
// home page
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../include/admin_inc.php');
include('../twitteroauth/twitterStatus.php');
include('../facebookapi/facebookStatus.php');
include('../pinterestapi/pinterestStatus.php');

list($today_yr,$today_mon,$today_day) = explode("-",date("Y-m-d"));

//create object
$obj = new admin;
$objlist=new admin;
$obj_subcat=new admin;
$obj_venuestate=new admin;
$obj_venuecounty = new admin;
$obj_venuecity=new admin;
$obj_venue=new admin;
$obj_edit=new admin;
$obj_add_ticket=new admin;
$obj_edit_ticket=new admin; 
$obj_delete=new admin;
$obj_add_category_by_event=new admin;
$obj_delete_category_by_event=new admin;
$objlist_most_used=new admin();
$obj_subcat_most_used=new admin();
$objlistMaincat=new admin;
$objlistMaintype=new admin;
$obj_thumb = new admin;
$obj_temp_tickets = new admin;
$obj_final_tickets = new admin();
$obj_check_tick = new admin;
$obj_temp_mulEve = new admin;

$objlist_event_delete=new admin;
$objlist_ticket_delete=new admin;
$obj_city_dis=new admin;
$obj_venue_dis=new admin;

$obj_event_photo = new admin;

$objCommon = new Common();
$objLocation = new user;
$objVenueLocation = new user;

$objlist->category_list();
$objlistMaincat->categorylistByEvent($_GET['id']);
$objlistMaintype->eventTypeBYEventId($_GET['id']);

$objlist_most_used->most_used_category();

$objTwitter = new twitterStatus();
$objFacebook = new facebookStatus();
$objPinterest = new pinterestStatus();

$obj_dup_event_master_type = new admin;
$obj_dup_event_master_type->getEventTypeMster();
$chk = "checked='checked'";
$objlist->category_list();

$objEventEdit = new admin;

$obj->getEventById($_GET['id']);
$obj->next_record();

$event_name_show = $obj->f('event_name_en');


// Get City name

$obj_city_dis->getCityById($obj->f('event_venue_city'));
$obj_city_dis->next_record();

// Get venue name
$obj_venue_dis->get_venue($obj->f('event_venue'));
$obj_venue_dis->next_record();

// check ticket lis for that event
$obj_check_tick->checkEventTicket($_GET['id']);


$explode_start_date_time_all = explode(" ",$obj->f('event_start_date_time'));
$explode_start_date = explode("-",$explode_start_date_time_all[0]);
$explode_start_time = explode(":",$explode_start_date_time_all[1]);
$start_yr = $explode_start_date[0];
$start_mon = $explode_start_date[1];
$start_day = $explode_start_date[2];
$start_hr = $explode_start_time[0];
if($start_hr>12)
{
   $display_start_hr = $start_hr-12;
}
else
{
   $display_start_hr = $start_hr;
}
$start_min = $explode_start_time[1];



$explode_end_date_time_all = explode(" ",$obj->f('event_end_date_time'));
$explode_end_date = explode("-",$explode_end_date_time_all[0]);
$explode_end_time = explode(":",$explode_end_date_time_all[1]);
$end_yr = $explode_end_date[0];
$end_mon = $explode_end_date[1];
$end_day = $explode_end_date[2];
$end_hr = $explode_end_time[0];
if($end_hr>12)
{
   $display_end_hr = $end_hr-12;
}
else
{
   $display_end_hr = $end_hr;
}
$end_min = $explode_end_time[1];


$explode_publish_date_time_all = explode(" ",$obj->f('publish_date'));
$explode_publish_start_date = explode("-",$explode_publish_date_time_all[0]);
//$explode_start_time = explode(":",$explode_start_date_time_all[1]);
$publish_yr = $explode_publish_start_date[0];
$publish_mon = $explode_publish_start_date[1];
$publish_day = $explode_publish_start_date[2]; 


$arrMaincat = array();
if($objlistMaincat->num_rows())
{
   while($objlistMaincat->next_record())
   {
	   $arrMaincat[] = $objlistMaincat->f('category_id');
   }
   //print_r($arrMaincat);exit;
}

$arrTypecat = array();
if($objlistMaintype->num_rows())
{
   while($objlistMaintype->next_record())
   {
	   $arrTypecat[] = $objlistMaintype->f('event_master_type_id');
   }
}


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
	header("location: ".$obj_base_path->base_path()."/admin/event-list");
	exit;
}


if(isset($_POST['editevent']) && $_POST['editevent'] == '1')	
{
	
	//print_r($_POST);exit;
	$finalArray = $_POST['maincat'];
	
	$event_name_sp = addslashes(str_replace("'"," ",$_POST['event_name_sp']));
	$event_name_en = addslashes(str_replace("'"," ",$_POST['event_name_en']));
	
	$short_desc_sp = addslashes(str_replace("'"," ",$_POST['short_desc_sp']));
	$short_desc_en = addslashes(str_replace("'"," ",$_POST['short_desc_en']));

	// Check weather short Description is empty
	if($short_desc_sp==""){
		$short_desc_sp = substr(trim(strip_tags(addslashes($_POST['page_content_sp']))),0,160);
	}
	
	if($short_desc_en==""){
		$short_desc_en = substr(trim(strip_tags(addslashes($_POST['page_content_en']))),0,160);
	}

	
	//echo "hii".$event_name_en; exit;
	
	if($_POST['event_start_ampm'] == 'PM')
	{
          //echo "1st str=".$_POST['event_hr_st'];
          if($_POST['event_hr_st'] == 12)
             {
               $event_start_hour=12;
             }
             else{
	    $event_start_hour = $_POST['event_hr_st']+12;
            //echo "evt_st_hr=".$event_start_hour;
             }
	}
	else
	{
	    $event_start_hour = $_POST['event_hr_st'];
            // echo "evt_st_hr_else=".$event_start_hour;
	}
	$event_start_date_time = $_POST['event_year_st']."-".$_POST['event_month_st']."-".$_POST['event_day_st']." ".$event_start_hour."-".$_POST['event_min_st']."-00";
	//echo "st_date_check=".$event_start_date_time;
        $event_start_ampm = $_POST['event_start_ampm'];
        //echo "st_ampm_check2=".$event_start_ampm;
	if($_POST['event_end_ampm'] == 'PM')
	{
          if($_POST['event_hr_end'] == 12)
             {
               $event_end_hour=12;
             }
          else{ 
	    $event_end_hour = $_POST['event_hr_end']+12;
            //echo "evnt_hr=".$event_end_hour ;
            }
            
	}
	else
	{
	    $event_end_hour = $_POST['event_hr_end'];
            //echo "evnt_hr_else=".$event_end_hour ;
	}
	$event_end_date_time = $_POST['event_year_end']."-".$_POST['event_month_end']."-".$_POST['event_day_end']." ".$event_end_hour."-".$_POST['event_min_end']."-00";
	//echo "end_date_check=".$event_end_date_time;
        $event_end_ampm = $_POST['event_end_ampm'];
        //echo "end_ampm_check=".$event_end_ampm;
        //exit;
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
	//$file_name = $_POST['event_photo'];
	
	$identical_function = $_POST['identical_function'];
	$recurring = $_POST['recurring'];
	$sub_events = $_POST['sub_events'];
	
	
	$Paypal = $_POST['Paypal'];
	$Bank = $_POST['Bank'];
	$Oxxo = $_POST['Oxxo'];
	$Mobile = $_POST['Mobile'];
	$Offline = $_POST['Offline'];
	
	
	$publish_date = $_POST['year_1']."-".$_POST['month_1']."-".$_POST['day_1'];
	$status = $_POST['status'];
	

	// check for venue status
	if($obj->f('status')=="publish"){
		$status = "publish";
	}
	// check for publish date
	if($publish_date=="--")
		$publish_date = $obj->f('publish_date');
	//echo "sss".$status.$publish_date;exit;
	
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
	$privacy = $_POST['privacy'];
	
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
	
	$admin_id = $_POST['admin_id'];
	//print_r($_POST);
	//echo "hii".$_POST['status']; exit;

    /*
     * Check to post to social
     * If already publish, then skip
     */
    
    $objEventEdit->getEventById($_POST['id']);
    $objEventEdit->next_record();
          
    
/*
if ($objEventEdit->f('status') != 'publish') {
        try {

            // post to twitter
            $objLocation->getStateCountyByEventID($_POST['id']);
            $objLocation->next_record();  
            $objVenueLocation->getVenueLocationByVenueID($venue);
            $objVenueLocation->next_record();

            $urlEventEN = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($_POST['id'], $objLocation, 'en', 'event', $event_name_en);
            $urlEventES = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($_POST['id'], $objLocation, 'es', 'evento', $event_name_sp);

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

            $statusTwitterEN = "$eventNameEN, $twitterDateEN, $venueEN, $cityName, $urlEventEN via @Kpasapp";
            $statusTwitterES = "$eventNameES, $twitterDateES, $venueES, $cityName, $urlEventES via @Kpasapp";
            $objTwitter->postStatus($statusTwitterEN);
            $objTwitter->postStatus($statusTwitterES);

            // Post to facebook
            $statusFacebookEN = [
                'link' => $urlEventEN,
                'message' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
            ];
            $statusFacebookES = [
                'link' => $urlEventES,
                'message' => "$eventNameES, $twitterDateES, $venueES, $cityName",
            ];
            $objFacebook->postStatus($statusFacebookEN);
            $objFacebook->postStatus($statusFacebookES);


            // Post to pinterest
            $imagePinterestDefault = $obj_base_path->base_path() . '/images/kpasapp_logo_fb.png';
            $obj_event_photo->getPhotoByEventId($_POST['id']);
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
    }

 */      

        $obj_edit->editSavedEventEdit($admin_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$privacy,$_POST['id']);
	
		//echo '111';
	//exit;

	// Add Multiple Events
	//$obj_multi->addMultipleEvent($_POST['unique_id'],$event_id);
	
	// Add category Event
	//$obj_add_category_by_event->addCategoryByEvent($finalArray,$event_id);
	
	// Add Event Type
	
	//$obj_add_eventtype->addEventType($event_types,$event_id);
	
	// Update event Id
	//$obj_edit_ticket->editTicketByEvent($_SESSION['unique_id'],$last_event_id);
	//echo "hii";
	//
	//header("location: ".$obj_base_path->base_path()."/admin/event-list");
	    
		if($_POST['status']=="updated")
		    $_SESSION['msg'] = "Event ".$_POST['status']." successfully";
		else if($_POST['status']=="publish")
		    $_SESSION['msg'] = "Event published successfully";
		else
		    $_SESSION['msg'] = "Event saved successfully";
		header("location: ".$obj_base_path->base_path()."/admin/edit-event/".$_POST['id']);
			
		exit;
}
else
{
	$_SESSION['unique_id'] = time();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Edit Event</title>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<meta name="p:domain_verify" content="3016db54dbfcb20339ca2c7c3c9b5fc3"/>

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

	

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
//calendar


$(document).ready(function() {
	$('#event_month_st').datepicker({
		firstDay: 1,
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

			// For Span Start Date
			var r_span_start = n[2]+"-"+n[0]+"-"+n[1];
			$('#r_span_start').val(r_span_start);
			
			var next_year = parseInt(n[2]) + 1;
			var r_span_end = next_year+"-"+n[0]+"-"+n[1];
			$('#r_span_end').val(r_span_end);
		}
	});
	
	$('#event_date_st').datepicker({	
		firstDay: 1,   
		showButtonPanel: true,
		onSelect: function(theDate) 
		{
           			
			$('#event_date_end').datepicker('option', 'defaultDate', theDate);
			$('#event_month_end').datepicker('option', 'defaultDate', theDate);	
			$('#event_year_end').datepicker('option', 'defaultDate', theDate);
				
			var n=theDate.split("/");
			
			$("input[name='to_ticket']").val(theDate);
			
			$("input[name='event_month_st']").val(n[0]);
			$("input[name='event_day_st']").val(n[1]);
			$("input[name='event_year_st']").val(n[2]);
			
			$('#event_month_end').val(n[0]);
			$('#event_date_end').val(n[1]);
			$('#event_year_end').val(n[2]);			

			// For Span Start Date
			var r_span_start = n[2]+"-"+n[0]+"-"+n[1];
			$('#r_span_start').val(r_span_start);
			
			var next_year = parseInt(n[2]) + 1;
			var r_span_end = next_year+"-"+n[0]+"-"+n[1];
			$('#r_span_end').val(r_span_end);
        }
		
	});
	
	$('#event_year_st').datepicker({
		showButtonPanel: true,
		firstDay: 1,
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

			// For Span Start Date
			var r_span_start = n[2]+"-"+n[0]+"-"+n[1];
			$('#r_span_start').val(r_span_start);
			
			var next_year = parseInt(n[2]) + 1;
			var r_span_end = next_year+"-"+n[0]+"-"+n[1];
			$('#r_span_end').val(r_span_end);
		}
	});
	
	$('#event_month_end').datepicker({
		firstDay: 1,
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
		}
	});
	
	$('#event_date_end').datepicker({
		firstDay: 1,
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
				
		}
	});
	
	
	$('#event_year_end').datepicker({
		firstDay: 1,
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
		}
	});
	
	
	
	
});
//add description
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#from_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
	$('#to_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
})
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
		 $('#loader').show();		
		 var ticketVal = {"ticket_name_en":$('#ticket_name_en').val(),"ticket_name_sp":$('#ticket_name_sp').val(),"description_en":$('#description_en').val(),"description_sp":$('#description_sp').val(),"price_mx":$('#price_mx').val(),"price_us":$('#price_us').val(),"ticket_num":$('#ticket_num').val(),"from_ticket":$('#from_ticket').val(),"to_ticket":$('#to_ticket').val(),"eairly_dis_percen":$('#eairly_dis_percen').val(),"eairly_days":$('#eairly_days').val(),"group_dis_per":$('#group_dis_per').val(),"group_dis_days":$('#group_dis_days').val(),"photoname":$('#photoname').val(),"members_only":$('input:radio[name=members_only]:checked').val(),"edit_ticket":$('#edit_ticket').val(),"exit_ticket_id":$('#exit_ticket_id').val(),"event_id":<?php echo $_GET['id']?>}
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
			 $("#from_ticket").val("<?php echo date("d-m-Y");?>");
			 $("#to_ticket").val("<?php echo $start_day."-".$start_mon."-".$start_yr;?>");
			 $("#eairly_dis_percen").val("");
			 $("#eairly_days").val("");
			 $("#group_dis_per").val("");
			 $("#group_dis_days").val("");
			 $("#photoname").val(""); 
			 document.getElementById("members_only1").checked = true ;

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
    var firstOptionCity = $("#venue_city option:first").html();
     var firstOptionVenue = $("#venue option:first").html();
     $('#div_city_display').html('<select name="venue_city" id="venue_city" class="selectbg12"><option value="">' + firstOptionCity + '</option></select></div>');
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
function deleteFinal(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_delete_ticket_final.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	     $("#save_create_ticket_display").html(data);
	   }
	 });
}
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


function status(type){
	alert(type);
	$("#status").val(type);
}



function saveAutoEvent()
{ //alert("hihii");
   
      var event_des_en = CKEDITOR.instances['page_content_en'].getData();
      var event_des_sp = CKEDITOR.instances['page_content_sp'].getData();
     
      //alert("en="+event_des_en);
     // alert("sp="+event_des_sp);
      sendData = $("#event_form").serialize();
      $.ajax({ 
         url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_saved_event_edit.php",
         async: false,
         cache: false,
         type: "POST",
         data: sendData+"&event_des_en="+encodeURIComponent(event_des_en)+"&event_des_sp="+encodeURIComponent(event_des_sp),   
         success: function(data){ 
        // alert(data);
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

function deleteTemp(ticket_id,event_id)
{
	 data = "ticket_id="+ticket_id+"&event_id="+event_id;
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
	   //alert(data['members_only']);
	   if(data['members_only']=="1")
		  document.getElementById("members_only1").checked = true ;
	   else
			document.getElementById("members_only2").checked = true ;
	   
	   $('#edit_ticket').val(1);
	   $('#exit_ticket_id').val(ticket_id);
	   $('#loader').hide();
	   //End Fill the Text field
	   
	   //save_new_popup();
	   }
	 });
}


$(document).ready(function() {
	$('#from_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
	$('#to_ticket').datepicker({firstDay: 1,dateFormat: 'dd-mm-yy' });
})

/*window.setInterval(function(){
saveAutoEvent()
}, 5000);*/


function deleteEvent(event_id)
{
	var conf = confirm("Are you sure you want to delete this event?")
	if(conf == true)
    {
       window.location.href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_event.php?event_id="+event_id+"&action=delete";
    }
    else
    {
       return false;
    }
}

function form_submit_but()
{
   //alert("hello1");
	$('#status').val("updated");
	document.getElementById("event_form").submit();
}

function promote_submit_but(e_id)
{
  window.location = "<?php echo $obj_base_path->base_path();?>/admin/add-promotion/event/"+e_id;
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

	/*var count_tic = "160";   //Example: var count = "175";
	function limiter_ticket(){
	
		var tex = document.event_form.description_en.value;
		var len = tex.length;
		if(len > count){
				tex = tex.substring(0,count_tic);
				document.event_form.description_en.value =tex;
				return false;
		}
		document.event_form.limit.value = count_tic-len;
	}*/

	
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

<!------->
 <script type="text/javascript">
   function media_library()
   {
        // alert('hi!');
            saveAutoEvent();
            //var e_id=$("#media_image").val();
            //alert("m= "+e_id);
   
            window.location="<?php echo $obj_base_path->base_path(); ?>/admin/gallery-list/event/<?php echo $obj->f('event_id'); ?>";
            
            return false;
           
   }
 </script>
<!-------->
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
		
    <form action="" method="post" name="event_form" id="event_form" enctype="multipart/form-data">
	<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']?>" />
	<input type="hidden" name="status" id="status" value="saved" />
    <input type="hidden" name="editevent" id="editevent" value="1" />
    <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $obj->f('admin_id');?>" />
    <div class="myevent_box">
    <div class="myevent_left">
	<div class="event_name8">
    <div style="float: left; position: absolute; margin: 0 0 0 303px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" alt="" width="38" height="38" border="0"/></div>
    <div style="float: left; margin: 0 auto;">
	<span class="lang_name">SP</span>
    <br/>
    <span class="event_fieldbg8">
		<input type="text" name="event_name_sp" id="event_name_sp" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="<?php echo htmlentities(stripslashes($obj->f('event_name_sp')));?>" onBlur="saveAutoEvent();"/>
	</span>	
	</div>
    
	<div style="float: right; margin: 0 auto;">	
	<span  class="lang_name_eng">EN</span><br/>
    <span class="event_fieldbg8">
     
	<input type="text" name="event_name_en" id="event_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field" value="<?php echo htmlentities(stripslashes($obj->f('event_name_en')));?>" onBlur="saveAutoEvent();"/>
	</span>		
    </div>
    </div>
    
    <div class="clear"></div>
    <div class="event_date">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><h1 style="padding: 35px 0 0 10px;"><?= AD_DATE ?></h1></td>
      <td><h1 style="padding: 35px 0 0 10px;"><?= AD_STARTS ?></h1></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>DD</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong>MM</strong></td>
            <td style="color:#FF0000; padding: 0;"><strong>/</strong></td>
            <td style="color:#FF0000; padding: 0 0 0 13px;"><strong><?= AD_YEAR_FORMAT ?></strong></td>
        </tr>
        <tr>
          <td><input type="text" name="event_day_st" id="event_date_st" value="<?php echo $start_day;?>"  class="textbg_grey"  style="width: 30px;" /></td>
          <td>/</td>
          <td><input type="text" name="event_month_st" id="event_month_st" value="<?php echo $start_mon;?>" class="textbg_grey"  style="width: 30px;" /></td>
          <td>/</td>
          <td><input type="text" name="event_year_st" id="event_year_st"  value="<?php echo $start_yr;?>" class="textbg_grey"  style="width: 40px;" /></td>
          <td></td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_st" class="selectbg" id="event_hr_st" title="Please select event hour" style="width:50px;float:left;" onChange="changeTime(this.value);">
            <?php 
                  for($i=0; $i<13; $i++) {
                  ?>
            <option value="<?php echo $i; ?>" <?PHP if($i==$display_start_hr) {echo 'selected="selected"';}?>><?php echo $i;?></option>
            <?php }?>
          </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
          <td style="padding: 9px 0;"><select name="event_min_st" class="selectbg" id="event_min_st" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=00; $j<60; $j++) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==$start_min) {echo 'selected="selected"';}?>><?php echo $j;?></option>
                  <?php }?>
                      
                </select></td>
          <td style="padding: 9px 0;">&nbsp;</td>
          <td style="padding: 9px 0;"><select name="event_start_ampm" class="selectbg" id="event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;" onchange="saveAutoEvent();">
			    <option value="AM" <?php if($obj->f('event_start_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
			    <option value="PM" <?php if($obj->f('event_start_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
                </select></td>
          <td style="padding: 9px 0;"></td>
        </tr>
      </table></td>
      <td><h1 style="padding: 35px 0 0 10px;"><?= AD_ENDS ?></h1></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 20px 0 0 0;">
        <tr>
          <td><input type="text" name="event_day_end" id="event_date_end" value="<?php echo $end_day;?>" class="textbg_grey" style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_month_end" id="event_month_end" value="<?php echo $end_mon;?>"  class="textbg_grey" style="width: 30px;"/></td>
          <td>/</td>
          <td><input type="text" name="event_year_end" id="event_year_end" value="<?php echo $end_yr;?>"  class="textbg_grey" style="width: 40px;"/></td>
        </tr>
        <tr>
          <td style="padding: 9px 0;"><select name="event_hr_end" class="selectbg" id="event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                  <?php 
                  for($i=0; $i<13; $i++) {
                  ?>
                  <option value="<?php echo $i; ?>" <?PHP if($i==$display_end_hr) {echo 'selected="selected"';}?>><?php echo $i;?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_min_end" class="selectbg" id="event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                  <?php 
                  for($j=0; $j<60; $j++) {
                  ?>
                  <option value="<?php echo $j; ?>" <?PHP if($j==$end_min) {echo 'selected="selected"';}?>><?php echo $j;?></option>
                  <?php }?>
                </select></td>
          <td style="padding: 9px 0;">/</td>
         <td style="padding: 9px 0;"><select name="event_end_ampm" class="selectbg" id="event_end_ampm" title="Please select event miniute" style="width:50px;float:left;" onchange="saveAutoEvent();">
				  <option value="AM" <?php if($obj->f('event_end_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
				  <option value="PM" <?php if($obj->f('event_end_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
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
      <td width="12%"><h1><?= AD_VENUE ?></h1></td>
      <td width="22%">
	  <select name="venue_state" id="venue_state" class="selectbg12" onChange="getCounty(this.value);" onblur="saveAutoEvent();">
	  <option value=""><?= AD_STATE ?></option>
	  <?php
	  $obj_venuestate->getVenueState($obj_venue_dis->f('venue_state'));
	  while($row = $obj_venuestate->next_record())
	  {
	  ?>
	  <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj_venue_dis->f('venue_state') == $obj_venuestate->f('id')) { echo 'selected'; }?>><?php echo $obj_venuestate->f('state_name');?></option>
	  <?php
	  }
	  ?>
      </select></td>
      <td width="22%">
		  <div id="div_county_display">
		  <select name="venue_county" class="selectbg12" onchange="getCity(this.value); saveAutoEvent();">
              <option value=""><?= AD_COUNTY ?></option>
              <?php
              $obj_venuecounty->getVenueCounty($obj_venue_dis->f('venue_state'));
              while($row = $obj_venuecounty->next_record())
              {
              ?>
              <option value="<?php echo $obj_venuecounty->f('id');?>" <?php if($obj_venue_dis->f('venue_county') == $obj_venuecounty->f('id')) { echo 'selected'; }?>><?php echo $obj_venuecounty->f('county_name');?></option>
              <?php
              }
              ?>
		  </select>
		  </div>
	  </td>          
      <td width="22%">
		  <div id="div_city_display">
		  <select name="venue_city" id="venue_city" class="selectbg12" onchange="getVenue(this.value); saveAutoEvent()">
		  <option value=""><?= AD_CITY ?></option>
		  <?php
		  $obj_venuecity->getVenueCity($obj_venue_dis->f('venue_county'));
		  while($row = $obj_venuecity->next_record())
		  {
		  ?>
		  <option value="<?php echo $obj_venuecity->f('id');?>" <?php if($obj_venue_dis->f('venue_city') == $obj_venuecity->f('id')) { echo 'selected'; }?>><?php echo $obj_venuecity->f('city_name');?></option>
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
			 $obj_venue->getVenueName($obj_venue_dis->f('venue_city'));
			 while($row = $obj_venue->next_record())
			 {
			?>
			<option value="<?php echo $obj_venue->f('venue_id');?>" <?php if($obj->f('event_venue') == $obj_venue->f('venue_id')) { echo 'selected'; }?>><?php echo $obj_venue->f('venue_name');?></option>
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
  <!-- <textarea name="page_content_sp" cols="35" rows="10"><?php //echo stripslashes($obj->f('event_details_sp'));?></textarea>-->
    <?php 
	include_once($obj_base_path->base_path()."/ckeditor/ckeditor.php");
       $CKeditor = new CKeditor();
       $CKeditor->BasePath = 'ckeditor/';
       $CKeditor->editor('page_content_sp',$obj->f('event_details_sp'));
	?>
    </div>
    <div class="TabbedPanelsContent2">
	<!--<textarea name="page_content_sp" cols="35" rows="10"><?php //echo stripslashes($obj->f('event_details_sp'));?></textarea>-->
     <?php 
       $CKeditor = new CKeditor();
       $CKeditor->BasePath = 'ckeditor/';
       $CKeditor->editor('page_content_en',$obj->f('event_details_en'));
	?>
    </div> 
    </div>
    </div>
    </div>	
    
    <div class="clear"></div>
    <div class="event_name8">
        <div style="float: left; margin: 0 auto;">            
            <?php
            $biodata_length1 = strlen($obj->f('event_short_desc_sp'));
            $biodata_character_remaining1 = 160 - $biodata_length1;
            ?>
            <span class="event_fieldbg8">
                Meta descripci&#243;n para redes sociales
                <textarea name="short_desc_sp" id="short_desc_sp" class="event_field" style="width:290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();" onkeyup="limiter()"><?php echo stripslashes($obj->f('event_short_desc_sp')); ?></textarea>
                <script type="text/javascript">
                    <?php if ($biodata_length1 > 0) { ?>
                            document.write("<input type=text name=limit size=4 readonly value=<?php echo $biodata_character_remaining1; ?>>");
                    <?php } else { ?>
                            document.write("<input type=text name=limit size=4 readonly value="+count+">");
                    <?php } ?>
                </script>
            </span>
        </div>

        <div style="float: right; margin: 0 auto;">	
            <?php
            $biodata_length = strlen($obj->f('event_short_desc_en'));
            $biodata_character_remaining = 160 - $biodata_length;
            ?>
            <span class="event_fieldbg8">
                Meta description for social networks
                <textarea name="short_desc_en" id="short_desc_en" class="event_field" style="width: 290px; margin: 5px 0; padding: 3px 5px; height: 60px;" onblur="saveAutoEvent();" onkeyup="limiter1()"><?php echo stripslashes($obj->f('event_short_desc_en')); ?></textarea>
                <script type="text/javascript">
                <?php if ($biodata_length > 0) { ?>
                    document.write("<input type=text name=limit1 size=4 readonly value=<?php echo $biodata_character_remaining; ?>>");
                <?php } else { ?>
                    document.write("<input type=text name=limit1 size=4 readonly value="+count1+">");
                <?php } ?>
                </script>
            </span>
        </div>
    </div>
    <div class="clear"></div>
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
			onSelect:function(theDate) 
			{
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
			onSelect: function(theDate) 
			{
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
		
		$('#multi_event_year_start').datepicker({
			firstDay: 1 ,	
			showButtonPanel: true,
			onSelect:function(theDate) 
			{
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
				$("input[name='multi_event_month_end']").datepicker('option', 'defaultDate', theDate);
				$("input[name='multi_event_day_end']").datepicker('option', 'defaultDate', theDate);	
				$("input[name='multi_event_year_end']").datepicker('option', 'defaultDate', theDate);
				
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
				$("input[name='multi_event_month_end']").datepicker('option', 'defaultDate', theDate);
				$("input[name='multi_event_day_end']").datepicker('option', 'defaultDate', theDate);	
				$("input[name='multi_event_year_end']").datepicker('option', 'defaultDate', theDate);
				
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
				$("input[name='multi_event_month_end']").datepicker('option', 'defaultDate', theDate);
				$("input[name='multi_event_day_end']").datepicker('option', 'defaultDate', theDate);	
				$("input[name='multi_event_year_end']").datepicker('option', 'defaultDate', theDate);
				
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
		 $("#multi_event_hr").val("7");
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
		 var ticketVal = {"multi_event_day_start":$('#multi_event_day_start').val(),"multi_event_month_start":$('#multi_event_month_start').val(),"multi_event_year_start":$('#multi_event_year_start').val(),"multi_event_hr_start":$('#multi_event_hr_start').val(),"multi_event_min_start":$('#multi_event_min_start').val(),"multi_event_start_ampm":$('#multi_event_start_ampm').val(),"multi_event_day_end":$('#multi_event_day_end').val(),"multi_event_month_end":$('#multi_event_month_end').val(),"multi_event_year_end":$('#multi_event_year_end').val(),"multi_event_hr_end":$('#multi_event_hr_end').val(),"multi_event_min_end":$('#multi_event_min_end').val(),"multi_event_end_ampm":$('#multi_event_end_ampm').val(),"multi_venue_state":$('#multi_venue_state').val(),"venue_county_multi":$('#venue_county_multi').val(),"multi_venue_city":$('#multi_venue_city').val(),"multi_venue":$('#multi_venue').val(),"edit_multi_event":$('#edit_multi_event').val(),"exit_multi_event":$('#exit_multi_event').val(),"edit_event_id":<?php echo $_GET['id']?>,"event_hr_st":$('#event_hr_st').val(),"event_min_st":$('#event_min_st').val(),"event_start_ampm":$('#event_start_ampm').val(),"event_hr_end":$('#event_hr_end').val(),"event_min_end":$('#event_min_end').val(),"event_end_ampm":$('#event_end_ampm').val(),"event_date_st":$('#event_date_st').val(),"event_month_st":$('#event_month_st').val(),"event_year_st":$('#event_year_st').val(),"event_date_end":$('#event_date_end').val(),"event_month_end":$('#event_month_end').val(),"event_year_end":$('#event_year_end').val()}
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
			 
			$('#add_edit_show').html('<h1 style="color:#000000;">Add another function</h1>');
			 
			 /*$("#multi_event_day_start").val("00");
			 $("#multi_event_month_start").val("00");
			 $("#multi_event_year_start").val("0000");
			 $("#multi_event_hr_start").val("7");
			 $("#multi_event_min_start").val("00");
			 
			// $("#multi_event_day_end").val("00");
			 $("#multi_event_month_end").val("00");
			 $("#multi_event_year_end").val("0000");
			 $("#multi_event_hr_end").val("9");
			 $("#multi_event_min_end").val("00");
			 $("#multi_event_hr").val("7");
			 $('#multi_venue_state').val("");
		     $('#venue_county_multi').val("");
		     $('#multi_venue_city').val("");
		     $('#multi_venue').val("");*/

			/* $('#div_state_display_multi').html('<select name="multi_venue_state" class="state selectbg12"><option value="">State</option></select>');
			 $('#div_county_display_multi').html('<select name="venue_county_multi" class="state selectbg12"><option value="">County</option></select>');
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
	$('#add_edit_show').html('<h1 style="color:#000000;">Edit function<h1>');
	
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
	   
	  /* getCounty_multi(data['multi_venue_state'],data['venue_county_multi']);
	   getCity_multi(data['venue_county_multi'],data['multi_venue_city']);
	   getVenue_multi(data['multi_venue_city'],data['multi_venue'])*/
	   
	   //alert(data);
	   if(parseInt(data['multi_tm_hr_start']) > 12)
		   show_hr_val_start = (parseInt(data['multi_tm_hr_start']) - 12);
		else
			show_hr_val_start = parseInt(data['multi_tm_hr_start']);
			
	   if(parseInt(data['multi_tm_hr_end']) > 12)
		   show_hr_val_end = (parseInt(data['multi_tm_hr_end']) - 12);
		else
			show_hr_val_end = parseInt(data['multi_tm_hr_end']);
			
		// Fill the Text field
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
	  /* $('#multi_venue_state').val(data['multi_venue_state']);
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
		$("#multi_event_day_start").css("border","1px solid #E1E1E1");
	}
	var month_start = document.getElementById('multi_event_month_start').value;
	if(month_start == 0){
		$("#multi_event_month_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_month_start").css("border","1px solid #E1E1E1");
	}
	var year_start = document.getElementById('multi_event_year_start').value;
	if(year_start == 0){
		$("#multi_event_year_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_year_start").css("border","1px solid #E1E1E1");
	}
	
	var hr_start = document.getElementById('multi_event_hr_start').value;
	if(hr_start == 0){
		$("#multi_event_hr_start").css("border","1px solid red");
		error = 1;
	}
	else
	{
		$("#multi_event_hr_start").css("border","1px solid #E1E1E1");
	}
	
//var day_end = document.getElementById('multi_event_day_end').value;
//	if(day_end == 0){
//		$("#multi_event_day_end").css("border","1px solid red");
//		error = 1;
//	}
//	else
//	{
//		$("#multi_event_day_end").css("border","1px solid #E1E1E1");
//	}
//	var month_end = document.getElementById('multi_event_month_end').value;
//	if(month_end == 0){
//		$("#multi_event_month_end").css("border","1px solid red");
//		error = 1;
//	}
//	else
//	{
//		$("#multi_event_month_end").css("border","1px solid #E1E1E1");
//	}
//	var year_end = document.getElementById('multi_event_year_end').value;
//	if(year_end == 0){
//		$("#multi_event_year_end").css("border","1px solid red");
//		error = 1;
//	}
//	else
//	{
//		$("#multi_event_year_end").css("border","1px solid #E1E1E1");
//	}
//	
//	var hr_end = document.getElementById('multi_event_hr_end').value;
//	if(hr_end == 0){
//		$("#multi_event_hr_end").css("border","1px solid red");
//		error = 1;
//	}
//	else
//	{
//		$("#multi_event_hr_end").css("border","1px solid #E1E1E1");
//	}
	
	/*var state = document.getElementById('multi_venue_state').value;
	if(state == 0){
		$("#multi_venue_state").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue_state").css("border","1px solid #E1E1E1");
	}
	
	var country = document.getElementById('venue_county_multi').value;
	if(country == 0){
		$("#venue_county_multi").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#venue_county_multi").css("border","1px solid #E1E1E1");
	}
	
	var city = document.getElementById('multi_venue_city').value;
	if(city == 0){
		$("#multi_venue_city").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue_city").css("border","1px solid #E1E1E1");
	}
	
	var venue = document.getElementById('multi_venue').value;
	if(venue == 0){
		$("#multi_venue").css("border","1px solid red");
		//return false;
		error = 1;
	}
	else
	{
		$("#multi_venue").css("border","1px solid #E1E1E1");
	}*/
	
	if(error == 1){
		return false;
	}
	else
	{
		return true;
	}
}

function subEvent(event_id) 
{
	//alert(event_id);
	//window.open("<?php echo $obj_base_path->base_path(); ?>/admin/sub-events/"+event_id);
	window.open("<?php echo $obj_base_path->base_path(); ?>/admin/sub-events-edit/"+event_id);
}

function subEventEdit() 
{
	window.open("<?php echo $obj_base_path->base_path(); ?>/admin/sub-events-edit/<?php echo $_GET['id']?>");
}

</script>
    <div class="clear"></div>
    <div class="event_date" style="float: right; width: 700px;">
  	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
    	<tr>
          <td width="75%"><p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/> <?= AD_EVENT_TYPE_ONE ?></p></td>
          <td width="25%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; width: 150px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;">
              <input name="identical_function" type="radio" onclick="showmultifunction(); saveAutoEvent();" value="1" <?php  if($obj->f('identical_function')==1){?> checked="checked"<?php }?>/>		  </td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;"><?= AD_YES_OPTION ?></td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;">
              <input name="identical_function" type="radio"  onclick="showmultifunction(); saveAutoEvent();" value="0" <?php if($obj->f('identical_function')==0){?> checked="checked"<?php }?>/>		  </td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;"><?= AD_NO_OPTION ?></td>
            </tr>
          </table></td>
        </tr>
	 	<tr style="display:none;" id="multi_fun_details">
     	 <td colspan="2">
	  		<div class="event_ticketl2">
           <img id="loader1" src="<?php echo $obj_base_path->base_path(); ?>/images/loader.gif" alt="" width="67" height="75" border="0" style="display:none;"/>
            	<div style="margin: 0 0 10px 0px;">
                
                	<span style="font-weight: bold;font-size:16px; padding: 0; margin:5px 0 0 14px; width: 240px; display: inline-block;"><?php echo stripslashes($event_name_show);?>,</span>
                	<span style="font-weight:bold; padding: 0; margin: 0; font-size:16px;"><?php echo date("D",strtotime($explode_start_date_time_all[0]));?><span style="color:#0094A4;font-weight:bold; font-size:16px;"><?php echo date("M",strtotime($explode_start_date_time_all[0]))." ".date("d",strtotime($explode_start_date_time_all[0]));?></span></span>
                	<span style="font-weight:bold; padding: 0; margin: 0; font-size:16px;color:#0094A4; padding-left:5px;">-</span>
                	<span style="font-weight:bold; padding: 0; margin: 0; font-size:16px;color:#0094A4; padding-left:5px;"><?php echo date('g:i A',strtotime($explode_start_date_time_all[1]));?></span>                </div>
				<div id="show_multi_events"  style="margin: 0 auto 5px auto;">
				<?php				
				echo '<div style=" max-height:95px;">';
				$obj_temp_mulEve->get_final_MultiEvent($_REQUEST['id']);
				if($obj_temp_mulEve->num_rows()){
					while($obj_temp_mulEve->next_record()){
				// Event Date
				list($event_date,$event_time) = explode(" ",$obj_temp_mulEve->f('event_start_date_time'));
				?>
				<style>
				/*.edit_del{
					margin: 0 6px 0 0; display:inline-block; float: right; width: 114px; border: 1px solid #CCCCCC; background: #f5f5f5; height: 23px;
				}*/
				</style>
				<div id="<?php echo $obj_temp_mulEve->f('multi_id');?>">
				<div style="float: left; width: 420px;">
				<?php /*?><p style="float: left; margin:0 auto;"><?php echo $obj_temp_mulEve->f('venue_name_multi').". ".$obj_temp_mulEve->f('city_name_multi').". ".$obj_temp_mulEve->f('state_name_multi')?></p><?php */?>
				<span style="float: right; margin:0 auto; padding: 5px 0 0 0;"><?php echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));?> at <?php echo date('g:i A',strtotime($event_time)); ?></span>
				</div>
				<!--<div class="clear"></div>-->
				<div style="float: right; width: 420px;">
					<!--<span><?php echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));?> - <?php echo date('g:i a A',strtotime($event_time)); ?></span>-->
					    <span class="edit_del">
						<span style="cursor:pointer;" onclick="edit_multipleEvents(<?php echo $obj_temp_mulEve->f('multi_id');?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> <?= AD_EDIT ?></span> 
						<span style="cursor:pointer;" onclick="delete_multipleEvents('<?php echo $obj_temp_mulEve->f('multi_id');?>','<?php echo $_GET['id'];?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> <?= AD_DELETE ?></span>
					 </span>
				</div>
				</div>
				 <?php
					}
				}
				echo '</div>';
				?>				
				</div>
                 <div class="clear"></div>
				<div id="add_edit_show"><h1 style="color:#000000;"><?= AD_ADD_ANOTHER_FUNC ?></h1></div>
				
				<div class="date_left">
                	<input type="hidden" name="edit_multi_event" id="edit_multi_event" value="0" />
                	<input type="hidden" name="exit_multi_event" id="exit_multi_event" value="0" />
                   <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="46%" style="text-align:left;"><h1 style="padding: 51px 0 0 8px; margin:0; text-align: left;"><?= AD_DATE ?> <?= AD_STARTS ?></h1></td>
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
                          	<input type="text" name="multi_event_day_start" id="multi_event_day_start" value="<?php echo $start_day;?>"  class="textbg_grey"  style="width:40px;"/>
                          </td>
                          <td style="text-align: center; padding: 0 0 0 9px;">/</td>
                          <td style="text-align:left;">
                           <input type="text" name="multi_event_month_start" id="multi_event_month_start" value="<?php echo $start_mon;?>" class="textbg_grey" style="width:40px;"/>
                          </td>
                          <td style="text-align: center; padding: 0;">/</td>
                          <td style="text-align:left; padding: 0;">
                          	<input type="text" name="multi_event_year_start" id="multi_event_year_start" value="<?php echo $start_yr;?>" class="textbg_grey" style="width: 40px;"/>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 3px 0; text-align:left;">
                          	<select name="multi_event_hr_start" class="selectbg" id="multi_event_hr_start" title="Please select event hour" style="width:50px;float:left;">
                            <?php 
                                  for($i=0; $i<13; $i++) {
                                  ?>
                            <option value="<?php echo $i; ?>" <?PHP if($i==$display_start_hr) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                            <?php }?>
                          </select></td>
                          <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                          <td style="padding: 3px 0 0 0;">
                          		<select name="multi_event_min_start" class="selectbg" id="multi_event_min_start" title="Please select event miniute" style="width:50px;float:left;">
                                  <?php 
                                  for($j=00; $j<60; $j++) {
                                  ?>
                                  <option value="<?php echo $j; ?>"<?PHP if($j==$start_min) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                                  <?php }?>
                                      
                                </select></td>
                          <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                          <td style="padding: 3px 0; text-align:left;"><select name="multi_event_start_ampm" class="selectbg" id="multi_event_start_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                                  <option value="AM" <?php if($obj->f('multi_event_start_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
                                  <option value="PM" <?php if($obj->f('multi_event_start_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
                                </select></td>
                          </tr>
                      </table></td>
                     </tr>
                    </table>
					</div>
<!--					<div class="date_right">
					<table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" style="margin: 20px auto 0 auto;">
                    <tr>
                      <td width="46%" style="text-align:left;"><h1 style="padding: 31px 12px 0 0; margin:0; text-align: right;">Ends</h1></td>
                      <td width="94%"><table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" style="margin: 17px 0;">      
                        <tr>
                          <td style="text-align:left; padding: 0;">
                          	<input type="text" name="multi_event_day_end" id="multi_event_day_end" value="<?php echo $end_day;?>"  class="textbg_grey"  style="width: 40px;"/>
                          </td>
                          <td style="text-align: center; padding: 0 0 0 9px;">/</td>
                          <td style="text-align:left;">
                          	<input type="text" name="multi_event_month_end" id="multi_event_month_end" value="<?php echo $end_mon;?>" class="textbg_grey"  style="width: 40px;"/>
                          </td>
                          <td style="text-align: center; padding: 0;">/</td>
                          <td style="text-align:left; padding: 0;">
                          	<input type="text" name="multi_event_year_end" id="multi_event_year_end"  value="<?php echo $end_yr;?>" class="textbg_grey"  style="width: 40px;"/>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 3px 0; text-align:left;">
                          	<select name="multi_event_hr_end" class="selectbg" id="multi_event_hr_end" title="Please select event hour" style="width:50px;float:left;">
                            <?php 
                                  for($i=0; $i<13; $i++) {
                                  ?>
                            <option value="<?php echo $i; ?>" <?PHP if($i==$display_end_hr) {echo 'selected="selected"';}?>><?php echo $i; ?></option>
                            <?php }?>
                          </select></td>
                          <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                          <td style="padding: 3px 0 0 0;">
                          		<select name="multi_event_min_end" class="selectbg" id="multi_event_min_end" title="Please select event miniute" style="width:50px;float:left;">
                                  <?php 
                                  for($j=00; $j<60; $j++) {
                                  ?>
                                  <option value="<?php echo $j; ?>" <?PHP if($j==$end_min) {echo 'selected="selected"';}?>><?php echo $j; ?></option>
                                  <?php }?>
                                      
                                </select></td>
                          <td style="padding: 3px 0; text-align:left;">&nbsp;</td>
                          <td style="padding: 3px 0; text-align:left;"><select name="multi_event_end_ampm" class="selectbg" id="multi_event_end_ampm" title="Please select AM or PM" style="width:50px;float:left;">
                                  <option value="AM" <?php if($obj->f('multi_event_end_ampm') == 'AM') {  ?> selected=selected <?php } ?>>AM</option>
                                  <option value="PM" <?php if($obj->f('multi_event_end_ampm') == 'PM') {  ?> selected=selected <?php } ?>>PM</option>
                                </select></td>
                          </tr>
                      </table></td>
                     </tr>
                    </table>
					</div>
-->					</div>                     
				 <div class="clear"></div>	
                 <input type="hidden" name="multi_venue_state" id="multi_venue_state" value="" />
                 <input type="hidden" name="venue_county_multi" id="venue_county_multi" value="" />
                 <input type="hidden" name="multi_venue_city" id="multi_venue_city" value="" />
                 <input type="hidden" name="multi_venue" id="multi_venue" value="" />
                 			
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
                                        <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('event_venue_state') == $obj_venuestate->f('id')) { echo 'selected'; }?>>
                                        <?php echo $obj_venuestate->f('state_name');?></option>
                                        <?php
                                      }
                                ?>
                              </select></div></td>
                              <td>
							  <div id="div_county_display_multi">
                                  <select name="venue_county_multi" id="venue_county_multi" class="state selectbg12" onChange="getCity_multi(this.value,'');">
                                  <option value="">County</option>
                                  <?php
                                        $obj_getcounty = new admin;
                                        $obj_getcounty->getCountyNameByState($obj->f('event_venue_state'));
                                        while($obj_getcounty->next_record())
                                        {
                                        ?>
                                        <option value=<?php echo $obj_getcounty->f("id")?>  <?php if($obj->f('event_venue_county') == $obj_getcounty->f('id')) { echo 'selected'; }?> >
                                        <?php echo $obj_getcounty->f('county_name')?></option>
                                        <?php
                                        }
                                  ?>
                                  </select>
                                  </div></td>
                              <td>
							  <div id="div_city_display_multi">
                                  <select name="multi_venue_city" id="multi_venue_city" class="state selectbg12"  onChange="getVenue_multi(this.value,'');">
                                  <option value="">City</option>
                                   <?php
                                        $obj_getcity_multi = new admin;
                                        $obj_getcity_multi->getCityNameByCounty($obj->f('event_venue_county'));
                                        while($obj_getcity_multi->next_record())
                                        {
                                        ?>
                                        <option value="<?php echo $obj_getcity_multi->f("id")?>"<?php if($obj->f('event_venue_city')==$obj_getcity_multi->f('id')) { echo 'selected'; }?>><?php echo $obj_getcity_multi->f('city_name')?></option>
                                        <?php
                                        }
                                  ?>
                                  </select>
                                  </div></td>
                              <td>
							  <div id="div_venue_display_multi">
                                  <select name="multi_venue" id="multi_venue" class="state selectbg12">
                                  <option value="">Venue</option>
                                   <?php
                                        $obj_getvenue_multi = new admin;
                                        $obj_getvenue_multi->getVenueNameByCity($obj->f('event_venue_city'));
                                        while($obj_getvenue_multi->next_record())
                                        {
                                        ?>
                                        <option value="<?php echo $obj_getvenue_multi->f("venue_id")?>"<?php if($obj->f('event_venue') == $obj_getvenue_multi->f('venue_id')) { echo 'selected'; }?>>
                                        <?php echo $obj_getvenue_multi->f('venue_name')?></option>
                                        <?php
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
                <div style="width: 403px; margin: 0 auto; float: right;">
                	<input class="event_save" type="button" value="<?= AD_SAVE_CREATE_FUNC ?>" onclick="save_multiple()" name="Submit_multi" style="float: left; margin: 10px 0 10px 8px;cursor:pointer;">
                    <input class="event_save" type="button" value="<?= AD_SAVE_EXIT ?>" onclick="save_multiple()" name="Submit" style="float:right;margin:10px 8px 10px 0;cursor:pointer;">
                </div>
                
         </td>
        </tr>
    	<tr>
          <td><p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/> <?= AD_EVENT_TYPE_TWO ?></p></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC; width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;">
              	<input name="recurring" type="radio" onclick="showrecurringfunction(); saveAutoEvent();" value="1" <?php  if($obj->f('recurring')==1){?> checked="checked"<?php }?> onfocus="saveAutoEvent();"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;"><?= AD_YES_OPTION ?></td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;">
              	<input name="recurring" type="radio" onclick="showrecurringfunction(); saveAutoEvent();" value="0" <?php  if($obj->f('recurring')==0){?> checked="checked"<?php }?> onfocus="saveAutoEvent();"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;"><?= AD_NO_OPTION ?></td>
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
				  <option value="Daily" <?php if($obj->f('event_time') == 'Daily') { echo 'selected'; } ?>><?= AD_DAILY ?></option>
				  <option value="Weekly" <?php if($obj->f('event_time') == 'Weekly') { echo 'selected'; } ?>><?= AD_WEEKLY ?></option>
				  <option value="Monthly" <?php if($obj->f('event_time') == 'Monthly') { echo 'selected'; } ?>><?= AD_MONTHLY ?></option>
				  <option value="Yearly" <?php if($obj->f('event_time') == 'Yearly') { echo 'selected'; } ?>><?= AD_YEARLY ?></option>
                </select></li>
	<li><?= AD_EVERY ?></li>
	<li><input type="text" name="event_time_period" id="event_time_period" value="<?php echo $obj->f('event_time_period')?>"  class="textbg_grey"  style="width: 40px;" onblur="saveAutoEvent();"/></li>
	<li id="week" class="all" style="display:none;"><?= AD_EVERY_OPTION_ONE ?></li>
	<li id="day" class="all" style="display:none;"><?= AD_EVERY_OPTION_TWO ?></li>
	<li id="month1" class="all" style="display:none;"><?= AD_EVERY_OPTION_THREE ?></li>
	<li id="year" class="all" style="display:none;"><?= AD_EVERY_OPTION_FOUR ?></li>
	</ul>
	</div>
	<div class="clear"></div>
	<div style="display:none;" id="week1" class="all">
	<ul>
	<li><input type="checkbox" name="Mon" value="1" style="padding:0; margin: 0;" <?php if($obj->f('mon') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_MON ?></li>
	<li><input type="checkbox" name="Tue" value="1" style="padding:0; margin: 0;" <?php if($obj->f('tue') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_TUE ?></li>
	<li><input type="checkbox" name="Wed" value="1" style="padding:0; margin: 0;" <?php if($obj->f('wed') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_WED ?></li>
	<li><input type="checkbox" name="Thu" value="1" style="padding:0; margin: 0;" <?php if($obj->f('thu') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_THU ?></li>
	<li><input type="checkbox" name="Fri" value="1" style="padding:0; margin: 0;" <?php if($obj->f('fri') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_FRI ?></li>
	<li><input type="checkbox" name="Sat" value="1" style="padding:0; margin: 0;" <?php if($obj->f('sat') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_SAT ?></li>
	<li><input type="checkbox" name="Sun" value="1" style="padding: 0; margin: 0;" <?php if($obj->f('sun') == '1') { echo 'checked'; }?> onclick="saveAutoEvent();"/></li>
	<li><?= AD_DAY_SUN ?></li>
	</ul>
	</div>
	
	<div style="display:none;" id="month" class="all">
		<ul>
			<li>
				<select name="r_month" class="selectbg" id="r_month" title="" style="width:70px;float:left; margin: 8px 0; height: 20px;" onchange="saveAutoEvent();">
                  <option value=""><?= AD_SELECT ?></option>
				  <option value="First" <?php if($obj->f('r_month') == 'First') { echo 'selected'; }?>><?= AD_FIRST ?></option>
				  <option value="Second" <?php if($obj->f('r_month') == 'Second') { echo 'selected'; }?>><?= AD_SECOND ?></option>
				  <option value="Third" <?php if($obj->f('r_month') == 'Third') { echo 'selected'; }?>><?= AD_THIRD ?></option>
				  <option value="Fourth" <?php if($obj->f('r_month') == 'Fourth') { echo 'selected'; }?>><?= AD_FOURTH ?></option>
				  <option value="Last" <?php if($obj->f('r_month') == 'Last') { echo 'selected'; }?>><?= AD_LAST ?></option>
                </select>
			</li>
			<li>
				<select name="r_month_day" class="selectbg" id="r_month_day" title="" style="width:70px;float:left; margin: 8px 0; height: 20px;" onchange="saveAutoEvent();">
                  <option value=""><?= AD_SELECT ?></option>
				  <option value="Monday" <?php if($obj->f('r_month_day') == 'Monday') { echo 'selected'; }?>><?= AD_DAY_MONDAY ?></option>
				  <option value="Tuesday" <?php if($obj->f('r_month_day') == 'Tuesday') { echo 'selected'; }?>><?= AD_DAY_TUESDAY ?></option>
				  <option value="Wednesday" <?php if($obj->f('r_month_day') == 'Wednesday') { echo 'selected'; }?>><?= AD_DAY_WEDNESDAY ?></option>
				  <option value="Thursday" <?php if($obj->f('r_month_day') == 'Thursday') { echo 'selected'; }?>><?= AD_DAY_THURSDAY ?></option>
				  <option value="Friday" <?php if($obj->f('r_month_day') == 'Friday') { echo 'selected'; }?>><?= AD_DAY_FRIDAY ?></option>
				  <option value="Saturday" <?php if($obj->f('r_month_day') == 'Saturday') { echo 'selected'; }?>><?= AD_DAY_SATURDAY ?></option>
				  <option value="Sunday" <?php if($obj->f('r_month_day') == 'Sunday') { echo 'selected'; }?>><?= AD_DAY_SUNDAY ?></option>
                </select>
			</li>
			<li><?= AD_OF_EACH_MONTH ?></li>
		</ul>
	</div>
	
			<div class="clear"></div>
			<div>
	<ul>	
	<li><?= AD_RECURRENCES_SPAN ?></li>
	<li><input type="text" name="r_span_start" id="r_span_start" value="<?php echo $obj->f('r_span_start')?>"  class="textbg_grey"  style="width: 70px;" /></li>
	<li><?= AD_TO ?></li>
	<li><input type="text" name="r_span_end" id="r_span_end" value="<?php echo $obj->f('r_span_end')?>"  class="textbg_grey"  style="width: 70px;" /></li>
	</ul>
	</div>
    <div class="clear"></div>
    <div>
        <ul>	
        <li>
			<input type="hidden" id="event_start" name="event_start" />
       
        </li>
        <li>
     		<input type="hidden" id="event_end" name="event_end" />
        </li>
          <li>
          	<input type="hidden" id="all_day" name="all_day" value="1" />
          </li>
        </ul>
    </div>
    <div class="clear"></div>
    <!--<div>
        <ul>
            <li>Each event lasts</li>
            <li><input type="text" name="event_lasts" id="event_lasts" value="<?php echo $obj->f('event_lasts')?>"  class="textbg_grey"  style="width: 110px;" onclick="saveAutoEvent();"/></li>
            <li>day(s)</li>
        </ul>
    </div>-->
        <div class="clear"></div>
		</div>
     </td>
     </tr>	
   	 <tr>
          <td><p style="text-align: right; padding-right: 13px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/> <?= AD_EVENT_TYPE_THREE ?></p></td>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 8px 0 0 0; border: 1px solid #CCCCCC;  width: 150px; background: #f5f5f5; height: 30px;">
            <tr>
              <td width="3%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="1" <?php  if($obj->f('sub_events')==1){?> checked="checked"<?php }?> onclick="saveAutoEvent(); subEvent(<?php echo $obj->f('event_id');?>);"/></td>
              <td width="6%" align="center" valign="middle" style="padding: 4px;"><?= AD_YES_OPTION ?></td>
              <td width="4%" align="center" valign="middle" style="padding: 4px;"><input name="sub_events" type="radio" value="0" <?php  if($obj->f('sub_events')==0){?> checked="checked"<?php }?> onclick="saveAutoEvent();"/></td>
              <td width="87%" align="center" valign="middle" style="padding: 4px;"><?= AD_NO_OPTION ?></td>
            </tr>
          </table></td>
    </tr>
    </table>
    </div>
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
	
	</script>
    <?php
	/*$obj_subEv = new event;
	$obj_subEv->allSubEventListByDt($_GET['id']);
	if($obj_subEv->num_rows()){*/
	if($obj->f('sub_events')==1){
	?>
	<div class="event_ticket" style="background:none;">
			
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2" id="div_subevent_list">
          <tr>
            <td width="22%" class="top_txt" style="text-align:left"><?= AD_EVENT ?></td>
            <td width="18%" class="top_txt" style="text-align:left"><?= AD_VENUE ?></td>
            <td width="10%" class="top_txt" style="text-align:left"><?= AD_EVENT_DATE ?></td>
            <td width="19%" class="top_txt" style="text-align:left"><?= AD_START_END_TIME ?></td>
            <td width="6%" class="top_txt" style="text-align:left"><?= AD_EDIT ?></td>
            <td width="9%" class="top_txt" style="text-align:left"><?= AD_DELETE ?></td>
          </tr>
          <?php
		  	$obj_subEv = new event;
			$obj_subEv->allSubEventListByDt($_GET['id']);
			if($obj_subEv->num_rows()){
				while($obj_subEv->next_record()){
					list($eve_date_st,$eve_time_st) = explode(" ",$obj_subEv->f('event_start_date_time'));
					list($eve_date_end,$eve_time_end) =  explode(" ",$obj_subEv->f('event_end_date_time'));
					
					
					list($ev_st_yr,$ev_st_mon,$ev_st_day) = explode("-",$eve_date_st);
		  ?>
           <tr>
            <td style="text-align:left"><?php echo stripslashes($obj_subEv->f('event_name_en'));?></td>
            <td style="text-align:left"><?php echo $obj_subEv->f('venue_name');?></td>
            <td style="text-align:left"><?php echo $ev_st_day."/".$ev_st_mon."/".$ev_st_yr;?></td>
            <td style="text-align:left"><?php echo date('g:i A',strtotime($eve_time_st))." - ".date('g:i A',strtotime($eve_time_end));?></td>
            <td style="text-align:left"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_sub_events_edit.php?sub_event_id=<?php echo $obj_subEv->f('event_id')?>&event_id=<?php echo $_GET['id'];?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></td>
            <td style="text-align:left"><a href="javascript:void(0);" onclick="deleteSubEvent('<?php echo $obj_subEv->f('event_id')?>','<?php echo $_GET['id'];?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></td>
          </tr>
          <?php
				}
			}
			else{
			?>
            <tr>
	            <td colspan="6" style="text-align:left"><?= AD_NO_RECORD ?></td>
            </tr>
			<?php
			}
          ?>
        </table>
<style>
.but{
	width:auto; height:24px;
	background:#777;
	border:0px;
	font:bold 13px/24px Arial, Helvetica, sans-serif;
	color:#FFF;
	text-decoration:none;
	cursor:pointer;
	display:block;
	margin:0;
	padding:0 15px;
	float:right;
}
.but:hover{
	color:#fff;
	background:#006684;
	text-decoration:none;
	display:block;
	cursor:pointer;
}
</style>
		<a href="<?php echo $obj_base_path->base_path(); ?>/admin/sub-events-edit/<?php echo $_GET['id'];?>" class="but" target="_blank"><?= AD_ADD_NEW_SUBEVENT ?></a>
	</div>
	<?php } ?>
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
		<span style="float: left;">
        	<p class="rad_button"><input type="radio" name="privacy" id="public_privacy" value="0" <?php if($obj->f('set_privacy') == '0') { ?> checked="checked" <?php } ?> onclick="privacy_policy(); saveAutoEvent();" /> <?= AD_PUBLIC ?></p>	
			<p class="rad_button"><input type="radio" name="privacy" id="private_privacy" value="1" <?php if($obj->f('set_privacy') == '1') { ?> checked="checked" <?php } ?> onclick="privacy_policy(); saveAutoEvent();" /> <?= AD_PRIVATE ?></p>
         </span>
		<span id="public_content"><?= AD_EVENT_PUBLIC_OPTION ?></span>
		<span id="private_content">
            <table width="100%" border="1">
              <tr>
                <td><?= AD_EVENT_PRIVATE_OPTION ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="attendees" id="attendees" value="1" <?php if($obj->f('attendees_share') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_ONE ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="invitation_only" id="invitation_only" value="1" <?php if($obj->f('attendees_invitation') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_TWO ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="password_protect_check" id="password_protect_check" value="1" <?php if($obj->f('password_protect') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"  />&nbsp; <?= AD_PRIVATE_CHECK_THREE ?> &nbsp; 
                	<input type="text" name="pass_protected" id="pass_protected" value="<?php echo $obj->f('password_protect_text');?>" onclick="saveAutoEvent();"  /></td>
              </tr>
            </table>

        	</span>
	</div>
     
	<div class="clear"></div>
	<div class="event_ticket">
	<h1><a href="javascript:media_library()"  onclick="" ><?= AD_SET_FEATURE_IMAGE_TITLE ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></a></h1>
        <div class="event_featue_text"><?= AD_SET_FEATURE_IMAGE_DESC ?></div>
        <div style="padding: 0 5px;"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $obj->f('event_photo'); ?>" alt="" /></div>
	<!--<ul style="margin-left: 10px;">
        <li><a href="#" class="here"> 
            <div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Upload Files</span></span></div><span id="mestatus1"></span>
            <div class="clear"></div>
            <span id="imgshow"><?php// if($obj->f('event_photo')){?>
           <img src="<?php //echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php// echo $obj->f('event_photo'); ?>" alt="" />
           <?php// } ?>
            
         </span>
          <input type="hidden" name="event_photo" id="event_photo" value="<?php// if($obj->f('event_photo')){ echo $obj->f('event_photo'); }?>" /></a></li>
        <li>|</li>
        <li><a href="<?php //echo $obj_base_path->base_path(); ?>/admin/gallery-list/event/<?php //echo $obj->f('event_id'); ?>"  target="_blank">Media Library</a></li>
	</ul>-->
	</div>
	<div class="clear"></div>
	<script type="text/javascript">
	function complete(){
		
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
		
		var fields = $("input[class='category_1']").serializeArray(); 
		if (fields.length == 0) 
		{ 
			alert('No Categories Selected!'); 
			// cancel submit
			return false;
		}
		
		$("#status").val('publish');
		
		var dd = document.getElementById("multi_event_day1").value;
		var mm = document.getElementById("multi_event_month1").value;
		var yy = document.getElementById("multi_event_year1").value;
		if(dd == 0 || mm == 0 || yy == 0){
			$("#complete").html('Incorrect Publish Date');
			document.getElementById("multi_event_day1").value = '0';
			document.getElementById("multi_event_month1").value = '0';
			document.getElementById("multi_event_year1").value = '0';
			return false;
		}
		else
		{
			document.getElementById("day_1").value = document.getElementById("multi_event_day1").value;
			document.getElementById("month_1").value = document.getElementById("multi_event_month1").value;
			document.getElementById("year_1").value = document.getElementById("multi_event_year1").value;
			//alert(document.getElementById("day_1").value);
			$("#complete").html('Event Published');
			return true;
        }
        
	}
	
	function showticketingsection(){
	//alert("telegraph");
		if(document.getElementById('radio_access').checked == true)
		//if($('input:radio[name=radio_access]:checked').val()==1)
		{
			$('#all_access').hide();
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
	$(document).ready(function(){
	})
	</script>
	<div class="clear"></div>
	<div class="event_ticketbg">
	<div class="event_ticket2">
    <div><h1><?= AD_TICKETING_RESERVATIONS ?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1></div>
    <div class="clear"></div>
    <div>
     <ul>
        <li><input name="radio_access" id="radio_access" type="radio" value="1" <?php if($obj->f('all_access') == '1') { ?> checked="checked" <?php } ?> onclick="showticketingsection(); saveAutoEvent();" /><strong><?= AD_TICKETING_RESERVATIONS_OP_ONE ?></strong></li>
        <li><input name="radio_access" id="radio_access" type="radio" value="0" <?php if($obj->f('all_access') == '0') { ?> checked="checked" <?php } ?> onclick="showticketingsection(); saveAutoEvent();" /><strong><?= AD_TICKETING_RESERVATIONS_OP_TWO ?></strong></li>
		<li id="all_access" style="display:none;">
		<?= AD_ALL_ACCESS_NOTICE ?>
		</li>
		
        <li class="payment_resarvation" style="margin-left:10px;display:none;"><?= AD_PRICE_INCLUDES_FEE ?>
        	<span class="ticektfee">
            	<input name="pay_ticket_fee" type="radio" value="1" <?php if($obj->f('include_payment') == '1') { ?> checked="checked" <?php } ?>  style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?> 
                <input name="pay_ticket_fee" type="radio" value="0" <?php if($obj->f('include_payment') == '0') { ?> checked="checked" <?php } ?> style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_NO_OPTION ?> 
            </span>
        </li>
        <li class="payment_resarvation" style="margin: 0 0 0 10px;display:none;"><?= AD_PRICE_INCLUDES_CHARGES ?>
        	<span class="ticketfee1" style="margin:0 34px;">
                <input name="promo_charge" type="radio" value="1" <?php if($obj->f('include_promotion') == '1') { ?> checked="checked" <?php } ?> style="margin: 5px;" onclick="saveAutoEvent();"/><?= AD_YES_OPTION ?>  
                <input name="promo_charge" type="radio" value="0" <?php if($obj->f('include_promotion') == '0') { ?> checked="checked" <?php } ?> style="margin:5px;" onclick="saveAutoEvent();"/><?= AD_NO_OPTION ?>  
            </span>
        </li>
	 </ul>
	</div>
    </div>
    
    <div id="ticket_area" style="display:none;">
       <div class="event_ticket2">
            <div><h2><?= AD_CER_TICKET ?><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" width="31" height="28" border="0"/>
                
</h2></div>
            <div class="clear"></div>
            <div id="save_create_ticket_display" class="event_ticketbox">
			<?php
			echo ' <div style=" max-height:95px; over flow:auto;">';
			 //Fetch records from temp table
			$obj_temp_tickets->get_final_tickets($_GET['id']);
			if($obj_temp_tickets->num_rows()){
				while($obj_temp_tickets->next_record()){
			?>
			<div id="save_create_ticket_display" class="event_ticketbox">
				<ul>
					<li><?php echo $obj_temp_tickets->f('ticket_name_sp');?></li>
					<li><?php echo $obj_temp_tickets->f('ticket_name_en');?></li>
					<li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_mx'),2);?> MXP </li>
					<li style="width: 90px;"><?php echo number_format($obj_temp_tickets->f('price_us'),2);?> USD </li>
					<li style="margin-right: 0;">
						<span class="tic_edit">
							<span style="cursor:pointer;" onclick="editTempTicket(<?php echo $obj_temp_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> <?= AD_EDIT ?> </span>
							<span style="cursor:pointer;" onclick="deleteTemp('<?php echo $obj_temp_tickets->f('ticket_id') ?>','<?php echo $_GET['id']?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" border="0" align="absmiddle"/> <?= AD_DELETE ?> </span>
						</span>
					</li>
				</ul>
			</div>
				
			 <?php
				}
			}
			echo '</div>';
			 ?>			
			</div>
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
            	<textarea name="description_sp" id="description_sp" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Breve descripci&oacute;n</textarea>
            </span>
        </div>
        <div style="float: right; margin: 0 auto;">	
        	<span class="show_english">EN</span><br/>
        	<span class="event_fieldbg8"><input type="text" name="ticket_name_en" id="ticket_name_en" style="width: 290px; margin: 5px 0; height: 25px;" class="event_field"   value="<?php if($msg!="" && $event_name_sp!=""){echo $event_name_sp;}else{echo "Name";}?>" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue"/>
        	</span>	<br/>
       		<span class="event_fieldbg8"><textarea name="description_en" id="description_en" class="event_field" style="width: 290px; margin: 5px 0; height: 60px;" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" >Short description</textarea>
             <script type="text/javascript">
				//document.write("<input type=text name=limit size=4 readonly value="+count_tic+">");
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
        <div class="event_date9">
        	<?= AD_NUMBER_AVAILABLE_SEATS ?> <input type="text" name="ticket_num" id="ticket_num" style="width: 64px;" /> 
        	<?= AD_FROM ?> <input type="text" name="from_ticket" id="from_ticket" value="<?php echo date("d-m-Y");?>"  /> 
            <?= AD_TO ?> <input type="text" name="to_ticket" id="to_ticket" value="<?php echo $start_day."-".$start_mon."-".$start_yr;?>"  />
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
                <input name="members_only" id="members_only2" type="radio" value="0" checked="checked"  style="margin: 5px;" /><?= AD_NO_OPTION ?> 
            </span>
        </div>
        <div class="event_date9"><?= AD_TICKET_ICON ?> - 
        	<div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><?= AD_UPLOAD_YOUR_TICKET_ICON ?></span></span></div><span id="mestatus"></span><br /><span id="imgid"></span>
        </div>
            
        <div style="float: right; width: 375px; margin: 0 auto;">
        	<input type="button" name="Submit2" value="<?= AD_SAVE_CREATE_TICKET ?>" class="event_save" onclick="save_new_popup()" style="cursor:pointer;" />
            <input type="button" name="Submit2" value="<?= AD_SAVE_EXIT ?>" class="event_save" onClick="save_new_popup()" style="cursor:pointer;"/></div>
        </div>

    </div>
    
	</div>	
	<div class="clar"></div>
    
	<div class="event_ticket" style="background: none; width: 702px; border: 0; margin: 0 auto 0 10px;">
     <div class="event_ticketl" style="visibility: hidden;">
		<h1><?= AD_PAYMENT_SETTING ?></h1>
        <div style="width: 180px; float: left; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_PAYMENTS ?> </h2>
                <li><input type="checkbox" name="Paypal" value="1" <?php if($obj->f('Paypal') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_PAYPAL_CC ?></li>
                <li><input type="checkbox" name="Bank" value="1" <?php if($obj->f('Bank_deposite') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_BANK_DEPOSITE ?></li>
                <li><input type="checkbox" name="Oxxo" value="1" <?php if($obj->f('Oxxo_Payment') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_OXXO_PAYMENT ?></li>
                <li><input type="checkbox" name="Mobile" value="1" <?php if($obj->f('Mobile_Payment') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_MOBILE_PAYMENT ?></li>
                <li><input type="checkbox" name="Offline" value="1" <?php if($obj->f('Offline_Payment') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_OFFLINE_PAYMENT ?></li>
            </ul>
        </div>
        <div style="width: 200px; float: right; margin: 0 auto;">
            <ul>
                <h2><?= AD_ALLOWED_DELIVERY ?> <!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/>--></h2>
                <li><input type="checkbox" name="paper_less_mob_ticket" value="1" <?php if($obj->f('paper_less_mob_ticket') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_PAPERLESS_MB_TICKET ?></li>
                <li><input type="checkbox" name="print" value="1" <?php if($obj->f('print') == '1') { ?> checked="checked" <?php } ?> onclick="saveAutoEvent();"/>  <?= AD_PRINT ?></li>
                <li><input type="checkbox" name="will_call" <?php if($obj->f('will_call') == '1') { ?> checked="checked" <?php } ?> value="1" onclick="saveAutoEvent();"/>  <?= AD_WILL_CALL?></li>
            </ul>
        </div>
	</div>
    <div class="event_ticket" style="background: none; width: 265px; border: 0; margin: -10px auto 0 10px;">    
      <div class="event_ticketr" style="float: right; margin-right: 24px;">
        <h1>
        	<img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deleteEvent(<?php echo $obj->f('event_id');?>);" />
                <?php if($obj->f('status') == 'publish' &&  date("Y-m-d") >= $obj->f('publish_date')) { echo '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; ?>
            	<?php } else {?>
                <input type="image" src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save" name="saveEvent" />
                <?php } ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $_GET['id'];?>" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>
        </h1>
	  	<div class="clear"></div>
		<?php if($obj->f('status') == 'publish') { ?>
		<?php if(date("Y-m-d")>=$obj->f('publish_date')) { ?>
            <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_PUBLISHED_ON ?> <?php echo date("d/m/Y",strtotime($obj->f('publish_date')));?></div>
            <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
            <div style="margin: 10px 0 2px 85px;"><input type="button" name="save" value="<?= AD_UPDATE ?>" class="update_btn" onclick="form_submit_but()" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>
        <!----For Promote------>
         <div style="margin:2px 0 2px 46px;font-weight:bold;"><?= AD_PROMOTE_YOUR_EVENT ?></div>
         <div style="margin: 10px 0 2px 85px;"><input type="button" name="promote" value="<?= AD_PROMOTE ?>" class="update_btn" onclick="promote_submit_but(<?php echo $obj->f('event_id')?>)" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>
         <!----Promote END------>
         
		<?php } else { ?>
        <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
        <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_PUBLISH_WHEN_DONE ?></div>
		<?php } ?>
		<?php } else { ?>
        <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
        <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_PUBLISH_WHEN_DONE ?></div>
		<?php } ?>
        <div class="clear"></div>
		<?php if($obj->f('status') == 'publish') { ?>
		<?php if(date("Y-m-d")< $obj->f('publish_date')) { ?>
          <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
			<input class="pub" type="submit" name="publish" value="Publish" onclick="return complete(0);"  />
			 <table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
				<tr>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_day1" id="multi_event_day1" value="<?php echo $publish_day;?>"  class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="day_1" id="day_1" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_month1" id="multi_event_month1" value="<?php echo $publish_mon;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="month_1" id="month_1" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_year1" id="multi_event_year1"  value="<?php echo $publish_yr;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="year_1" id="year_1" value="" />
				  </td>
				</tr>
				<tr>
					<td colspan="5"><div id="complete" style="color:#920125;"></div></td>
				</tr>
			</table>
        </div>
		<?php } ?>
		<?php } else { ?>
          <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
			<input class="pub" type="submit" name="publish" value="Publish" onclick="return complete(0);"  />
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
		<?php } ?>
      </div>
	</div>
	 <div class="clear"></div>
	</div>
	<div class="clear"></div>	
    </div>    
    <div class="myevent_right">
        <div class="event_ticketr" style="width: 276px; margin: 8px auto; float: none;">
            <h1>
                <img src="<?php echo $obj_base_path->base_path(); ?>/images/deleteicon.png" alt="" width="30" height="35" border="0" onclick="deleteEvent(<?php echo $obj->f('event_id');?>);" />
                <?php if($obj->f('status') == 'publish' &&  date("Y-m-d") >= $obj->f('publish_date')) { echo '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; ?>
                <?php } else {?>
                <input type="image" src="<?php echo $obj_base_path->base_path(); ?>/images/icon18.png" alt="" width="41" height="35" border="0" title="Save" name="saveEvent" />
                <?php } ?>
                <a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $_GET['id'];?>" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_btn.gif" alt="" width="100" height="33" border="0" /></a>
            </h1>
	  	<div class="clear"></div>
		<?php if($obj->f('status') == 'publish') { ?>
		<?php if(date("Y-m-d")>=$obj->f('publish_date')) { ?>
        <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_PUBLISHED_ON ?> <?php echo date("d/m/Y",strtotime($obj->f('publish_date')));?></div>
        <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
        <div style="margin: 10px 0 2px 85px;"><input type="button" name="save" value="<?= AD_UPDATE ?>" class="update_btn" onclick="form_submit_but()" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>
        
         <!----For Promote------>
         <div style="margin:2px 0 2px 46px;font-weight:bold;"><?= AD_PROMOTE_YOUR_EVENT ?></div>
         <div style="margin: 10px 0 2px 85px;"><input type="button" name="promote" value="<?= AD_PROMOTE ?>" class="update_btn" onclick="promote_submit_but(<?php echo $obj->f('event_id')?>)" /><img src="<?php echo $obj_base_path->base_path(); ?>/images/question_img.gif" alt="" width="28" height="28" border="0" align="absmiddle" style="margin: 10px 0 0 0;"/></div>
         <!----Promote END------>
         
		<?php } else { ?>
        <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
        <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_PUBLISH_WHEN_DONE ?></div>
		<?php } ?>
		<?php } else { ?>
        <div style="margin:2px 0 2px 40px; font-weight:bold;"><?= AD_SAVE_YOUR_WORK ?></div>
        <div style="margin:2px 0 2px 30px;font-weight:bold;"><?= AD_PUBLISH_WHEN_DONE ?></div>
		<?php } ?>
        <div class="clear"></div>
		<?php if($obj->f('status') == 'publish') { ?>
		<?php if(date("Y-m-d")< $obj->f('publish_date')) { ?>
        <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
			<input type="submit" name="publish" value="Publish" onclick="return complete(1);" class="pub" />		
			<table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
				<tr>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_day2" id="multi_event_day2" value="<?php echo $publish_day;?>"  class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="day_2" id="day_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_month2" id="multi_event_month2" value="<?php echo $publish_mon;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="month_2" id="month_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_year2" id="multi_event_year2"  value="<?php echo $publish_yr;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="year_2" id="year_2" value="" />
				  </td>
				</tr>
				<tr>
					<td colspan="5"><div id="complete1" style="color:#920125;"></div></td>
				</tr>
			</table>
        </div>
		<?php } ?>
		<?php } else { ?>
        <div class="selectbgpublish" style="overflow: visible; height:auto; padding:0px;">
			<input type="submit" name="publish" value="Publish" onclick="return complete(1);" class="pub" />		
			<table border="0" cellspacing="0" cellpadding="0" class="publ_class">       
				<tr>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_day2" id="multi_event_day2" value="<?php echo $today_day;?>"  class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="day_2" id="day_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_month2" id="multi_event_month2" value="<?php echo $today_mon;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="month_2" id="month_2" value="" />
				  </td>
				  <td style="text-align: center;">/</td>
				  <td style="text-align:left;">
					<input type="text" name="multi_event_year2" id="multi_event_year2"  value="<?php echo $today_yr;?>" class="textbg_grey"  style="width: 40px;"/>
					<input type="hidden" name="year_2" id="year_2" value="" />
				  </td>
				</tr>
				<tr>
					<td colspan="5"><div id="complete1" style="color:#920125;"></div></td>
				</tr>
			</table>
        </div>
		<?php } ?>
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
						//echo $obj_dup_event_master_type->f('event_master_type_id');
				?>
                <li style="padding-left: 8px;"><input type="checkbox" name="event_types[]" id="event_types<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" value="<?php echo $obj_dup_event_master_type->f('event_master_type_id');?>" class="check" onclick="saveAutoEvent();" <?php if(in_array($obj_dup_event_master_type->f('event_master_type_id'),$arrTypecat)) { echo 'checked'; }?> /> 
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
						
						if(in_array($objlist->f('category_id'),$arrMaincat)) {
					?>
					<script language="javascript">
					$(document).ready(function(){
					showSubCat(<?php echo $objlist->f('category_id');?>);
					})
					</script>
					<?php } ?>
					
                    <li style="padding-left: 8px;">
                    	<input type="checkbox" name="maincat[]" id="maincat<?php echo $objlist->f('category_id');?>" value="<?php echo $objlist->f('category_id');?>" class="category_1" onclick="showSubCat(<?php echo $objlist->f('category_id');?>); saveAutoEvent();" <?php if(in_array($objlist->f('category_id'),$arrMaincat)) { echo 'checked'; }?> />
                            <?php $categoryName = $_SESSION['langAdminSelected'] == 'en' ? 'category_name' : 'category_name_' . $_SESSION['langAdminSelected']; echo $objlist->f($categoryName); if($obj_subcat->num_rows()){?> 
                        <span id="shwsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;" onclick="showSubCat(<?php echo $objlist->f('category_id');?>)">( + )</span> 
                  		<span id="hdsubcatview<?php echo $objlist->f('category_id');?>" style="cursor:pointer;display:none;" onclick="hideSubCat(<?php echo $objlist->f('category_id');?>)">( - )</span> <?php } ?>
                  
                        <ul style="margin-left:30px;display:none;" id="sub_cat<?php echo $objlist->f('category_id');?>">
                    <?php
						if($obj_subcat->num_rows()){
							while($obj_subcat->next_record()){
					 ?>
                        
                            <li style="padding-left:8px;"><input onclick="checkCat(<?php echo $objlist->f('category_id');?>);saveAutoEvent();" type="checkbox" name="maincat[]" value="<?php echo $obj_subcat->f('category_id');?>" <?php if(in_array($obj_subcat->f('category_id'),$arrMaincat)) { echo 'checked'; }?> /><?php echo $obj_subcat->f($categoryName);?></li>
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
		<div><input type="text" name="event_tag" id="event_tag" class="textbg_add" value="<?php echo stripslashes($obj->f('event_tag'));?>" /> <input type="button" name="save" value="<?= AD_BUTTON_ADD ?>" class="btn_add" onclick="saveAutoEvent();" /></div>
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


<?php if($obj->f('event_time') == 'Daily') 
{
?>
  <script language="javascript" type="text/javascript">
  $(document).ready(function() {
	check('Daily');
	});
  </script>
<?php
}
?>
<?php if($obj->f('event_time') == 'Weekly') 
{
?>
  <script language="javascript" type="text/javascript">
  $(document).ready(function() {
	check('Weekly');
	});
  </script>
<?php
}
?>
<?php if($obj->f('event_time') == 'Monthly') 
{
?>
  <script language="javascript" type="text/javascript">
  $(document).ready(function() {
	check('Monthly');
	});
  </script>
<?php
}
?>
<?php if($obj->f('event_time') == 'Yearly') 
{
?>
  <script language="javascript" type="text/javascript">
  $(document).ready(function() {
	check('Yearly');
	});
  </script>
<?php
}
?>


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

<?php  
if($obj->f('identical_function')==1) 
{ 
	echo '<script>showmultifunction();</script>'; 
}
if($obj->f('recurring')==1) 
{ 
	echo '<script>showrecurringfunction();</script>';
}
if($obj->f('set_privacy')==1) 
{ 
	echo '<script>privacy_policy();</script>';
}
if($obj->f('all_access')==1) 
{ 
	echo '<script>showticketingsection();</script>';
}
if($obj->f('sub_events')==1) 
{ 
	/*echo '<script>subEventEdit();</script>';*/
}
?>