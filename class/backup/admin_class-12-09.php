<?php 
  class admin extends DB_Sql 
{

		function getAdminUserDetails($user_id)
		{
			$sql = "SELECT * FROM ".$this->prefix()."admin WHERE admin_id=".$user_id;
			$this->query($sql);
			if($this->num_rows() > 0)
			{
				return 1;
			}
			return 0;
		}
		function updateAdminUserDetails($new_password,$user_id)
		{
			$sql="update ".$this->prefix()."admin set password='".$new_password."' WHERE  admin_id=".$user_id;
			$this->query($sql);
			return 1;
		}
//==================================== End ============================================
// ================================== thumb nail ==================================

function create_thumbnail($infile,$outfile,$maxw,$maxh,$stretch = FALSE) {
  clearstatcache();
  if (!is_file($infile)) {
    trigger_error("Cannot open file: $infile",E_USER_WARNING);
    return FALSE;
  }
  if (is_file($outfile)) {
      trigger_error("Output file already exists: $outfile",E_USER_WARNING);
    return FALSE;
  }
 
  $functions = array(
    'image/png' => 'ImageCreateFromPng',
    'image/jpeg' => 'ImageCreateFromJpeg',
  );
 
  // Add GIF support if GD was compiled with it
  if (function_exists('ImageCreateFromGif')) { $functions['image/gif'] = 'ImageCreateFromGif'; }
 
  $size = getimagesize($infile);
 
  // Check if mime type is listed above
  if (!$function = $functions[$size['mime']]) {
      trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
    return FALSE;
  }
 
  // Open source image
  if (!$source_img = $function($infile)) {
      trigger_error("Unable to open source file: $infile",E_USER_WARNING);
    return FALSE;
  }
 
  $save_function = "image" . strtolower(substr(strrchr($size['mime'],'/'),1));
 
  // Scale dimensions
  list($neww,$newh) = $this->scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);
 
  if ($size['mime'] == 'image/png') {
    // Check if this PNG image is indexed
    $temp_img = imagecreatefrompng($infile);
    if (imagecolorstotal($temp_img) != 0) {
      // This is an indexed PNG
      $indexed_png = TRUE;
    } else {
      $indexed_png = FALSE;
    }
    imagedestroy($temp_img);
  }
 
  // Create new image resource
  if ($size['mime'] == 'image/gif' || ($size['mime'] == 'image/png' && $indexed_png)) {
    // Create indexed 
    $new_img = imagecreate($neww,$newh);
    // Copy the palette
    imagepalettecopy($new_img,$source_img);
 
    $color_transparent = imagecolortransparent($source_img);
    if ($color_transparent >= 0) {
      // Copy transparency
      imagefill($new_img,0,0,$color_transparent);
      imagecolortransparent($new_img, $color_transparent);
    }
  } else {
    $new_img = imagecreatetruecolor($neww,$newh);
  }
 
  // Copy and resize image
  imagecopyresampled($new_img,$source_img,0,0,0,0,$neww,$newh,$size[0],$size[1]);
 
