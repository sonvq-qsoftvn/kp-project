<?php
// home page
session_start();
include('../include/admin_inc.php');

//create object
$obj = new duplicate_event;
$obj_add = new duplicate_event;
$obj_get_cat = new duplicate_event;
$obj_get_type = new duplicate_event;
$obj_add_duplicate_category_by_event = new duplicate_event;
$obj_add_type = new duplicate_event;
$obj_get_ticket = new duplicate_event;
$obj_add_duplicate_ticket_by_event = new duplicate_event;
$obj_get_identical = new duplicate_event;
$obj_add_duplicate_identical_by_event = new duplicate_event;
$obj_chck_sb_event = new duplicate_event;
$obj_add_subev = new duplicate_event;
$obj_get_sub_cat = new duplicate_event;
$obj_add_subcat = new duplicate_event;
$obj_get_sub_type = new duplicate_event;
$obj_add_sub_type = new duplicate_event;
$obj_get_sub_ticket = new duplicate_event;
$obj_addsub_eve_tckt = new duplicate_event;



$chk = "checked='checked'";


$obj->getEventById($_GET['id']);
$obj->next_record();


$_SESSION['unique_id'] = time();
///////////////////////ADD DUPLICATE EVENT/////////////////////////////

$admin_id = $obj->f('admin_id');
$event_name_sp = addslashes($obj->f('event_name_sp'));
$event_name_en = addslashes($obj->f('event_name_en'));
$short_desc_sp = addslashes($obj->f('event_short_desc_sp'));
$short_desc_en = addslashes($obj->f('event_short_desc_en'));
$event_start_date_time = $obj->f('event_start_date_time');
$event_end_date_time = $obj->f('event_end_date_time');
$event_start_ampm = $obj->f('event_start_ampm');
$event_end_ampm = $obj->f('event_end_ampm');
$venue_state = $obj->f('event_venue_state');
$venue_county = $obj->f('event_venue_county');
$venue_city = $obj->f('event_venue_city');
$venue = $obj->f('event_venue');
$page_content_en = addslashes($obj->f('event_details_en'));
$page_content_sp = addslashes($obj->f('event_details_sp'));
$event_tag = $obj->f('event_tag');
$event_photo = $obj->f('event_photo');

$identical_function = $obj->f('identical_function');

$recurring = $obj->f('recurring');

$sub_events = $obj->f('sub_events');

$event_status = $obj->f('event_status');
$post_date = $obj->f('post_date');
$Paypal = $obj->f('Paypal');
$Bank = $obj->f('Bank_deposite');
$Oxxo = $obj->f('Oxxo_Payment');
$Mobile = $obj->f('Mobile_Payment');
$Offline = $obj->f('Offline_Payment');
$print = $obj->f('print');
$will_call = $obj->f('will_call');
$set_privacy = $obj->f('set_privacy');
$attendees_share = $obj->f('attendees_share');
$attendees_invitation = $obj->f('attendees_invitation');
$password_protect = $obj->f('password_protect');
$password_protect_text = $obj->f('password_protect_text');
$publish_date = '';
$event_time = $obj->f('event_time');
$event_time_period = $obj->f('event_time_period');
$r_month = $obj->f('r_month');
$r_month_day = $obj->f('r_month_day');
$mon = $obj->f('mon');
$tue = $obj->f('tue');
$wed = $obj->f('wed');
$thu = $obj->f('thu');
$fri = $obj->f('fri');
$sat = $obj->f('sat');
$sun = $obj->f('sun');
$r_span_start = $obj->f('r_span_start');
$r_span_end = $obj->f('r_span_end');
$event_start = $obj->f('event_start');
$event_end = $obj->f('event_end');
$all_day = $obj->f('all_day');
$event_lasts = $obj->f('event_lasts');
$include_payment = $obj->f('include_payment');
$include_promotion = $obj->f('include_promotion');
$all_access = $obj->f('all_access');
$unique_id = $_SESSION['unique_id'];
$status = 'saved';

//echo $venue; exit;
//$last_event_id = 43;

// Add General Event Table...
$last_event_id = $obj_add->addDuplicateEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_end_date_time,$event_start_ampm,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$identical_function,$recurring,$sub_events,$event_status,$post_date,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$print,$will_call,$set_privacy,$attendees_share,$attendees_invitation,$password_protect,$password_protect_text,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$include_payment,$include_promotion,$all_access,$_SESSION['unique_id'],$status,$event_photo);


// Add Category By Event...
$obj_get_cat->getCategoryByEvent($_GET['id']);
if($obj_get_cat->num_rows())
{
   while($obj_get_cat->next_record())
   {
	  $obj_add_duplicate_category_by_event->addDuplicateCategoryByEvent($last_event_id,$obj_get_cat->f('category_id'));
   }
}

// Add Event type By Event...
$obj_get_type->getTypeByEvent($_GET['id']);
	if($obj_get_type->num_rows())
	{
	   while($obj_get_type->next_record())
	   {
	      $obj_add_type->addDuplicateTypeByEvent($last_event_id,$obj_get_type->f('event_master_type_id'));
	   }
    }


