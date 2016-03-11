<?php
/*
************************************ PAYPAL STANDARD FUNCTIONS ***************************************************
*/
/*	$AutoRedirect = True, if we want it to redirect to paypal without button click. Else set False.	
	$PayMode = Live / Test
	$MerchantEmail = Merchant Email Address
	$PaymentType = 	1 -> Single-item payments with Buy Now Buttons
					2 -> Charity payments with Donation Buttons
				  	3 -> Recurring payments with Subscription Buttons
				  	4 -> Multi-item payments with the PayPal Shopping Cart
				  	5 -> Submitting third-party shopping cart contents with Cart Upload				  				  
	$ItemNumber = This has to be an array for PaymentType = 5.
	$ItemName = This has to be an array for PaymentType = 5.
	$Quantity = This has to be an array for PaymentType = 5.
	$Amount = This has to be an array for PaymentType = 5.
	$NotifyUrl = Instant Payment Notification URL
	$ReturnUrl = Return URL after payment.
	$CustomVal = Custom value to fetch in IPN script.
*/

function goPaypalStandard ($AutoRedirect, $PayMode, $MerchantEmail, $PaymentType, $ItemNumber, $ItemName, $Quantity, $Amount, $NotifyUrl, $ReturnUrl, $CustomVal, $TaxVal) {
	$paypalActionUrl = ($PayMode=="Live")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr";
		
	$paypalFormCode = "<form name=\"__frmPaypal\" method=\"POST\" action=\"$paypalActionUrl\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"business\" value=\"$MerchantEmail\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"currency_code\" value=\"USD\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"notify_url\" value=\"$NotifyUrl\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"return\" value=\"$ReturnUrl\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"no_note\" value=\"1\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"no_shipping\" value=\"1\">\n";
	$paypalFormCode .= "<input type=\"hidden\" name=\"custom\" value=\"$CustomVal\">\n";
	switch($PaymentType) {
		case 1:
			$paypalFormCode .= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_number\" value=\"$ItemNumber\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_name\" value=\"$ItemName\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"amount\" value=\"$Amount\">\n";
			break;
		case 2:	
			$paypalFormCode .= "<input type=\"hidden\" name=\"cmd\" value=\"_donations\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_number\" value=\"$ItemNumber\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_name\" value=\"$ItemName\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"amount\" value=\"$Amount\">\n";
			break;
		case 3:
			$paypalFormCode .= "<input type=\"hidden\" name=\"cmd\" value=\"_subscribe\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_name\" value=\"$ItemName\">\n";
			break;
		case 4:
			$paypalFormCode .= "<input type=\"hidden\" name=\"cmd\" value=\"_cart\">\n";			
			$paypalFormCode .= "<input type=\"hidden\" name=\"add\" value=\"1\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"item_name\" value=\"$ItemName\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"amount\" value=\"$Amount\">\n";			
			break;
		case 5:
			$paypalFormCode .= "<input type=\"hidden\" name=\"cmd\" value=\"_cart\">\n";
			$paypalFormCode .= "<input type=\"hidden\" name=\"upload\" value=\"1\">\n";
			$i = 1;
			foreach($ItemName as $ItemNameVal) $paypalFormCode .= "<input type=\"hidden\" name=\"item_name_".($i++)."\" value=\"$ItemNameVal\">\n";
			$i = 1;
			foreach($Quantity as $QuantityVal) $paypalFormCode .= "<input type=\"hidden\" name=\"quantity_".($i++)."\" value=\"$QuantityVal\">\n";
			$i = 1;
			foreach($Amount as $AmountVal) $paypalFormCode .= "<input type=\"hidden\" name=\"amount_".($i++)."\" value=\"$AmountVal\">\n";
			if ($TaxVal) $paypalFormCode .= "<input type=\"hidden\" name=\"tax_cart\" value=\"$TaxVal\">\n";			
	}
	if (!$AutoRedirect) $paypalFormCode .= "<input type=\"submit\" value=\"Proceed for Payment\">\n";
	$paypalFormCode .= "</form>\n";
	if ($AutoRedirect) {
		$paypalFormCode .= "<script language=\"Javascript\" type=\"text/javascript\">\n";
		$paypalFormCode .= "document.__frmPaypal.submit();\n";		
		$paypalFormCode .= "</script>\n";
		echo $paypalFormCode;
	}
	else return $paypalFormCode;		
}

