<?php
$to = 'amit.unified@gmail.com';
$from = 'amit.startafresh@gmail.com';
$subject = "Success Payment";
/*$body = "Hits";
$obj_mail_try->send_mail($from,$to,$subject,$body); exit;*/


// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
	$req .= "&$key=$value";
}

// assign posted variables to local variables
$data['item_name']			= $_POST['item_name'];
$data['item_number'] 		= $_POST['item_number'];
$data['payment_status'] 	= $_POST['payment_status'];
$data['payment_amount'] 	= $_POST['mc_gross'];
$data['payment_currency']	= $_POST['mc_currency'];
$data['txn_id']				= $_POST['subscr_id'];
$data['receiver_email'] 	= $_POST['receiver_email'];
$data['payer_email'] 		= $_POST['payer_email'];
$data['user_id'] 			= $_POST['custom'];

/*$custArray = explode("-",$custStrng);
$data['hidden_tips_cost_ses'] 	= $custArray[11];*/

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);	

if (!$fp) 
{
	// HTTP ERROR
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
			
			if (strcmp($res, "VERIFIED") == 0) 
			{
				// Used for debugging
				//$obj_mail_try->send_mail($from,$to,$subject,"Verified Response<br />data = <pre>".print_r($_POST, true)."</pre>"); exit;
				mail($to,$subject,"Verified Response<br />data = <pre>".print_r($_POST, true)."</pre>",$from);exit;
		
			}
			 if (strcmp ($res, "INVALID") == 0) {
		
			// PAYMENT INVALID & INVESTIGATE MANUALY! 
			// E-mail admin or alert user
			
			// Used for debugging
			//@mail("you@youremail.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
		}		
	}	
fclose ($fp);


}	
	
?>