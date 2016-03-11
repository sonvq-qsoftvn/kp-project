<?php
class User extends DB_Sql
{
	function api_show()
	{
		$sql = "select * from ".$this->prefix()."setting " ;
		$this->query($sql);
	}
//====================== Api Setting======================

		function api_setting()
		{	
			$sql="SELECT * FROM  ".$this->prefix()."setting";
			$this->query($sql);
		}
//======================= End ===============================


	
// ===================== Event Page =========================
		
	function random_gen($length)
	{
	  $random= "";
	  srand((double)microtime()*1000000);
	  //$char_list  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $char_list = "abcdefghijklmnopqrstuvwxyz";
	  $char_list .= "1234567890";
	  // Add the special characters to $char_list if needed
	
	  for($i = 0; $i < $length; $i++)  
	  {    
		 $random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
	  }  
	  return $random;
	}
	function getAdminByEmail($email)
	{
		$sql = "SELECT * FROM  ".$this->prefix()."admin WHERE username='".$email."' OR email='".$email."'";
		//echo $sql;
		$this->query($sql);
		
	}			
	//====================================================== end =======================================================
	

	
	
	
	// =====================add newsletter contact================

		function add_contact($email){
			
			$this->newsletter_signup_mail($email);
			
			$sql="INSERT INTO ".$this->prefix()."newsletter_contacts SET 
			user_email='".$email."',
			contact_date='".date("y-m-d H:i:s")."' ";
			return $this->query($sql);
		}
// ======================end==================================

	
	//====================================================== Newsletter signup mail =======================================================
	function newsletter_signup_mail($email){
	
		$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td valign="top" align="center">

            <table width="100%" cellspacing="0" cellpadding="0">                  
                 
                <tbody><tr>
                    <td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
                        <center>
                            <a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
                            <img border="0" align="middle" alt="Ticket Hype" title="Ticket Hype" src="'.$this->base_path().'/images/email_logo.jpg"></a>
                        </center>
                                            </td>
                </tr>
                            </tbody></table>

            <table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
                <tbody><tr>
                    <td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
                                    <p style="margin-top:0px">
                                    </p><div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Ticket Hype Ticketing Newsletter signup</div>
                                
                                
                                
                                    <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thanks for using Ticket Hype Newsletter!<br><br>

You have subscribe for Ticket Hype Newsletter so that you can get all informations, advertisement from Ticket Hype at everytime to be updated or locate your tickets. <br><br>
Log into your TicketHype account at any time at: <a target="_blank" href="'.$this->base_path().'/login" style="font-weight:bold;">Login</a><br><br>

All the best,<br>
Ticket Hype</span>
                            <p></p>
                    </td>
                </tr>
                                    <tr>
                        <td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
                            <div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
                                <div style="float:right">
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/twitter_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/facebook_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
    </div><div>Copyright &copy; 2011 Ticket Hype, Inc. All rights reserved.</div>                            </div>
                        </td>
                    </tr>
                            </tbody></table>
        </td>
    </tr>
</tbody></table>';
	//echo $output; exit;
	//from email
	$this->admin_setting();
	$this->next_record();
	$from=$this->f('email');
	$to=$email;
	$subject='Ticket Hype Newsletter Signup';
	$com_name='Ticket Hype';
	
	// To send HTML mail, the Content-type header must be set
	/*$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Ticket Hype <'.$from.'>' . "\r\n";*/
	
	// Mail it
	//mail($to, $subject, $output, $headers);
	$this->send_mail($from,$to,$subject,$output,$com_name);
	
	}	
	
	//====================================================== end =======================================================
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
	

//---------------------------------------------------------------------------function to get address of an event (Priyanka-15-12-11)-------------------------------------------
// ===================== Content Page =========================
		function GetContentBypage_link($page_link)
		{
			$sql="SELECT * FROM  ".$this->prefix()."page WHERE page_link='".$page_link."'  ";
			$this->query($sql);
			
		}				
			
// =========================== end ================================	



//====================================================== ticket pdf mail =======================================================
	function ticket_pdf_mail($filename,$user_id,$order_id,$event_id,$attachment){

	$details=$this->order_detailByOrderId($user_id,$order_id);
	$this->next_record();
	
	
	$event_name=$this->f('event_name');
	$purchased_on=$this->f('date');
	$email=$this->f('email');
	$name=$this->f('f_name')." ".$this->f('l_name');
	if($this->f('ticket_holder')){
	$ticket_holder='Ticket Holder name:'.$this->f('ticket_holder');
	}
	
		$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td valign="top" align="center">

            <table width="100%" cellspacing="0" cellpadding="0">                  
                 
                <tbody><tr>
                    <td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
                        <center>
                            <a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
                            <img border="0" align="middle" alt="Ticket Hype" title="Ticket Hype" src="'.$this->base_path().'/images/email_logo.jpg"></a>
                        </center>
                                            </td>
                </tr>
                            </tbody></table>

            <table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
                <tbody><tr>
                    <td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
                                    <p style="margin-top:0px">
                                    </p><div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Ticket Hype Purchased Ticket Information</div>
                                
                                
                                
                                    <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thanks for using Ticket Hype Ticketing!<br><br>
Hello '.$name.',<br>
Your purchase details for <span style="font-size:16px; font-weight:bold">'.$event_name.'</span> on '.$purchased_on.'. <br><br>
'.$ticket_holder.'<br><br>

Your ticket details is attached with the mail. Please download and print the ticket to claim your product.<br><br>
Log into your TicketHype account at any time at: <a target="_blank" href="'.$this->base_path().'/login" style="font-weight:bold;">Login</a><br><br>

All the best,<br>
Ticket Hype</span>
                            <p></p>
                    </td>
                </tr>
                                    <tr>
                        <td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
                            <div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
                                <div style="float:right">
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/twitter_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/facebook_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
    </div><div>Copyright &copy; 2011 Ticket Hype, Inc. All rights reserved.</div>                            </div>
                        </td>
                    </tr>
                            </tbody></table>
        </td>
    </tr>
</tbody></table>';
	//echo $output; exit;
	//from email
	$this->admin_setting();
	$this->next_record();
	$from=$this->f('email');
	$to=$email;
	$subject='Ticket Hype '.$event_name.' Purchased Information';
	$com_name='Ticket Hype';
	
	// To send HTML mail, the Content-type header must be set
	/*$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Ticket Hype <'.$from.'>' . "\r\n";*/
	
	// Mail it
	//mail($to, $subject, $output, $headers);
	$this->send_mail($from,$to,$subject,$output,$com_name,$attachment,$filename);
	return;
	}	
	