  // Save output file
  if ($save_function == 'imagejpeg') {
      // Change the JPEG quality here
      if (!$save_function($new_img,$outfile,75)) {
          trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  } else {
      if (!$save_function($new_img,$outfile)) {
          trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  }
 
  // Cleanup
  imagedestroy($source_img);
  imagedestroy($new_img);
 
  return TRUE;
}
// Scales dimensions
function scale_dimensions($w,$h,$maxw,$maxh,$stretch = FALSE) {
    if (!$maxw && $maxh) {
      // Width is unlimited, scale by width
      $newh = $maxh;
      if ($h < $maxh && !$stretch) { $newh = $h; }
      else { $newh = $maxh; }
      $neww = ($w * $newh / $h);
    } elseif (!$maxh && $maxw) {
      // Scale by height
      if ($w < $maxw && !$stretch) { $neww = $w; }
      else { $neww = $maxw; }
      $newh = ($h * $neww / $w);
    } elseif (!$maxw && !$maxh) {
      return array($w,$h);
    } else {
      if ($w / $maxw > $h / $maxh) {
        // Scale by height
        if ($w < $maxw && !$stretch) { $neww = $w; }
        else { $neww = $maxw; }
        $newh = ($h * $neww / $w);
      } elseif ($w / $maxw <= $h / $maxh) {
        // Scale by width
        if ($h < $maxh && !$stretch) { $newh = $h; }
        else { $newh = $maxh; }
        $neww = ($w * $newh / $h);
      }
    }
    return array(round($neww),round($newh));
}

// ================================== End ==================================
//=====================================  crop image ===========
function cropimage($filename,$crop_width,$crop_height){
// Original image

 
// Get dimensions of the original image
list($current_width, $current_height) = getimagesize($filename);
 
// The x and y coordinates on the original image where we
// will begin cropping the image
$left = 10;
$top = 10;
 
// This will be the final size of the image (e.g. how many pixels
// left and down we will be going)
//$crop_width = 200;
//$crop_height = 200;
 
// Resample the image
$canvas = imagecreatetruecolor($crop_width, $crop_height);
$current_image = imagecreatefromjpeg($filename);
imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
imagejpeg($canvas, $filename, 100);
}
// ================================== End ==================================



	

//====================================================== generate Password =======================================================
	function str_rand($length = 8, $seeds = 'alphanum')
		{
			// Possible seeds
			$seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
			$seedings['numeric'] = '0123456789';
			$seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
			$seedings['hexidec'] = '0123456789abcdef';
			
			// Choose seed
			if (isset($seedings[$seeds]))
			{
				$seeds = $seedings[$seeds];
			}
			
			// Seed generator
			list($usec, $sec) = explode(' ', microtime());
			$seed = (float) $sec + ((float) $usec * 100000);
			mt_srand($seed);
			
			// Generate
			$str = '';
			$seeds_count = strlen($seeds);
			
			for ($i = 0; $length > $i; $i++)
			{
				$str .= $seeds{mt_rand(0, $seeds_count - 1)};
			}
			
			return $str;
		}
	//====================================================== end =======================================================
	//====================================================== admin setting =======================================================
	function admin_setting(){
	
			$sql = "SELECT * FROM ".$this->prefix()."setting WHERE id=1" ;
			$this->query($sql);
			
	}
	//====================================================== end =======================================================
	
	//====================================================== admin setting =======================================================
	function getAdminByemail_pass($email,$recover_pass)
		{
			$sql = "select * from ".$this->prefix()."admin WHERE email='".$email."' AND recover_pass='".$recover_pass."'";
			$this->query($sql);
			
		}
	function update_admin_pass($recover_pass,$password)
		{
			//$recover_pass=$this->str_rand();
			$sql="UPDATE ".$this->prefix()."admin SET password='".md5($password)."'
			WHERE recover_pass='".$recover_pass."'";
			$rs=$this->query($sql);
						
		}		
	//====================================================== end =======================================================
	
	



//==================================== End ============================================
// =========================== mail ================================	
	/*function send_mail($from,$to,$subject,$body,$name=''){
		$sql="SELECT * FROM ".$this->prefix()."setting WHERE id=1 ";
		$this->query($sql);
		$this->next_record();
		
		if($this->f('smtp_active')==1){
			require_once "Mail.php";
			
			$from1 = $name." <".$from.">";			
			$host = $this->f('smtp_host');
			$port = $this->f('smtp_port');
			$username = $this->f('smtp_username');
			$password = $this->f('smtp_password');
	 
			$headers = array("MIME-Version"=> '1.0', 
			"Content-type" => "text/html; charset=iso-8859-1",
			"From" => $from,
			"To" => $to, 
			"Subject" => $subject);			
			
			$smtp = Mail::factory('smtp',
			array ('host' => $host,
			'port' => $port,
			'auth' => true,
			'username' => $username,
			'password' => $password));			 
			$mail = $smtp->send($to, $headers, $body);
			
		}
		else{
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$name.' <'.$from.'>' . "\r\n";
			// Mail it
			mail($to, $subject, $body, $headers);
		}
	
	}
	
	*/
	
	function send_mail($from,$to,$subject,$body,$name='',$attachment=false,$filename=false,$reply_to=false){
		$sql="SELECT * FROM ".$this->prefix()."setting WHERE id=1 ";
		$this->query($sql);
		$this->next_record();
		
		if($this->f('smtp_active')==1){
			require_once "Mail.php";
			
			$from1 = $name." <".$from.">";			
			$host = $this->f('smtp_host');
			$port = $this->f('smtp_port');
			$username = $this->f('smtp_username');
			$password = $this->f('smtp_password');
	 
			$headers = array("MIME-Version"=> '1.0', 
			"Content-type" => "text/html; charset=iso-8859-1",
			"From" => $from,
			"To" => $to, 
			"Subject" => $subject);			
			
			$smtp = Mail::factory('smtp',
			array ('host' => $host,
			'port' => $port,
			'auth' => true,
			'username' => $username,
			'password' => $password));			 
			$mail = $smtp->send($to, $headers, $body);
			
		}
		else{
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$name.' <'.$from.'>' . "\r\n";
			if($reply_to){
				$headers .= 'Reply-To: Ticket Hype <'.$reply_to.'>' . "\r\n";
			}
			// Mail it
			if($attachment){
				
				$separator = md5(time());
				// carriage return type (we use a PHP end of line constant)
				$eol = PHP_EOL;
				// main header (multipart mandatory)
				$headers = "From: ".$name." <".$from.">".$eol;
				$headers .= "MIME-Version: 1.0".$eol;
				$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
				$headers .= "Content-Transfer-Encoding: 7bit".$eol;
				
				 
				// message
				$headers .= "--".$separator.$eol;
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
				$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
				$headers .= $body.$eol.$eol;
				 
				// attachment
				$headers .= "--".$separator.$eol;
				$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
				$headers .= "Content-Transfer-Encoding: base64".$eol;
				$headers .= "Content-Disposition: attachment".$eol.$eol;
				$headers .= $attachment.$eol.$eol;
				$headers .= "--".$separator."--";
				
			}
			if(mail($to, $subject, $body, $headers)){
			//if(mail('unified.ujjal@gmail.com', $subject, $body, $headers)){
				return true;
			}else{
				
			return false;	
			}
		}
	
	}

	// =========================== end ================================	
		
// ========================================================End=============================================





	function api_show()
	{
		$sql = "select * from ".$this->prefix()."setting " ;
		$this->query($sql);
	}

//========================= Admin login===================================
function check_admin_user($user_name,$pasword)
{
		//echo $this->prefix(); exit;
		$sql = "SELECT * FROM ".$this->prefix()."admin a WHERE (a.email = '".$user_name."' OR a.phone = '".$user_name."') AND a.password = '".md5($pasword)."' AND a.`activate_status` = 1 AND a.`account_type`!= 0 ";
		//echo $sql;exit;
		$this->query($sql);
		 if($this->num_rows()>0)
			{
			   return 1;
			}
			   return 0;
}
//============= Admin change password =========== 


function event_category_list($flag=false){
	if($flag!="")
	{
		$sql="SELECT * FROM ".$this->prefix()."event_category  ORDER BY category_id LIMIT 0,5";
	}
	else
	{
		$sql="SELECT * FROM ".$this->prefix()."event_category  ORDER BY category_name LIMIT 0,5";
	}
	//echo $sql;
	return $this->query($sql);
}
function getVenueById($venue_id,$organization_id){

	$sql = "SELECT * from ".$this->prefix()."venue WHERE venue_id='".$venue_id."' AND organization_id=".$organization_id;
	$this->query($sql);
}



//==================================== Dashboard ============================================
function event_list_upcoming($organization_id,$limit)
{
	$sql="SELECT * FROM ".$this->prefix()."events WHERE organization_id='".$organization_id."' AND now() < event_date   $limit";
	$this->query($sql);
}		
function event_list_upcoming_num($organization_id)
{
	$sql="SELECT * FROM ".$this->prefix()."events  WHERE organization_id='".$organization_id."' AND now() < event_date  ORDER BY event_id ";
	$this->query($sql);
}		
function total_sale_on_day($organization_id,$date)
{			
	$sql="SELECT * FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  WHERE b.organization_id='".$organization_id."' AND a.date LIKE '".$date."%' ";
	$this->query($sql);
}
function total_sale_Ticket_on_day($organization_id,$date)
{			
	$sql="SELECT * FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  INNER JOIN ".$this->prefix()."order_detail c ON c.order_id=a.order_id  WHERE b.organization_id='".$organization_id."' AND a.date LIKE '".$date."%' ";
	$this->query($sql);
}			
			
//==================================== End ============================================

function getAdminById($admin_id)
{
	$sql = "select * from ".$this->prefix()."admin WHERE admin_id=".$admin_id;
	$this->query($sql);
	
}

function event_total_sold_ticket($event_id)
{
	$sql="SELECT SUM(ticket_sold) as total_sold_event FROM ".$this->prefix()."price_level WHERE event_id='".$event_id."' GROUP BY event_id  ";
	$this->query($sql);
}	

function adminBillingDetails($admin_id){
	$sql = "SELECT * FROM ".$this->prefix()."admin_card_billing WHERE admin_id='".$admin_id."'" ;
	$this->query($sql);			
}
	

//=============  event =========== 

	//step 1
	function add_event($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$icon_image,$admin_id,$organization_id,$send_newsletter)
	{
		$sql="INSERT INTO ".$this->prefix()."events set event_name='".$event_name."',event_date='".$event_date."',venue='".$venue."',description='".$description."',on_sale_date='".$on_sale_date."',sale_close_date='".$sale_close_date."',category_id='".$category_id."',age='".$age."',event_web_site='".$event_web_site."',event_image='".$event_image."' ,icon_image='".$icon_image."' ,admin_id='".$admin_id."',organization_id='".$organization_id."',send_newsletter='".$send_newsletter."' ";
		$rs=$this->query($sql);
		return mysql_insert_id();
	}
	
	//event step
	function event_step_no($event_id,$event_step){
		$sql="SELECT * FROM ".$this->prefix()."events  WHERE event_id='".$event_id."'  ";
		$this->query($sql);
		$this->next_record();
		if($event_step > $this->f('event_step')){
			$sql="UPDATE ".$this->prefix()."events SET event_step='".$event_step."' WHERE event_id='".$event_id."'   ";
			$rs=$this->query($sql);
		}
	}

	function edit_event_step_1($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$icon_image,$event_id,$send_newsletter)
{
	$sql="UPDATE ".$this->prefix()."events set event_name='".$event_name."',event_date='".$event_date."',venue='".$venue."',description='".$description."',on_sale_date='".$on_sale_date."',sale_close_date='".$sale_close_date."',category_id='".$category_id."',age='".$age."',event_web_site='".$event_web_site."',event_image='".$event_image."',icon_image='".$icon_image."',send_newsletter='".$send_newsletter."'
	WHERE event_id='".$event_id."'
	  ";
	
	$rs=$this->query($sql);
	return mysql_insert_id();
}

//=============  event Category =========== 

function category_list(){
	
		$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = 0 AND  category_status ='Y'  ORDER BY category_name ";
		return $this->query($sql);
	}
function category_sub_list($category_id){
	
		$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = ".$category_id." AND  category_status ='Y'  ORDER BY category_id ";
		//echo $sql;
		return $this->query($sql);
	}
	
	
	
	
	
	function addTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$add_event_id)
	{
		$sql="INSERT INTO ".$this->prefix()."final_tickets SET 
					event_id = '".$add_event_id."',
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
				   unique_id = '".$unique_id."',
				   post_date = '".time()."'";
		$rs=$this->query($sql);	

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


function fetch_temp_tickets($uid)
{
  $sel="select * from  ".$this->prefix()."temporary_tickets where unique_id='".$uid."'";
  $res=mysql_query($sel);
  return $row=mysql_num_rows($res);
}
function addEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status)
{
	//echo "hii".$event_name_en; exit;
	$sql="INSERT INTO ".$this->prefix()."general_events SET 
															admin_id = '".$_SESSION['ses_user_id']."',
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
															
															post_date = '".time()."'";
	$rs=$this->query($sql);	
	return $last_event_id=mysql_insert_id();
}

function addCategoryByEvent($finalArray,$last_event_id)
{
   if(count($finalArray)>0)
   {
	   for($a=0;$a<count($finalArray);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."category_by_event SET event_id = '".$last_event_id."',
																	   category_id = '".$finalArray[$a]."'";
			$rs=$this->query($sql);	
	   }
   }
}

function addFinalTicket($unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."final_tickets (ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id) (SELECT ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id FROM ".$this->prefix()."temporary_tickets WHERE unique_id = '".$unique_id."')";
	//echo $sql;
	$this->query($sql);
	return $last_event_id=mysql_insert_id();
}


function addFinalTicket2($event_id,$ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."final_tickets SET ticket_name_en = '".$ticket_name_en."',
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
														   event_id = '".$event_id."',
														   post_date = '".time()."'";
	return $this->query($sql);
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

function deleteEvent($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."general_events WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}
function deleteCategoryByEvent($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}
function deleteTicketByEvent($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_tickets WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}

function fetchEventId($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events WHERE unique_id = '".$unique_id."'";
	$this->query($sql);
}

function changeEventStatus($id,$status)
{
	if($status == 'Y')
	{
	  $new_status = 'N';
	}
	else
	{
	  $new_status = 'Y';
	}

	$sql = "UPDATE ".$this->prefix()."general_events SET event_status='".$new_status."' WHERE event_id = '".$id."'";
	return $this->query($sql);
}

function allEventList($limit,$venue_state = false,$venue_county = false,$venue_city = false,$venue = false,$show_pastevent = false)			
{
	$whereClause = '';
	if($venue_state)
		$whereClause = " AND event_venue_state = '".$venue_state."'";	
	
	if($venue_county)
		$whereClause .= " AND event_venue_county = '".$venue_county."'";	
	
	if($venue_city)
		$whereClause .= " AND  event_venue_city = '".$venue_city."'";	
	
	if($venue)
		$whereClause .= " AND  event_venue = '".$venue."'";	
		
	if($show_pastevent==0)	
		$whereClause .= " AND  event_start_date_time >= now() ";	
		
	if($_SESSION['ses_user_id']!=1)
		$whereClause .= " AND  B.admin_id = '".$_SESSION['ses_user_id']."'";	
	
	$sql="SELECT A.venue_name,C.city_name,S.county_name,B.* FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_events AS B, ".$this->prefix()."city AS C, ".$this->prefix()."county S  WHERE A.venue_id = B.event_venue AND C.id = B.event_venue_city AND S.id = B.event_venue_county $whereClause ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC $limit";
	
	//$sql = "SELECT A.venue_name,C.city_name,S.county_name,B.* FROM kcp_general_events AS B  LEFT JOIN kcp_venue AS A ON(A.venue_id = B.event_venue) LEFT JOIN kcp_city AS C  ON(C.id = B.event_venue_city) LEFT JOIN kcp_county S ON(S.id = B.event_venue_county) WHERE 1 = 1 $whereClause ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC $limit";
	
	//echo $sql; 
	$this->query($sql);
}

function allEventListCount($venue_state = false,$venue_county = false,$venue_city = false,$venue = false,$show_pastevent = false)			
{
	$whereClause = '';
	if($venue_state)
		$whereClause = " AND event_venue_state = '".$venue_state."'";	
	
	if($venue_county)
		$whereClause .= " AND event_venue_county = '".$venue_county."'";	
	
	if($venue_city)
		$whereClause .= " AND  event_venue_city = '".$venue_city."'";	
	
	if($venue)
		$whereClause .= " AND  event_venue = '".$venue."'";	

	if($show_pastevent==0)	
		$whereClause .= " AND  event_start_date_time >= now() ";	

	if($_SESSION['ses_user_id']!=1)
		$whereClause .= " AND  B.admin_id = '".$_SESSION['ses_user_id']."'";	
	
	//$sql="SELECT A.venue_name,C.city_name,S.county_name,B.* FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_events AS B, ".$this->prefix()."city AS C, ".$this->prefix()."county S  WHERE A.venue_id = B.event_venue AND C.id = B.event_venue_city AND S.id = B.event_venue_county $whereClause ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC ";
	$sql="SELECT A.venue_name,C.city_name,S.county_name,B.* FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_events AS B, ".$this->prefix()."city AS C, ".$this->prefix()."county S  WHERE A.venue_id = B.event_venue AND C.id = B.event_venue_city AND S.id = B.event_venue_county $whereClause ORDER BY S.county_name,C.city_name,A.venue_name,B.event_start_date_time ASC ";

	$this->query($sql);
}	

function getEventById($id)
{
	$sql = "SELECT * FROM ".$this->prefix()."general_events  WHERE event_id = '".$id."'";
	$this->query($sql);
}
function eventVenue($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."venue AS A, ".$this->prefix()."general_events AS B WHERE A.venue_id = B.event_venue  AND B.event_id = ".$event_id;
	//echo $sql;;
	$this->query($sql);
}
function getCityByEventId($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."general_events AS A, ".$this->prefix()."city AS B WHERE A.event_venue_city = B.id AND A.event_id = '".$event_id."'";
	$this->query($sql);
}


function editEvent($event_name_sp,$event_name_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$event_id)
{
	$sql="UPDATE ".$this->prefix()."general_events SET event_name_sp = '".$event_name_sp."',
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
													   sub_events = '".$sub_events."'
													   
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

													   WHERE event_id = '".$event_id."'";
	$rs=$this->query($sql);	
	return $last_event_id=mysql_insert_id();
}

function catBySubEvent($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_sub_event WHERE sub_event_id = '".$event_id."'";
	$this->query($sql);
}

function categorylistByEvent($event_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	$this->query($sql);
}

/*function deleteCategoryByEvent($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}
*/
function most_used_category()
{
	$sql="SELECT count(*) as no_of_duplicate,category_id FROM `kcp_category_by_event` GROUP BY `category_id` HAVING no_of_duplicate>1 ORDER BY no_of_duplicate DESC";
	return $this->query($sql);
}
//function category_sub_list($category_id){
//	
//		$sql="SELECT * FROM ".$this->prefix()."event_category Where parent_category = ".$category_id." AND  category_status ='Y'  ORDER BY category_id ";
//		//echo $sql;
//		return $this->query($sql);
//	}





function allTicketList($event_id,$limit)			
{
	$sql="SELECT * FROM ".$this->prefix()."final_tickets WHERE event_id = '".$event_id."' ORDER BY ticket_id ASC $limit";
	$this->query($sql);
}

function allTicketListCount($event_id)			
{
	 $sql="SELECT * FROM ".$this->prefix()."final_tickets WHERE event_id = '".$event_id."'";
	$this->query($sql);
}	

function getTicketById($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = ".$event_id;
	$this->query($sql);
}

// Get temp tickets

function get_temp_tickets($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = '".$event_id."'";
	$this->query($sql);
}
function get_final_tickets($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = '".$event_id."'";
	$this->query($sql);
}
function getTempTicketById_final($ticket_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE ticket_id = '".$ticket_id."'";
	$this->query($sql);
}
function getTempTicketById($ticket_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE ticket_id = '".$ticket_id."'";
	$this->query($sql);
}

function delete_temp_ticket($ticket_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_tickets  WHERE ticket_id = '".$ticket_id."' "; 
	$this->query($sql);
}

function delete_final_ticket($ticket_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_tickets  WHERE ticket_id = '".$ticket_id."' "; 
	$this->query($sql);
}

function getEventId($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events  WHERE unique_id = '".$unique_id."' "; 
	$this->query($sql);
}

function editTempTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$ticket_id)
{
		
		$sql="Update ".$this->prefix()."final_tickets SET
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

function editFinalTicket($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$from_ticket,$to_ticket,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$ticket_icon,$members_only,$unique_id,$ticket_id)
{
		
		$sql="Update ".$this->prefix()."final_tickets SET
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
	

function ticket_info($ticket_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets WHERE ticket_id = '".$ticket_id."'";
	$this->query($sql);
}

function ticketById($ticket_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets WHERE ticket_id = '".$ticket_id."'";
	$this->query($sql);
}

function edit_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$from_ticket,$to_ticket,$photoname,$exit_ticket_id)
{
	$sql="Update ".$this->prefix()."final_tickets SET
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
			   ticket_icon = '".$photoname."',
			   members_only = '".$members_only."'	
			   WHERE 		
				ticket_id='".$exit_ticket_id."' ";

		$rs=$this->query($sql);
}

function add_tickets($ticket_name_en,$ticket_name_sp,$description_en,$description_sp,$price_mx,$price_us,$ticket_num,$eairly_dis_percen,$eairly_days,$group_dis_per,$group_dis_days,$members_only,$from_ticket,$to_ticket,$photoname,$event_id)
{
	$sql="INSERT INTO ".$this->prefix()."final_tickets SET
		 	   event_id = '".$event_id."',
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
			   ticket_icon = '".$photoname."',
			   members_only = '".$members_only."',
			   post_date = '".time()."'";

		$rs=$this->query($sql);
}

function venue_details_eventId($event_id){

	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'general_events E Inner join '.$this->prefix().'venue V ON (E.event_venue = V.venue_id ) Inner join '.$this->prefix().'state S on (S.id = E.event_venue_state)  Inner join '.$this->prefix().'city C on (C.id = E.event_venue_city) WHERE E.event_id="'.$event_id.'" AND E.event_status="Y" ';
	return $this->query($sql);	
}
function checkEventTicket($event_id)
{
	$sql = 'SELECT * FROM '.$this->prefix().'general_events E Inner join '.$this->prefix().'final_tickets T on (E.event_id = T.event_id ) where  E.event_id="'.$event_id.'" and E. 	event_status="Y" ' ;
	$this->query($sql);
}


// ============================== Saved Event =============================================
function addSavedEvent($ses_user_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."general_events 
			SET event_name_sp = '".$event_name_sp."',
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
			unique_id = '".$unique_id."',
			
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

			post_date = '".time()."'"; 
	$rs=$this->query($sql);	
	return mysql_insert_id();
}


function addSavedCategoryByEvent($category_id,$last_event_id)
{
			$sql="INSERT INTO ".$this->prefix()."category_by_event SET event_id = '".$last_event_id."',
																	   category_id = '".$category_id."'";
			$rs=$this->query($sql);	
}

function chkExistSavedcat($last_event_id,$category_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_event WHERE category_id = '".$category_id."' AND event_id = '".$last_event_id."' ";
	//echo $sql;
	$query = $this->query($sql);
	return mysql_num_rows($query);
}

function deleteSavedTickets($unique_id)
{
	$sql="DELETE FROM ".$this->prefix()."saved_tickets WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function addSavedTickets($unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."saved_tickets (ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id) (SELECT ticket_name_en, ticket_name_sp,description_en,description_sp,price_mx,price_us,ticket_num,from_ticket,to_ticket,eairly_dis_percen,eairly_days,group_dis_per,group_dis_days,ticket_icon,members_only,post_date,unique_id FROM ".$this->prefix()."temporary_tickets WHERE unique_id = '".$unique_id."')";
	//echo $sql;
	return $this->query($sql);
}

function editSavedTicketByEvent($unique_id,$last_event_id)
{
	$sql="UPDATE ".$this->prefix()."saved_tickets SET event_id = '".$last_event_id."' WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function deleteSavedCategory($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	return $this->query($sql);
}


function editSavedEvent($ses_user_id,$event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$status,$privacy,$unique_id)
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
															
													   WHERE unique_id = '".$_SESSION['unique_id']."'"; 
	$rs=$this->query($sql);	
}

function checkSavedEvent($uid)
{
  $sql="select * from  ".$this->prefix()."general_events where unique_id='".$uid."'";
  //echo $sql;
  $rs=$this->query($sql);	
}

//function checkSavedEventEdit($uid)
//{
//  $sql="select * from  ".$this->prefix()."general_events where unique_id='".$uid."'";
//  //echo $sql;
//  $rs=$this->query($sql);	
//}

function checkSavedEventIdentical($uid)
{
  $sql="select * from  ".$this->prefix()."temporary_multi_events where unique_id='".$uid."'";
  //echo $sql;
  $rs=$this->query($sql);	
}

function checkSavedSubEvent($uid)
{
  $sql="select * from  ".$this->prefix()."general_subevents where unique_id='".$uid."'";
  //echo $sql;
  $rs=$this->query($sql);	
}


// ========================== Multiple Events ===============================

	function addTempMultiEvent($event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$unique_id,$event_id)
	{
		$sql="INSERT INTO ".$this->prefix()."final_multi_event SET admin_id = '".$_SESSION['ses_user_id']."',
																   event_id = '".$event_id."',
																   event_start_date_time = '".$event_start_date_time."',
																   event_start_ampm ='".$event_start_ampm."',
																   event_end_date_time = '".$event_end_date_time."',
																   event_end_ampm ='".$event_end_ampm."',
																   multi_venue_state = '".$multi_venue_state."',
																   venue_county_multi = '".$venue_county_multi."',
																   multi_venue_city = '".$multi_venue_city."',
																   multi_venue = '".$multi_venue."',
																   unique_id = '".$unique_id."',
																   post_date = '".time()."'";
				   
		$rs=$this->query($sql);	
	}
	
	function SavedaddTempMultiEvent($event_start_date_time,$event_start_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$unique_id,$status)
	{
		//echo $unique_id; exit;
		$sql="INSERT INTO ".$this->prefix()."temporary_multi_events 
				SET admin_id = '".$_SESSION['ses_user_id']."',
				   event_start_date_time = '".$event_start_date_time."',
				   event_start_ampm ='".$event_start_ampm."',
				   multi_venue_state = '".$multi_venue_state."',
				   venue_county_multi = '".$venue_county_multi."',
				   multi_venue_city = '".$multi_venue_city."',
				   multi_venue = '".$multi_venue."',
				   unique_id = '".$unique_id."',
				   status = '".$status."',
				   post_date = '".time()."'";
				   
		$rs=$this->query($sql);	
	}
	
	function SavededitTempMultiEvent($event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$unique_id,$multi_event_id,$status)
	{
		$sql="UPDATE ".$this->prefix()."temporary_multi_events SET event_start_date_time = '".$event_start_date_time."',
																   event_start_ampm ='".$event_start_ampm."',
																   multi_venue_state = '".$multi_venue_state."',
																   venue_county_multi = '".$venue_county_multi."',
																   multi_venue_city = '".$multi_venue_city."',
																   status = '".$status."',
																   multi_venue = '".$multi_venue."'
																   WHERE unique_id = '".$unique_id."'";
		$rs=$this->query($sql);	
	}
	
	function addMultipleEvent($unique_id,$last_event_id)
	{
		
		$qry=mysql_query("select * from  ".$this->prefix()."temporary_multi_events where unique_id='".$unique_id."'");
		while($row = mysql_fetch_array($qry)){
		
		$sql="INSERT INTO ".$this->prefix()."final_multi_event 
				   SET admin_id = '".$_SESSION['ses_user_id']."',
				   event_id = '".$last_event_id."',
				   event_start_date_time = '".$row['event_start_date_time']."',
				   event_start_ampm ='".$row['event_start_ampm']."',
				   multi_venue_state = '".$row['multi_venue_state']."',
				   venue_county_multi = '".$row['venue_county_multi']."',
				   multi_venue_city = '".$row['multi_venue_city']."',
				   multi_venue = '".$row['multi_venue']."',
				   unique_id = '".$unique_id."',
				   post_date = '".time()."'";
				   
		$rs=$this->query($sql);	
		}
	}
	
function editTempMultiEvent($event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$multi_venue_state,$venue_county_multi,$multi_venue_city,$multi_venue,$unique_id,$multi_event_id)
{
	$sql="UPDATE ".$this->prefix()."final_multi_event SET  event_start_date_time = '".$event_start_date_time."',
														   event_start_ampm ='".$event_start_ampm."',
														   event_end_date_time = '".$event_end_date_time."',
														   event_end_ampm ='".$event_end_ampm."',
														   multi_venue_state = '".$multi_venue_state."',
														   venue_county_multi = '".$venue_county_multi."',
														   multi_venue_city = '".$multi_venue_city."',
														   multi_venue = '".$multi_venue."'
														   WHERE multi_id = '".$multi_event_id."'";
	$rs=$this->query($sql);	
}

function deleteTempMultiEvent($temp_multi_event_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_multi_event WHERE multi_id = '".$temp_multi_event_id."'";
	return $this->query($sql);
}

function get_temp_MultiEvent($event_id)
{
	$sql = "SELECT TM.*,C.city_name city_name_multi,S.state_name state_name_multi,V.venue_name venue_name_multi FROM ".$this->prefix()."final_multi_event TM LEFT join ".$this->prefix()."venue V ON (TM.multi_venue = V.venue_id ) LEFT join ".$this->prefix()."state S on (S.id = TM.multi_venue_state) LEFT join ".$this->prefix()."city C on (C.id = TM.multi_venue_city) WHERE TM.event_id = '".$event_id."'"; //echo $sql; exit;
	$this->query($sql);
}

function getTempMultiEvents($temp_multi_event_id)
{
  $sql="select * from  ".$this->prefix()."final_multi_event where multi_id='".$temp_multi_event_id."'";
  //echo $sql;
  $rs=$this->query($sql);	
}
function AddTempMultiEvnt($event_id)
{
		$qry=mysql_query("select * from  ".$this->prefix()."final_multi_event where event_id='".$event_id."'");
		while($row = mysql_fetch_array($qry)){
		
		$sql="INSERT INTO ".$this->prefix()."temporary_multi_events 
				   SET admin_id = '".$_SESSION['ses_user_id']."',
				   event_start_date_time = '".$row['event_start_date_time']."',
				   event_start_ampm ='".$row['event_start_ampm']."',
				   multi_venue_state = '".$row['multi_venue_state']."',
				   venue_county_multi = '".$row['venue_county_multi']."',
				   multi_venue_city = '".$row['multi_venue_city']."',
				   multi_venue = '".$row['multi_venue']."',
				   unique_id = '".$_SESSION['unique_id']."',
				   post_date = '".time()."'";
				   
		$rs=$this->query($sql);	
		}}

// ========================== Multiple Events ===============================



// ========================== Duplicate Events ===============================

function getDuplEventDtls($event_id)
{
	$sql = "SELECT GE.*,C.*,S.*,V.* FROM ".$this->prefix()."general_events GE LEFT join ".$this->prefix()."venue V ON (GE.event_venue = V.venue_id) LEFT join ".$this->prefix()."state S on (S.id = GE.event_venue_state) LEFT join ".$this->prefix()."city C on (C.id = GE.event_venue_city) LEFT join ".$this->prefix()."county Co on (Co.id = GE.event_venue_county) WHERE GE.event_id = '".$event_id."'";
	$this->query($sql);
}

function AddTempTickets($event_id)
{
	
	$qry=mysql_query("select * from  ".$this->prefix()."final_tickets where event_id='".$event_id."'");
	while($row = mysql_fetch_array($qry)){
	
	$sql="INSERT INTO ".$this->prefix()."temporary_tickets 
			  		   SET ticket_name_en = '".$row['ticket_name_en']."',
					   ticket_name_sp = '".$row['ticket_name_sp']."',
					   description_en ='".$row['description_en']."',
					   description_sp = '".$row['description_sp']."',
					   price_mx = '".$row['price_mx']."',
					   price_us = '".$row['price_us']."',
					   ticket_num = '".$row['ticket_num']."',
					   from_ticket = '".$row['from_ticket']."',
					   to_ticket = '".$row['to_ticket']."',	
					   eairly_dis_percen = '".$row['eairly_dis_percen']."', 
					   eairly_days ='".$row['eairly_days']."',
					   group_dis_per = '".$row['group_dis_per']."',
					   group_dis_days = '".$row['group_dis_days']."',
					   members_only = '".$row['members_only']."',	
					   unique_id = '".$_SESSION['unique_id']."',
					   post_date = '".time()."'";
			   
	$rs=$this->query($sql);	
	}
}
function sub_event_by_id($event_id)
{
  $sql="select * from  ".$this->prefix()."type_by_sub_event where sub_event_id='".$event_id."'";
  $rs=$this->query($sql);	
}
function eventTypeBYEventId($event_id)
{
  $sql="select * from  ".$this->prefix()."event_types where event_id='".$event_id."'";
  $rs=$this->query($sql);	
}
function getEventTypeMster()
{
  $sql="select * from  ".$this->prefix()."master_event_types ";
  $rs=$this->query($sql);	
}
function getPerformerTypeMster()
{
  $sql="select * from  ".$this->prefix()."master_performer_types ";
  $rs=$this->query($sql);	
}

// ========================== Venue ===============================

function addEventType($event_types,$last_event_id)
{
   if(count($event_types)>0)
   {
	   for($a=0;$a<count($event_types);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."venue_types SET venue_id = '".$last_event_id."',
																	   event_master_type_id = '".$event_types[$a]."'";
			$rs=$this->query($sql);	
	   }
   }
}

function addCategoryByVenue($finalArray,$last_event_id)
{
   if(count($finalArray)>0)
   {
	   for($a=0;$a<count($finalArray);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."category_by_venue SET venue_id = '".$last_event_id."',
																	   category_id = '".$finalArray[$a]."'";
			$rs=$this->query($sql);	
	   }
   }
}

function addVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$venue_unique_id,$venue_stat)
{
	$sql="INSERT INTO ".$this->prefix()."venue 
				SET admin_id = '".$_SESSION['ses_user_id']."',
				   venue_name_sp = '".$venue_name_sp."',
				   venue_short_add_sp ='".$venue_short_add_sp."',
				   venue_name = '".$venue_name."',
				   venue_short_add_en = '".$venue_short_add_en."',
				   venue_state = '".$venue_state."',
				   venue_county = '".$venue_county."',
				   venue_city = '".$venue_city."',
				   venue_zip = '".$venue_zip."',
				   venue_address = '".$venue_address."',
				   venue_contact_name = '".$venue_contact_name."',
				   venue_head_manager = '".$venue_head_manager."',
				   venue_phone = '".$venue_phone."',
				   venue_fax = '".$venue_fax."',
				   venue_cell = '".$venue_cell."',
				   venue_email = '".$venue_email."',
				   venue_url = '".$venue_url."',
				   venue_capacity = '".$venue_capacity."',
				   venue_map = '".$venue_map."',
				   venue_media_gallery = '".$venue_media_gallery."',
				   venue_authorize_manager = '".$venue_authorize_manager."',
				   allowed_commments = '".$allowed_commments."',
				   allowed_share = '".$allowed_share."',
				   show_FB_like = '".$show_FB_like."',
				   venue_description = '".$venue_description."',
				   venue_description_sp = '".$venue_description_sp."',
				   venue_image = '".$file_name."',
				   private_privacy = '".$private_privacy."',
				   public_privacy = '".$public_privacy."',
				   tags = '".$tags."',
				   publish_date = '".$publish_date."',
				   venue_stat = '".$venue_stat."',
				   unique_id = '".$venue_unique_id."',
				   post_date = '".time()."'";
  $rs=$this->query($sql);	
  return $last_event_id=mysql_insert_id();
}

function editVenue($venue_name_sp,$venue_short_add_sp,$venue_name,$venue_short_add_en,$venue_state,$venue_county,$venue_city,$venue_zip,$venue_address,$venue_contact_name,$venue_head_manager,$venue_phone,$venue_fax,$venue_cell,$venue_email,$venue_url,$venue_capacity,$venue_map,$venue_media_gallery,$venue_authorize_manager,$allowed_commments,$allowed_share,$show_FB_like,$venue_description,$venue_description_sp,$file_name,$private_privacy,$public_privacy,$tags,$publish_date,$venue_stat,$venue_id)
{
	$sql="UPDATE ".$this->prefix()."venue 
				SET venue_name_sp = '".$venue_name_sp."',
				   venue_short_add_sp ='".$venue_short_add_sp."',
				   venue_name = '".$venue_name."',
				   venue_short_add_en = '".$venue_short_add_en."',
				   venue_state = '".$venue_state."',
				   venue_county = '".$venue_county."',
				   venue_city = '".$venue_city."',
				   venue_zip = '".$venue_zip."',
				   venue_address = '".$venue_address."',
				   venue_contact_name = '".$venue_contact_name."',
				   venue_head_manager = '".$venue_head_manager."',
				   venue_phone = '".$venue_phone."',
				   venue_fax = '".$venue_fax."',
				   venue_cell = '".$venue_cell."',
				   venue_email = '".$venue_email."',
				   venue_url = '".$venue_url."',
				   venue_capacity = '".$venue_capacity."',
				   venue_map = '".$venue_map."',
				   venue_media_gallery = '".$venue_media_gallery."',
				   venue_authorize_manager = '".$venue_authorize_manager."',
				   allowed_commments = '".$allowed_commments."',
				   allowed_share = '".$allowed_share."',
				   show_FB_like = '".$show_FB_like."',
				   venue_description = '".$venue_description."',
				   venue_description_sp = '".$venue_description_sp."',
				   venue_image = '".$file_name."',
				   private_privacy = '".$private_privacy."',
				   public_privacy = '".$public_privacy."',
				   tags = '".$tags."',
				   venue_stat = '".$venue_stat."',
				   publish_date = '".$publish_date."'
			WHERE venue_id  = '".$venue_id."'";
	//echo $sql;
	//exit;
			
  $rs=$this->query($sql);	
  //return $last_event_id=mysql_insert_id();
}

function allVenueList($limit,$venue_state = false,$venue_county = false,$venue_city = false)			
{
	$whereClause = '';
	if($venue_state)
		$whereClause = " AND venue_state = '".$venue_state."'";	
	
	if($venue_county)
		$whereClause .= " AND venue_county = '".$venue_county."'";	
	
	if($venue_city)
		$whereClause .= " AND  venue_city = '".$venue_city."'";
		
	if($_SESSION['ses_user_id']!=1)
		$whereClause .= " AND  A.admin_id = '".$_SESSION['ses_user_id']."'";	
	
	
	$sql="SELECT A.*,C.city_name,S.county_name,St.state_name FROM kcp_venue AS A LEFT JOIN kcp_city AS C ON(A.venue_city = C.id) LEFT JOIN kcp_county S ON(S.id = A.venue_county) LEFT JOIN kcp_state St ON(St.id = A.venue_state)  WHERE  1=1 $whereClause ORDER BY St.state_name,S.county_name,C.city_name ASC $limit";
	
	/*SELECT A.*,C.city_name,S.county_name,St.state_name FROM ".$this->prefix()."venue AS A, ".$this->prefix()."city AS C, ".$this->prefix()."county S,".$this->prefix()."state St  WHERE A.venue_city = C.id AND S.id = A.venue_county AND St.id = A.venue_state $whereClause ORDER BY St.state_name,S.county_name,C.city_name ASC $limit";*/
	
	//echo $sql;
	$this->query($sql);
}

function allVenueListCount($venue_state = false,$venue_county = false,$venue_city = false)			
{
	$whereClause = '';
	if($venue_state)
		$whereClause = " AND venue_state = '".$venue_state."'";	
	
	if($venue_county)
		$whereClause .= " AND venue_county = '".$venue_county."'";	
	
	if($venue_city)
		$whereClause .= " AND  venue_city = '".$venue_city."'";
		
	if($_SESSION['ses_user_id']!=1)
		$whereClause .= " AND  A.admin_id = '".$_SESSION['ses_user_id']."'";	
	
	$sql="SELECT A.*,C.city_name,S.county_name,St.state_name FROM kcp_venue AS A LEFT JOIN kcp_city AS C ON(A.venue_city = C.id) LEFT JOIN kcp_county S ON(S.id = A.venue_county) LEFT JOIN kcp_state St ON(St.id = A.venue_state)  WHERE  1=1 $whereClause ORDER BY St.state_name,S.county_name,C.city_name ASC";
	$this->query($sql);
}	

function changeVenueStatus($id,$status)
{
	if($status == 'Y')
	{
	  $new_status = 'N';
	}
	else
	{
	  $new_status = 'Y';
	}

	$sql = "UPDATE ".$this->prefix()."venue SET venue_active='".$new_status."' WHERE venue_id = '".$id."'";
	//echo $sql;exit;
	return $this->query($sql);
}

function getVenueDetails($venue_id)
{
	$sql="SELECT A.*,C.city_name,S.county_name,St.state_name FROM kcp_venue AS A LEFT JOIN kcp_city AS C ON(A.venue_city = C.id) LEFT JOIN kcp_county S ON(S.id = A.venue_county) LEFT JOIN kcp_state St ON(St.id = A.venue_state)  WHERE A.venue_id = $venue_id ";
	
	//$sql="SELECT A.*,B.city_name,C.county_name,D.state_name FROM ".$this->prefix()."venue AS A, ".$this->prefix()."city AS B, ".$this->prefix()."county C,".$this->prefix()."state D   WHERE A.venue_city = B.id AND C.id = A.venue_county AND D.id = A.venue_state AND A.venue_id = $venue_id ";
	//echo $sql;
	$this->query($sql);
}
function eventTypeBYVenueId($venue_id )
{
  $sql="select * from  ".$this->prefix()."venue_types where venue_id ='".$venue_id ."'";
  $rs=$this->query($sql);	
}
function categorylistByVenue($venue_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_venue WHERE venue_id = '".$venue_id."'";
	$this->query($sql);
}

function delCatByVenueId($venue_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_venue WHERE venue_id = '".$venue_id."'";
	return $this->query($sql);
}

function delvenueTypeByVenueId($venue_id)
{
	$sql="DELETE FROM ".$this->prefix()."venue_types WHERE venue_id = '".$venue_id."'";
	return $this->query($sql);
}
function delete_venue($venue_id)
{
	$sql="DELETE FROM ".$this->prefix()."venue WHERE venue_id = '".$venue_id."'";
	return $this->query($sql);
}

function checkSavedVenue($uid)
{
  $sql="select * from  ".$this->prefix()."venue where unique_id='".$uid."'";
  //echo $sql;
  $rs=$this->query($sql);	
}
function get_venue($venue_id)
{
  $sql="select * from  ".$this->prefix()."venue where venue_id ='".$venue_id ."'";
  //echo $sql;
  $rs=$this->query($sql);	
}


// ========================== Venue ===============================



function get_event_id($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_events WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}

function get_sub_event_id($unique_id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE unique_id = '".$unique_id."'";
	return $this->query($sql);
}


function addSubEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$event_id,$status,$unique_id,$privacy,$event_id)
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


