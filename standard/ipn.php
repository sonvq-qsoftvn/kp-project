<?php
// Response from Paypal
	
	//include file
	session_start();
	require("../class/db_mysql.inc");
	require("../class/user_class.php");
	//mail("sumitra.unified@gmail.com", "PAYPAL", "","admin@gmail.com");
	
	//create object
	$obj_edit=new user;
	$obj=new user;
	$obj_res_acc=new user;

	//mail("sumitra.unified@gmail.com", "PAYPAL1", "","admin@gmail.com");

	
	// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
	$req .= "&$key=$value";
}

// assign posted variables to local variables
$data['item_name']		= $_POST['item_name'];
$data['item_number'] 		= $_POST['item_number'];
$data['payment_status'] 	= $_POST['payment_status'];
$data['payment_amount'] 	= $_POST['mc_gross'];
$data['payment_currency']	= $_POST['mc_currency'];
$data['txn_id']			= $_POST['txn_id'];
$data['receiver_email'] 	= $_POST['receiver_email'];
$data['payer_email'] 		= $_POST['payer_email'];

$custStrng			= $_POST['custom'];
$custArray 			= explode("-",$custStrng);


$data['event_id'] 	= $custArray[0];
$data['ticket'] 	= $custArray['1'];
$data['payment'] 	= $custArray['2']; // this is empty value
$data['ticket_id'] 	= $custArray['3'];
$data['multi_id'] 	= $custArray['4'];
$data['user_id'] 	= $custArray['5'];
$data['cart_id'] 	= $custArray['6'];
$data['unique_id'] 	= $custArray['7'];

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
		

