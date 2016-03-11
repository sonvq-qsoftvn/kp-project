<?php

	include("class/db_mysql.inc");
	include("class/user_class.php");
	//session_start();  //if use session its not working..
	
	$obj_base_path = new DB_Sql;
	
include('VPCPaymentConnection.php');
$conn = new VPCPaymentConnection();


// This is secret for encoding the SHA256 hash
// This secret will vary from merchant to merchant

$secureSecret = "895B1F1354B4F3681ACC3236A9AEBC8F";  //for Test
//$secureSecret = "15F7D91BB5A23AA2D31A553D37B02413";   //for production

// Set the Secure Hash Secret used by the VPC connection object
$conn->setSecureSecret($secureSecret);


// *******************************************
// START OF MAIN PROGRAM
// *******************************************
// Sort the POST data - it's important to get the ordering right
ksort ($_POST);

// add the start of the vpcURL querystring parameters
$vpcURL = $_POST["virtualPaymentClientURL"];




// for attempt//
                $obj_attempt=new user;
		$obj_attempt_update=new user;
		$obj_attempt_insert=new user;
		
                 if($_POST['attempt_id']!="")
		 {
			//echo "hello";
			 
			  $obj_attempt->GetAllAttemptById($_POST['attempt_id']);
			  $obj_attempt->next_record();
			  $attempt_count = $obj_attempt->f('attempt_count');
			  
			  $attempt_count_update = $attempt_count + 1;
			  $obj_attempt_update->UpdateAttemptById($attempt_count_update,$_POST['attempt_id']);
			  $attempt_id=$_POST['attempt_id'];
		 }
		 else
		  {
			//echo "hello2";
			$attempt_count=1;
			$attempt_id=$obj_attempt_insert->add_attempt_TNS($_POST["vpc_OrderInfo"],$attempt_count);
		  }

//for attempt end//




// This is the title for display
$title  = $_POST["Title"];
//echo $title;
$parches_amount = $_POST["parches_amount"];
//echo $parches_amount;
$custom = $_POST["custom"];
//echo $custom;

$item_name = $_POST["item_name"];
//echo "item_name= ".$item_name;
$event_id = $_POST["event_id"].'-'.$_POST["ticket_id"];
//echo "eid= ".$event_id;
$ticket = $_POST["ticket"];
//echo "tktid= ".$ticket;
$payment_type = $_POST["payment_type"];
//echo "ptyp= ".$payment_type;
//$ticket_id = $_POST["ticket_id"];
//echo "tkid= ".$ticket_id;
$multi_id = $_POST["multi_id"];
//echo "mlid= ".$multi_id;
				//
				//if($_POST["attempt_id"]=="")
				//  {
				//    $_POST["attempt_id"]=1;
				//  }
				
$cart_id = $_POST["cart_id"].'-'.$attempt_id;
//echo "crt id= ".$cart_id;
$user_id = $_POST["user_id"];
//echo "uid= ".$user_id;
//$attempt_id = $_POST["attempt_id"];
//echo $attempt_id;
$vpc_OrderInfo = $_POST["vpc_OrderInfo"];
//echo $vpc_OrderInfo;
$vpc_MerchTxnRef = $_POST["vpc_MerchTxnRef"];
//echo $vpc_MerchTxnRef;




// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]); 
unset($_POST["SubButL"]);
unset($_POST["Title"]);
unset($_POST["amount"]);
unset($_POST["custom"]);
unset($_POST["item_name"]);
unset($_POST["event_id"]);
unset($_POST["ticket"]);
unset($_POST["payment_type"]);
unset($_POST["ticket_id"]);
unset($_POST["multi_id"]);
unset($_POST["cart_id"]);
unset($_POST["user_id"]);    
unset($_POST["attempt_id"]);
//unset($_POST["vpc_OrderInfo"]);
//unset($_POST["vpc_MerchTxnRef"]);

// Add VPC post data to the Digital Order
foreach($_POST as $key => $value) {
	if (strlen($value) > 0) {
		$conn->addDigitalOrderField($key, $value);
	}
}



// Add original order HTML so that another transaction can be attempted.
$conn->addDigitalOrderField("AgainLink", $againLink);

// Obtain a one-way hash of the Digital Order data and add this to the Digital Order
$secureHash = $conn->hashAllFields();
$conn->addDigitalOrderField("Title", $title);
$conn->addDigitalOrderField("AMOUNT", $parches_amount);
$conn->addDigitalOrderField("CUSTOM", $custom);
$conn->addDigitalOrderField("ITEMNAME", $item_name);
$conn->addDigitalOrderField("EVENTID", $event_id);
$conn->addDigitalOrderField("TICKET", $ticket);
$conn->addDigitalOrderField("PAYMENTTYPE", $payment_type);
$conn->addDigitalOrderField("ATTEMPTID", $attempt_id);
$conn->addDigitalOrderField("TICKETID", $ticket_id);
$conn->addDigitalOrderField("MULTIID", $multi_id);
$conn->addDigitalOrderField("CARTID", $cart_id);
$conn->addDigitalOrderField("USERID", $user_id);
$conn->addDigitalOrderField("vpc_SecureHash", $secureHash);
$conn->addDigitalOrderField("vpc_SecureHashType", "SHA256");

// Obtain the redirection URL and redirect the web browser
$vpcURL = $conn->getDigitalOrder($vpcURL);
header("Location: ".$vpcURL);
//echo "<a href=$vpcURL>$vpcURL</a>";

?>