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

  
   print_r($httpParsedResponseAr); exit;
$ack = strtoupper($httpParsedResponseAr["ACK"]);

if($ack=="SUCCESS"){
	//update status DB
	$obj_edit->idea_update_status_id($_REQUEST['idea_id'],$httpParsedResponseAr);
	//user mail
	$obj->idea_detail_by_id($_REQUEST['idea_id']);
	$obj->next_record();
	//user detail
	$obj_user->userDetailById($obj->f('user_id'));
	$obj_user->next_record();
	
	// Create transation record for ideaPoster
	$obj_res_acc->add_res_admin_account($response_id,$_REQUEST['idea_id'],$obj->f('user_id'),$amount);
	
	//post idea mail
	$obj_mail->post_idea_receipt_mail($obj_user->f('email'),$obj_user->f('f_name'),$obj_user->f('username'),$obj->f('post_title'),$httpParsedResponseAr,$_REQUEST['idea_id']);
	
}
if($ack!="SUCCESS")  {
		
    $_SESSION['reshash']=$httpParsedResponseAr;
	$location = $obj_base_path->base_path()."/payment-idea/".$_REQUEST['idea_id'];
	header("Location: $location");
   }
   
   }
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Welcome to Ideacoil</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="maindiv_out">
<div id="maindiv">
<!--header-->
<?php include("include/header.php"); ?>
<!--header-->
</div>
<div class="clear"></div>
<div class="content">
<div style="float: none; margin: 0 auto; width: 130px;">
  <h1>Post Success </h1>
</div>
<div class="clear"></div>
<div class="contact_us">
<form action="" method="post" enctype="multipart/form-data">
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" style="padding: 24px 0;">
    
	<tr>
      <td>
      <div style="text-align:center; color:#06F; font-size:18px;font-weight:bold;width:200px;margin:0 auto;margin-top:100px">
      Thank you for submitting payment.</div></td>
    </tr>
   
    <tr>
      <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>    
   </table>
</form>   
</div>
</div>
<div class="clear"></div>
<div id="footerbg">

<script>
setInterval('location.href="<?php echo $obj_base_path->base_path(); ?>"', 4000);
</script>
<!--footer-->
<?php include("include/footer.php"); ?>
<!--footer-->
</div>
<div><img src="<?php echo $obj_base_path->base_path(); ?>/images/footer_bg.png" alt="" width="968" height="27" /></div>
<div class="clear"></div>
</div>
</body>
</html>