function get_sub_event($id)
{
	$sql="SELECT * FROM ".$this->prefix()."general_subevents WHERE event_id = '".$id."'";
	return $this->query($sql);
}

function get_sub_event_ticket($id)
{
	$sql="SELECT * FROM ".$this->prefix()."final_tickets WHERE ticket_id = '".$id."'";
	return $this->query($sql);
}









// ========================== Performer  ===============================

function checkSavedPerformer($uid)
{
  $sql="select * from  ".$this->prefix()."performer where unique_id='".$uid."'";
 // echo $sql;
  $rs=$this->query($sql);	
}

function chkExistSavedcatPerformer($performer_id,$category_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_performer WHERE category_id = '".$category_id."' AND performer_id = '".$performer_id."' ";
	//echo $sql;
	$query = $this->query($sql);
	return mysql_num_rows($query);
}

function addSavedCatByPerfrm($category_id,$performer_id)
{
			$sql="INSERT INTO ".$this->prefix()."category_by_performer SET performer_id = '".$performer_id."',
																	   category_id = '".$category_id."'";
			$rs=$this->query($sql);	
}
function addperformertype($performer_master_type_id,$performer_id)
{
			$sql="INSERT INTO ".$this->prefix()."performer_types SET performer_id = '".$performer_id."',performer_master_type_id = '".$performer_master_type_id."'";
			$rs=$this->query($sql);	
}