// Add ticket to final ticket table...
$obj_get_ticket->getTicketByEvent($_GET['id']);
if($obj_get_ticket->num_rows())
{
   while($obj_get_ticket->next_record())
   {
		$ticket_name_en = $obj_get_ticket->f('ticket_name_en');
		$ticket_name_sp = $obj_get_ticket->f('ticket_name_sp');
		$description_en = $obj_get_ticket->f('description_en');
		$description_sp = $obj_get_ticket->f('description_sp');
		$price_mx = $obj_get_ticket->f('price_mx');
		$price_us = $obj_get_ticket->f('price_us');
		$ticket_num = $obj_get_ticket->f('ticket_num');
		$from_ticket = $obj_get_ticket->f('from_ticket');
		$to_ticket = $obj_get_ticket->f('to_ticket');
		$eairly_dis_percen = $obj_get_ticket->f('eairly_dis_percen');
		$eairly_days = $obj_get_ticket->f('eairly_days');
		$group_dis_per = $obj_get_ticket->f('group_dis_per');
		$group_dis_days = $obj_get_ticket->f('group_dis_days');
		$members_only = $obj_get_ticket->f('members_only');
		$unique_id = $obj_get_ticket->f('unique_id');
		$post_date = $obj_get_ticket->f('post_date');
	  
		$obj_add_duplicate_ticket_by_event->addDuplicateTicketByEvent($last_event_id,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$_SESSION['unique_id'],$post_date);
   }
}

// Add Multi event if exists...
$obj_get_identical->getIdenticalByEvent($_GET['id']);
if($obj_get_identical->num_rows())
{
   while($obj_get_identical->next_record())
   {
		$event_start_date_time = $obj_get_identical->f('event_start_date_time');
		$event_start_ampm = $obj_get_identical->f('event_start_ampm');
		$multi_venue_state = $obj_get_identical->f('multi_venue_state');
		$venue_county_multi = $obj_get_identical->f('venue_county_multi');
		$multi_venue_city = $obj_get_identical->f('multi_venue_city');
		$multi_venue = $obj_get_identical->f('multi_venue');
		$unique_id = $obj_get_identical->f('unique_id');
		$post_date = $obj_get_identical->f('post_date');
	  
		$obj_add_duplicate_identical_by_event->addDuplicateIdenticalByEvent($last_event_id,$event_start_date_time,$event_start_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$_SESSION['unique_id'],$post_date);
   }
}