	//====================================================== end =======================================================

		



	
	
	
############################################################### END ####################################################################################################	
	
// =========================== mail ================================	
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


function register_user($fname,$lname,$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type,$language) 	
{
	$sql="INSERT INTO ".$this->prefix()."admin SET username='".$email."',password ='".$password ."',account_type ='".$account_type ."',country_id ='".$country_id ."',country_code ='".$country_code ."',rem_password ='".$rem_password ."',fname='".$fname."',lname='".$lname."',phone='".$phone."',email='".$email."',language ='".$language."',post_date ='".time()."'";

	$this->query($sql);	
	$instid = mysql_insert_id();
	return $instid;
}			

//====================================================== Merchant login mail =======================================================
//function merchant_login_mail($password_rem,$email,$user_id,$output,$subject){
function merchant_login_mail($subject,$email,$user_id,$output){

	$this->admin_setting();
	$this->next_record();
	//$from=$this->f('email');
	$from="verify@kpasapp.com";
	$to=$email.",amit.unified@gmail.com";
	//$subject='Your activation key for your kpasapp.com account!';
	$com_name='Kpasapp';
	
	
	$this->send_mail($from,$to,$subject,$output,$com_name);

}	

function merchant_login_pass_mail($password_rem,$email){

	$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
<tbody><tr>
	<td valign="top" align="center">

		<table width="100%" cellspacing="0" cellpadding="0">                  
			 
			<tbody><tr>
				<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
					<center>
						<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
						<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'.$this->base_path().'/images/KPasapp_logo.png"></a>
					</center>
										</td>
			</tr>
						</tbody></table>

		<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
			<tbody><tr>
				<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
					<p style="margin-top:0px"></p>
					<div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Kpasapp Ticketing Login Information</div>

				
					<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thanks for using Kpasapp!<br><br>
					  
					  Thank you for sign-up so that you can return to Kpasapp at anytime to view your purchase history or locate your tickets. <br><br>
				  		Your temporary password: <span style="font-size:16px; font-weight:bold">'.$password_rem.'</span>.<br>
					  <br><br>
					  
					  All the best,<br>
				  Kpasapp</p>
<p></p>
				</td>
			</tr>
			<tr>
			<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
						<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
							<div style="float:right">
	<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/twitter_icon.png"></a>
	<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/facebook_icon.png"></a>
	<a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
	</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
					</td>
				</tr>
	</tbody></table>
	</td>
</tr>
</tbody></table>';
//echo $output; exit;
//from email
$this->admin_setting();
$this->next_record();
//$from=$this->f('email');
$from="verify@kpasapp.com";
$to=$email;
$subject='Kpasapp Ticketing Account Information';
$com_name='Kpasapp';


$this->send_mail($from,$to,$subject,$output,$com_name);

}	

function forgot_pass($password_rem,$email){

	$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
<tbody><tr>
	<td valign="top" align="center">

		<table width="100%" cellspacing="0" cellpadding="0">                  
			 
			<tbody><tr>
				<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
					<center>
						<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
						<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'.$this->base_path().'/images/KPasapp_logo.png"></a>
					</center>
										</td>
			</tr>
						</tbody></table>

		<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
			<tbody><tr>
				<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
					<p style="margin-top:0px"></p>
					<div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Kpasapp Ticketing Login Information</div>

				
					<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thanks for using Kpasapp!<br>
				  		Your  password: <span style="font-size:16px; font-weight:bold">'.$password_rem.'</span>.<br>
				  </p>
				  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">&nbsp;</p>
					<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><br>
					  
					  All the best,<br>
				  Kpasapp</p>
<p></p>
				</td>
			</tr>
			<tr>
			<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
						<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
							<div style="float:right">
	<a target="_blank" href="https://twitter.com/KPasapp"><img width="" border="0" height="" src="'.$this->base_path().'/images/twitter_icon.png"></a>
	<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="" border="0" height="" src="'.$this->base_path().'/images/facebook_icon.png"></a>
	<a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
	</div><div>Copyright &copy; 2013 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
					</td>
				</tr>
						</tbody></table>
	</td>
</tr>
</tbody></table>';
//echo $output; exit;
//from email
$this->admin_setting();
$this->next_record();
//$from=$this->f('email');
$from="verify@kpasapp.com";
$to=$email;
$subject='Kpasapp Forgot Password.';
$com_name='Kpasapp';


$this->send_mail($from,$to,$subject,$output,$com_name);

}	

//====================================================== end =======================================================
	
function EventAll($limit = false,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories){
	
	$whereCluase = '';
	$frmClause = '';
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND E.event_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  E.event_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  E.event_venue_county = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND ( E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' )";
	}
	if($event_categories!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories."'";
	}
	
	/*if($tags!="")
	{
		$whereCluase = " AND event_tag = '".$tags."'";
	}*/
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";
		
		$sql="select *,E.event_id as id from ".$this->prefix()."general_events E LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) $frmClause where E.`event_time`!= 'Weekly' AND E.event_start_date_time > '".$start_date."' AND E.event_start_date_time <= '".$end_date."' AND E.status = 'publish' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql="select *,E.event_id as id from ".$this->prefix()."general_events E LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) $frmClause where E.`event_time`!= 'Weekly' AND now() <= E.event_start_date_time AND E.status = 'publish' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	//echo $sql;//exit;
	$this->query($sql);
}
	
function EventAll_num($tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories){
	
	$whereCluase = '';
	$frmClause='';
	
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND E.event_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  E.event_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  E.event_venue_county = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	if($event_categories!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories."'";
	}

	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";

		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) $frmClause where E.event_start_date_time > '".$start_date."' AND E.event_start_date_time <= '".$end_date."' AND E.status = 'publish' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) $frmClause where now() <= E.event_start_date_time AND E.status = 'publish' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}	

	$this->query($sql);
}
	
function venue_by_ieventd($event_id){

	$sql='SELECT * FROM '.$this->prefix().'general_events E Inner join '.$this->prefix().'venue V on (E.event_venue =V.venue_id ) where  E.event_id="'.$event_id.'" and E. 	event_status="Y" ';	
	//echo $sql;
	return $this->query($sql);	
}

function min_ticket_cost_perEvent($event_id)
{
	$sql = "SELECT min(`price_mx`) as price_mx,min(`price_us`) as price_us FROM `kcp_final_tickets` WHERE `event_id` = ".$event_id;
	return $this->query($sql);	
}
function count_num_ticket($event_id)
{
	$sql = "SELECT * FROM `kcp_final_tickets` WHERE `event_id` = ".$event_id;
	//echo $sql."<br />";
	return $this->query($sql);	
}

	
function event_by_id($event_id)
{
	$sql="SELECT * FROM  ".$this->prefix()."general_events WHERE event_id='".$event_id."' ";
	$this->query($sql);

}
function venue_details_eventId($event_id){

	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'general_events E Inner join '.$this->prefix().'venue V ON (E.event_venue = V.venue_id ) Inner join '.$this->prefix().'state S on (S.id = V.venue_state)  Inner join '.$this->prefix().'city C on (C.id = V.venue_city) WHERE E.event_id="'.$event_id.'"  ';
	//echo $sql;
	return $this->query($sql);	
}


function venue_details_subId($event_id){

	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'general_subevents E Inner join '.$this->prefix().'venue V ON (E.event_venue = V.venue_id ) Inner join '.$this->prefix().'state S on (S.id = V.venue_state)  Inner join '.$this->prefix().'city C on (C.id = V.venue_city) WHERE E.event_id="'.$event_id.'" ';
	return $this->query($sql);	
}


//--------------------intro page start-----------------------------
function intro_page($page_id)
{
	$sql="SELECT * FROM ".$this->prefix()."page  where page_link='".$page_id."' ";
	$this->query($sql);
}
function intro_page_id($page_id)
{
	$sql="SELECT * FROM ".$this->prefix()."page  where page_id='".$page_id."' ";
	$this->query($sql);
}
//---------------------intro page end------------------------------