function addSavedPerformer($admin_id,$performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$unique_id)
{
	$sql="INSERT INTO ".$this->prefix()."performer 
				SET admin_id = '".$_SESSION['ses_user_id']."',
				   performer_name_sp = '".$performer_name_sp."',
				   performer_name_en ='".$performer_name_en."',
				   performer_short_add_sp = '".$performer_short_add_sp."',
				   performer_short_add_en = '".$performer_short_add_en."',
				   performer_state = '".$performer_state."',
				   performer_county = '".$performer_county."',
				   performer_city = '".$performer_city."',
				   performer_zip = '".$performer_zip."',
				   performer_address = '".$performer_address."',
				   performer_contact_name = '".$performer_contact_name."',
				   performer_fax = '".$performer_fax."',
				   performer_cell = '".$performer_cell."',
				   performer_email = '".$performer_email."',
				   performer_url = '".$performer_url."',
				   avail_performanace = '".$avail_performanace."',
				   manager_name = '".$manager_name."',
				   manager_phone = '".$manager_phone."',
				   manager_fax = '".$manager_fax."',
				   manager_cell = '".$manager_cell."',
				   manager_email = '".$manager_email."',
				   manager_url = '".$manager_url."',
				   performer_description_sp = '".$performer_description_sp."',
				   performer_description_en = '".$performer_description_en."',
				   privacy = '".$privacy."',
				   st_rate = '".$st_rate."',
				   activate_status = '".$activate_status."',
				   performer_photo = '".$file_name."',
				   performer_tags = '".$performer_tags."',
				   unique_id = '".$unique_id."',
				   post_date = '".time()."'";
				   //echo $sql;
  $rs=$this->query($sql);	
  return $last_event_id=mysql_insert_id();
}

