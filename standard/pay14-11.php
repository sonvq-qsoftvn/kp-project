<?php
	include("../class/db_mysql.inc");
	include("../class/user_class.php");
	session_start();
	
	$obj_base_path = new DB_Sql;
	$customArray = array($_POST['event_id'],$_POST['ticket'],$_POST['payment'],$_POST['ticket_id'],$_POST['multi_id'],$_POST['user_id']);
	$customString = implode("-",$customArray);

?>
<form  action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="_xclick">
<table width="675" cellpadding="2" cellspacing="2" border="0" align="center">
<tr><td>											
<input type="text" name="cmd" value="_xclick">
<input type="text" name="rm" value="2">
<input type="text" name="business" value="amit.unified-facilitator@gmail.com">
<!--<input type="hidden" name="business" value="<?php //echo $obj_setting->f('paypal_standard_id'); ?>">-->
<input type="text" name="return" value="<?php echo $obj_base_path->base_path(); ?>/payment-complete.php">
<input type="text" name="cancel_return" value="<?php echo $obj_base_path->base_path(); ?>/index">
<input type="text" name="notify_url" value="<?php echo $obj_base_path->base_path(); ?>/standard/ipn">
<?php 
if($_SESSION['pay'] == 'us'){?>
<input type="text" name="currency_code" value="USD" />
<?php
}elseif($_SESSION['pay'] == 'mx'){
?>
<input type="text" name="currency_code" value="MXN" />
<?php }?>
<input type="text" name="item_name" value="<?php echo $_POST['name']; ?>">

<input type="text" name="amount" value="<?php echo $_POST['amount']; ?>">
<input type="text" name="custom" value="<?php echo $customString; ?>" >
<input type="submit" name="submit1" value="Submit" class="btn3" />
</td></tr></table>
</form>