function eventDetails($event_county_cal,$event_cities_cal,$event_venues_cal,$event_categories_cal){
	
	$whereCluase = '';
	$frmClause = '';
	if($event_county_cal!="")
	{
		$whereCluase = " AND V.venue_county = '".$event_county_cal."'";
	}
	if($event_cities_cal!="")
	{
		$whereCluase .= " AND V.venue_city = '".$event_cities_cal."'";
	}
	if($event_venues_cal!="")
	{
		$whereCluase .= " AND E.event_venue = '".$event_venues_cal."'";
	}
	if($event_categories_cal!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories_cal."'";
	}
	
	//$sql="select *,E.event_id as evnt,V.venue_name as ven_nam,V.venue_name_sp as ven_nam_sp from ".$this->prefix()."general_events E Inner join ".$this->prefix()."venue V ON (E.event_venue = V.venue_id ) $frmClause where `event_status`='Y' $whereCluase Order by E.event_start_date_time ";
	$sql="select *,E.event_id as evnt,V.venue_name as ven_nam,V.venue_name_sp as ven_nam_sp,C.city_name from ".$this->prefix()."general_events E Inner join ".$this->prefix()."venue V ON (E.event_venue = V.venue_id ) LEFT join ".$this->prefix()."city C ON (V.venue_city = C.id) $frmClause where event_time!= 'Weekly' $whereCluase Order by E.event_start_date_time ";
	//echo $sql;

	$this->query($sql);
}
	
function getTicketById($event_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."final_tickets  WHERE event_id = ".$event_id;
	$this->query($sql);
}

function subgetTicketById($event_id,$parent_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."sub_event_tickets WHERE event_id = ".$event_id;
	$this->query($sql);
}




//===============FETCH EVENT TAG LIST===================//
function allEventTagList()
{
	$sql = "SELECT * FROM ".$this->prefix()."general_events  WHERE event_status = 'Y' AND event_tag <> ''";
	$this->query($sql);
}

//===============FETCH PARENT CATEGORY LIST===================//
function allEventParentCategoryList()
{
	$sql = "SELECT * FROM ".$this->prefix()."event_category  WHERE category_status = 'Y' AND parent_category = '0' ORDER BY category_name ASC";
	$this->query($sql);
}

//===============FETCH SUB CATEGORY LIST===================//
function allEventSubCategoryList()
{
	$sql = "SELECT * FROM ".$this->prefix()."event_category  WHERE category_status = 'Y' AND parent_category <> '0'  ORDER BY category_name ASC";
	$this->query($sql);
}

//===============FETCH CITY LIST===================//
function allCityList()
{
	$sql = "SELECT * FROM ".$this->prefix()."city ORDER BY city_name";
	$this->query($sql);
}

//===============FETCH VENUE LIST===================//
function allVenueList()
{
	$sql = "SELECT * FROM ".$this->prefix()."venue ORDER BY venue_name";
	$this->query($sql);
}

// ================= FETCH COUNTY LIST +++++++++++++++++++++++++++++

function allEventCountyList()
{
	$sql = "SELECT * FROM ".$this->prefix()."county ORDER BY county_name";
	$this->query($sql);
}

function allEventPicture()
{
	$sql = "SELECT * FROM `".$this->prefix()."general_events` WHERE now() <= event_start_date_time Order by event_id Desc";
	//echo $sql."<br />";
	return $this->query($sql);	
}



function getCityNameByCounty($countyId)
{
	$sql="SELECT * FROM ".$this->prefix()."city WHERE county_id = '".$countyId."' ORDER BY id ASC";
	return $this->query($sql);
}

function getVenueNameByCity($cityId)
{
	$sql="SELECT * FROM ".$this->prefix()."venue WHERE venue_city = '".$cityId."' ORDER BY venue_id ASC";
	//echo $sql;
	return $this->query($sql);
}

function adminSettings()
{
	$sql = "SELECT * FROM ".$this->prefix()."admin WHERE admin_id = '1'";
	$this->query($sql);
}

// ================= FETCH Recurring LIST +++++++++++++++++++++++++++++


function recur_evnt_dtls($event_county_cal,$event_cities_cal,$event_venues_cal,$event_categories_cal){
	
	$whereCluase = '';
	$frmClause = '';
	if($event_county_cal!="")
	{
		$whereCluase = " AND E.event_venue_county = '".$event_county_cal."'";
	}
	if($event_cities_cal!="")
	{
		$whereCluase .= " AND E.event_venue_city = '".$event_cities_cal."'";
	}
	if($event_venues_cal!="")
	{
		$whereCluase .= " AND E.event_venue = '".$event_venues_cal."'";
	}
	if($event_categories_cal!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories_cal."'";
	}
	
	$sql="select *,E.event_id as evnt,V.venue_name as ven_nam,V.venue_name_sp as ven_nam_sp,C.city_name from ".$this->prefix()."general_events E Inner join ".$this->prefix()."venue V ON (E.event_venue = V.venue_id ) LEFT join ".$this->prefix()."city C ON (E.event_venue_city = C.id) $frmClause where `event_status`='Y' AND recurring = '1' AND identical_function = '0' AND sub_events = '0' $whereCluase Order by E.event_start_date_time ";
	//echo $sql;exit;
	$this->query($sql);
}



function EventAllRecurring($limit = false,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val){
	
	$whereCluase = '';
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND E.event_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  E.event_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  E.event_venue_county = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	
	/*if($tags!="")
	{
		$whereCluase = " AND event_tag = '".$tags."'";
	}*/
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";
		
		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  Inner join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) where E.`event_status`='Y' AND E.event_start_date_time > '".$start_date."' AND E.event_start_date_time <= '".$end_date."' AND recurring = '1' AND identical_function = '0' AND sub_events = '0' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  Inner join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) where E.`event_status`='Y' AND now() <= E.event_start_date_time AND recurring = '1' AND identical_function = '0' AND sub_events = '0' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	//echo $sql;
	$this->query($sql);
}
	
function EventAllRecurring_num($tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val){
	
$whereCluase = '';
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND E.event_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  E.event_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  E.event_venue_county = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";

		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  Inner join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) where E.`event_status`='Y' AND E.event_start_date_time > '".$start_date."' AND E.event_start_date_time <= '".$end_date."' AND recurring = '1' AND identical_function = '0' AND sub_events = '0' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql=" select *,E.event_id as id from ".$this->prefix()."general_events E  Inner join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) where E.`event_status`='Y' AND now() <= E.event_start_date_time AND recurring = '1' AND identical_function = '0' AND sub_events = '0' $whereCluase order by E.`event_start_date_time` ASC $limit ";
	}	

	$this->query($sql);
}
// ================= FETCH Recurring LIST +++++++++++++++++++++++++++++


//==================================== Country list ============================================
	function countries_list(){
	
		$sql="SELECT * FROM ".$this->prefix()."countries order by order_no desc, nicename asc ";
		return $this->query($sql);
	}
	
	function countries_byid($id){
	
		$sql="SELECT * FROM ".$this->prefix()."countries where id='$id'  ";
		return $this->query($sql);
	}
//==================================== End ============================================

function venue_details_venueid($venue_id){
	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'venue V LEFT join '.$this->prefix().'state S on (S.id = V.venue_state) LEFT join '.$this->prefix().'city C on (C.id = V.venue_city) WHERE V.venue_id="'.$venue_id.'" ';

	return $this->query($sql);

}

function checkEmail($email){

	$sql="SELECT * FROM ".$this->prefix()."admin where email='$email'  ";
	return $this->query($sql);
}

function activateUser($user_id)
{
	$sql="UPDATE ".$this->prefix()."admin SET activate_status = 1 where admin_id = '".$user_id."'";
	$this->query($sql);
}
function getAdminById($admin_id)
	{
		$sql = "SELECT * FROM  ".$this->prefix()."admin WHERE admin_id=".$admin_id;
		//echo $sql;
		$this->query($sql);
		
	}


// ====================Login Page ==========================
	function login($email,$pass)
	{
		$sql="SELECT * FROM ".$this->prefix()."admin WHERE (email= '".$email."' OR phone = '".$email."' ) and password = '".md5($pass)."' AND activate_status = 1 ";
		$res = $this->query($sql);
	}		
//=======================End==============================