function captureIPN($PayMode) {
	$paypalDomain = ($PayMode=="Live")?"www.paypal.com":"www.sandbox.paypal.com";
	
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}	
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Host: $paypalDomain\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= 'Content-Length: ' . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ('ssl://'.$paypalDomain, "443", $errno, $errstr, 30);
	if ($fp) {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			$res = trim($res);
			//paypalLog("WHILE... - " . $res);
			if (strcmp($res,"VERIFIED") == 0) {
				if ($_POST['payment_status'] == "Completed" || $_POST['payment_status'] == "Pending") {
					ipnSuccess(); //This function needs to be defined within IPN script.
				}
			}
	}
		fclose ($fp);
	}		
}

function paypalLog($log) {
	$fp = fopen("paypal.debug.log", "a");
	fputs($fp, $log."\n");
	fclose($fp);
}

/*
************************************ PAYFLOW PRO FUNCTIONS ***************************************************
*/
function processPayflowPro( $PayflowSettings, $paymentType, $paymentAmount, $creditCardType, $creditCardNumber, $expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, $countryCode, $currencyCode, $orderdescription,$SHIPTOCITY,$SHIPTOCOUNTRY,$SHIPTOFIRSTNAME,$SHIPTOLASTNAME,$SHIPTOMIDDLENAME,$SHIPTOSTATE,$SHIPTOSTREET,$SHIPTOZIP,$EMAIL ) {
	global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
	global $API_Endpoint, $API_User, $API_Password, $API_Vendor, $API_Partner, $Env;

	//Defines all the global variables and the wrapper functions 
	//********************************************/
	$PROXY_HOST = '127.0.0.1';
	$PROXY_PORT = '808';
	
	//$Env = "live";//"pilot";
	$Env = $PayflowSettings['Env'];
	
	//'------------------------------------
	//' Payflow API Credentials 
	//'------------------------------------
	$API_User=$PayflowSettings['API_User'];
	$API_Password=$PayflowSettings['API_Password'];
	$API_Vendor=$PayflowSettings['API_Vendor'];
	$API_Partner=$PayflowSettings['API_Partner'];
	
	/*	
	' Define the PayPal Redirect URLs.  
	' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
	' 	change the URL depending if you are testing on the sandbox or the live PayPal site
	'
	' For the sandbox, the URL is https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=
	' For the live site, the URL is https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=
	*/
		
	if ($Env == "pilot") 
	{
		$API_Endpoint = "https://pilot-payflowpro.verisign.com";
		$PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
	}
	else
	{
		$API_Endpoint = "https://payflowpro.verisign.com";
		$PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
	}
	
	$USE_PROXY = false;
	
	$resArray = DirectPayment ( $paymentType, $finalPaymentAmount, $creditCardType, $creditCardNumber, $expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, $countryCode, $currencyCode, $orderDescription,$SHIPTOCITY,$SHIPTOCOUNTRY,$SHIPTOFIRSTNAME,$SHIPTOLASTNAME,$SHIPTOMIDDLENAME,$SHIPTOSTATE,$SHIPTOSTREET,$SHIPTOZIP,$EMAIL );
	$ack = $resArray["RESULT"];
	
	return ($ack!='0')?false:true;	
}
/********************************************
/* An express checkout transaction starts with a token, that
   identifies to PayPal your transaction
   In this example, when the script sees a token, the script
   knows that the buyer has already authorized payment through
   paypal.  If no token was found, the action is to send the buyer
   to PayPal to first authorize payment
   */

