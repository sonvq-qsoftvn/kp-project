<?php
session_start();

include('../include/admin_inc.php');


//print_r($_POST);exit;

$obj_add = new admin;
$obj_temp_tickets = new admin;
$obj_edit_tic = new admin;
$obj_temp_tickets1 = new admin;
$obj_temp_tickets_call = new admin;

$obj_check_saved = new admin;
$obj_edit_saved = new admin;
$obj_add_saved = new admin;
$obj_add_saved_cat = new admin;
$obj_add_saved_tickets = new admin;
$obj_edit_saved_ticket = new admin;
$obj_saved_category = new admin;
$obj_add_ticket = new admin;
$obj_edit_ticket = new admin;	
$obj_duplicate = new admin;
$obj_del_saved_cat = new admin;
$obj_eventtype = new admin;
$obj_del_eventtype = new admin;

$finalArray = $_POST['maincat'];
	
$event_name_sp = addslashes($_POST['event_name_sp']);
$event_name_en = addslashes($_POST['event_name_en']);

$short_desc_sp = addslashes($_POST['short_desc_sp']);
$short_desc_en = addslashes($_POST['short_desc_en']);


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
/*print_r($a1);
$arr = explode("/",$a1);

$a = array($arr[2],$arr[0],$arr[1]);
$r_span_start = implode("-",$a);*/

$r_span_end = $_POST['r_span_end'];
/*$arr1 = explode("/",$b1);
$b = array($arr1[2],$arr1[0],$arr1[1]);
$r_span_end = implode("-",$b);*/

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

$status = 'saved';


	// Check if the event is already save or not
	$obj_check_saved->checkSavedEvent($_SESSION['unique_id']);
	if($obj_check_saved->num_rows())
	{
	
		$obj_check_saved->next_record();
	    $link_event_id = $obj_check_saved->f('event_id');
		$obj_edit_saved->editSavedEvent($_SESSION['ses_user_id'],$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$privacy,$_SESSION['unique_id']);
		

		// Delete previous category..
		$obj_del_saved_cat->deleteSavedCategory($obj_check_saved->f('event_id'));
		
		// Update category Event
		if(count($finalArray)>0)
   		{
		   for($a=0;$a<count($finalArray);$a++)
		   {
				$checkCnt = $obj_duplicate->chkExistSavedcat($obj_check_saved->f('event_id'),$finalArray[$a]);
				if(!$checkCnt){
					$obj_saved_category->addSavedCategoryByEvent($finalArray[$a],$obj_check_saved->f('event_id'));
				}
			}
		}
		
		// Delete previous Event type..
		$obj_del_eventtype->del_event_type($obj_check_saved->f('event_id'));
		
		// Add Event type
		if(count($event_types)>0)
   		{
		   $obj_eventtype->Add_auto_save_eventtype($event_types,$obj_check_saved->f('event_id'));
		}		

		
		$fetch_temp_tickets_num=$obj_temp_tickets_call->fetch_temp_tickets($_SESSION['unique_id']);
		if(($fetch_temp_tickets_num!=0 && $_POST['ticket_buy']==1) || $_POST['ticket_buy']==0)
		{
			// Delete previous Tickets..
			$obj_del_saved_cat->deleteSavedTickets($_SESSION['unique_id']);
			// Update Event Tickets
			$obj_add_ticket->addSavedTickets($_SESSION['unique_id']);
			
			// Update event Id
			$obj_edit_ticket->editSavedTicketByEvent($_SESSION['unique_id'],$obj_check_saved->f('event_id'));
		}
		
	}
	else 
	{
		// Add Event
		$last_event_id = $obj_add_saved->addSavedEvent($_SESSION['ses_user_id'],$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$_SESSION['unique_id']);
		
		$_SESSION['event_id'] = $last_event_id;
		$link_event_id = $last_event_id;
		// Add category Event
		if(count($finalArray)>0)
   		{
		   for($a=0;$a<count($finalArray);$a++)
		   {
				$checkCnt = $obj_duplicate->chkExistSavedcat($last_event_id,$finalArray[$a]);
				if(!$checkCnt){
					$obj_saved_category->addSavedCategoryByEvent($finalArray[$a],$last_event_id);
				}
			}
		}		
		
		// Add Event type
		if(count($event_types)>0)
   		{
		   $obj_eventtype->Add_auto_save_eventtype($event_types,$last_event_id);
		}		
		
		
		$fetch_temp_tickets_num=$obj_temp_tickets_call->fetch_temp_tickets($_SESSION['unique_id']);
		if(($fetch_temp_tickets_num!=0 && $_POST['ticket_buy']==1) || $_POST['ticket_buy']==0)
		{
			// Add Event Tickets
			$obj_add_saved_tickets->addSavedTickets($_SESSION['unique_id']);
			
			// Update event Id
			$obj_edit_saved_ticket->editSavedTicketByEvent($_SESSION['unique_id'],$last_event_id);
		
			//echo "Event saved successfully";
		}
	}
	
	echo $link_event_id;
/*}
else
{
	echo "You must add tickets!!!";
}
	*/

 ?>