function already_register($uid, $oauth_provider){
			$sql = "SELECT * FROM ".$this->prefix()."social_login WHERE oauth_uid ='".$uid."' AND oauth_provider  ='".$oauth_provider."' " ;
			$this->query($sql);			
	}

  function checkUser($uid, $oauth_provider, $username,$email,$twitter_otoken,$twitter_otoken_secret) {
	  $sql="INSERT ".$this->prefix()."social_login SET 
			oauth_provider='".$oauth_provider."',
			oauth_uid='".$uid."',
			username='".$username."',
			email='".$email."',
			twitter_oauth_token='".$twitter_otoken."',
			twitter_oauth_token_secret='".$twitter_otoken_secret."'	";		
			//echo $sql;exit;  
	  $this->query($sql);	
	  return 1;
}	

// ====================Google Plus ==========================


function checkGoogleUser($user_id,$email)
{
	$sql = "SELECT * FROM  ".$this->prefix()."google_user WHERE google_id=$user_id or google_email = '".$email."'";
	$this->query($sql);
	
}

  function insertGoogleUser($user_id,$email) {
	  $sql="INSERT ".$this->prefix()."google_user SET 
			google_id='".$user_id."',
			google_email='".$email."'";		
			//echo $sql;exit;  
	  $this->query($sql);	
	  return 1;
}	
function userDetailByemail($email)
{
	$sql="SELECT * FROM ".$this->prefix()."admin WHERE email='".$email."' ";
	$this->query($sql);
}

function checkAdminUser($email)
{
	$sql="SELECT * FROM ".$this->prefix()."admin WHERE (email= '".$email."' OR phone = '".$email."' ) ";
	//echo $sql;
	$this->query($sql);
}

function MultiEventAll($limit = false,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories){
	
	$whereCluase = '';
	$frmClause = '';
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND ME.multi_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  ME.multi_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  ME.venue_county_multi = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	if($event_categories!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories."'";
	}
	
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";
		
		$sql="select *,E.event_id as id,ME.event_start_date_time as multi_start,ME.event_end_date_time as multi_end from ".$this->prefix()."general_events E Inner join ".$this->prefix()."final_multi_event ME on (E.event_id = ME.event_id ) LEFT join ".$this->prefix()."venue V on (ME.multi_venue = V.venue_id ) $frmClause where E.`identical_function`= 1 AND E.`recurring`= 0 AND ME.event_start_date_time > '".$start_date."' AND ME.event_start_date_time <= '".$end_date."' AND E.status = 'publish' $whereCluase order by ME.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql="select *,E.event_id as id,ME.event_start_date_time as multi_start,ME.event_end_date_time as multi_end from ".$this->prefix()."general_events E Inner join ".$this->prefix()."final_multi_event ME on (E.event_id = ME.event_id ) LEFT join ".$this->prefix()."venue V on (ME.multi_venue = V.venue_id ) $frmClause where E.`identical_function`= 1 AND E.`recurring`= 0 AND now() <= ME.event_start_date_time AND E.status = 'publish' $whereCluase order by ME.`event_start_date_time` ASC $limit ";
	}
	//echo $sql;//exit;
	$this->query($sql);
}

function SubEventAll($limit = false,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories){
	
	$whereCluase = '';
	$frmClause = '';
	if($tags!="")
	{
		$whereCluase = " AND E.event_tag = '".$tags."'";
	}
	
	if($evn_city!="")
	{
		$whereCluase .= " AND ME.event_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  ME.event_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  ME.event_venue_county = '".$county_val."'";
	}
	if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	if($event_categories!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories."'";
	}
	
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";
		
		$sql="select *,E.event_id as id,ME.event_start_date_time as multi_start,ME.event_end_date_time as multi_end,ME.event_id as sub_event_id,E.event_name_en as eve_name_en,E.event_name_sp as eve_name_sp from ".$this->prefix()."general_events E Inner join ".$this->prefix()."general_subevents ME on (E.event_id = ME.parent_id ) LEFT join ".$this->prefix()."venue V on (ME.event_venue = V.venue_id ) $frmClause where E.`sub_events`= 1 AND E.`recurring`= 0 AND ME.event_start_date_time > '".$start_date."' AND ME.event_start_date_time <= '".$end_date."' AND E.status = 'publish' $whereCluase order by ME.`event_start_date_time` ASC $limit ";
	}
	else
	{
		$sql="select *,E.event_id as id,ME.event_start_date_time as multi_start,ME.event_end_date_time as multi_end,ME.event_id as sub_event_id,E.event_name_en as eve_name_en,E.event_name_sp as eve_name_sp from ".$this->prefix()."general_events E Inner join ".$this->prefix()."general_subevents ME on (E.event_id = ME.parent_id ) LEFT join ".$this->prefix()."venue V on (ME.event_venue = V.venue_id ) $frmClause where E.`sub_events`= 1 AND E.`recurring`= 0 AND now() <= ME.event_start_date_time AND E.status = 'publish' $whereCluase order by ME.`event_start_date_time` ASC $limit ";
	}
	//echo $sql;//exit;
	$this->query($sql);
}

function getMultiEventByEventID($event_id,$tags,$category,$evn_city,$evn_venue,$start_date,$end_date,$key_word,$county_val,$event_categories){
	
	if($evn_city!="")
	{
		$whereCluase .= " AND E.multi_venue_city = '".$evn_city."'";
	}
	
	if($evn_venue!="")
	{
		$whereCluase .= " AND  E.multi_venue = '".$evn_venue."'";
	}
	if($county_val!="")
	{
		$whereCluase .= " AND  E.venue_county_multi = '".$county_val."'";
	}
	/*if($key_word!="")
	{
		$whereCluase .= " AND (  E.event_name_en like '".$key_word."%' OR E.event_name_sp like '".$key_word."%' OR E.event_details_en like '".$key_word."%' OR E.event_details_sp like '".$key_word."%' ) ";
	}
	if($event_categories!="")
	{
		$frmClause = " Inner join ".$this->prefix()."category_by_event CE ON (E.event_id  = CE.event_id) ";
		$whereCluase .= " AND CE.category_id = '".$event_categories."'";
	}*/
	
	if($start_date!="" && $end_date!="")
	{
		$start_date = $start_date." 00:01:01";
		$end_date = $end_date." 23:59:59";
		
		$sql="SELECT * FROM ".$this->prefix()."final_multi_event E LEFT join ".$this->prefix()."venue V on (E.multi_venue = V.venue_id ) $frmClause where E.event_start_date_time > '".$start_date."' AND E.event_start_date_time <= '".$end_date."' AND event_id='".$event_id."' $whereCluase order by E.`event_start_date_time` ASC ";
	}
	else
	{
		$sql="SELECT * FROM ".$this->prefix()."final_multi_event E LEFT join ".$this->prefix()."venue V on (E.multi_venue = V.venue_id ) $frmClause where E.event_id='".$event_id."' $whereCluase order by E.`event_start_date_time` ASC ";
	}
	//echo $sql."<br/>";
	return $this->query($sql);
}

function venue_multi_details($multi_id){

	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'final_multi_event E LEFT join '.$this->prefix().'venue V ON (E.multi_venue = V.venue_id ) LEFT join '.$this->prefix().'state S on (S.id = E.multi_venue_state)  LEFT join '.$this->prefix().'city C on (C.id = E.multi_venue_city) WHERE E.multi_id="'.$multi_id.'" ';
	//echo $sql."<br/>";
	return $this->query($sql);	
}