function delPerCat($performer_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_performer WHERE performer_id = '".$performer_id."'";
	return $this->query($sql);
}

function delPertypes($performer_id)
{
	$sql="DELETE FROM ".$this->prefix()."performer_types WHERE performer_id = '".$performer_id."'";
	return $this->query($sql);
}


function editSavedPerformer($performer_name_sp,$performer_name_en,$performer_short_add_sp,$performer_short_add_en,$performer_state,$performer_county,$performer_county,$performer_city,$performer_zip,$performer_address,$performer_contact_name,$performer_phone,$performer_fax,$performer_cell,$performer_email,$performer_url,$avail_performanace,$manager_name,$manager_phone,$manager_fax,$manager_cell,$manager_email,$manager_url,$performer_description_sp,$performer_description_en,$privacy,$st_rate,$activate_status,$file_name,$performer_tags,$unique_id)
{
	$sql="UPDATE ".$this->prefix()."performer 
				SET 
				   performer_name_sp = '".$performer_name_sp."',
				   performer_name_en ='".$performer_name_en."',
				   performer_short_add_sp = '".$performer_short_add_sp."',
				   performer_short_add_en = '".$performer_short_add_en."',
				   performer_state = '".$performer_state."',
				   performer_county = '".$performer_county."',
				   performer_city = '".$performer_city."',
				   performer_zip = '".$performer_zip."',
				   performer_address = '".$performer_address."',
				   performer_contact_name = '".$performer_contact_name."',
				   performer_fax = '".$performer_fax."',
				   performer_cell = '".$performer_cell."',
				   performer_email = '".$performer_email."',
				   performer_url = '".$performer_url."',
				   avail_performanace = '".$avail_performanace."',
				   manager_name = '".$manager_name."',
				   manager_phone = '".$manager_phone."',
				   manager_fax = '".$manager_fax."',
				   manager_cell = '".$manager_cell."',
				   manager_email = '".$manager_email."',
				   manager_url = '".$manager_url."',
				   performer_description_sp = '".$performer_description_sp."',
				   performer_description_en = '".$performer_description_en."',
				   privacy = '".$privacy."',
				   st_rate = '".$st_rate."',
				   activate_status = '".$activate_status."',
				   performer_photo = '".$file_name."',
				   performer_tags = '".$performer_tags."',
				   unique_id = '".$unique_id."'
			WHERE unique_id = '".$unique_id."'";
				   //echo $sql;
  $rs=$this->query($sql);	
  return $last_event_id=mysql_insert_id();
}

