<?php
include('include/user_inc.php');
$obj=new user;
if( isset($_POST['hid_sign']) )
{
	$faq = new User;
	$output = "Send Mail!";
	$from="amit.startafresh@gmail.com";
	$to=$_POST['email_cell'];
	$subject='Kpasapp Ticketing Account Information';
	$com_name='Kpasapp';
	
	
	send_mail($from,$to,$subject,$output,$com_name);
}


?>


	<form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete = "off">
    <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
        <table width="100%" align="center" border="1" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
        <td width="30%" style="text-align: left;">Email</td>
        <td width="70%"><input type="text" name="email_cell" id="email_cell" class="textbg_grey" value="" style="width:190px;"/><div id="email_err" style="color:red;"></div></td>
        </tr>
        
        <tr>
        <td><input type="submit" name="submit11" id="submit11" value="Submit" class="event_save"  style="text-align: left; margin-left: 0;"/></td>
        <td style="padding-top: 13px;">&nbsp; </td>
        </tr>
        </table>
    </form>
    
<?php
	function send_mail($from,$to,$subject,$body,$name='',$attachment=false,$filename=false,$reply_to=false){
		
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
	
	

?>    