function venue_details_multi_eventId($multi_id){

	$sql='SELECT V.*, S.state_name as st_name,C.city_name as city FROM '.$this->prefix().'final_multi_event E LEFT join '.$this->prefix().'venue V ON (E.multi_venue = V.venue_id ) LEFT join '.$this->prefix().'state S on (S.id = E.multi_venue_state) LEFT join '.$this->prefix().'city C on (C.id = E.multi_venue_city) WHERE E.multi_id="'.$multi_id.'" ';
	//echo $sql."<br/>";
	return $this->query($sql);	
}


// =========================== Socail Sign Up ====================

	function user_exist($email)
	{
		
		$sql="SELECT * FROM ".$this->prefix()."admin where email = '".$email."'";
		$this->query($sql);
	}

// =========================== Socail Sign Up ====================


function edit_admin_details($account_type,$fname,$lname,$email,$phone,$propphone,$us_phone,$nextel,$country_id,$country_code,$language,$province,$county,$city,$address,$postal_code,$admin_id,$mobile_code,$phone_code)
{
	$sql="UPDATE ".$this->prefix()."admin SET fname = '".$fname."',
											  lname = '".$lname."',
											  email = '".$email."',
											  mobile = '".$phone."',
											  mobile_code = '".$mobile_code."',
											  phone_code = '".$phone_code."',
											  phone = '".$propphone."',
											  us_phone = '".$us_phone."',
											  nextel = '".$nextel."',
											  country_id = '".$country_id."',
											  country_code = '".$country_code."',
											  language = '".$language."', 
											  province = '".$province."',
											  county = '".addslashes($county)."',
											  city = '".addslashes($city)."',
											  account_type = '".$account_type."',
											  address = '".addslashes($address)."',
											  postal_code = '".$postal_code."'											  
											  
											  where admin_id = '".$admin_id."'";
	//echo $sql;exit;
	$this->query($sql);
}
function updateAccountType($param, $admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin SET account_type = '".$param."'										  
											  
											  where admin_id = '".$admin_id."'";
	//echo $sql;exit;
	$this->query($sql);
}
function checkEmailexists($email,$admin_id){

	$sql="SELECT * FROM ".$this->prefix()."admin where email='$email' AND admin_id!= '".$admin_id."' ";
	return $this->query($sql);
}

function savedEventByUser($limit,$user_id){

	$sql="SELECT *,E.event_id as id FROM ".$this->prefix()."user_saved_events S Inner join ".$this->prefix()."general_events E ON (E.event_id = S.event_id) Inner join ".$this->prefix()."venue V ON (E.event_venue = V.venue_id ) where S.admin_id= '".$user_id."' $limit ";
	$this->query($sql);
}


function savedEventByUserCount($user_id){

	$sql="SELECT * FROM ".$this->prefix()."user_saved_events S Inner join ".$this->prefix()."general_events E ON (E.event_id = S.event_id) Inner join ".$this->prefix()."venue V ON (E.event_venue = V.venue_id ) where S.admin_id= '".$user_id."'";
	$this->query($sql);
}

function delSavedEvents($saved_id){

	$sql="Delete FROM ".$this->prefix()."user_saved_events where saved_id='".$saved_id."' ";
	$this->query($sql);
}

function add_saved_events_by_user($event_id) {
	  $sql="INSERT ".$this->prefix()."user_saved_events SET 
			event_id='".$event_id."',
			admin_id='".$_SESSION['ses_admin_id']."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
	  return 1;
}	
function checkedSavedUserEvent($event_id){

	$sql="SELECT * FROM ".$this->prefix()."user_saved_events where event_id='".$event_id."' AND admin_id='".$_SESSION['ses_admin_id']."' ";
	$this->query($sql);
}

function getVenueState()
{
	$sql="SELECT * FROM ".$this->prefix()."state WHERE active_status = 1 order by state_name ";
	return $this->query($sql);
}
function getStateById($country_id)
{
	$sql="SELECT * FROM ".$this->prefix()."state where country_id  = '".$country_id."' order by state_name";
	//echo $sql;exit;
	return $this->query($sql);
}
function getCountyNameByState($stateId)
{
	$sql="SELECT * FROM ".$this->prefix()."county WHERE state_id = '".$stateId."' ORDER BY id ASC";
	return $this->query($sql);
}

// =========================  For event Page ================================

function getOrgEvent($event_id)
{
	$sql = "select * from ".$this->prefix()."general_events E  LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) LEFT join ".$this->prefix()."city C on (E.event_venue_city = C.id ) where E.event_id = '".$event_id."' ";
	//echo $sql;
	$this->query($sql);
}

function multi_event($event_id){

	$sql="SELECT *, ME.event_start_date_time as multi_start_time, ME.event_end_date_time as multi_end_time FROM ".$this->prefix()."general_events E Inner join ".$this->prefix()."final_multi_event ME on (E.event_id = ME.event_id ) LEFT join ".$this->prefix()."venue V on (ME.multi_venue = V.venue_id) LEFT join ".$this->prefix()."city C on (ME.multi_venue_city = C.id ) where ME.event_id='$event_id' ORDER BY ME.event_start_date_time ";
	//echo $sql;
	return $this->query($sql);
}


function sub_event($event_id){

	$sql="SELECT * from ".$this->prefix()."general_subevents where parent_id='$event_id'";
	//echo $sql;
	return $this->query($sql);
}


function subevent_datewise($event_id,$event_start_date_time,$next_date){

	$sql="SELECT *, ME.event_start_date_time as multi_start_time, ME.event_end_date_time as multi_end_time,C.city_name as city_name1,ME.event_name_en as sub_eve_en,ME.event_name_sp as sub_eve_sp FROM ".$this->prefix()."general_events E Inner join ".$this->prefix()."general_subevents ME on (E.event_id = ME.parent_id) LEFT join ".$this->prefix()."venue V on (ME.event_venue = V.venue_id) LEFT join ".$this->prefix()."city C on (ME.event_venue_city = C.id ) where ME.parent_id='".$event_id."' and ME.event_start_date_time > '".$event_start_date_time."' AND ME.event_start_date_time < '".$next_date."' ORDER BY ME.event_start_date_time ";
	//echo $sql."<br/><br/><br/>";
	return $this->query($sql);
}

function multi_event_datewise($event_id,$event_start_date_time,$next_date){

	$sql="SELECT *, ME.event_start_date_time as multi_start_time, ME.event_end_date_time as multi_end_time,C.city_name as city_name1 FROM ".$this->prefix()."general_events E Inner join ".$this->prefix()."final_multi_event ME on (E.event_id = ME.event_id ) LEFT join ".$this->prefix()."venue V on (ME.multi_venue = V.venue_id) LEFT join ".$this->prefix()."city C on (ME.multi_venue_city = C.id ) where ME.event_id='".$event_id."' and ME.event_start_date_time > '".$event_start_date_time."' AND ME.event_start_date_time < '".$next_date."' ORDER BY ME.event_start_date_time ";
	//echo $sql."<br/><br/><br/>";
	return $this->query($sql);
}

function getCurrMultiEve($event_id){

	$sql="SELECT ME.event_start_date_time as multi_start_time, ME.event_end_date_time as multi_end_time FROM ".$this->prefix()."general_events E Inner join ".$this->prefix()."final_multi_event ME on (E.event_id = ME.event_id ) where ME.event_id='".$event_id."' and ME.event_start_date_time > '".date("Y-m-d")."' ORDER BY ME.event_start_date_time LIMIT 1 ";
	//echo $sql."<br/><br/><br/>";
	return $this->query($sql);
}


function sub_event_datewise($parent_id,$event_start_date_time,$next_date){

	$sql="SELECT * from ".$this->prefix()."general_subevents where parent_id='".$parent_id."' AND event_start_date_time > '".$event_start_date_time."' AND event_start_date_time < '".$next_date."' ORDER BY event_start_date_time ";
	//echo $sql."<br/><br/><br/>";
	return $this->query($sql);
}


