<?php
	include("../class/db_mysql.inc");
	include("../class/user_class.php");
	$obj_base_path = new DB_Sql;
	$customArray = array($_POST['event_id'],$_POST['ticket']);
	$customString = implode("-",$customArray);

?>
<form  action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="_xclick">
<table width="675" cellpadding="2" cellspacing="2" border="0" align="center">
<tr><td>											
<input type="text" name="cmd" value="_xclick">
<input type="text" name="rm" value="2">
<input type="text" name="business" value="amit.unified-facilitator@gmail.com">
<!--<input type="hidden" name="business" value="<?php //echo $obj_setting->f('paypal_standard_id'); ?>">-->
<input type="text" name="return" value="<?php echo $obj_base_path->base_path(); ?>/payment-receipt">
<input type="text" name="cancel_return" value="<?php echo $obj_base_path->base_path(); ?>/index">
<input type="text" name="notify_url" value="<?php echo $obj_base_path->base_path(); ?>/standard/ipn">
<input type="text" name="currency_code" value="USD" />
<input type="text" name="item_name" value="Post Idea price">

<input type="text" name="amount" value="<?php echo $_POST['amount']; ?>">
<input type="text" name="custom" value="<?php echo $customString; ?>" >
<input type="submit" name="submit1" value="Submit" class="btn3" />
</td></tr></table>
</form>

