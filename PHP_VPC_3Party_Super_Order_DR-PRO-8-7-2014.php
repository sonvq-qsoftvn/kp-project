<?php


// Initialisation
// ==============

        require("class/db_mysql.inc");
	require("class/user_class.php");
	$obj=new user;
	$obj_cartDetails=new user;
// 
include('VPCPaymentConnection.php');
$conn = new VPCPaymentConnection();


// This is secret for encoding the SHA256 hash
// This secret will vary from merchant to merchant

//$secureSecret = "895B1F1354B4F3681ACC3236A9AEBC8F";  //for Test
$secureSecret = "15F7D91BB5A23AA2D31A553D37B02413";   //for production

// Set the Secure Hash Secret used by the VPC connection object
$conn->setSecureSecret($secureSecret);


// Set the error flag to false
$errorExists = false;



// *******************************************
// START OF MAIN PROGRAM
// *******************************************


// This is the title for display
$title  = $_GET["Title"];
//echo "title=".$title;
$parches_amount = $_GET["AMOUNT"];
//echo " AMNT= ".$parches_amount;
$item_name = $_GET["ITEMNAME"];
//echo " ITEMNAME= ".$item_name;
$event_id = $_GET["EVENTID"];
//echo " EVENTID= ".$event_id;
//$ticket = $_GET["TICKET"];
//echo " TKT= ".$ticket;
$ticket = $_GET["PAYMENTTYPE"];
//echo " PYTYP= ".$ticket;
//$ticket_id = $_GET["TICKETID"];
//echo " TKTID= ".$ticket_id;
$multi_id = $_GET["MULTIID"];
//echo " MULTIID= ".$multi_id;
$cart_id = $_GET["CARTID"];
//echo " CARTID= ".$cart_id;
$user_id = $_GET["USERID"];
//echo " USRID= ".$user_id;
$attempt_id = $_GET["ATTEMPTID"];



//$custom = $_GET["CUSTOM"];
//echo "custom=".$custom;
//$custArray = explode("-",$custom);

//$no_of_ticket = $custArray['1'];
//echo $no_of_ticket;
//

 
// Add VPC post data to the Digital Order
foreach($_GET as $key => $value) {
	if (($key!="vpc_SecureHash") && ($key != "vpc_SecureHashType") && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
		$conn->addDigitalOrderField($key, $value);
	}
}

// Obtain a one-way hash of the Digital Order data and
// check this against what was received.
$serverSecureHash	= array_key_exists("vpc_SecureHash", $_GET)	? $_GET["vpc_SecureHash"] : "";
$secureHash = $conn->hashAllFields();
if ($secureHash==$serverSecureHash) {
	$hashValidated = "<font color='#00AA00'><strong>CORRECT</strong></font>";
} else {
	$hashValidated = "<font color='#FF0066'><strong>INVALID HASH</strong></font>";
	$errorsExist = true;
}

    
/*  If there has been a merchant secret set then sort and loop through all the
    data in the Virtual Payment Client response. while we have the data, we can
    append all the fields that contain values (except the secure hash) so that
    we can create a hash and validate it against the secure hash in the Virtual
    Payment Client response.

    NOTE: If the vpc_TxnResponseCode in not a single character then
    there was a Virtual Payment Client error and we cannot accurately validate
    the incoming data from the secure hash. 

    // remove the vpc_TxnResponseCode code from the response fields as we do not 
    // want to include this field in the hash calculation
    
    if (secureSecret != null && secureSecret.length() > 0 && 
        (fields.get("vpc_TxnResponseCode") != null || fields.get("vpc_TxnResponseCode") != "No Value Returned")) {
        
        // create secure hash and append it to the hash map if it was created
        // remember if secureSecret = "" it wil not be created
        String secureHash = vpc3conn.hashAllFields(fields);
    
        // Validate the Secure Hash (remember MD5 hashes are not case sensitive)
        if (vpc_Txn_Secure_Hash.equalsIgnoreCase(secureHash)) {
            // Secure Hash validation succeeded, add a data field to be 
            // displayed later.
            hashValidated = "<font color='#00AA00'><strong>CORRECT</strong></font>";
        } else {
            // Secure Hash validation failed, add a data field to be
            // displayed later.
            errorExists = true;
            hashValidated = "<font color='#FF0066'><strong>INVALID HASH</strong></font>";
        }
    } else {
        // Secure Hash was not validated, 
        hashValidated = "<font color='orange'><strong>Not Calculated - No 'SECURE_SECRET' present.</strong></font>";
    }
*/

    // Extract the available receipt fields from the VPC Response
    // If not present then let the value be equal to 'Unknown'
    // Standard Receipt Data


