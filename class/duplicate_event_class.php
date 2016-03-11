<?php 
class duplicate_event extends DB_Sql 
{

	function getEventById($id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."general_events  WHERE event_id = '".$id."'";
		$this->query($sql);
	}
		
	function addDuplicateEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_end_date_time,$event_start_ampm,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$identical_function,$recurring,$sub_events,$event_status,$post_date,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$print,$will_call,$set_privacy,$attendees_share,$attendees_invitation,$password_protect,$password_protect_text,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$include_payment,$include_promotion,$all_access,$unique_id,$status,$event_photo)
	{
			$sql="INSERT INTO ".$this->prefix()."general_events SET admin_id = '".$_SESSION['ses_user_id']."',
			                                                        event_name_sp = '".$event_name_sp."',
																	event_name_en = '".$event_name_en."',
																	event_short_desc_sp = '".$short_desc_sp."',
																	event_short_desc_en = '".$short_desc_en."',
																	event_start_date_time = '".$event_start_date_time."',
																	event_end_date_time = '".$event_end_date_time."',
																	event_start_ampm = '".$event_start_ampm."',
																	event_end_ampm = '".$event_end_ampm."',
																	event_venue_state = '".$venue_state."',
																	event_venue_county = '".$venue_county."',
																	event_venue_city = '".$venue_city."',
																	event_venue = '".$venue."',
																	event_details_en = '".$page_content_en."',
																	event_details_sp = '".$page_content_sp."',
																	event_tag = '".$event_tag."',
																	identical_function = '".$identical_function."',
																	recurring = '".$recurring."',
																	sub_events = '".$sub_events."',
																	event_status = '".$event_status."',
																	event_photo = '".$event_photo."',
																	post_date = '".$post_date."',
																	Paypal = '".$Paypal."',
																	Bank_deposite = '".$Bank_deposite."',
																	Oxxo_Payment = '".$Oxxo_Payment."',
																	Mobile_Payment = '".$Mobile_Payment."',
																	Offline_Payment = '".$Offline_Payment."',
																	print = '".$print."',
																	will_call = '".$will_call."',
																	set_privacy = '".$set_privacy."',
																	attendees_share = '".$attendees_share."',
																	attendees_invitation = '".$attendees_invitation."',
																	password_protect = '".$password_protect."',
																	password_protect_text = '".$password_protect_text."',
																	publish_date = '".$publish_date."',
																	event_time = '".$event_time."',
																	event_time_period = '".$event_time_period."',
																	r_month = '".$r_month."',
																	r_month_day = '".$r_month_day."',
																	mon = '".$mon."',
																	tue = '".$tue."',
																	wed = '".$wed."',
																	thu = '".$thu."',
																	fri = '".$fri."',
																	sat = '".$sat."',
																	sun = '".$sun."',
																	r_span_start = '".$r_span_start."',
																	r_span_end = '".$r_span_end."',
																	event_start = '".$event_start."',
																	event_end = '".$event_end."',
																	all_day = '".$all_day."',
																	event_lasts = '".$event_lasts."',
																	include_payment = '".$include_payment."',
																	include_promotion = '".$include_promotion."',
																	all_access = '".$all_access."',
																	unique_id = '".$unique_id."',
																	status = '".$status."'"; 

		//echo $sql; exit;
		$this->query($sql);
		return $last_event_id = mysql_insert_id();
	}
	
	function getCategoryByEvent($event_id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function addDuplicateCategoryByEvent($last_event_id,$category_id)
	{
		$sql="INSERT INTO ".$this->prefix()."category_by_event SET event_id = '".$last_event_id."',
																   category_id = '".$category_id."'";
		$this->query($sql);
	}
	
	function getTypeByEvent($event_id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."event_types WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function addDuplicateTypeByEvent($last_event_id,$type_id)
	{
		$sql="INSERT INTO ".$this->prefix()."event_types SET event_id = '".$last_event_id."',
															 event_master_type_id = '".$type_id."'";
		$this->query($sql);
	}
	
	function getTicketByEvent($event_id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function addDuplicateTicketByEvent($last_event_id,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$unique_id,$post_date)
	{
		$sql="INSERT INTO ".$this->prefix()."final_tickets SET event_id = '".$last_event_id."',
															   ticket_name_en = '".$ticket_name_en."',
															   ticket_name_sp = '".$ticket_name_sp."',
															   description_en = '".$description_en."',
															   description_sp = '".$description_sp."',
															   price_mx = '".$price_mx."',
															   price_us = '".$price_us."',
															   ticket_num = '".$ticket_num."',
															   from_ticket = '".$from_ticket."',
															   to_ticket = '".$to_ticket."',
															   eairly_dis_percen = '".$eairly_dis_percen."',
															   eairly_days = '".$eairly_days."',
															   group_dis_per = '".$group_dis_per."',
															   group_dis_days = '".$group_dis_days."',
															   members_only = '".$members_only."',
															   unique_id = '".$unique_id."',
															   post_date = '".$post_date."'";
		$this->query($sql);
	}
	
	function getIdenticalByEvent($event_id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."final_multi_event  WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function addDuplicateIdenticalByEvent($last_event_id,$event_start_date_time,$event_start_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$unique_id,$post_date)
	{
		$sql="INSERT INTO ".$this->prefix()."final_multi_event SET event_id = '".$last_event_id."',
		                                                           admin_id = '".$_SESSION['ses_user_id']."',
																   event_start_date_time = '".$event_start_date_time."',
																   event_start_ampm = '".$event_start_ampm."',
																   multi_venue_state = '".$multi_venue_state."',
																   venue_county_multi = '".$venue_county_multi."',
																   multi_venue_city = '".$multi_venue_city."',
																   multi_venue = '".$multi_venue."',
																   unique_id = '".$unique_id."',
																   post_date = '".$post_date."'";
		$this->query($sql);
	}
	
	function checkEventTicket($event_id)
	{
		$sql = 'SELECT * FROM '.$this->prefix().'general_events E Inner join '.$this->prefix().'final_tickets T on (E.event_id = T.event_id ) where  E.event_id="'.$event_id.'" and E.event_status="Y" ' ;
		$this->query($sql);
	}
	
	function getVenueState()
	{
		$sql="SELECT * FROM ".$this->prefix()."state";
		return $this->query($sql);
	}
	
	function getVenueCounty($state)
	{
		$sql="SELECT * FROM ".$this->prefix()."county WHERE state_id = '".$state."'";
		return $this->query($sql);
	}
	
	function getVenueCity($county)
	{
		$sql="SELECT * FROM ".$this->prefix()."city WHERE county_id = '".$county."'";
		return $this->query($sql);
	}
	
	function getVenueName($city)
	{
		$sql="SELECT * FROM ".$this->prefix()."venue WHERE venue_city = '".$city."'";
		return $this->query($sql);
	}
	
	function get_final_MultiEvent($event_id)
	{
	 $sql = "SELECT TM.*,C.city_name city_name_multi,S.state_name state_name_multi,V.venue_name venue_name_multi FROM ".$this->prefix()."final_multi_event TM LEFT join ".$this->prefix()."venue V ON (TM.multi_venue = V.venue_id ) LEFT join ".$this->prefix()."state S on (S.id = TM.multi_venue_state) LEFT join ".$this->prefix()."city C on (C.id = TM.multi_venue_city) WHERE TM.event_id = '".$event_id."'"; 
	 $this->query($sql);
	}
	
	function getCountyNameByState($stateId)
	{
		$sql="SELECT * FROM ".$this->prefix()."county WHERE state_id = '".$stateId."' ORDER BY id ASC";
		return $this->query($sql);
	}
	
	function getCityNameByCounty($countyId)
	{
		$sql="SELECT * FROM ".$this->prefix()."city WHERE county_id = '".$countyId."' ORDER BY id ASC";
		return $this->query($sql);
	}
	
	function getVenueNameByCity($cityId)
	{
		$sql="SELECT * FROM ".$this->prefix()."venue WHERE venue_city = '".$cityId."' ORDER BY venue_id DESC";
		return $this->query($sql);
	}
	
	function get_final_tickets($event_id)
	{
		$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function getEventTypeMster()
	{
	  $sql="select * from  ".$this->prefix()."master_event_types ";
	  $rs=$this->query($sql);	
	}
	
	function category_list()
	{
		$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = 0 AND  category_status ='Y'  ORDER BY category_name ";
		return $this->query($sql);
	}
	
	function category_sub_list($category_id)
	{
		$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = ".$category_id." AND  category_status ='Y'  ORDER BY category_id ";
		return $this->query($sql);
	}
	
	function categorylistByEvent($event_id)
	{
		$sql="SELECT * FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
		$this->query($sql);
	}
	
	function eventTypeBYEventId($event_id)
	{
	  $sql="SELECT * FROM ".$this->prefix()."event_types WHERE event_id='".$event_id."'";
	  $rs=$this->query($sql);	
	}
	
	function editSavedEventEdit($ses_user_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$privacy,$eve_id)
	{
		$sql="UPDATE ".$this->prefix()."general_events SET event_name_sp = '".$event_name_sp."',
														   event_name_en = '".$event_name_en."',
														   event_short_desc_en = '".$short_desc_en."',
														   event_short_desc_sp = '".$short_desc_sp."',
														   admin_id ='".$ses_user_id."',
														   event_start_date_time ='".$event_start_date_time."',
														   event_start_ampm = '".$event_start_ampm."',
														   event_end_date_time = '".$event_end_date_time."',
														   event_end_ampm = '".$event_end_ampm."',
														   event_venue_state = '".$venue_state."',
														   event_venue_county = '".$venue_county."',
														   event_venue_city = '".$venue_city."',
														   event_venue = '".$venue."',
														   event_details_en = '".$page_content_en."',
														   event_details_sp = '".$page_content_sp."',
														   event_tag = '".$event_tag."',
														   event_photo = '".$file_name."',
														   identical_function = '".$identical_function."',
														   recurring = '".$recurring."',
														   sub_events = '".$sub_events."',
														   Paypal = '".$Paypal."',
														   Bank_deposite = '".$Bank."',
														   Oxxo_Payment = '".$Oxxo."',
														   Mobile_Payment = '".$Mobile."',
														   Offline_Payment = '".$Offline."',
														   publish_date = '".$publish_date."',
														   event_time = '".$event_time."',
														   event_time_period = '".$event_time_period."',
														   r_month = '".$r_month."',
														   r_month_day = '".$r_month_day."',
														   mon = '".$mon."',
														   tue = '".$tue."',
														   wed = '".$wed."',
														   thu = '".$thu."',
														   fri = '".$fri."',
														   sat = '".$sat."',
														   sun = '".$sun."',
														   r_span_start = '".$r_span_start."',
														   r_span_end = '".$r_span_end."',
														   event_start = '".$event_start."',
														   event_end = '".$event_end."',
														   all_day = '".$all_day."',
														   event_lasts = '".$event_lasts."',
														   attendees_share = '".$attendees."',
														   attendees_invitation = '".$invitation_only."',
														   password_protect = '".$password_protect_check."',
														   password_protect_text = '".$pass_protected."',
														   all_access = '".$radio_access."',
														   include_promotion = '".$promo_charge."',
														   include_payment = '".$pay_ticket_fee."',
														   paper_less_mob_ticket = '".$paper_less_mob_ticket."',
														   print = '".$print."',
														   will_call = '".$will_call."',
														   status = '".$status."',
														   set_privacy = '".$privacy."'
														   WHERE event_id = '".$eve_id."'"; //echo $sql;exit;
		$rs=$this->query($sql);	
	}
	
// Sub events.................

function getsubeventByEventId($id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE parent_id = '".$id."'";
	return $this->query($sql);
}

function addSubEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$unique_id,$privacy,$event_id)
{
	//echo "hii".$event_name_en; exit;
	$sql="INSERT INTO ".$this->prefix()."general_subevents SET 
															admin_id = '".$_SESSION['ses_user_id']."',
															parent_id = '".$event_id."',
															
															event_name_sp = '".$event_name_sp."',
															event_name_en = '".$event_name_en."',
															
															event_short_desc_en = '".$short_desc_en."',
															event_short_desc_sp = '".$short_desc_sp."',
															
															event_start_date_time ='".$event_start_date_time."',
															event_start_ampm = '".$event_start_ampm."',
															event_end_date_time = '".$event_end_date_time."',
															event_end_ampm = '".$event_end_ampm."',
															event_venue_state = '".$venue_state."',
															event_venue_county = '".$venue_county."',
															event_venue_city = '".$venue_city."',
															event_venue = '".$venue."',
														    event_details_en = '".$page_content_en."',
														    event_details_sp = '".$page_content_sp."',
															event_tag = '".$event_tag."',
															event_photo = '".$file_name."',
														    identical_function = '".$identical_function."',
														    recurring = '".$recurring."',
															sub_events = '".$sub_events."',
															
															Paypal = '".$Paypal."',
															Bank_deposite = '".$Bank."',
															Oxxo_Payment = '".$Oxxo."',
															Mobile_Payment = '".$Mobile."',
															Offline_Payment = '".$Offline."',
															
															publish_date = '".$publish_date."',
															
															event_time = '".$event_time."',
															event_time_period = '".$event_time_period."',
															r_month = '".$r_month."',
															r_month_day = '".$r_month_day."',
															mon = '".$mon."',
															tue = '".$tue."',
															wed = '".$wed."',
															thu = '".$thu."',
															fri = '".$fri."',
															sat = '".$sat."',
															sun = '".$sun."',
															r_span_start = '".$r_span_start."',
															r_span_end = '".$r_span_end."',
															event_start = '".$event_start."',
															event_end = '".$event_end."',
															all_day = '".$all_day."',
															event_lasts = '".$event_lasts."',
															
															attendees_share = '".$attendees."',
															attendees_invitation = '".$invitation_only."',
															password_protect = '".$password_protect_check."',
															password_protect_text = '".$pass_protected."',
															
															all_access = '".$radio_access."',
															include_promotion = '".$promo_charge."',
															include_payment = '".$pay_ticket_fee."',
															
															paper_less_mob_ticket = '".$paper_less_mob_ticket."',
															print = '".$print."',
															will_call = '".$will_call."',
															unique_id = '".$unique_id."',
															status = '".$status."',
															
															set_privacy = '".$privacy."',
															
															post_date = '".time()."'";
	$rs=$this->query($sql);	
	return $last_event_id=mysql_insert_id();
}


function catBySubEventid($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_sub_event WHERE event_id = '".$event_id."'";
	$this->query($sql);
}
function addSavedSubCat($category_id,$sub_event_id,$event_id)
{
			$sql="INSERT INTO ".$this->prefix()."category_by_sub_event SET event_id = '".$event_id."',
																	   sub_event_id = '".$sub_event_id."',
																	   category_id = '".$category_id."'";
			$rs=$this->query($sql);	
}

function getTypeBySubEvent($event_id)
{
  $sql="select * from  ".$this->prefix()."type_by_sub_event where event_id='".$event_id."'";
  $rs=$this->query($sql);	
}

function Add_auto_sub_save_eventtype($event_master_type_id,$sub_event_id,$event_id)
{
	$sql="INSERT INTO ".$this->prefix()."type_by_sub_event SET 
										event_id = '".$event_id."',
										sub_event_id = '".$sub_event_id."',
										event_master_type_id = '".$event_master_type_id."'";
										//echo $sql;
	$rs=$this->query($sql);	
}

function getSubTicketByEvent($parent_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets WHERE parent_id = '".$parent_id."'";
	$this->query($sql);
}

function add_dup_sub_ticket($last_event_id,$event_id_subticket,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$unique_id,$post_date)
	{
		$sql="INSERT INTO ".$this->prefix()."sub_event_tickets SET 
															   parent_id = '".$last_event_id."',
															   event_id = '".$event_id_subticket."',
															   ticket_name_en = '".$ticket_name_en."',
															   ticket_name_sp = '".$ticket_name_sp."',
															   description_en = '".$description_en."',
															   description_sp = '".$description_sp."',
															   price_mx = '".$price_mx."',
															   price_us = '".$price_us."',
															   ticket_num = '".$ticket_num."',
															   from_ticket = '".$from_ticket."',
															   to_ticket = '".$to_ticket."',
															   eairly_dis_percen = '".$eairly_dis_percen."',
															   eairly_days = '".$eairly_days."',
															   group_dis_per = '".$group_dis_per."',
															   group_dis_days = '".$group_dis_days."',
															   members_only = '".$members_only."',
															   unique_id = '".$unique_id."',
															   post_date = '".$post_date."'";
		$this->query($sql);
	}


function get_dup_sub_event_category($get_sub_event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_sub_event WHERE sub_event_id = '".$get_sub_event_id."'";
	$this->query($sql);
}
	
function get_dup_sub_event_type($get_sub_event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."type_by_sub_event WHERE sub_event_id = '".$get_sub_event_id."'";
	$this->query($sql);
}
	
function get_dup_sub_event_tickets($sub_event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets WHERE event_id = '".$sub_event_id."'";
	$this->query($sql);
}



	

};

?>