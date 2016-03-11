<?php
//payment success page
include('include/user_inc.php');

//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();

$environment = 'sandbox';	// or 'beta-sandbox' or 'live'


//print_r($_POST); exit;

if($_POST['custom']=='' && $_POST['mode_name']=="directpayment"){

function PPHttpPost($methodName_, $nvpStr_) {
	global $environment;

	// Set up your API credentials, PayPal end point, and API version.
	$API_UserName = urlencode('amit.u_1346333240_biz_api1.gmail.com');
	$API_Password = urlencode('1346333292');
	$API_Signature = urlencode('An5ns1Kso7MWUdW4ErQKJJJ4qi4-A.MTuGLzYyFk8qcsnLH4d-Dzp.iZ');


	/*$API_UserName = urlencode('payments_api1.ideacoil.com');
	$API_Password = urlencode('PWQHVJUYQFB2XT9N');
	$API_Signature = urlencode('AFcWxV21C7fd0v3bYYYRCpSSRl31AQia-wtmkw-U6MdQ.ffSIxBljeWv');*/

	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}

/**
 * Get required parameters from the web form for the request
 */
$response_id =urlencode( $_POST['response_id']);
$firstName =urlencode( $_POST['firstname']);
$lastName =urlencode( $_POST['lastName']);
$creditCardType =urlencode( $_POST['cardtype']);
$creditCardNumber = urlencode($_POST['cardnumber']);
$expDateMonth =urlencode( $_POST['cardmonth']);

$ticket =urlencode( $_POST['ticket']);
$ticket_id =urlencode( $_POST['ticket_id']);
$multi_id =urlencode( $_POST['multi_id']);
$user_id =urlencode( $_POST['user_id']);
$name =urlencode( $_POST['name']);
$cart_id =urlencode( $_POST['cart_id']);
//$paymentType =urlencode( $_POST['paymentType']);

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['cardyear']);
$cvv2Number = urlencode($_POST['cardcvv']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);
//$currencyCode=urlencode($_POST['currency']);
$currencyCode="USD";
$paymentType ='Sale';

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
   $nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
			"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
			"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
			
// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr);

  
//print_r($httpParsedResponseAr); exit;
$data = $httpParsedResponseAr;
$ack = strtoupper($httpParsedResponseAr["ACK"]);

if($ack=="SUCCESS"){
	//update status DB
	//$obj_edit->idea_update_status_id($_REQUEST['idea_id'],$httpParsedResponseAr);
	//user mail
	function generateRandomString($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	    }
	
	$order_no = generateRandomString();
	
	$tid = $obj_edit->add_order(urldecode($name),'',$data['ACK'],urldecode($data['AMT']),$data['CURRENCYCODE'],$data['TRANSACTIONID'],'','',$_REQUEST['event'],$ticket,$paymentType,$ticket_id,$multi_id,$user_id,$order_no,$cart_id);
	
	$_SESSION['tid'] = $tid;
	
	$obj_gettkt=new user;
	$obj_gettkt->getTicketDetails($ticket_id);
	$obj_gettkt->next_record();
	
	$new = $obj_gettkt->f('ticket_num')-$ticket;
	
	$obj_updtkt=new user;
	$obj_updtkt->update_ticket($new,$ticket_id);
	
}
if($ack!="SUCCESS")  {
	//echo "hii"; exit;	
    $_SESSION['reshash']=$httpParsedResponseAr;
	$location = $obj_base_path->base_path()."/payment/".$_REQUEST['event'];
	header("Location: $location");
   }
   
   }
   
?>
<?php
	$obj_user->user_details($obj_order_details->f('user_id'));
	$obj_user->next_record();
	
	$recipient = $obj_user->f('email');
	echo "recipient: " .$recipient., "<br>";
	
	if($_SESSION['langSessId']=='eng') {
		$name = $objEvent->f('event_name_en');
	}
	else
	{
		$name = $objEvent->f('event_name_sp');
	}
	echo $name;
	
	if($_SESSION['langSessId']=='eng') {
		$tname = $obj_ticket->f('ticket_name_en');
	  }
	  elseif($_SESSION['langSessId']=='spn')
	  {
	    $tname = $obj_ticket->f('ticket_name_sp');
	  }
	echo $tname;
	
	//$date = date("F j, Y, g:i a",strtotime($objEvent->f('event_start_date_time')));
	$showdate = date("F j, Y",strtotime($date))." ".$start;
	echo $showdate;
	$message="
	Dear ".$obj_user->f('fname')." <br>
	
	Thank you for your order.<br><br> 
	Your order reference number is: <strong>".$obj_order_details->f('order_no')."</strong> <br><br>
	
	
	Please keep it securely, as it will be required when you check in.<br> 
	Please print this message and present it to check in at the event.<br>
	You ordered <br><br>
	
	".$obj_order_details->f('ticket')." ".$tname.", ".$name.", ".$showdate." <br><br>
	
	Thank you for using KPasapp.com, your passport to all the events of Baja California Sur <br><br>

	We look forward to seeing you at ".$name.", <br><br>
	
	The KPasapp Team<br>
	Do not reply to this email.<br>
	Email us at info@kpasapp.com if you require additional assistance.<br>
	";
	
	$subject="Order confirmation for ".$name."!";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: info@kpasapp.com' . "\r\n";
	//$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	@mail($recipient, $subject, $message, $headers);
	//@mail('unified.subhrajyoti@gmail.com', $subject, $message, $headers);
?>