$Title 				= array_key_exists("Title", $_GET) 				        ? $_GET["Title"] 			: "";
$AMOUNT			        = array_key_exists("AMOUNT", $_GET) 				        ? $_GET["AMOUNT"] 			: "";
//$CUSTOM 			= array_key_exists("CUSTOM", $_GET) 				        ? $_GET["CUSTOM"] 			: "";



$ITEMNAME 			= array_key_exists("ITEMNAME", $_GET) 				        ? $_GET["ITEMNAME"] 			: "";
$EVENTID 			= array_key_exists("EVENTID", $_GET) 				        ? $_GET["EVENTID"] 			: "";
//$TICKET 			= array_key_exists("TICKET", $_GET) 				        ? $_GET["TICKET"] 			: "";
$PAYMENTTYPE 			= array_key_exists("PAYMENTTYPE", $_GET) 				? $_GET["PAYMENTTYPE"] 			: "";
$ATTEMPTID 			= array_key_exists("ATTEMPTID", $_GET) 				        ? $_GET["ATTEMPTID"] 			: "";
$TICKETID 			= array_key_exists("TICKETID", $_GET) 				        ? $_GET["TICKETID"] 			: "";
$MULTIID 			= array_key_exists("MULTIID", $_GET) 				        ? $_GET["MULTIID"] 			: "";
$CARTID 			= array_key_exists("CARTID", $_GET) 				        ? $_GET["CARTID"] 			: "";
$USERID 			= array_key_exists("USERID", $_GET) 				        ? $_GET["USERID"] 			: "";




$againLink 			= array_key_exists("AgainLink", $_GET) 					? $_GET["AgainLink"] 			: "";
$amount 			= array_key_exists("vpc_Amount", $_GET) 				? $_GET["vpc_Amount"] 			: "";
$locale 			= array_key_exists("vpc_Locale", $_GET) 				? $_GET["vpc_Locale"] 			: "";
$currency			= array_key_exists("vpc_Currency", $_GET) 				? $_GET["vpc_Currency"] 		: "";
$batchNo 			= array_key_exists("vpc_BatchNo", $_GET) 				? $_GET["vpc_BatchNo"] 			: "";
$command 			= array_key_exists("vpc_Command", $_GET) 				? $_GET["vpc_Command"] 			: "";
$message 			= array_key_exists("vpc_Message", $_GET) 				? $_GET["vpc_Message"]			: "";
$version  			= array_key_exists("vpc_Version", $_GET) 				? $_GET["vpc_Version"] 			: "";
$cardType   		= array_key_exists("vpc_Card", $_GET) 					? $_GET["vpc_Card"] 			: "";
$orderInfo 			= array_key_exists("vpc_OrderInfo", $_GET) 				? $_GET["vpc_OrderInfo"] 		: "";
$receiptNo 			= array_key_exists("vpc_ReceiptNo", $_GET) 				? $_GET["vpc_ReceiptNo"] 		: "";
$merchantID  		= array_key_exists("vpc_Merchant", $_GET) 				? $_GET["vpc_Merchant"] 		: "";
$merchTxnRef 		= array_key_exists("vpc_MerchTxnRef", $_GET) 			? $_GET["vpc_MerchTxnRef"]		: "";
$authorizeID 		= array_key_exists("vpc_AuthorizeId", $_GET) 			? $_GET["vpc_AuthorizeId"] 		: "";
$transactionNo  	= array_key_exists("vpc_TransactionNo", $_GET) 			? $_GET["vpc_TransactionNo"] 	: "";
$acqResponseCode 	= array_key_exists("vpc_AcqResponseCode", $_GET) 		? $_GET["vpc_AcqResponseCode"] 	: "";
$txnResponseCode 	= array_key_exists("vpc_TxnResponseCode", $_GET) 		? $_GET["vpc_TxnResponseCode"] 	: "";
$riskOverallResult	= array_key_exists("vpc_RiskOverallResult", $_GET) 		? $_GET["vpc_RiskOverallResult"]: "";

		// Obtain the 3DS response