// ================= Check For sub-events and insert records..

	// Add Sub-event event if exists...
	$obj_chck_sb_event->getsubeventByEventId($_GET['id']);
	if($obj_chck_sb_event->num_rows()){
		while($obj_chck_sb_event->next_record())
		{
			$event_name_sp = addslashes($obj_chck_sb_event->f('event_name_sp'));
			$event_name_en = addslashes($obj_chck_sb_event->f('event_name_en'));
			$short_desc_sp = addslashes($obj_chck_sb_event->f('event_short_desc_en'));
			$short_desc_en = addslashes($obj_chck_sb_event->f('event_short_desc_sp'));
			$event_start_date_time = $obj_chck_sb_event->f('event_start_date_time');
			$event_end_date_time = $obj_chck_sb_event->f('event_end_date_time');
			$event_start_ampm = $obj_chck_sb_event->f('event_start_ampm');
			$event_end_ampm = $obj_chck_sb_event->f('event_end_ampm');
			$venue_state = $obj_chck_sb_event->f('event_venue_state');
			$venue_county = $obj_chck_sb_event->f('event_venue_county');
			$venue_city = $obj_chck_sb_event->f('event_venue_city');
			$venue = $obj_chck_sb_event->f('event_venue');
			$page_content_en = addslashes($obj_chck_sb_event->f('event_details_en'));
			$page_content_sp = addslashes($obj_chck_sb_event->f('event_details_sp'));
			$event_tag = $obj_chck_sb_event->f('event_tag');
			$event_photo = $obj_chck_sb_event->f('event_photo');
			
			$identical_function = $obj_chck_sb_event->f('identical_function');
			
			$recurring = $obj_chck_sb_event->f('recurring');
			
			$sub_events = $obj_chck_sb_event->f('sub_events');
			
			$event_status = $obj_chck_sb_event->f('event_status');
			$post_date = $obj_chck_sb_event->f('post_date');
			$Paypal = $obj_chck_sb_event->f('Paypal');
			$Bank = $obj_chck_sb_event->f('Bank_deposite');
			$Oxxo = $obj_chck_sb_event->f('Oxxo_Payment');
			$Mobile = $obj_chck_sb_event->f('Mobile_Payment');
			$Offline = $obj_chck_sb_event->f('Offline_Payment');
			$print = $obj_chck_sb_event->f('print');
			$will_call = $obj_chck_sb_event->f('will_call');
			$set_privacy = $obj_chck_sb_event->f('set_privacy');
			$attendees_share = $obj_chck_sb_event->f('attendees_share');
			$attendees_invitation = $obj_chck_sb_event->f('attendees_invitation');
			$password_protect = $obj_chck_sb_event->f('password_protect');
			$password_protect_text = $obj_chck_sb_event->f('password_protect_text');
			$publish_date = '';
			$event_time = $obj_chck_sb_event->f('event_time');
			$event_time_period = $obj_chck_sb_event->f('event_time_period');
			$r_month = $obj_chck_sb_event->f('r_month');
			$r_month_day = $obj_chck_sb_event->f('r_month_day');
			$mon = $obj_chck_sb_event->f('mon');
			$tue = $obj_chck_sb_event->f('tue');
			$wed = $obj_chck_sb_event->f('wed');
			$thu = $obj_chck_sb_event->f('thu');
			$fri = $obj_chck_sb_event->f('fri');
			$sat = $obj_chck_sb_event->f('sat');
			$sun = $obj_chck_sb_event->f('sun');
			$r_span_start = $obj_chck_sb_event->f('r_span_start');
			$r_span_end = $obj_chck_sb_event->f('r_span_end');
			$event_start = $obj_chck_sb_event->f('event_start');
			$event_end = $obj_chck_sb_event->f('event_end');
			$all_day = $obj_chck_sb_event->f('all_day');
			$event_lasts = $obj_chck_sb_event->f('event_lasts');
			$include_payment = $obj_chck_sb_event->f('include_payment');
			$include_promotion = $obj_chck_sb_event->f('include_promotion');
			$all_access = $obj_chck_sb_event->f('all_access');
			$unique_id = $_SESSION['unique_id'];
			$status = $obj_chck_sb_event->f('status');
			
			$paper_less_mob_ticket = $obj_chck_sb_event->f('paper_less_mob_ticket');
			$get_sub_event_id = $obj_chck_sb_event->f('event_id');
			
			$insert_sub_event_id = $obj_add_subev->addSubEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$event_photo,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees_share,$attendees_invitation,$password_protect,$password_protect_text,$all_access,$include_payment,$include_promotion,$paper_less_mob_ticket,$print,$will_call,$status,$unique_id,$set_privacy,$last_event_id);
			
			
			// Add Category By Sub - Event...
			$obj_get_sub_cat->get_dup_sub_event_category($get_sub_event_id);
			if($obj_get_sub_cat->num_rows())
			{
			   while($obj_get_sub_cat->next_record())
			   {
				  $obj_add_subcat->addSavedSubCat($obj_get_sub_cat->f('category_id'),$insert_sub_event_id,$last_event_id);
			   }
			}
			// ================== End=============
			
			
			// Add sub-Event-type By ...
			$obj_get_sub_type->get_dup_sub_event_type($get_sub_event_id);
			if($obj_get_sub_type->num_rows())
			{
			   while($obj_get_sub_type->next_record())
			   {
				  $obj_add_sub_type->Add_auto_sub_save_eventtype($obj_get_sub_type->f('event_master_type_id'),$insert_sub_event_id,$last_event_id);
			   }
			}
			// ================== End=============
			

			// Add ticket to Sub event ticket table...
			$obj_get_sub_ticket->get_dup_sub_event_tickets($get_sub_event_id);
			if($obj_get_sub_ticket->num_rows())
			{
			   while($obj_get_sub_ticket->next_record())
			   {
					$event_id_subticket = $obj_get_sub_ticket->f('event_id');
					$ticket_name_en = $obj_get_sub_ticket->f('ticket_name_en');
					$ticket_name_sp = $obj_get_sub_ticket->f('ticket_name_sp');
					$description_en = $obj_get_sub_ticket->f('description_en');
					$description_sp = $obj_get_sub_ticket->f('description_sp');
					$price_mx = $obj_get_sub_ticket->f('price_mx');
					$price_us = $obj_get_sub_ticket->f('price_us');
					$ticket_num = $obj_get_sub_ticket->f('ticket_num');
					$from_ticket = $obj_get_sub_ticket->f('from_ticket');
					$to_ticket = $obj_get_sub_ticket->f('to_ticket');
					$eairly_dis_percen = $obj_get_sub_ticket->f('eairly_dis_percen');
					$eairly_days = $obj_get_sub_ticket->f('eairly_days');
					$group_dis_per = $obj_get_sub_ticket->f('group_dis_per');
					$group_dis_days = $obj_get_sub_ticket->f('group_dis_days');
					$members_only = $obj_get_sub_ticket->f('members_only');
					$unique_id = $obj_get_sub_ticket->f('unique_id');
					$post_date = $obj_get_sub_ticket->f('post_date');
				  
					$obj_addsub_eve_tckt->add_dup_sub_ticket($last_event_id,$insert_sub_event_id,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$_SESSION['unique_id'],$post_date);
			   }
			}
			// ================== End=============

		}
	}
		


// ================= Check For sub-events and insert records..


header("location: ".$obj_base_path->base_path()."/admin/edit-event/".$last_event_id);
exit;

?>
