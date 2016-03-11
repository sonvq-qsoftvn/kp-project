<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
	$notify_url = 'http://122.176.67.22/recurringpayment/payipn.php';
	$successful_payment = 'http://122.176.67.22/recurringpayment/successful_payment.php';
	$failure_payment = 'http://122.176.67.22/recurringpayment/failure_payment.php';
?>
<!--<form name="formPayPal" action="https://www.paypal.com/cgi-bin/webscr" method="post">-->
<form name="formPayPal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_blank">

<input type="hidden" name="cmd" value="_xclick-subscriptions">
<input type="hidden" name="business" value="amit.s_1348505830_biz@gmail.com">
<input type="hidden" name="item_name" value="Test">
<input type="hidden" name="notify_url" value="<?php echo $notify_url;?>"/>
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo $successful_payment;?>">
<input type="hidden" name="cancel_return" value="<?php echo $failure_payment;?>">
<input type="hidden" name="currency_code" value="USD">
<!--<input type="hidden" name="custom" value="'.$_GET['upgrade_membership'].',">-->
<input type="hidden" name="a3" value="15.00">
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="D">

<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">

<input type="hidden" name="no_note" value="1">
<input type="submit" value="Enter"  />

</form>
</body>
</html>