// =========================  For event Page ================================


function check_access($sub_id){
	$sql = "select * from ".$this->prefix()."general_subevents where event_id = ".$sub_id;
	return $this->query($sql);
}

function get_first_sub_eve_tm($parent_id){
	$sql = "select * from ".$this->prefix()."general_subevents where parent_id = ".$parent_id." order by event_id asc LIMIT 1";
	return $this->query($sql);
}

function get_last_sub_eve_tm($parent_id){
	$sql = "select * from ".$this->prefix()."general_subevents where parent_id = ".$parent_id." order by event_id desc LIMIT 1";
	return $this->query($sql);
}


#####################################FORGET PASSWORD MAIL STARTS###################################################

function forget_password_mail($email,$subject,$output,$from){


$this->admin_setting();
$this->next_record();
$from="verify@kpasapp.com";
$to=$email;
if($_SESSION['langSessId']=='eng') {
$subject='Request to reset your KPasapp password.';
}else{
$subject='Solicitud para reinicializar su contraseña KPasapp';
}
$com_name='Kpasapp';

$this->send_mail($from,$to,$subject,$output,$com_name);

}

#####################################FORGET PASSWORD MAIL ENDS###################################################

#####################################CHECK PASSWORD STARTS###################################################
	function checkpass($userid)
	{
		$sql="SELECT * FROM ".$this->prefix()."admin WHERE admin_id= '".$userid."'";
		$this->query($sql);
	}		
#####################################CHECK PASSWORD ENDS###################################################

#####################################CHANGE PASSWORD STARTS###################################################
	function changepass($userid,$password)
	{
		$sql="UPDATE ".$this->prefix()."admin SET rem_password = '".$password."', password = '".md5($password)."' WHERE admin_id= '".$userid."'";
		$this->query($sql);
	}		
#####################################CHANGE PASSWORD ENDS###################################################


function send_confrimation($email,$fname,$output,$subject){


$this->admin_setting();
$this->next_record();

$from="verify@kpasapp.com";
$to=$email;
//$subject='Confirm your new email address';
$com_name='Kpasapp';


$this->send_mail($from,$to,$subject,$output,$com_name);

}	

function add_more_emailid_user($email_address) {
	  $sql="INSERT ".$this->prefix()."admin_additional_email SET 
			email_address='".$email_address."',
			admin_id='".$_SESSION['ses_admin_id']."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
	  return 1;
}	

function add_more_phone_user($phone) {
	  $sql="INSERT ".$this->prefix()."admin_additional_phone SET 
			phone='".$phone."',
			admin_id='".$_SESSION['ses_admin_id']."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
	  return 1;
}

function getAllEmailId($admin_id){

	$sql="SELECT `email` as email,primary_email_stat as status FROM ".$this->prefix()."admin A where A.admin_id='".$admin_id."'
			UNION
		  SELECT `email_address` as email,primary_email_stat as status FROM ".$this->prefix()."admin_additional_email B where B.admin_id='".$admin_id."'";
	//echo $sql."<br/><br/><br/>";
	return $this->query($sql);
}