$vpc_3DSECI				= array_key_exists("vpc_3DSECI", $_GET) 			? $_GET["vpc_3DSECI"] : "";
$vpc_3DSXID				= array_key_exists("vpc_3DSXID", $_GET) 			? $_GET["vpc_3DSXID"] : "";
$vpc_3DSenrolled 		= array_key_exists("vpc_3DSenrolled", $_GET) 		? $_GET["vpc_3DSenrolled"] : "";
$vpc_3DSstatus 			= array_key_exists("vpc_3DSstatus", $_GET) 			? $_GET["vpc_3DSstatus"] : "";
$vpc_VerToken 			= array_key_exists("vpc_VerToken", $_GET) 			? $_GET["vpc_VerToken"] : "";
$vpc_VerType 			= array_key_exists("vpc_VerType", $_GET) 			? $_GET["vpc_VerType"] : "";
$vpc_VerStatus			= array_key_exists("vpc_VerStatus", $_GET) 			? $_GET["vpc_VerStatus"] : "";
$vpc_VerSecurityLevel	= array_key_exists("vpc_VerSecurityLevel", $_GET) 	? $_GET["vpc_VerSecurityLevel"] : "";


    // CSC Receipt Data
$cscResultCode 	= array_key_exists("vpc_CSCResultCode", $_GET)  			? $_GET["vpc_CSCResultCode"] : "";
$ACQCSCRespCode = array_key_exists("vpc_AcqCSCRespCode", $_GET) 			? $_GET["vpc_AcqCSCRespCode"] : "";
    
// Get the descriptions behind the QSI, CSC and AVS Response Codes
    // Only get the descriptions if the string returned is not equal to "No Value Returned".
    
$txnResponseCodeDesc = "";
$cscResultCodeDesc = "";
$avsResultCodeDesc = "";
    
    if ($txnResponseCode != "No Value Returned") {
        $txnResponseCodeDesc = getResultDescription($txnResponseCode);
    }
    
    if ($cscResultCode != "No Value Returned") {
        $cscResultCodeDesc = getCSCResultDescription($cscResultCode);
    }
    
    
		$error = "";
    // Show this page as an error page if error condition
    if ($txnResponseCode=="7" || $txnResponseCode=="No Value Returned" || $errorExists) {
        $error = "Error ";
    }
        
    // FINISH TRANSACTION - Process the VPC Response Data
    // =====================================================
    // For the purposes of demonstration, we simply display the Result fields on a
    // web page.
?>
<!----------------------cLOSE FOR TEST-------------
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
    <html>
    <head><title><?php echo($title) ?> - VPC Response <?php echo($error) ?>Page</title>
        <meta http-equiv='Content-Type' content='text/html, charset=iso-8859-1'>
       
    </head>
    <body>------------------------------------->
    

