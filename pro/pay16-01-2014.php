<?php
	include("../class/db_mysql.inc");
	include("../class/user_class.php");
	$obj_base_path = new DB_Sql;
/************************************************************
This is the main web page for the DoDirectPayment sample.
This page allows the user to enter name, address, amount,
and credit card information. It also accept input variable
paymentType which becomes the value of the PAYMENTACTION
parameter.

When the user clicks the Submit button, DoDirectPaymentReceipt.php
is called.

Called by index.html.

Calls DoDirectPaymentReceipt.php.

************************************************************/
// clearing the session before starting new API Call
//session_unset();
//$paymentType = $_REQUEST['paymentType'] ;
//echo "<pre>";
//print_r($_REQUEST); 
?>


<form method="POST" action="<?php echo $obj_base_path->base_path(); ?>/payment-receipt/<?php echo $_REQUEST['event_id']; ?>" name="DoDirectPaymentForm">
<!--Payment type is <?=$paymentType?><br> -->
<input type="hidden" name="paymentType" value="<?php echo $paymentType?>" />
<input type="hidden" name="amount" value="<?php echo $_REQUEST['amount']; ?>" />
<input type="hidden" name="ticket" value="<?php echo $_REQUEST['ticket']; ?>" />
<input type="hidden" name="ticket_id" value="<?php echo $_REQUEST['ticket_id']; ?>" />
<input type="hidden" name="multi_id" value="<?php echo $_REQUEST['multi_id']; ?>" />
<input type="hidden" name="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />

<input type="hidden" name="response_id" value="<?php echo $response_id; ?>" />
<input type="hidden" name="mode_name" value="directpayment" />

<table width="675" border="0" align="center" cellpadding="0" cellspacing="0" class="credit_box">
	<style>
		.credit_box tr.gray_line td{
			border-bottom: 1px solid #CCCCCC;
		}
		.credit_box td, .credit_box th{
			padding: 4px 0;
		}
	</style>
    <tr class="gray_line">
      <td width="210"><h1 style="border:0px;">Credit Card</h1></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td >Card Type</td>
        <td style="float:left">
            <select name="cardtype" >
                <option value="visa" selected="selected">Visa</option>
                <option value="MasterCard">Master Card</option>
                <option value="AmericanExpress">American Express</option>
                <option value="Discover">Discover</option>
           </select>
        </td>
	</tr>
     <tr>
      <td>Amount</td>
      <td style="text-align:left; font-weight:bold" colspan="2">$<?php echo number_format($_REQUEST['amount'],2); ?></td>
    </tr>
    	<tr>
		<td >First Name</td>
		<td style="float:left"><input name="firstname" type="text" value="" class="textfield_reg1"  maxlength="32"></td>
	</tr>
	<tr>
		<td >Last Name</td>
		<td style="float:left"><input name="lastname" type="text" value="" class="textfield_reg1" maxlength="32" ></td>
	</tr>

   <!-- <tr>
      <td>Name as it appears on card</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="name"/></span></td>
    </tr>-->
    <tr>
      <td>Card Number</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="cardnumber"/></span></td>
    </tr>
    <tr>
      <td>Expiration Date</td>
      <td width="87" style="float:left"><select name="cardmonth"  style="width: 80px; height:32px;">
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select></td>
      <td  style="float:left">
	  <select name="cardyear"  style="width: 80px; height:32px; float:left;">
	  <?php for($i=date("Y");$i<=date("Y")+15;$i++){?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	  <?php }?>		
	  </select>
			
	 </td>
    </tr>
    <tr>
      <td style="padding-top:20px;"><div style="margin-top:20px">Card Security Code</div></td>
      <td colspan="2"><span style="float:left; margin:20px 5px 0 0;"><input type="password" class="textfield_reg2" name="cardcvv" style="width:100px"/></span>  <span style="float:left"><!--<img src="<?php //echo $obj_base_path->secure_base_path(); ?>/images/securitycode.png" alt=""  width="100" />--></span></td>
    </tr>
     <tr class="gray_line">
      <td colspan="3" align="left"><h1  style="border:0px;">Billing Address</h1></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
   <!-- <tr>
      <td>Name</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="textfield524"/></span></td>
    </tr>-->
    <tr>
      <td>Address 1</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="address1"/></span></td>
    </tr>
    <tr>
      <td>Address 2</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="address2"/></span></td>
    </tr>
    <tr>
      <td>City</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="city"/></span></td>
    </tr>
    <tr>
      <td>State</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="state"/></span></td>
    </tr>
    <tr>
      <td>Country</td>
      <th colspan="2" style="float:left; padding:8px 0 0 30px;"><select name="select2" class="textfield_reg1" style="width:200px; height:32px;">
	  
	  <?php 
			//list country
			//$obj_countries->countries_list();
//			while($obj_countries->next_record()){
			?>
			<!--<option value="<?php //echo $obj_countries->f('iso'); ?>"><?php //echo $obj_countries->f('printable_name'); ?></option>-->
			<?php //}?>
	  </select></th>

    <tr>
      <td>Zipcode</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textfield_reg1" name="zip"  style="width:196px;"/></span></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="Submit52" class="btn3" value="Submit" style="float:left;"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>