//mail("sumitra.unified@gmail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($custArray, true)."</pre>");
//mail("sumitra.unified@gmail.com", "PAYPAL DEBUGGING2", "Verified Response2<br />data = <pre>".print_r($post, true)."</pre>");exit;


	fputs ($fp, $header . $req);
	//mail("unified.subhrajyoti@gmail.com", "PAYPAL2", "","admin@gmail.com");
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		//mail("unified.subhrajyoti@gmail.com", "PAYPAL1", "".$res."","admin@gmail.com");
		if (strcmp($res, "VERIFIED") == 0) 
		{
			// Used for debugging
			//@mail("unified.subhrajyoti@gmail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($data, true)."</pre>");exit;
			//mail("sumitra.unified@gmail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($data, true)."</pre>");
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
			$tid = $obj->add_order($data['item_name'],$data['item_number'],$data['payment_status'],$data['payment_amount'],$data['payment_currency'],$data['txn_id'],$data['receiver_email'],$data['payer_email'],$data['event_id'],$data['ticket'],$data['payment'],$data['ticket_id'],$data['multi_id'],$data['user_id'],$order_no,$data['cart_id'],$data['unique_id']);
			
			//$_SESSION['tid'] = $tid;
					
/*-------------------------------------------Newly Added----------------------------------------------------------------------------------*/

			/*Get Data From Trnasaction Table*/
			$obj_get_trans=new user;
			$obj_get_trans->getOrderDetails($tid);
			$obj_get_trans->next_record();
			$payment_currency = trim($obj_get_trans->f('payment_currency'));
			//echo $payment_currency;
			/*Get Data From Trnasaction Table*/
			
			/*update cart  table  with  transaction  id*/
			$unique_id = $data['unique_id'];
			//echo $unique_id;
			$obj_updcart_trans=new user;
			$obj_updcart_trans->update_cart_by_trns_id($tid,$payment_currency,$unique_id);
			
			/*update cart  table  with  transaction  id*/
		
			
		/*------------------HERE I DO TRANSACTION TABLE CALCULATION FOR  FEE INCLUDE/NON INCLUDEAMOUNT START----------------------------*/
		        $obj_cart_trans=new user;
			$obj_cart_trans->getAll_cart_by_trns_id($tid);
                        
                         $cnt=0;
                        while($obj_cart_trans->next_record())
                         {
                               
				$ticket_fee_inc=$obj_cart_trans->f('ticket_fee_included');
				$promo_fee_inc=$obj_cart_trans->f('promo_fee_included');
                                //echo "tckt_fee_inc=".$ticket_fee_inc;
                                //echo "promo_fee_inc=".$promo_fee_inc;
                               // $payment_currency='USD';
                                
                            if($payment_currency=='USD')
			         {
                                        //echo "check usd";
					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount =  number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us'))),2,'.',',');
					  //echo "fee_incl_amount=".$fee_incl_amount;
                                          $fee_non_incl_amount = 0.00;
                                          //echo "fee_non_incl_amount=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 1 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_us'))),2,'.',',');
                                          //echo "fee_incl_amount3= ".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('promo_fee_us'))),2,'.',',');
                                          //echo "fee_non_incl_amount4=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('promo_fee_us'))),2,'.',',');
                                          //echo "fee_incl_amount=".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_us'))),2,'.',',');
                                          //echo "fee_non_incl_amount=".$fee_non_incl_amount;
					}
					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount = 0.00;
                                          //echo "fee_incl_amount7=".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us'))),2,'.',',');
					  //echo "fee_non_incl_amount8=".$fee_non_incl_amount;
                                        }
				
			         }  // if  end..
			    elseif($payment_currency=='MXN')
			         {
                                        //echo "check";
					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
					{
					   $fee_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx'))),2,'.',',');
					   //echo "fee_incl_amount1=".$fee_incl_amount;
                                           $fee_non_incl_amount = 0.00;
                                           //echo "fee_non_incl_amount2=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 1 && $promo_fee_inc == 0)
					{
					  $fee_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_mx'))),2,'.',',');
                                           //echo "fee_incl_amount3= ".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('promo_fee_mx'))),2,'.',',');
                                           //echo "fee_non_incl_amount4=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 0 && $promo_fee_inc == 1)
					{
					  $fee_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('promo_fee_mx'))),2,'.',',');
                                          //echo "fee_incl_amount5=".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_mx'))),2,'.',',');
                                          //echo "fee_non_incl_amount6=".$fee_non_incl_amount;
					}
					else if($ticket_fee_inc== 0 && $promo_fee_inc == 0)
					{
						//echo "tck= ".$obj_cart_trans->f('ticket');
						//echo "tck-fessmx= ".$obj_cart_trans->f('ticket_fee_mx');
						//echo "pro-fessmx= ".$obj_cart_trans->f('promo_fee_mx');
						
					  $fee_incl_amount = 0.00;
                                          //echo "fee_incl_amount7=".$fee_incl_amount;
					  $fee_non_incl_amount += number_format($obj_cart_trans->f('ticket')*(($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx'))),2,'.',',');
					  //echo "fee_non_incl_amount8=".$fee_non_incl_amount;
                                        }
				
			         }  //else if  end..
				 
				 
                            $cnt++;
                         } //WHILE END
		/*--------------------------LOOP END  HERE-------------------------------------------------*/
		 //----------- update  the  transaction  table  with 
			$net_to_admin =($obj_get_trans->f('payment_amount')-($fee_incl_amount+$fee_non_incl_amount));
			$obj_update_trans=new user;
			$obj_update_trans->update_transaction_by_id($tid,$fee_incl_amount,$fee_non_incl_amount,$net_to_admin);
		//exit();
		
	/*------------------HERE I DO TRANSACTION TABLE CALCULATION FOR  FEE INCLUDE/NON INCLUDEAMOUNT END----------------------------*/
			
/*--------------------------------Newly Added-------------------------------------------------------------------------------------------------*/
	
	/*--------------ticket deduction from ticket table start-----------*/		
		$obj_gettkt=new user;
		$obj_gettkt->getTicketDetails($data['ticket_id']);
		$obj_gettkt->next_record();
		
		$new = $obj_gettkt->f('ticket_num')-$data['ticket'];
		
		$obj_updtkt=new user;
		$obj_updtkt->update_ticket($new,$data['ticket_id']);
	/*--------------ticket deduction from ticket table end-----------*/
	
	
		
						
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