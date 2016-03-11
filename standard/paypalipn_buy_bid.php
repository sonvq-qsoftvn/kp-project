<?php
	//include file
	include("../config/connect.php");
	include("../functions.php");
	include "paypal.functions.php";
	
	writeLog("Calling IPN Script ***********");
	
	//get paypal detail
	$paypal_detail=getPaypalId();
	
	if($paypal_detail['paypal_type']=='live')
	captureIPN("Live");
	if($paypal_detail['paypal_type']=='demo')
	captureIPN("Demo");

function writeLog($log) {
	$fp = fopen("paypalipn_buy_bid.log", "a");
	fputs($fp, $log."\n");
	fclose($fp);
}

function ipnSuccess() {
	writeLog("Inside IPN Success...");
	//$test_ipn=$_POST['test_ipn'];
	
	//foreach($_POST as $key => $val) $returnStr .= "$key = $val";
	$returnStr=serialize($_POST);
	writeLog($returnStr);
	$item_name = $_POST['item_name1'];
	$receiver_email = $_POST['receiver_email'];
	$item_number = $_POST['item_number'];
	$quantity = $_POST['quantity1'];
	$invoice = $_POST['invoice'];
	$payment_status = $_POST['payment_status'];
	$payment_gross = $_POST['payment_gross'];
	$txn_id = $_POST['txn_id'];
	$payer_email = $_POST['payer_email'];
	$payer_name	= $_POST['last_name'];
	$payer_phone	= $_POST['contact_ phone'];
	$payer_address	= $_POST['residence_country'];
	$payer_id = $_POST['payer_id'];
	$pending_reason = $_POST['pending_reason'];
	$payment_date = $_POST['payment_date'];
	$payment_fee = $_POST['payment_fee'];
	$payer_status = $_POST['payer_status'];
	$payment_type = $_POST['payment_type'];
	$notify_version = $_POST['notify_version'];
	$verify_sign = $_POST['verify_sign'];
	$custom = $_POST['custom'];
	$payment_gross = $_POST['payment_gross'];
	writeLog($payer_phone);
	
	$a=split(",",$custom);
	$payer_id=$a[0];
	$domain=$a[1];
	$pay_date=date('l jS \of F Y h:i:s A');
	//mysql_query("insert into payment values('','$payer_id','$domain','$pay_date','$payment_gross')");
	//mysql_query("update newton_order set order_status='PAID' where order_id='$custom' ");
	//
	//writeLog("UPDATE  ".SITE_PREFIX."bid_user SET bid_status='1'   WHERE id='".$custom."' ");
	$sql=mysql_query("UPDATE  ".SITE_PREFIX."bid_user SET bid_status='1'   WHERE id='".$custom."' ");
	$rs=getBidUserBuy($custom);
	$row=mysql_fetch_array($rs);
	
	writeLog($row['user_id'].$row['total_bid']);
	
	update_user_bid_pack($row['user_id'],$row['total_bid']);
	
	$subject="Payment Confirmation";
	$recipient="shantanu.uss@gmail.com";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: info@abcd.com' . "\r\n";
		$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	$message="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='left' valign='top'>
		<fieldset style=' margin-left:8px; margin-right:8px;padding-left:10px; padding-right:10px;'>
			<LEGEND  ACCESSKEY=L><span class='heading_txt'>Billing / Shipping </span></LEGEND>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50%' align='left' valign='middle' ><table width='90%' border='1' align='left' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Name:&nbsp;</td>
        <td width='50%' align='left' valign='middle'>".$payer_name."</td>
      </tr>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Address:&nbsp;</td>
        <td width='50%' align='left' valign='middle'>".$payer_address."</td>
      </tr>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Phone:&nbsp;</td>
        <td width='50%' align='left' valign='middle'>".$payer_phone."</td>
      </tr>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Email:&nbsp;</td>
        <td width='50%' align='left' valign='middle'>".$payer_email."</td>
      </tr>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>&nbsp;</td>
        <td width='50%' align='left' valign='middle'>&nbsp;</td>
      </tr>
    </table></td>
    <td width='50%' align='right' valign='top'><table width='90%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Order No. </td>
        <td width='50%' class='td'>".$invoice."</td>
      </tr>
      <tr>
        <td width='50%' align='right' valign='middle' class='td'>Order Date </td>
        <td width='50%' class='td'>".$pay_date."</td>
      </tr>

    </table></td>
  </tr>
  
  
<tr>
    <td width='50%' align='left' valign='middle' >&nbsp;</td>
    <td width='50%'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' align='left' valign='middle'><table width='100%' border='1' align='left' cellpadding='0' cellspacing='0' bordercolor='#CCCCCC' style=' border-collapse: collapse;'>
      <tr>
        <td width='9%' class='td'>Sl.No</td>
        <td width='38%' class='td'>Product Name </td>
        <td width='19%' class='td'>Unit</td>
        <td width='18%' class='td'>Unit Price </td>
        <td width='16%' class='td'>Amount</td>
      </tr>
      <tr>
        <td class='td'>1</td>
        <td class='td'>".$item_name."</td>
        <td class='td'>".$quantity."</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
      </tr>
      <tr>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
      </tr>
      <tr>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
      </tr>
      <tr>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
        <td class='td'>&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td width='50%' align='right' valign='middle'>&nbsp;</td>
    <td width='50%'>&nbsp;</td>
  </tr>
  <tr>
    <td align='right' valign='middle'>&nbsp;</td>
    <td><table width='90%' border='0' align='right' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='45%' align='right' valign='middle' class='td'>Total</td>
        <td width='45%' align='left' valign='middle' class='td'>".$payment_gross."</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align='right' valign='middle'>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

	  </fieldset>
	</td>
  </tr>
  <tr>
    <td align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td align='left' valign='top'>&nbsp;</td>
  </tr>
  <tr>
    <td align='left' valign='top'>&nbsp;</td>
  </tr>
</table>";
		@mail($recipient, $subject, $message, $headers);
}
?>