<?php //}


		$cartIdAttemptId = $_GET["CARTID"];
	        ///echo "cartIdAttemptId=".$cartIdAttemptId;
	        $cartIdAttemptIdArray = explode("-",$cartIdAttemptId);
		$cart_id_arr=$cartIdAttemptIdArray[0];
		///echo "ex_cart_id= ".$cart_id_arr;
		$only_cart_id = explode(",",$cart_id_arr);
		$cart_id=$only_cart_id[0];
		///echo "cart_id= ".$cart_id;
		
		$attempt_id=$cartIdAttemptIdArray[1];
		///echo "ex_attempt_id= ".$attempt_id;
		
		$ticket_arr =explode(',',$ticket);   //num of tickets array..
		$sumticket=array_sum($ticket_arr);
		///echo "sumticket=".$sumticket;
		
		$obj_cartDetails->cart_details($cart_id);
                $obj_cartDetails->next_record();
		$unique_id = $obj_cartDetails->f('unique_id');
		///echo "unique_id= ".$unique_id;
       //--------------------------------------------------------//
         $event_id_ticket_id = explode('-',$event_id);
	 $new_event_id = $event_id_ticket_id[0];
	 //echo "event_id= ".$new_event_id;
	 
	
	 
	 $new_ticket_id = $event_id_ticket_id[1];  
	/// echo "ticket_id= ".$new_ticket_id;
	 
	  $ticket_id_arr = explode(',',$new_ticket_id)      ; //num of tickets array..
          //$obj_cartDetails=new user;
          //$obj_cartDetails->cart_details($cart_id);
          //$obj_cartDetails->next_record();
	  //$ticket_id_for_this_cart=$obj_cartDetails->f('ticket_id');
	  //$ticket_id_for_this_cart=$ticket_id;
	  //echo $ticket_id_for_this_cart;
	$objEvent=new user;
	$objEvent->getEventDetails($new_event_id);
	$objEvent->next_record();
	
	$event_name = $objEvent->f('event_name_en');
								
       //--------------------------------------------------------//
       //------------------Amount Changing from cent to original data for insertion in table--------------------------------------//
       //echo "Amount= ".$amount;
       $cent_amount=$amount/100;
       $cent_amount=number_format($cent_amount,2,'.','');
	//echo "cAmnt= ".$cent_amount;
	//echo "above= ".$txnResponseCode; die;
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++ THIS  SECTION COMENTED 19_05_14+++++++++++++++++++++++++++++++//
	
	
     if($txnResponseCode==="0") //Means Transaction Successfull....
      {
         //user detail
        //echo "inside= ".$txnResponseCode;
	
$tid = $obj->add_order_TNS($event_name,$item_number,$txnResponseCodeDesc,$cent_amount,$currency,$receiptNo,$receiver_email,$payer_email,$new_event_id,$sumticket,'CC',$new_ticket_id,$multi_id,$user_id,$cart_id,$cart_id,$unique_id); //order_info=order_id=$cart_id
			///echo "transaction-id= ".$tid;
			
			/*Get Data From Trnasaction Table*/
			$obj_get_trans=new user;
			$obj_get_trans->getOrderDetails($tid);
			$obj_get_trans->next_record();
			$payment_currency = trim($obj_get_trans->f('payment_currency'));
			//echo $payment_currency;
			/*Get Data From Trnasaction Table*/
			
			/*update cart  table  with  transaction  id*/
			
			$obj_updcart_trans=new user;
			$obj_updcart_trans->update_cart_by_trns_id($tid,$payment_currency,$unique_id);
						
			/*update cart  table  with  transaction  id*/
			
		/*----------------------------------------------------------------------------*/
		        $obj_cart_trans=new user;
			$obj_cart_trans->getAll_cart_by_trns_id($tid);
                        
                         $cnt=0;
                        while($obj_cart_trans->next_record())
                         {
                                //echo "ok";
				$ticket_fee_inc=$obj_cart_trans->f('ticket_fee_included');
				$promo_fee_inc=$obj_cart_trans->f('promo_fee_included');
                                //echo "tckt_fee_inc=".$ticket_fee_inc;
                                //echo "promo_fee_inc=".$promo_fee_inc;
                               // $payment_currency='USD';
                                //$sumticket=4;
                            if($payment_currency=='USD')
			         {
                                        //echo "check usd";
					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount =  number_format($sumticket*($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us')),2,'.',',');
					  //echo "fee_incl_amount=".$fee_incl_amount;
                                          $fee_non_incl_amount = 0.00;
                                          //echo "fee_non_incl_amount=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 1 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_us')),2,'.',',');
                                          //echo "fee_incl_amount3= ".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('promo_fee_us')),2,'.',',');
                                          //echo "fee_non_incl_amount4=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount = number_format($sumticket*($obj_cart_trans->f('promo_fee_us')),2,'.',',');
                                          //echo "fee_incl_amount=".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_us')),2,'.',',');
                                          //echo "fee_non_incl_amount=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount = 0.00;
                                          //echo "fee_incl_amount7=".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us')),2,'.',',');
					  //echo "fee_non_incl_amount8=".$fee_non_incl_amount;
                                        }
				
			         }  // if  end..
			    elseif($payment_currency=='MXN')
			         {
                                        //echo "check";
					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
					{
					   $fee_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx')),2,'.',',');
					   //echo "fee_incl_amount1=".$fee_incl_amount;
                                           $fee_non_incl_amount = 0.00;
                                           //echo "fee_non_incl_amount2=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 1 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_mx')),2,'.',',');
                                           //echo "fee_incl_amount3= ".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('promo_fee_mx')),2,'.',',');
                                           //echo "fee_non_incl_amount4=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 0 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount = number_format($sumticket*($obj_cart_trans->f('promo_fee_mx')),2,'.',',');
                                          //echo "fee_incl_amount5=".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_mx')),2,'.',',');
                                          //echo "fee_non_incl_amount6=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 0 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount = 0.00;
                                          //echo "fee_incl_amount7=".$fee_incl_amount;
					  $fee_non_incl_amount = number_format($sumticket*($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx')),2,'.',',');
					  //echo "fee_non_incl_amount8=".$fee_non_incl_amount;
                                        }
				
			         }  //else if  end..
				 
				  //----------- update  the  transaction  table  with 
				        $obj_update_trans=new user;
			                $obj_update_trans->update_transaction_by_id($tid,$fee_incl_amount,$fee_non_incl_amount);
                            $cnt++;
                         }
		/*---------------------------------------------------------------------------*/
		
		
		
	        /*------------------------------------------------------------------------*/
		 
		   for($i=0;$i<count($ticket_id_arr);$i++)
		   {
			///echo "tckt_id= ".$ticket_id = $ticket_id_arr[$i];
			///echo "tckt_num= ".$ticket = $ticket_arr[$i];
			
			$obj_gettkt=new user;
			$obj_gettkt->getTicketDetails($ticket_id_arr[$i]);
			$obj_gettkt->next_record();
			
			$new = $obj_gettkt->f('ticket_num')-$ticket_arr[$i]; //$ticket= no_of_ticket.
			//echo $new;
			$obj_updtkt=new user;
			$obj_updtkt->update_ticket($new,$ticket_id_arr[$i]);
		   }
                     header("location: http://kpasapp.com/payment-complete-TNS.php?bank-auth=".$authorizeID."&trans_id=".$tid);


      }
     else
      {
	header("location: http://kpasapp.com/payment/".$new_event_id."/attempt/".$attempt_id);
      }
 

//+++++++++++++++++++++++++++++++++++++++++++++++++++++ THIS  SECTION COMENTED 19_05_14+++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
?>
    
    <!--<center><P><A HREF='PHP_VPC_3Party_Super_Order.html'>New Transaction</A></P></center>-->
    
    
  
    </body>
    </html>