function addStandardRates($performer_id,$rate_name_en,$rate_name_sp,$description_en,$description_sp,$price_mx,$price_us)
{
			$sql="INSERT INTO ".$this->prefix()."performer_rates SET performer_id = '".$performer_id."',
																	  rate_name_en = '".$rate_name_en."',
																	  rate_name_sp = '".$rate_name_sp."',
																	  description_en = '".$description_en."',
																	  description_sp = '".$description_sp."',
																	  price_mx = '".$price_mx."',
																	  price_us = '".$price_us."'";
			$rs=$this->query($sql);	
}


function editStandardRates($performer_id,$rate_name_en,$rate_name_sp,$description_en,$description_sp,$price_mx,$price_us,$exit_rate_id)
{
			$sql="UPDATE ".$this->prefix()."performer_rates 
								  SET performer_id = '".$performer_id."',
								  rate_name_en = '".$rate_name_en."',
								  rate_name_sp = '".$rate_name_sp."',
								  description_en = '".$description_en."',
								  description_sp = '".$description_sp."',
								  price_mx = '".$price_mx."',
								  price_us = '".$price_us."'
				WHERE performer_rates_id = '".$exit_rate_id."'";
			$rs=$this->query($sql);	
}

function getStandardRate($performer_id)
{
	$sql="SELECT * FROM ".$this->prefix()."performer_rates WHERE performer_id = '".$performer_id."'";
	return $this->query($sql);
}