/*   
'-------------------------------------------------------------------------------------------------------------------------------------------
' Purpose: 	Prepares the parameters for the shortcut implementation of SetExpressCheckout
' Inputs:  
'		paymentAmount:  	Total value of the shopping cart
'		currencyCodeType: 	Currency code value
'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
'--------------------------------------------------------------------------------------------------------------------------------------------	
*/
function CallShortcutExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL) 
{
	//------------------------------------------------------------------------------------------------------------------------------------
	// Construct the parameter string that describes SetExpressCheckout in the shortcut implementation

	$nvpstr = "&TENDER=P&ACTION=S";
	if ("Sale" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	elseif ("Authorization" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=A";
	}
	else //default to sale
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	$nvpstr .= "&AMT=" . $paymentAmount;
	$nvpstr .= "&CURRENCY=" . $currencyCodeType;
	$nvpstr .= "&CANCELURL=" . $cancelURL;
	$nvpstr .= "&RETURNURL" . $returnURL;
	
	$_SESSION["currencyCodeType"] = $currencyCodeType;	  
	$_SESSION["PaymentType"] = $paymentType;

	// Each part of Express Checkout must have a unique request ID.
	$unique_id = generateGUID();
	
	//'--------------------------------------------------------------------------------------------------------------- 
	//' Make the API call to Payflow
	//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
	//' If an error occured, show the resulting errors
	//'---------------------------------------------------------------------------------------------------------------
	$resArray = hash_call($nvpstr,$unique_id);
	$ack = strtoupper($resArray["RESULT"]);
	if($ack=="0")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['TOKEN']=$token;
	}
	
	   
	return $resArray;
}

/*   
'-------------------------------------------------------------------------------------------------------------------------------------------
' Purpose: 	Prepares the parameters for the mark implementation of SetExpressCheckout
' Inputs:  
'		paymentAmount:  	Total value of the shopping cart
'		currencyCodeType: 	Currency code value the PayPal API
'		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
'		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
'		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
'		shipToName:			the Ship to name entered on the merchant's site
'		shipToStreet:		the Ship to Street entered on the merchant's site
'		shipToCity:			the Ship to City entered on the merchant's site
'		shipToState:		the Ship to State entered on the merchant's site
'		shipToCountryCode:	the Code for Ship to Country entered on the merchant's site
'		shipToZip:			the Ship to ZipCode entered on the merchant's site
'		shipToStreet2:		the Ship to Street2 entered on the merchant's site
'		phoneNum:			the phoneNum  entered on the merchant's site
'--------------------------------------------------------------------------------------------------------------------------------------------	
*/
function CallMarkExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, 
								  $cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
								  $shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum
								) 
{
	//------------------------------------------------------------------------------------------------------------------------------------
	// Construct the parameter string that describes SetExpressCheckout in the mark implementation

	$nvpstr = "&TENDER=P&ACTION=S";
	if ("Sale" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	elseif ("Authorization" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=A";
	}
	else //default to sale
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	$nvpstr .= "&AMT=" . $paymentAmount;
	$nvpstr .= "&CURRENCY=" . $currencyCodeType;
	$nvpstr .= "&CANCELURL=" . $cancelURL;
	$nvpstr .= "&RETURNURL" . $returnURL;
	$nvpstr .= "&SHIPTOSTREET=" . $shipToStreet;
	$nvpstr .= "&SHIPTOSTREET2=" . $shipToStreet2;
	$nvpstr .= "&SHIPTOCITY=" . $shipToCity;
	$nvpstr .= "&SHIPTOSTATE=" . $shipToState;
	$nvpstr .= "&SHIPTOCOUNTRY=" . $shipToCountryCode;
	$nvpstr .= "&SHIPTOZIP=" . $shipToZip;
	$nvpstr .= "&ADDROVERRIDE=1";	// address override
	
	$_SESSION["currencyCodeType"] = $currencyCodeType;	  
	$_SESSION["PaymentType"] = $paymentType;

	// Each part of Express Checkout must have a unique request ID.
	$unique_id = generateGUID();
	
	//'--------------------------------------------------------------------------------------------------------------- 
	//' Make the API call to Payflow
	//' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.  
	//' If an error occured, show the resulting errors
	//'---------------------------------------------------------------------------------------------------------------
	$resArray = hash_call($nvpstr,$unique_id);
	$ack = strtoupper($resArray["RESULT"]);
	if($ack=="0")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['TOKEN']=$token;
	}
	   
	return $resArray;
}

