<?php
	include("class/db_mysql.inc");
	include("class/user_class.php");
	session_start();  //if use session its not working..
	
	$obj_base_path = new DB_Sql;
	//$customArray = array($_POST['event_id'],$_POST['ticket'],$_POST['payment'],$_POST['ticket_id'],$_POST['multi_id'],$_SESSION['ses_admin_id'],$_POST['cart_id']);
	//$customArray = array($_POST['event_id'],$_POST['ticket'],'TNS',$_POST['ticket_id'],$_POST['multi_id'],$_POST['cart_id']);
	//$customString = implode("-",$customArray);
        $obj=new user;
        $obj_attempt=new user;
        $obj_cartDetails=new user;
        $obj_event=new user;
        $objEvent=new user;
        
                    
	                //for attempt....
                       // echo "attempt= ".$_POST['attempt_id'];
			if($_POST['attempt_id']>0)
			 {
                            
                          //  echo "post attempt has  value.";
                          //  echo "attempt= ".$_POST['attempt_id'];
			  
			  $obj_attempt->GetAllAttemptById($_POST['attempt_id']);
			  $obj_attempt->next_record();
			  $order_id = $obj_attempt->f('order_id');
                          ///echo "order_id= ".$order_id;
			  $attempt_count = $obj_attempt->f('attempt_count');
                          ///echo "attempt_count= ". $attempt_count;
                          $attempt_count_add=$attempt_count + 1;
                          ///echo "attempt_count_add= ". $attempt_count_add;
			  $order_info = $order_id;
                          $vpc_MerchTxnRef= $order_info.'/'.$attempt_count_add;
                          ///echo "order_info= ".$order_info;
                          ///echo "vpc_ref= ".$vpc_MerchTxnRef;
                          $obj_cartDetails->cart_details($order_info);
                          $obj_cartDetails->next_record();
                          $event_id=$obj_cartDetails->f('event_id');
                          ///echo "event_id= ".$event_id;
 
                                $parches_amount=$_POST['amount'];
                                $parches_amount= str_replace( ',', '', $parches_amount)*100; //for cent value
			 }
			 else
			  {
                            //echo "1st attempt.";
                            //echo "cart =".$_POST['cart_id'];
                            //$cartarr = $_POST['cart_id'];
                           $cart_arr =explode(",",$_POST['cart_id']);
			   $order_info = $cart_arr[0];
                           //echo "oinfo= ".$order_info;
                           $vpc_MerchTxnRef= $order_info.'/1';
                           //$attempt_count='1';
                            //$parches_amount_array=explode(".",$_POST['amount']);
                            //$parches_amount=$parches_amount_array[0];
                           // echo "hidAmount=".$_POST['amount'];
                            $parches_amount=$_POST['amount'];
                            $parches_amount= str_replace( ',', '', $parches_amount)*100; //for cent value
			  }
			
                        
        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>Virtual Payment Client Example</title>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <style type='text/css'>
        <!--
        H1       { font-family:Arial,sans-serif; font-size:20pt; color:#08185A; font-weight:600; margin-bottom:0.1em}
        H2       { font-family:Arial,sans-serif; font-size:14pt; color:#08185A; font-weight:100; margin-top:0.1em}
        H2.co    { font-family:Arial,sans-serif; font-size:24pt; color:#08185A; margin-top:0.1em; margin-bottom:0.1em; font-weight:100}
        H3.co    { font-family:Arial,sans-serif; font-size:16pt; color:#FFFFFF; margin-top:0.1em; margin-bottom:0.1em; font-weight:100}
        BODY     { font-family:Verdana,Arial,sans-serif; font-size:10pt; color:#08185A background-color:#FFFFFF }
        TR       { height:25px; }
        TR.shade { height:25px; background-color:#CED7EF }
        TR.title { height:25px; background-color:#0074C4 }
        TD       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        P        { font-family:Verdana,Arial,sans-serif; font-size:10pt; color:#FFFFFF }
        P.blue   { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#08185A }
        P.red    { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
        P.green  { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#00AA00 }
        DIV.bl   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#0074C4 }
        LI       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
        INPUT    { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold }
        SELECT   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold }
        TEXTAREA { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:normal; scrollbar-arrow-color:#08185A; scrollbar-base-color:#CED7EF }
        A:link   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        A:visited{ font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        A:hover  { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0000 }
        A:active { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0000 }
        -->
    </style>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){
         $("form#order").submit();
        });
      

    </script>
</head>

<body>
    <div align="center"><h1>Processing...</h1></div>
     <div style="display: none;">
<!-- start branding table -->
<table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
    <tr>
        <td bgcolor='#CED7EF' width='90%'><h2 class='co'>&nbsp;Banamex Virtual Payment Client Example</h2></td>
    </tr>
</table>
<!-- end branding table -->

<center><h1>PHP 3-Party Transaction</h1></center>
<center><h2>Simply input those required fields to change the functionality.</h2></center>


<!-- The "Pay Now!" button submits the form and gives control to the form 'action' parameter -->
<form id="order" action="PHP_VPC_3Party_Super_Order_DO.php" method="post" accept-charset="UTF-8">
<input type="hidden" name="Title" value = "PHP VPC 3 Party Super Transacion">

<!--------------------------------------------------------------------------->
   <?php if($_POST['attempt_id']>0) { 
    // $obj_event=event_by_id($obj_cartDetails->f('event_id'));
    ?>
        <input type="hidden" name="item_name" value="<?php echo $_POST['name']; ?>">
        <input type="hidden" name="event_id" value="<?php echo $_POST['event_id'];?>">
        <input type="hidden" name="ticket" value="<?php echo $_POST['ticket'];?>">
        <input type="hidden" name="payment_type" value="<?php echo $_POST['ticket'];?>">  <!---payment_type = ticket_id becaz can't get the value of ticket_id -->
        <input type="hidden" name="ticket_id" value="<?php echo $_POST['ticket_id'];?>">
        <input type="hidden" name="multi_id" value="<?php echo $_POST['multi_id'];?>">
        <input type="hidden" name="cart_id" value="<?php echo $_POST['cart_id'];?>">
        <input type="hidden" name="user_id" value="<?php echo $_POST['user_id'];?>">
    
    <?php }
    else {
        
        ?>
                
        <!--<input type="hidden" name="amount" value="<?php //echo $parches_amount; ?>">-->
        <input type="hidden" name="item_name" value="<?php echo $_POST['name']; ?>">
        <input type="hidden" name="event_id" value="<?php echo $_POST['event_id'];?>">
        <input type="hidden" name="ticket" value="<?php echo $_POST['ticket'];?>">
        <input type="hidden" name="payment_type" value="<?php echo $_POST['ticket'];?>">  <!---payment_type = ticket_id becaz can't get the value of ticket_id -->
        <input type="hidden" name="ticket_id" value="<?php echo $_POST['ticket_id'];?>">
        <input type="hidden" name="multi_id" value="<?php echo $_POST['multi_id'];?>">
        <input type="hidden" name="cart_id" value="<?php echo $_POST['cart_id'];?>">
        <input type="hidden" name="user_id" value="<?php echo $_POST['user_id'];?>">

      <?php } ?>
      
<!---------------------------------------------------------------------------->
<!--<input type="hidden" name="custom" value="<?php //echo $customString; ?>">-->

<!-- get user input -->
<table width="80%" align="center" border="0" cellpadding='0' cellspacing='0'>

<tr class="shade">
    <td align="right"><strong><em>Virtual Payment Client URL:&nbsp;</em></strong></td>
    <td><input name="virtualPaymentClientURL" size="65" value="https://banamex.dialectpayments.com/vpcpay" maxlength="250"/></td>
</tr>
<tr><td colspan="2">&nbsp;<hr width="75%">&nbsp;</td></tr>
<tr class="title">
    <td colspan="2" height="25"><p><strong>&nbsp;Basic 3-Party Transaction Fields</strong></p></td>
</tr>
<tr>
    <td align="right"><strong><em> VPC Version: </em></strong></td>
    <td><input name="vpc_Version" value="1" size="20" maxlength="8"/></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Command Type: </em></strong></td>
    <td><input name="vpc_Command" value="pay" size="20" maxlength="16"/></td>
</tr>
<!--<input type="hidden" name="vpc_AccessCode" value="44473583" size="20" maxlength="8"/>--> <!---Test mode---->
<input type="hidden" name="vpc_AccessCode" value="5C2BF768" size="20" maxlength="8"/>   <!---production mode---->

<input type="hidden" name="vpc_MerchTxnRef" value="<?php echo $vpc_MerchTxnRef;?>" size="20" maxlength="40"/>

<!--<input type="hidden" name="vpc_Merchant" value="TEST1026854" size="20" maxlength="16"/>--> <!---Test mode---->
<input type="hidden" name="vpc_Merchant" value="1026854" size="20" maxlength="16"/>     <!---production mode---->

<input type="hidden" name="vpc_OrderInfo" value="<?php echo $order_info;?>" size="20" maxlength="34"/>

<tr>
    <td align="right"><strong><em>Purchase Amount: </em></strong></td>
    <td><?php echo number_format($parches_amount/100,2); ?>
	<input type="hidden" name="vpc_Amount" value="<?php echo $parches_amount; ?>" maxlength="10" readonly/>
    </td>
    
</tr>

<input  type="hidden" name="vpc_ReturnURL" size="65" value="http://kpasapp.com/PHP_VPC_3Party_Super_Order_DR.php" maxlength="250"/>
<tr>
    <td align="right"><strong><em>Payment Server Display Language Locale: </em></strong></td>
    <?php if($_SESSION['langSessId']=='eng') {?>
    <td><select name="vpc_Locale"><option SELECTED>en_MX</option><option>es_MX</option></select></td>
    <?php }elseif($_SESSION['langSessId']=='spn'){?>
    <td><select name="vpc_Locale"><option SELECTED>es_MX</option><option>en_MX</option></select></td>
    <?php } ?>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Currency: </em></strong></td>
    <td><select name="vpc_Currency"><option SELECTED>MXN</option></select></td>
</tr>

<tr class="title">
    <td colspan="2" height="25"><p><strong>&nbsp;Custom Payment Plan Field</strong></p></td>
</tr>
<tr>
<td align="right"><strong><em>Custom Payment Plan ID:</strong></em></td><td><input type="text" name="vpc_CustomPaymentPlanPlanId" value="" size="20" maxlength="16"></td>

<tr>    <td colspan="2">&nbsp;</td></tr>

<input type="hidden" name="attempt_id" size="65" value="<?php echo $_POST['attempt_id'];?>" maxlength="250"/>


<tr>
    <td>&nbsp;</td>
    <td><input type="submit" NAME="SubButL" value="Pay Now!"></td>
</tr>
<tr><td colspan="2">&nbsp;<hr width="75%">&nbsp;</td></tr>

<tr>
    <td colspan="2">
        <p class='blue'><strong><em><u>Note</u>:</em></strong><br/>
            Any information passed through the customer's browser
            can potentially be modified by the customer, or even by third parties to
            fraudulently alter the transaction data. Therefore all transactional
            information should <strong>not</strong> be passed through the browser in
            a way that could potentially be modified (e.g. hidden form fields).
            Transaction data should only be accepted once from a browser at the
            point of input, and then kept in a way that does not allow others
            to modify it (e.g. database, server session, etc.). Any transaction
            information displayed to a customer, such as amount, should be passed
            only as display information and the actual transactional data should be
            retrieved from the secure source last thing at the point of processing
        the transaction.</p>
       
    </td>
</tr>

<tr>
    <td width="40%">&nbsp;</td>
    <td width="60%">&nbsp;</td>
</tr>

</table>

</form>
</div> <!---Div visibility none----->
          
</body>

<head>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
</head>
</html>
