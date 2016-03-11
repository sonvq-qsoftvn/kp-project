<?php
// Response from Paypal
	
	//include file
	session_start();
	require("../class/db_mysql.inc");
	require("../class/user_class.php");
	//mail("amit.unified@gmail.com", "PAYPAL", "","admin@gmail.com");
	
	//create object
	$obj_edit=new user;
	$obj=new user;
	$obj_res_acc=new user;

	//mail("unified.subhrajyoti@gmail.com", "PAYPAL1", "","admin@gmail.com");exit;

	
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
$data['txn_id']				= $_POST['txn_id'];
$data['receiver_email'] 	= $_POST['receiver_email'];
$data['payer_email'] 		= $_POST['payer_email'];

$custStrng			 		= $_POST['custom'];
$custArray 					= explode("-",$custStrng);


$data['event_id'] 		= $custArray[0];
$data['ticket'] 	= $custArray['1'];
$data['payment'] 	= $custArray['2'];
$data['ticket_id'] 	= $custArray['3'];
$data['multi_id'] 	= $custArray['4'];
$data['user_id'] 	= $custArray['5'];
$data['cart_id'] 	= $custArray['6'];

$pay_date=date('l jS \of F Y h:i:s A');
$recipient="info@kcpasa.com";

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";	
//$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Host: www.paypal.com:443\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);	
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) 
{
	// HTTP ERROR
} 
else 
{
		
//mail("unified.subhrajyoti@gmail.com", "PAYPAL1", "","admin@gmail.com");
	fputs ($fp, $header . $req);
	//mail("unified.subhrajyoti@gmail.com", "PAYPAL2", "","admin@gmail.com");
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		//mail("unified.subhrajyoti@gmail.com", "PAYPAL1", "".$res."","admin@gmail.com");
		if (strcmp($res, "VERIFIED") == 0) 
		{
			// Used for debugging
			//@mail("unified.subhrajyoti@gmail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($data, true)."</pre>");exit;
	
			//update status DB
			//$obj_edit->idea_update_status_id($data['idea_id'],$_POST);
			
			function generateRandomString($length = 8) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randomString = '';
				for ($i = 0; $i < $length; $i++) {
				    $randomString .= $characters[rand(0, strlen($characters) - 1)];
				}
				return $randomString;
			    }
			
			$order_no = generateRandomString();
			
			//user detail
			$tid = $obj->add_order($data['item_name'],$data['item_number'],$data['payment_status'],$data['payment_amount'],$data['payment_currency'],$data['txn_id'],$data['receiver_email'],$data['payer_email'],$data['event_id'],$data['ticket'],$data['payment'],$data['ticket_id'],$data['multi_id'],$data['user_id'],$order_no,$data['cart_id']);
			
			$_SESSION['tid'] = $tid;
			
			$obj_gettkt=new user;
			$obj_gettkt->getTicketDetails($data['ticket_id']);
			$obj_gettkt->next_record();
			
			$new = $obj_gettkt->f('ticket_num')-$data['ticket'];
			
			$obj_updtkt=new user;
			$obj_updtkt->update_ticket($new,$data['ticket_id']);
			
			//$obj->delete_order($data['user_id']);    ********imp
			// Create transation record for ideaPoster
			//$obj_res_acc->add_res_admin_account($data['response_id'],$data['idea_id'],$obj->f('user_id'),$data['payment_amount']);
		
			
			//$message="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			//			  <tr>
			//				<td align='left' valign='top'>
			//					<fieldset style=' margin-left:8px; margin-right:8px;padding-left:10px; padding-right:10px;'>
			//						<LEGEND  ACCESSKEY=L><span class='heading_txt'>Billing / Shipping </span></LEGEND>
			//						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			//			  <tr>
			//				<td width='50%' align='left' valign='middle' ><table width='90%' border='1' align='left' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>Name:&nbsp;</td>
			//					<td width='50%' align='left' valign='middle'>".$data['item_name']."</td>
			//				  </tr>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>Address:&nbsp;</td>
			//					<td width='50%' align='left' valign='middle'>".$payer_address."</td>
			//				  </tr>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>Phone:&nbsp;</td>
			//					<td width='50%' align='left' valign='middle'>".$payer_phone."</td>
			//				  </tr>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'> Payer Email:&nbsp;</td>
			//					<td width='50%' align='left' valign='middle'>".$data['payer_email']."</td>
			//				  </tr>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>&nbsp;</td>
			//					<td width='50%' align='left' valign='middle'>&nbsp;</td>
			//				  </tr>
			//				</table></td>
			//				<td width='50%' align='right' valign='top'><table width='90%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>Order No. </td>
			//					<td width='50%' class='td'>".$invoice."</td>
			//				  </tr>
			//				  <tr>
			//					<td width='50%' align='right' valign='middle' class='td'>Order Date </td>
			//					<td width='50%' class='td'>".$pay_date."</td>
			//				  </tr>
			//			
			//				</table></td>
			//			  </tr>
			//			  
			//			  
			//			<tr>
			//				<td width='50%' align='left' valign='middle' >&nbsp;</td>
			//				<td width='50%'>&nbsp;</td>
			//			  </tr>
			//			  <tr>
			//				<td colspan='2' align='left' valign='middle'><table width='100%' border='1' align='left' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
			//				  <tr>
			//					<td width='9%' class='td'>Sl.No</td>
			//					<td width='38%' class='td'>Product Name </td>
			//					<td width='19%' class='td'>Unit</td>
			//					<td width='18%' class='td'>Unit Price </td>
			//					<td width='16%' class='td'>Amount</td>
			//				  </tr>
			//				  <tr>
			//					<td class='td'>1</td>
			//					<td class='td'>".$item_name."</td>
			//					<td class='td'>".$quantity."</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//				  </tr>
			//				  <tr>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//				  </tr>
			//				  <tr>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//				  </tr>
			//				  <tr>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//					<td class='td'>&nbsp;</td>
			//				  </tr>
			//				</table></td>
			//				</tr>
			//			  <tr>
			//				<td width='50%' align='right' valign='middle'>&nbsp;</td>
			//				<td width='50%'>&nbsp;</td>
			//			  </tr>
			//			  <tr>
			//				<td align='right' valign='middle'>&nbsp;</td>
			//				<td><table width='90%' border='0' align='right' cellpadding='0' cellspacing='0'>
			//				  <tr>
			//					<td width='45%' align='right' valign='middle' class='td'>Total</td>
			//					<td width='45%' align='left' valign='middle' class='td'> $".$data['payment_amount']."</td>
			//				  </tr>
			//				</table></td>
			//			  </tr>
			//			  <tr>
			//				<td align='right' valign='middle'>&nbsp;</td>
			//				<td>&nbsp;</td>
			//			  </tr>
			//			</table>
			//			
			//				  </fieldset>
			//				</td>
			//			  </tr>
			//			  <tr>
			//				<td align='left' valign='top'>&nbsp;</td>
			//			  </tr>
			//			  <tr>
			//				<td align='left' valign='top'>&nbsp;</td>
			//			  </tr>
			//			  <tr>
			//				<td align='left' valign='top'>&nbsp;</td>
			//			  </tr>
			//			</table>";
			//	
			//	$subject="Payment Confirmation";
			//	$headers  = 'MIME-Version: 1.0' . "\r\n";
			//	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//	$headers .= 'From: info@abcd.com' . "\r\n";
			//	$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
			//	@mail($recipient, $subject, $message, $headers);
			//	@mail('unified.subhrajyoti@gmail.com', $subject, $message, $headers);
						
		}
		
		if (strcmp ($res, "INVALID") == 0) {
	
		// PAYMENT INVALID & INVESTIGATE MANUALY! 
		// E-mail admin or alert user
		
		$message = '
			Dear Administrator,
			A payment has been made but is flagged as INVALID.
			Please verify the payment manualy and contact the buyer.
			Buyer Email: '.$data['payer_email'].'
			';
		// Used for debugging
		@mail($recipient, "PAYPAL DEBUGGING".$message, "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");

	}		
}	
fclose ($fp);
}	
	
?>