/*
'-------------------------------------------------------------------------------------------
' Purpose: 	Prepares the parameters for GetExpressCheckoutDetails.
'
' Inputs:  
'		None
' Returns: 
'		The NVP Collection object of the GetExpressCheckoutDetails response.
'-------------------------------------------------------------------------------------------
*/
function GetShippingDetails( $token )
{
	//'--------------------------------------------------------------
	//' At this point, the buyer has completed authorizing the payment
	//' through Payflow.  The function will call Payflow to obtain the details
	//' of the authorization, incuding any shipping information of the
	//' buyer.  Remember, the authorization is not a completed transaction
	//' at this state - the buyer still needs an additional step to finalize
	//' the transaction
	//'--------------------------------------------------------------
   
	//'---------------------------------------------------------------------------
	//' Build a second API request to Payflow, using the token as the
	//'  ID to get the details on the payment authorization
	//'---------------------------------------------------------------------------
	$paymentType = $_SESSION['paymentType'];
	$nvpstr = "&TOKEN=" . $token . "&TENDER=P&ACTION=G";
	if ("Sale" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	elseif ("Authorization" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=A";
	}
	else //default to sale
	{
		$nvpstr .= "&TRXTYPE=S";
	}

	// Each part of Express Checkout must have a unique request ID.
	$unique_id = generateGUID();
	
	//'---------------------------------------------------------------------------
	//' Make the API call and store the results in an array.  
	//'	If the call was a success, show the authorization details, and provide
	//' 	an action to complete the payment.  
	//'	If failed, show the error
	//'---------------------------------------------------------------------------
	$resArray = hash_call($nvpstr,$unique_id);
	$ack = strtoupper($resArray["RESULT"]);
	if($ack == "0")
	{	
		$_SESSION['payer_id'] =	$resArray['PAYERID'];
	} 
	return $resArray;
}
	
/*
'-------------------------------------------------------------------------------------------------------------------------------------------
' Purpose: 	Prepares the parameters for DoExpressCheckoutPayment.
'
' Inputs:  
'		FinalPaymentAmt - the total transaction amount.
' Returns: 
'		The NVP Collection object of the DoExpressCheckoutPayment response.
' Note:
'       There are other optional parameters that can be passed to DoExpressCheckoutPayment that are not used here.
'       See Table 7.6 in http://www.paypal.com/en_US/pdf/PayflowPro_Guide.pdf for details on the optional parameters.
'--------------------------------------------------------------------------------------------------------------------------------------------	
*/
function ConfirmPayment( $FinalPaymentAmt )
{
	/* Gather the information to make the final call to
	   finalize the PayPal payment.  The variable nvpstr
	   holds the name value pairs
	   */
	
	//Format the other parameters that were stored in the session from the previous calls	
	$token 				= $_SESSION['token'];
	$paymentType 		= $_SESSION['paymentType'];
	$currencyCodeType 	= $_SESSION['currencyCodeType'];
	$payerID 			= $_SESSION['payer_id'];

	$serverName 		= $_SERVER['SERVER_NAME'];

	$nvpstr = "&TENDER=P&ACTION=D";
	if ("Sale" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	elseif ("Authorization" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=A";
	}
	else //default to sale
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	
	$nvpstr .= "&TOKEN=" . $token . "&PAYERID=" . $payerID . "&AMT=" . $FinalPaymentAmt;
	$nvpstr .= '&CURRENCY=' . $currencyCodeType . '&IPADDRESS=' . $serverName;

	// Each part of Express Checkout must have a unique request ID.
	// Save it as a session variable in order to avoid duplication
	$unique_id = isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : generateGUID();
	$_SESSION['unique_id'] = $unique_id;
	
	 /* Make the call to PayPal to finalize payment
		If an error occured, show the resulting errors
		*/
	$resArray = hash_call($nvpstr,$unique_id);

	/* Display the API response back to the browser.
	   If the response from PayPal was a success, display the response parameters'
	   If the response was an error, display the errors received using APIError.php.
	   */
	$ack = strtoupper($resArray["RESULT"]);

	return $resArray;
}

/*
'-------------------------------------------------------------------------------------------------------------------------------------------
' Purpose: 	Prepares the parameters for direct payment (credit card) and makes the call.
'
' Inputs:  
'		paymentType: 		paymentType has to be one of the following values: Sale or Order
'		paymentAmount:  	Total value of the shopping cart
'		creditCardType		Credit card type has to one of the following values: Visa or MasterCard or Discover or Amex or Switch or Solo 
'		creditCardNumber	Credit card number
'		expDate				Credit expiration date
'		cvv2				CVV2
'		firstName			Customer's First Name
'		lastName			Customer's Last Name
'		street				Customer's Street Address
'		city				Customer's City
'		state				Customer's State				
'		zip					Customer's Zip					
'		countryCode			Customer's Country represented as a PayPal CountryCode
'		currencyCode		Customer's Currency represented as a PayPal CurrencyCode
'		orderdescription	Short textual description of the order
'
' Note:
'		There are other optional inputs for credit card processing that are not presented here.
'		For a complete list of inputs available, please see the documentation here for US and UK:
'		http://www.paypal.com/en_US/pdf/PayflowPro_Guide.pdf
'		https://www.paypal.com/en_GB/pdf/PP_WebsitePaymentsPro_IntegrationGuide.pdf
'		
' Returns: 
'		The NVP Collection object of the Response.
'--------------------------------------------------------------------------------------------------------------------------------------------	
*/
function DirectPayment( $paymentType, $paymentAmount, $creditCardType, $creditCardNumber, $expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, $countryCode, $currencyCode, $orderdescription,$SHIPTOCITY,$SHIPTOCOUNTRY,$SHIPTOFIRSTNAME,$SHIPTOLASTNAME,$SHIPTOMIDDLENAME,$SHIPTOSTATE,$SHIPTOSTREET,$SHIPTOZIP,$EMAIL )
{
	// Construct the parameter string that describes the credit card payment
	$replaceme = array("-", " ");
	$card_num = str_replace($replaceme,"",$creditCardNumber);
	$order_num = $orderdescription;
	
	$nvpstr = "&TENDER=C";
	if ("Sale" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=S";
	}
	elseif ("Authorization" == $paymentType)
	{
		$nvpstr .= "&TRXTYPE=A";
	}
	else //default to sale
	{
		$nvpstr .= "&TRXTYPE=S";
	}

	// Other information
	$ipaddr = $_SERVER['REMOTE_ADDR'];
			
	$nvpstr .= '&ACCT='.$card_num.'&EXPDATE='.$expDate.'&ACCTTYPE='.$creditCardType.'&AMT='.$paymentAmount.'&CURRENCY='.$currencyCode;
	if($cvv2!="")		 
		$nvpstr .= '&CVV2='.$cvv2;
	$nvpstr .= '&EMAIL='.$EMAIL.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$street.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRY='.$countryCode;
	
	$nvpstr .= '&SHIPTOCOUNTRY='.$SHIPTOCOUNTRY.'&SHIPTOFIRSTNAME='.$SHIPTOFIRSTNAME;
	$nvpstr .= '&SHIPTOLASTNAME='.$SHIPTOLASTNAME;
	$nvpstr .= '&SHIPTOSTATE='.$SHIPTOSTATE.'&SHIPTOSTREET='.$SHIPTOSTREET.'&SHIPTOCITY='.$SHIPTOCITY.'&SHIPTOZIP='.$SHIPTOZIP;
	$nvpstr .= '&CLIENTIP='.$ipaddr.'&INVNUM='.$order_num.'&ORDERDESC='.$orderdescription;
	$nvpstr .= '&VERBOSITY=MEDIUM';
	$unique_id = date('ymd-H').rand(1000,9999);		
	$resArray = hash_call($nvpstr,$unique_id);
	return $resArray;
}

/**
  '-------------------------------------------------------------------------------------------------------------------------------------------
  * hash_call: Function to perform the API call to Payflow
  * @nvpStr is nvp string.
  * returns an associtive array containing the response from the server.
  '-------------------------------------------------------------------------------------------------------------------------------------------
*/
function hash_call($nvpStr,$unique_id)
{
	//declaring of global variables						
	global $API_Endpoint, $API_User, $API_Password, $API_Vendor, $API_Partner,$Env;
	global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
	global $gv_ApiErrorURL;
	$nvpreq = "USER=".$API_User.'&VENDOR='.$API_Vendor.'&PARTNER='.$API_Partner.'&PWD='.$API_Password . $nvpStr; 				
	$len = strlen($nvpStr);
	$headers[] = "Content-Type: text/namevalue";
	$headers[] = "Content-Length: ".$len;
	// Set the server timeout value to 45, but notice below in the cURL section, the timeout
	// for cURL is set to 90 seconds.  Make sure the server timeout is less than the connection.
	$headers[] = "X-VPS-CLIENT-TIMEOUT: 45";
	$headers[] = "X-VPS-REQUEST-ID:" . $unique_id;
	
	// set the host header
	if ($Env == "pilot") 
	{
		$headers[] = "Host: pilot-payflowpro.verisign.com";
	}
	else
	{
		$headers[] = "Host: payflowpro.verisign.com";
	}
	
	//setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$API_Endpoint);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	//turning off the server and peer verification(TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 90); 		// times out after 90 secs
	curl_setopt($ch, CURLOPT_POST, 1);
	
	//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
	if($USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, $PROXY_HOST. ":" . $PROXY_PORT); 

	//NVPRequest for submitting to server
	
	
	//setting the nvpreq as POST FIELD to curl
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	//getting response from server
	$response = curl_exec($ch);
	
	//convrting NVPResponse to an Associative Array
	$nvpResArray=deformatNVP($response);
	$nvpReqArray=deformatNVP($nvpreq);
	$_SESSION['nvpReqArray']=$nvpReqArray;

	if (curl_errno($ch)) 
	{
		// moving to display page to display curl errors
		  $_SESSION['curl_error_no']=curl_errno($ch) ;
		  $_SESSION['curl_error_msg']=curl_error($ch);

		  //Execute the Error handling module to display errors. 
	} 
	else 
	{
		 //closing the curl
		curl_close($ch);
	}
	return $nvpResArray;
}

/*'----------------------------------------------------------------------------------
 Purpose: Redirects to PayPal.com site.
 Inputs:  NVP string.
 Returns: 
----------------------------------------------------------------------------------
*/
function RedirectToPayPal ( $token )
{
	global $PAYPAL_URL;
	
	// Redirect to paypal.com here
	$payPalURL = $PAYPAL_URL . $token;
	header("Location: ".$payPalURL);
}

	
/*'----------------------------------------------------------------------------------
 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
  * It is usefull to search for a particular key and displaying arrays.
  * @nvpstr is NVPString.
  * @nvpArray is Associative Array.
   ----------------------------------------------------------------------------------
  */
function deformatNVP($nvpstr)
{
	$intial=0;
	$nvpArray = array();

	while(strlen($nvpstr))
	{
		//postion of Key
		$keypos= strpos($nvpstr,'=');
		//position of value
		$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

		/*getting the Key and Value values and storing in a Associative Array*/
		$keyval=substr($nvpstr,$intial,$keypos);
		$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
		//decoding the respose
		$nvpArray[urldecode($keyval)] =urldecode( $valval);
		$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	 }
	return $nvpArray;
}

function generateCharacter () {
	$possible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	return $char;
}

function generateGUID () {
	$GUID = generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
	$GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
	$GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
	$GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter()."-";
	$GUID = $GUID .generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter().generateCharacter();
	return $GUID;
}
?>