function getStandardRateById($performer_rates_id)
{
	$sql="SELECT * FROM ".$this->prefix()."performer_rates WHERE performer_rates_id  = '".$performer_rates_id ."'";
	return $this->query($sql);
}

function del_standard_rates($performer_rates_id)
{
	$sql="DELETE FROM ".$this->prefix()."performer_rates WHERE performer_rates_id = '".$performer_rates_id."'";
	return $this->query($sql);
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

function checkSavedEventEdit($event_id)
{
  $sql="select * from  ".$this->prefix()."general_events where event_id='".$event_id."'";
  //echo $sql;
  $rs=$this->query($sql);	
}

function get_final_MultiEvent($event_id)
{
 $sql = "SELECT TM.*,C.city_name city_name_multi,S.state_name state_name_multi,V.venue_name venue_name_multi FROM ".$this->prefix()."final_multi_event TM LEFT join ".$this->prefix()."venue V ON (TM.multi_venue = V.venue_id ) LEFT join ".$this->prefix()."state S on (S.id = TM.multi_venue_state) LEFT join ".$this->prefix()."city C on (C.id = TM.multi_venue_city) WHERE TM.event_id = '".$event_id."'"; 
 $this->query($sql);
}



function Add_auto_save_eventtype($event_types,$last_event_id)
{
   if(count($event_types)>0)
   {
	   for($a=0;$a<count($event_types);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."event_types SET 
												event_id = '".$last_event_id."',
												event_master_type_id = '".$event_types[$a]."'";
												//echo $sql;
			$rs=$this->query($sql);	
	   }
   }
}

function del_event_type($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."event_types WHERE event_id  = '".$event_id."'";
	return $this->query($sql);
}



function getSubeventTicketById($ticket_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets  WHERE ticket_id = '".$ticket_id."'";
	$this->query($sql);
}

function del_sub_event_cat($sub_event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_sub_event WHERE sub_event_id = '".$sub_event_id."'";
	return $this->query($sql);
}
function chkExistsubcat($last_event_id,$category_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_event WHERE category_id = '".$category_id."' AND event_id = '".$last_event_id."' ";
	//echo $sql;
	$query = $this->query($sql);
	return mysql_num_rows($query);
}
function chkExistsubcategory($last_event_id,$category_id)
{
	$sql="SELECT * FROM ".$this->prefix()."category_by_sub_event WHERE category_id = '".$category_id."' AND sub_event_id = '".$last_event_id."' ";
	//echo $sql;
	$query = $this->query($sql);
	return mysql_num_rows($query);
}

function addSavedSubCat($category_id,$sub_event_id,$event_id)
{
			$sql="INSERT INTO ".$this->prefix()."category_by_sub_event SET event_id = '".$event_id."',
																	   sub_event_id = '".$sub_event_id."',
																	   category_id = '".$category_id."'";
			$rs=$this->query($sql);	
}

function del_sub_event_type($sub_event_id)
{
	$sql="DELETE FROM ".$this->prefix()."type_by_sub_event WHERE sub_event_id  = '".$sub_event_id."'";
	return $this->query($sql);
}

function Add_auto_sub_save_eventtype($event_types,$sub_event_id,$event_id)
{
   if(count($event_types)>0)
   {
	   for($a=0;$a<count($event_types);$a++)
	   {
			$sql="INSERT INTO ".$this->prefix()."type_by_sub_event SET 
												event_id = '".$event_id."',
												sub_event_id = '".$sub_event_id."',
												event_master_type_id = '".$event_types[$a]."'";
												//echo $sql;
			$rs=$this->query($sql);	
	   }
   }
}

function del_sub_tickets($ticket_id)
{
	$sql="DELETE FROM ".$this->prefix()."sub_event_tickets  WHERE ticket_id = '".$ticket_id."' "; 
	$this->query($sql);
}


/////////////////////////DELETE EVENTS AND CORRESPONDINGS/////////////////////////////

function delete_event($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."general_events WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_event_type($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."event_types WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_event_category($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_event WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_event_ticket($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."final_multi_event WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}	

function delete_sub_event($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."general_subevents WHERE parent_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_type($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."type_by_sub_event WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_category($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."category_by_sub_event WHERE event_id = '".$event_id."'";
	
	return $this->query($sql);
}

function delete_sub_event_ticket($event_id)
{
	$sql="DELETE FROM ".$this->prefix()."sub_event_tickets WHERE parent_id = '".$event_id."'";
	
	return $this->query($sql);
}	

function getCityById($city_id)
{
	$sql="SELECT * FROM ".$this->prefix()."city WHERE id = '".$city_id."'";
	return $this->query($sql);
}




};

?>