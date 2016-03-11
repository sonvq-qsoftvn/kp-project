<?php 
class Event extends DB_Sql 
{

function getEventById($id)
{
	$sql = "SELECT * FROM ".$this->prefix()."general_events  WHERE event_id = '".$id."'";
	$this->query($sql);
}

function getEventTypeMster()
{
  $sql="select * from  ".$this->prefix()."master_event_types ";
  $rs=$this->query($sql);	
}

function category_list()
{
	$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = 0  ORDER BY category_name ";
	return $this->query($sql);
}

function category_sub_list($category_id)
{
	$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = ".$category_id."  ORDER BY category_id ";
	return $this->query($sql);
}

function getVenueState()
{
	$sql="SELECT * FROM ".$this->prefix()."state WHERE active_status = 1 order by state_name";
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

function get_event_id($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function get_event_by_id($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}

function fetch_event_id($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events WHERE event_id = '".$event_id."'";
	//$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE parent_id = '".$event_id."' order by event_id desc limit 0,1";
	
	return $this->query($sql);
}

function fetch_subevent_id($event_id)
{
	//$sql="SELECT * FROM ".$this->prefix()."general_events WHERE event_id = '".$event_id."'";
	$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE parent_id = '".$event_id."' order by event_id desc limit 0,1";
	
	return $this->query($sql);
}


function get_sub_event_id($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function fetch_temp_tickets($uid)
{
  $sel="select * from  ".$this->prefix()."temporary_tickets where unique_id='".$uid."'";
  $res=mysql_query($sel);
  return $row=mysql_num_rows($res);
}

function addFinalTicket($unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."final_tickets (ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id) (SELECT ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id FROM ".$this->prefix()."temporary_tickets WHERE unique_id = '".$unique_id."')";
	$this->query($sql);
	return $last_event_id=mysql_insert_id();
}

function deleteTicket($unique_id)
{
	$sql="DELETE FROM ".$this->prefix()."temporary_tickets WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function deleteFinalTicket($ticket_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_tickets WHERE ticket_id = '".$ticket_id."'";
	return $this->query($sql);
}


function addEventType($event_types,$event_id,$sub_event_id)
{
   if(count($event_types)>0)
   {
	   for($a=0;$a<count($event_types);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."type_by_sub_event SET event_id = '".$event_id."',
			                                                           sub_event_id = '".$sub_event_id."',
																       event_master_type_id = '".$event_types[$a]."'";
			$rs=$this->query($sql);	
	   }
   }
}

function addCategoryByEvent($finalArray,$event_id,$sub_event_id)
{
   if(count($finalArray)>0)
   {
	   for($a=0;$a<count($finalArray);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."category_by_sub_event SET event_id = '".$event_id."',
			                                                               sub_event_id = '".$sub_event_id."',
																	       category_id = '".$finalArray[$a]."'";
			$rs=$this->query($sql);	
	   }
   }
}

function editSavedSubEventById($ses_user_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$unique_id,$privacy,$sub_event_id)
{
	$sql="UPDATE ".$this->prefix()."general_subevents SET event_name_sp = '".$event_name_sp."',
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
														set_privacy = '".$privacy."',
														status = '".$status."'
															
													   WHERE event_id = '".$sub_event_id."'";
	$rs=$this->query($sql);	
}

function editSavedSubEvent($ses_user_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$unique_id,$privacy,$event_id)
{
	$sql="UPDATE ".$this->prefix()."general_subevents SET event_name_sp = '".$event_name_sp."',
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
														set_privacy = '".$privacy."',
														status = '".$status."'
															
													   WHERE unique_id = '".$unique_id."'";
	$rs=$this->query($sql);	
}

function addTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."subevent_final_tickets SET    ticket_name_en = '".$ticket_name_en."',
																	   ticket_name_sp = '".$ticket_name_sp."',
																	   description_en ='".$description_en."',
																	   description_sp = '".$description_sp."',
																	   price_mx = '".$price_mx."',
																	   price_us = '".$price_us."',
																	   ticket_num = '".$ticket_num."',
																	   from_ticket = '".$from_ticket."',
																	   to_ticket = '".$to_ticket."',	
																	   eairly_dis_percen = '".$eairly_dis_percen."', 
																	   eairly_days ='".$eairly_days."',
																	   group_dis_per = '".$group_dis_per."',
																	   group_dis_days = '".$group_dis_days."',
																	   ticket_icon = '".$ticket_icon."',
																	   members_only = '".$members_only."',	
																	   unique_id = '".$unique_id."',
																	   post_date = '".time()."'"; //echo $sql; exit;
	$rs=$this->query($sql);	
}

function editTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$ticket_id)
{
		$sql="update ".$this->prefix()."subevent_final_tickets SET  ticket_name_en = '".$ticket_name_en."',
															   ticket_name_sp = '".$ticket_name_sp."',
															   description_en ='".$description_en."',
															   description_sp = '".$description_sp."',
															   price_mx = '".$price_mx."',
															   price_us = '".$price_us."',
															   ticket_num = '".$ticket_num."',
															   from_ticket = '".$from_ticket."',
															   to_ticket = '".$to_ticket."',	
															   eairly_dis_percen = '".$eairly_dis_percen."', 
															   eairly_days ='".$eairly_days."',
															   group_dis_per = '".$group_dis_per."',
															   group_dis_days = '".$group_dis_days."',
															   ticket_icon = '".$ticket_icon."',
															   members_only = '".$members_only."'	
															   WHERE ticket_id='".$ticket_id."'"; //echo $sql; exit;
		$rs=$this->query($sql);
}

function fetchEventById($event_id)
{
    $sql="SELECT A.venue_name,C.city_name,S.county_name,B.* FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_events AS B, ".$this->prefix()."city AS C, ".$this->prefix()."county S  WHERE A.venue_id = B.event_venue AND C.id = A.venue_city AND S.id = A.venue_county AND B.event_id = '".$event_id."' ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC";
	$this->query($sql);
}

	
function allSubEventList($event_id)			
{
	//$sql="SELECT A.venue_name,C.city_name,S.county_name,B.* FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_subevents AS B, ".$this->prefix()."city AS C, ".$this->prefix()."county S  WHERE A.venue_id = B.event_venue AND C.id = B.event_venue_city AND S.id = B.event_venue_county AND B.parent_id = '".$event_id."' ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC"; 

	$sql = "SELECT A.venue_name,C.city_name,S.county_name,B.* FROM kcp_general_subevents AS B LEFT JOIN kcp_venue AS A ON(A.venue_id = B.event_venue) LEFT JOIN kcp_city AS C ON(C.id = B.event_venue_city) LEFT JOIN kcp_county S ON(S.id = B.event_venue_county) WHERE  B.parent_id =  '".$event_id."' ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC ";
	//echo $sql; exit;
	$this->query($sql);
}

function allSubEventListByDt($event_id)			
{
	$sql = "SELECT A.venue_name,C.city_name,S.county_name,B.* FROM kcp_general_subevents AS B LEFT JOIN kcp_venue AS A ON(A.venue_id = B.event_venue) LEFT JOIN kcp_city AS C ON(C.id = B.event_venue_city) LEFT JOIN kcp_county S ON(S.id = B.event_venue_county) WHERE  B.parent_id =  '".$event_id."' ORDER BY B.event_start_date_time,S.county_name,C.city_name,A.venue_name ASC ";
	//echo $sql; exit;
	$this->query($sql);
}

function allSubEventListCount($event_id)			
{
	$sql = "SELECT A.venue_name,C.city_name,S.county_name,B.* FROM kcp_general_subevents AS B LEFT JOIN kcp_venue AS A ON(A.venue_id = B.event_venue) LEFT JOIN kcp_city AS C ON(C.id = B.event_venue_city) LEFT JOIN kcp_county S ON(S.id = B.event_venue_county) WHERE  B.parent_id =  '".$event_id."' ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC ";

	$this->query($sql);
}

function delete_sub_event($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."general_subevents WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_type($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."type_by_sub_event WHERE sub_event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_category($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_sub_event WHERE sub_event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_ticket($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."sub_event_tickets WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}	


	function addsub_event_final_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id_subevent,$parent_event_id,$sub_event_id)
	{
		$sql="INSERT INTO ".$this->prefix()."sub_event_tickets SET 
					parent_id = '".$parent_event_id."',
					event_id = '".$sub_event_id."',
					ticket_name_en = '".$ticket_name_en."',
				    ticket_name_sp = '".$ticket_name_sp."',
				    description_en ='".$description_en."',
				    description_sp = '".$description_sp."',
				    price_mx = '".$price_mx."',
				  	price_us = '".$price_us."',
				   ticket_num = '".$ticket_num."',
				   from_ticket = '".$from_ticket."',
				   to_ticket = '".$to_ticket."',	
				   eairly_dis_percen = '".$eairly_dis_percen."', 
				   eairly_days ='".$eairly_days."',
				   group_dis_per = '".$group_dis_per."',
				   group_dis_days = '".$group_dis_days."',
				   ticket_icon = '".$ticket_icon."',
				   members_only = '".$members_only."',	
				   unique_id = '".$unique_id_subevent."',
				   post_date = '".time()."'";
		$rs=$this->query($sql);	

	}
	

function editsub_event_final_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$ticket_id)
{
		
		$sql="Update ".$this->prefix()."sub_event_tickets SET
		 	   ticket_name_en = '".$ticket_name_en."',
			   ticket_name_sp = '".$ticket_name_sp."',
			   description_en ='".$description_en."',
			   description_sp = '".$description_sp."',
			   price_mx = '".$price_mx."',
			   price_us = '".$price_us."',
			   ticket_num = '".$ticket_num."',
			   from_ticket = '".$from_ticket."',
			   to_ticket = '".$to_ticket."',	
			   eairly_dis_percen = '".$eairly_dis_percen."', 
			   eairly_days ='".$eairly_days."',
			   group_dis_per = '".$group_dis_per."',
			   group_dis_days = '".$group_dis_days."',
			   ticket_icon = '".$ticket_icon."',
			   members_only = '".$members_only."'	
			   WHERE 		
				ticket_id='".$ticket_id."' ";

		$rs=$this->query($sql);
	}

function getSubEventTicket($unique_id)
{
	 $sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets  WHERE unique_id = '".$unique_id."'";
	$this->query($sql);
}

function getSub_ticket($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets  WHERE event_id = '".$event_id."'";
	$this->query($sql);
}

function getLastSubEv($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents where parent_id = '".$event_id."' order by event_id DESC LIMIT 1";
	return $this->query($sql);
}
function sub_event_details_byId($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents where event_id = '".$event_id."' ";
	return $this->query($sql);
}


function eventTypeBYEventId($event_id)
{
    $sql="select * from  ".$this->prefix()."event_types where event_id='".$event_id."'";
    $rs=$this->query($sql);	
}
function subeventType($sub_event_id)
{
    $sql="select * from  ".$this->prefix()."type_by_sub_event where sub_event_id='".$sub_event_id."'";
    $rs=$this->query($sql);	
}

function categorylistByEvent($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	$this->query($sql);
}
function subeventcat($sub_event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_sub_event WHERE sub_event_id = '".$sub_event_id."'";
	$this->query($sql);
}

};

?>