function getalternateEmail($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."admin_additional_email WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}	
function getalternateEmailc($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."admin_additional_email WHERE admin_id= '".$admin_id."' AND alt_email_status = 'Y'";
	$this->query($sql);
}
function getalternatephone($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."admin_additional_phone WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}

function getphn($admin_id)
{
	$sql="SELECT phone FROM ".$this->prefix()."admin WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}
function deleteAltEmail($altername_email){
	$sql="Delete FROM ".$this->prefix()."admin_additional_email where email_address='".$altername_email."' ";
	$this->query($sql);
}

function deleteAltEmail2($admin_id){
	$sql="Delete FROM ".$this->prefix()."admin_additional_email where admin_id='".$admin_id."' ";
	$this->query($sql);
}
function deleteAltPhone($altername_phone){
	$sql="Delete FROM ".$this->prefix()."admin_additional_phone where phone='".$altername_phone."' ";
	$this->query($sql);
}


function saveAltEmail($altername_email,$admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin_additional_email SET email_address = '".$altername_email."',alt_email_status = 'N' WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}	
	
function conf_alt_email($admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin_additional_email SET alt_email_status = 'Y' WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}
function makePrimary($altername_email,$old_email,$admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin_additional_email SET email_address = '".$old_email."' WHERE admin_id = '".$admin_id."'";
	$this->query($sql);
	
	$sql2="UPDATE ".$this->prefix()."admin SET email = '".$altername_email."', username = '".$altername_email."' WHERE admin_id = '".$admin_id."'";
	$this->query($sql2); 
}

function savephn($phone,$admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin SET phone = '".$phone."' WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}

function saveAltphn($altername_phone,$admin_id)
{
	$sql="UPDATE ".$this->prefix()."admin_additional_phone SET phone = '".$altername_phone."' WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}
function savepass($password,$md5pass,$admin_id)
{
	$sql ="UPDATE ".$this->prefix()."admin SET rem_password = '".$password."', password = '".$md5pass."' WHERE admin_id = '".$admin_id."'";
	$this->query($sql); 
}

function alt_email_change($email,$fname,$output,$subject){


$this->admin_setting();
$this->next_record();

$from="verify@kpasapp.com";
$to=$email;
//$subject='Confirm your new email address';
$com_name='Kpasapp';


$this->send_mail($from,$to,$subject,$output,$com_name);

}	
function make_primary_mail($email,$fname,$output,$subject){
	
	

$this->admin_setting();
$this->next_record();

$from="verify@kpasapp.com";
$to=$email;
$subject=$subject;
//$subject='Request to replace your primary email address with your alternate email address';
$com_name='Kpasapp';


$this->send_mail($from,$to,$subject,$output,$com_name);

}	

#==================================== Socail networks ====================================

function checkAlreadyadded($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."user_social_network WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}
/*function addSocialNetworkUser($facebook_page,$twitter_account,$youtube_channel,$google_account,$pinterest,$linkedin,$tumblr,$whatsapp,$instagram,$flickr,$admin_id) 
{
	  $sql="INSERT ".$this->prefix()."user_social_network SET 
			facebook_page='".$facebook_page."',
			twitter_account='".$twitter_account."',
			youtube_channel='".$youtube_channel."',
			google_account='".$google_account."',
			pinterest='".$pinterest."',
			linkedin='".$linkedin."',
			tumblr='".$tumblr."',
			whatsapp='".$whatsapp."',
			instagram='".$instagram."',
			flickr='".$flickr."',
			admin_id='".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}*/	

function addSocialNetworkUser($facebook_page,$facebook_page_text,$twitter_account,$twitter_account_text,$google_account,$google_account_text,$admin_id) 
{
	  $sql="INSERT ".$this->prefix()."user_social_network SET 
			facebook_page='".$facebook_page."',
			facebook_page_text='".$facebook_page_text."',
			twitter_account='".$twitter_account."',
			twitter_account_text='".$twitter_account_text."',
			google_account='".$google_account."',
			google_account_text='".$google_account_text."',
			admin_id='".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}

/*function editSocialNetworkUser($facebook_page,$twitter_account,$youtube_channel,$google_account,$pinterest,$linkedin,$tumblr,$whatsapp,$instagram,$flickr,$admin_id) 
{
	  $sql="UPDATE ".$this->prefix()."user_social_network SET 
			facebook_page='".$facebook_page."',
			twitter_account='".$twitter_account."',
			youtube_channel='".$youtube_channel."',
			google_account='".$google_account."',
			pinterest='".$pinterest."',
			linkedin='".$linkedin."',
			tumblr='".$tumblr."',
			whatsapp='".$whatsapp."',
			instagram='".$instagram."',
			flickr='".$flickr."'
			WHERE 
				admin_id = '".$admin_id."'";
	
	  $this->query($sql);	
}	*/
function editSocialNetworkUser($facebook_page,$facebook_page_text,$twitter_account,$twitter_account_text,$google_account,$google_account_text,$admin_id) 
{
	  $sql="UPDATE ".$this->prefix()."user_social_network SET 
			facebook_page='".$facebook_page."',
			facebook_page_text='".$facebook_page_text."',
			twitter_account='".$twitter_account."',
			twitter_account_text='".$twitter_account_text."',
			google_account='".$google_account."',
			google_account_text='".$google_account_text."'
			WHERE 
				admin_id = '".$admin_id."'";
	
	  $this->query($sql);	
}	


#==================================== Socail networks ====================================



#==================================== Prefernce ====================================

function checkPreference($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."user_preference WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}


function addPreferenceUser($weekly_newsletter,$daily_alert,$fan_alert,$spcl_event_alert,$send_notification_to_email,$send_notification_to_phone,$send_notification_to_links,$allCat,$county_id,$state,$admin_id) 
{
	  $sql="INSERT ".$this->prefix()."user_preference SET 
			weekly_newsletter='".$weekly_newsletter."',
			daily_alert='".$daily_alert."',
			fan_alert='".$fan_alert."',
			spcl_event_alert='".$spcl_event_alert."',
			send_notification_to_email='".$send_notification_to_email."',
			send_notification_to_phone='".$send_notification_to_phone."',
			send_notification_to_links='".$send_notification_to_links."',
			category='".$allCat."',
			state='".$state."',
			county='".$county_id."',
			admin_id='".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}
	
function editPreferenceUser($weekly_newsletter,$daily_alert,$fan_alert,$spcl_event_alert,$send_notification_to_email,$send_notification_to_phone,$send_notification_to_links,$allCat,$county_id,$state,$admin_id) 
{
	  $sql="UPDATE ".$this->prefix()."user_preference SET 
			weekly_newsletter='".$weekly_newsletter."',
			daily_alert='".$daily_alert."',
			fan_alert='".$fan_alert."',
			spcl_event_alert='".$spcl_event_alert."',
			send_notification_to_email='".$send_notification_to_email."',
			send_notification_to_phone='".$send_notification_to_phone."',
			send_notification_to_links='".$send_notification_to_links."',
			category='".$allCat."',
			state='".$state."',
			county='".$county_id."'
			WHERE 
				admin_id = '".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}	

#==================================== Prefernce ====================================


#==================================== Payment Section ====================================

function checkPaymentByuser($admin_id)
{
	$sql="SELECT * FROM ".$this->prefix()."user_payment WHERE admin_id= '".$admin_id."'";
	$this->query($sql);
}


function add_user_payment($dep_method,$dep_paypal_text,$dep_bank_acount,$dep_bank_account_no,$dep_bank_account_hold_name,$inter_bank_key,$routing_number,$swift_code,$dep_bank_account_country,$chrg_method,$charg_paypal_text,$chrg_credit_card_type,$chrg_credit_crd_no,$chrg_exp,$chrg_card_hold_name,$chrg_billing_zip,$chrg_bank_acount,$chrg_bank_account_no,$chrg_inter_bank_key,$chrg_routing_number,$chrg_swift_code,$chrg_bank_account_hold_name,$chrg_bank_account_country,$chrg_card_account_country,$admin_id) 
{
	  $sql="INSERT ".$this->prefix()."user_payment SET 
			dep_method='".$dep_method."',
			dep_paypal_text='".$dep_paypal_text."',
			dep_bank_acount='".$dep_bank_acount."',
			dep_bank_account_no='".$dep_bank_account_no."',
			dep_bank_account_hold_name='".$dep_bank_account_hold_name."',
			inter_bank_key='".$inter_bank_key."',
			routing_number='".$routing_number."',
			swift_code='".$swift_code."',
			dep_bank_account_country='".$dep_bank_account_country."',
			chrg_method='".$chrg_method."',
			charg_paypal_text='".$charg_paypal_text."',
			chrg_credit_card_type='".$chrg_credit_card_type."',
			chrg_credit_crd_no='".$chrg_credit_crd_no."',
			chrg_exp='".$chrg_exp."',
			chrg_card_hold_name='".$chrg_card_hold_name."',
			chrg_billing_zip='".$chrg_billing_zip."',
			chrg_bank_acount='".$chrg_bank_acount."',
			chrg_bank_account_no='".$chrg_bank_account_no."',
			chrg_inter_bank_key='".$chrg_inter_bank_key."',
			chrg_routing_number='".$chrg_routing_number."',
			chrg_swift_code='".$chrg_swift_code."',
			chrg_bank_account_hold_name='".$chrg_bank_account_hold_name."',
			chrg_bank_account_country='".$chrg_bank_account_country."',
			chrg_card_account_country='".$chrg_card_account_country."',
			admin_id='".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}
	
function edit_user_payment($dep_method,$dep_paypal_text,$dep_bank_acount,$dep_bank_account_no,$dep_bank_account_hold_name,$inter_bank_key,$routing_number,$swift_code,$dep_bank_account_country,$chrg_method,$charg_paypal_text,$chrg_credit_card_type,$chrg_credit_crd_no,$chrg_exp,$chrg_card_hold_name,$chrg_billing_zip,$chrg_bank_acount,$chrg_bank_account_no,$chrg_inter_bank_key,$chrg_routing_number,$chrg_swift_code,$chrg_bank_account_hold_name,$chrg_bank_account_country,$chrg_card_account_country,$admin_id) 
{
	  $sql="UPDATE ".$this->prefix()."user_payment SET 
			dep_method='".$dep_method."',
			dep_paypal_text='".$dep_paypal_text."',
			dep_bank_acount='".$dep_bank_acount."',
			dep_bank_account_no='".$dep_bank_account_no."',
			dep_bank_account_hold_name='".$dep_bank_account_hold_name."',
			inter_bank_key='".$inter_bank_key."',
			routing_number='".$routing_number."',
			swift_code='".$swift_code."',
			dep_bank_account_country='".$dep_bank_account_country."',
			chrg_method='".$chrg_method."',
			charg_paypal_text='".$charg_paypal_text."',
			chrg_credit_card_type='".$chrg_credit_card_type."',
			chrg_credit_crd_no='".$chrg_credit_crd_no."',
			chrg_exp='".$chrg_exp."',
			chrg_card_hold_name='".$chrg_card_hold_name."',
			chrg_billing_zip='".$chrg_billing_zip."',
			chrg_bank_acount='".$chrg_bank_acount."',
			chrg_bank_account_no='".$chrg_bank_account_no."',
			chrg_inter_bank_key='".$chrg_inter_bank_key."',
			chrg_routing_number='".$chrg_routing_number."',
			chrg_swift_code='".$chrg_swift_code."',
			chrg_bank_account_hold_name='".$chrg_bank_account_hold_name."',
			chrg_card_account_country='".$chrg_card_account_country."',
			chrg_bank_account_country='".$chrg_bank_account_country."'
			WHERE 
				admin_id = '".$admin_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}	

#==================================== Payment Section ====================================

#================================== Business Info start ==================================

function getBusinessInfoById($admin_id)
{
	$sql = "SELECT * FROM  ".$this->prefix()."admin_business WHERE admin_id=".$admin_id;
	//echo $sql;
	$this->query($sql);
	
}
	
function checkBusinessInfo($admin_id)
{
	$sql="SELECT * FROM `".$this->prefix()."admin_business` where `admin_id` = '".$admin_id."' ";
	return $this->query($sql);
}

function edit_admin_business_info($bus_name,$bus_display_name,$bus_email,$bus_phone,$bus_propphone,$bus_us_phone,$bus_nextel,$bus_country_id,$bus_country_code,$bus_language,$bus_province,$bus_county,$bus_city,$bus_address,$bus_postal_code,$tax_id_num,$act_event,$act_venue,$act_perform,$act_provider,$act_sponser,$website,$admin_id,$bus_mobile_code,$bus_phone_code)
{
	$sql="UPDATE ".$this->prefix()."admin_business SET busi_name = '".$bus_name."',
													   busi_display_name = '".$bus_display_name."',
													   busi_primary_email = '".$bus_email."',
													   busi_mobile = '".$bus_phone."',
													   busi_phone = '".$bus_propphone."',
													   busi_us_phone = '".$bus_us_phone."',
													   busi_nextel = '".$bus_nextel."',
													   busi_country_id = '".$bus_country_id."',
													   busi_lang = '".$bus_language."', 
													   busi_country_code = '".$bus_country_code."',
													   busi_province = '".$bus_province."',
													   busi_county = '".$bus_county."',
													   busi_city = '".$bus_city."',
													   busi_address = '".addslashes($bus_address)."',
													   busi_postal_code = '".$bus_postal_code."',
													   busi_tax_id_num = '".$tax_id_num."',
													   busi_acti_event_mgmt = '".$act_event."',
													   busi_acti_venue_mgmt = '".$act_venue."',
													   busi_acti_performer = '".$act_perform."',
													   busi_acti_provider = '".$act_provider."',
													   busi_acti_sponsor = '".$act_sponser."',
													   bus_mobile_code = '".$bus_mobile_code."',
													   bus_phone_code = '".$bus_phone_code."',
													   busi_website = '".$website."'										  
													  
													   where admin_id = '".$admin_id."'";
	//echo $sql;exit;
	$this->query($sql);
}

function add_admin_business_info($bus_name,$bus_display_name,$bus_email,$bus_phone,$bus_propphone,$bus_us_phone,$bus_nextel,$bus_country_id,$bus_country_code,$bus_language,$bus_province,$bus_county,$bus_city,$bus_address,$bus_postal_code,$tax_id_num,$act_event,$act_venue,$act_perform,$act_provider,$act_sponser,$website,$admin_id,$bus_mobile_code)
{
	$sql="INSERT INTO `".$this->prefix()."admin_business` SET `busi_name` = '".$bus_name."',
															  `busi_display_name` = '".$bus_display_name."',
														      `busi_primary_email` = '".$bus_email."',
														      `busi_mobile` = '".$bus_phone."',
														      `busi_phone` = '".$bus_propphone."',
														      `busi_us_phone` = '".$bus_us_phone."',
														      `busi_nextel` = '".$bus_nextel."',
														      `busi_country_id` = '".$bus_country_id."',
														      `busi_lang` = '".$bus_language."',
														      `busi_country_code` = '".$bus_country_code."',
														      `busi_province` = '".$bus_province."',
														      `busi_county` = '".$bus_county."',
														      `busi_city` = '".$bus_city."',
														      `busi_address` = '".addslashes($bus_address)."',
														      `busi_postal_code` = '".$bus_postal_code."',
														      `busi_tax_id_num` = '".$tax_id_num."',
														      `busi_acti_event_mgmt` = '".$act_event."',
														      `busi_acti_venue_mgmt` = '".$act_venue."',
														      `busi_acti_performer` = '".$act_perform."',
														      `busi_acti_provider` = '".$act_provider."',
														      `busi_acti_sponsor` = '".$act_sponser."',
														      `busi_website` = '".$website."',
															   bus_mobile_code = '".$bus_mobile_code."',
															  `admin_id` = '".$admin_id."' ";
	//echo $sql;exit;
	$this->query($sql);
}
#=================================== Business Info end ===================================

function add_to_cart($event_id,$multi_id,$ticket,$mx_price,$us_price,$unique,$tid,$payment) {
	  $sql="INSERT ".$this->prefix()."cart SET 
			event_id='".$event_id."',
			multi_id='".$multi_id."',
			ticket='".$ticket."',
			us_price='".$us_price."',
			mx_price='".$mx_price."',
			unique_id='".$unique."',
			ticket_id='".$tid."',
			payment='".$payment."',
			user_id='".$_SESSION['ses_admin_id']."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
	  $instid = mysql_insert_id();
	  return $instid;
}	


function update_cart($cid,$user_id,$unique)
{
	$sql="UPDATE ".$this->prefix()."cart SET user_id = '".$user_id."' where cart_id = '".$cid."' and unique_id = '".$unique."'";
	$this->query($sql);
}


function getCartDetails($admin_id)
{
	$sql="SELECT * FROM `".$this->prefix()."cart` where `user_id` = '".$admin_id."' group by `event_id`";
	$this->query($sql);
}

function getEventDetails($event_id)
{
	$sql = "select * from ".$this->prefix()."general_events E  LEFT join ".$this->prefix()."venue V on (E.event_venue = V.venue_id ) LEFT join ".$this->prefix()."city C on (E.event_venue_city = C.id ) LEFT join ".$this->prefix()."state S on (S.id = V.venue_state ) LEFT join ".$this->prefix()."countries T on (T.id = V.venue_county) where E.event_id = '".$event_id."' ";
	//echo $sql;
	$this->query($sql);
}

function getTicket($admin_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."cart C LEFT join ".$this->prefix()."final_tickets T on (C.ticket_id = T.ticket_id)  WHERE user_id = ".$admin_id;
	$this->query($sql);
}


function getCartCount($admin_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."cart  WHERE user_id = ".$admin_id;
	$this->query($sql);
}

function remove($tid){
	$sql="Delete FROM ".$this->prefix()."cart where cart_id='".$tid."' ";
	//echo $sql; exit;
	$this->query($sql);
}

function totalTicket($admin_id)
{
	$sql = "SELECT SUM(ticket) AS Total FROM ".$this->prefix()."cart WHERE user_id = ".$admin_id;
	$this->query($sql);
}

function totalAmount($admin_id,$type)
{
	if($type == 'mx'){
		$sql = "SELECT SUM(mx_price*ticket) AS Amt FROM ".$this->prefix()."cart WHERE user_id = ".$admin_id;
		$this->query($sql);
	}
	elseif($type == 'us'){
		$sql = "SELECT SUM(us_price*ticket) AS Amt FROM ".$this->prefix()."cart WHERE user_id = ".$admin_id;
		$this->query($sql);
	}
}


function add_order($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$event_id,$ticket,$payment,$ticket_id,$multi_id,$user_id) {
	  $sql="INSERT ".$this->prefix()."transaction SET 
			item_name='".$item_name."',
			item_number='".$item_number."',
			payment_status='".$payment_status."',
			payment_amount='".$payment_amount."',
			payment_currency='".$payment_currency."',
			txn_id='".$txn_id."',
			receiver_email='".$receiver_email."',
			payer_email='".$payer_email."',
			event_id='".$event_id."',
			ticket='".$ticket."',
			payment='".$payment."',
			ticket_id='".$ticket_id."',
			multi_id='".$multi_id."',
			user_id='".$user_id."'";
	
	  //echo $sql;exit;  
	  $this->query($sql);	
}	

function delete_order($user_id){
	$sql="Delete FROM ".$this->prefix()."cart where user_id='".$user_id."' ";
	$this->query($sql);
}

};
?>
