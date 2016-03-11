
<?php
	include("../class/db_mysql.inc");
	include("../class/user_class.php");
	$obj_base_path = new DB_Sql;
	session_start();
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
	//include('../include/user_inc.php');
//echo "dfgdgfgf".$_SESSION['langSessId'];
	
$obj=new user;
$obj_cat=new user;

//echo "hh ".$_REQUEST['languageId']; 

############# Code For Language Change ###############
if($_REQUEST['languageId']!= "")
{
	$_SESSION['langSessId'] = $_REQUEST['languageId'];
	if($_SESSION['ses_admin_id'] == ''){
		$_SESSION['site_lang'] = $_REQUEST['languageId'];
	}
}

if($_SESSION['langSessId']=='')
{
?>	
<script>
$(document).ready(function(){
	
	var language = window.navigator.userLanguage || window.navigator.language;
	//alert(language); 
	if(language=="es"){
		<?php	
		$_SESSION['langSessId'] = 'spn';
		$_SESSION['langSessDir'] = "languages/spanish";
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
		?>
		$('#languageId').val("spn");
	}
	else{
		<?php	
		$_SESSION['langSessId'] = 'eng';
		$_SESSION['langSessDir'] = "languages/english";
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
		?>
		$('#languageId').val("eng");
	}
	$('#frmlanguage').submit();
})
</script>
<?php	
}	
else
{
	if($_REQUEST['languageId'])
	{
		$_SESSION['langSessId'] = $_REQUEST['languageId'];
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
		if($_REQUEST['languageId']== 'eng')
			$_SESSION['langSessDir'] = "languages/english";
		else
			$_SESSION['langSessDir'] = "languages/spanish";
	}
}
$url = basename($_SERVER['PHP_SELF']);
/*$url = $_SERVER['REQUEST_URI'];
$url_arr = explode("/",$url);*/
if($url !="")	$page = $url;
else			$page = "index.php";

if($_SESSION['langSessId'] == 'eng')
{
	include("../include/languages/english.php");
	include($_SESSION['langSessDir']."/".$page);
}
else
{
	include("../include/languages/spanish.php");
	include($_SESSION['langSessDir']."/".$page);
}

if($_SESSION['ses_admin_id']!=""){
// Check if user has lang or not
$obj_check = new user;
$obj_check->getAdminById($_SESSION['ses_admin_id']);
$obj_check->next_record();

if($obj_check->f('language')==""){
?>

<script>
$(document).ready(function(){
	if($('#language').length){
		if($('#languageId').val()=="spn")
			$('#language').val("Spanish");
		else
			$('#language').val("English");
	}
});
</script>
<?php
}
}
	
	
	
//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();


?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up</title>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />


</head>
<body>

<!--header-->
<?php include("../include/secondary_header.php");?>
<?php include("../include/menu_header.php");?>
<!--header-->

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
                <div style="text-align: right;"><a href="<?php echo $obj_base_path->base_path(); ?>/payment/<?php echo $_REQUEST['event_id']; ?>"><input type="button" class="btn1_sudip" value="<?php if($_SESSION['langSessId']=='eng'){echo "Cancel & Return to payment selection";}elseif($_SESSION['langSessId']=='spn'){ echo "Cancelar y Volver a la selecci&oacute;n de pago";}?>"></a></div> 
                  <div class="clear"></div>
                          <div class="clear"></div>
                            
                              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="padding: 24px 0;">
                                
                                <tr>
                                  <td>
                                  <div style="text-align:center;">
                                  <form method="POST" action="<?php echo $obj_base_path->base_path(); ?>/payment-receipt/<?php echo $_REQUEST['event_id']; ?>" name="DoDirectPaymentForm" autocomplete="off">
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

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="credit_box">
	<style>
		.credit_box tr.gray_line td{
			border-bottom: 1px solid #CCCCCC;
		}
		.credit_box td, .credit_box th{
			padding: 4px 0;
		}
	</style>
    <tr class="gray_line">
      <td width="20%"><h1 style="border:0px;"><?php if($_SESSION['langSessId']=='eng'){echo "Credit Card";}elseif($_SESSION['langSessId']=='spn'){echo "Tarjeta de Cr&eacute;dito";} ?></h1></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td ><?php if($_SESSION['langSessId']=='eng'){echo "Card Type";}elseif($_SESSION['langSessId']=='spn'){echo "Tipo de tarjeta";} ?></td>
        <td style="float:left;margin-left: 6px;">
            <select name="cardtype" >
                <option value="visa" selected="selected">Visa</option>
                <option value="MasterCard">Master Card</option>
                <option value="AmericanExpress">American Express</option>
                <option value="Discover">Discover</option>
           </select>
        </td>
	</tr>
     <tr>
      <td><?php if($_REQUEST['currency'] == 'us'){echo "US$";}elseif($_REQUEST['currency'] == 'mx'){echo "MX Peso";}?></td>
      <td style="text-align:left; font-weight:bold; margin-left: 6px;" colspan="2">$<?php echo number_format($_REQUEST['amount'],2); ?></td>
    </tr>
    	<tr>
		<td ><?php if($_SESSION['langSessId']=='eng'){echo "First Name";}elseif($_SESSION['langSessId']=='spn'){echo "Nombre";} ?></td>
		<td style="float:left"><input name="firstname" type="text" class="textbg_grey"  maxlength="32" value="<?php echo $_REQUEST['fname']; ?>"></td>
	</tr>
	<tr>
		<td ><?php if($_SESSION['langSessId']=='eng'){echo "Last Name";}elseif($_SESSION['langSessId']=='spn'){ echo "Apellido";} ?></td>
		<td style="float:left"><input name="lastname" type="text" class="textbg_grey" maxlength="32" value="<?php echo $_REQUEST['lname']; ?>"></td>
	</tr>

   <!-- <tr>
      <td>Name as it appears on card</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="name"/></span></td>
    </tr>-->
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "Card Number";}elseif($_SESSION['langSessId']=='spn'){ echo "N&#250;mero de tarjeta";} ?></td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="cardnumber"/></span></td>
    </tr>
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "Expiration Date";}elseif($_SESSION['langSessId']=='spn'){ echo "fecha de expiraci&oacute;n";} ?></td>
      <td  style="float:left;margin-left: 6px;"><select name="cardmonth" class="selectbg12">
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
			</select>
	
	  <select name="cardyear" class="selectbg12">
	  <?php for($i=date("Y");$i<=date("Y")+15;$i++){?>
		<option value="<?php echo $i+1; ?>"><?php echo $i+1; ?></option>
	  <?php }?>		
	  </select>
			
	 </td>
    </tr>
    <tr>
      <td style="padding-top:20px;"><div style="margin-top:20px"><?php if($_SESSION['langSessId']=='eng'){echo "Card Security Code";}elseif($_SESSION['langSessId']=='spn'){ echo "C&oacute;digo de Seguridad";} ?></div></td>
      <td colspan="2"><span style="float:left; margin:20px 5px 0 0;"><input type="password" class="textbg_grey" name="cardcvv" style="width:100px"/></span>  <span style="float:left"><!--<img src="<?php //echo $obj_base_path->secure_base_path(); ?>/images/securitycode.png" alt=""  width="100" />--></span></td>
    </tr>
     <tr class="gray_line">
      <td colspan="3" align="left"><h1  style="border:0px;"><?php if($_SESSION['langSessId']=='eng'){echo "Billing Address";}elseif($_SESSION['langSessId']=='spn'){ echo "Direcci&oacute;n de Facturaci&oacute;n";} ?></h1></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
   <!-- <tr>
      <td>Name</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="textfield524"/></span></td>
    </tr>-->
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "Address";}elseif($_SESSION['langSessId']=='spn'){ echo "Direcci&#243;n";}?></td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="address1" value="<?php echo $_REQUEST['address']; ?>"/></span></td>
    </tr>
    <?php /*?><tr>
      <td>Address 2</td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="address2"/></span></td>
    </tr> <?php */?>
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "City";}elseif($_SESSION['langSessId']=='spn'){ echo "Ciudad";}?></td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="city" value="<?php echo $_REQUEST['city']; ?>"/></span></td>
    </tr>
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "State";}elseif($_SESSION['langSessId']=='spn'){ echo "Estado";}?></td>
      <?php
      $obj_province_name = new User;
      $obj_province_name->getstateNameById($_REQUEST['country_id'], $_REQUEST['province']);
      $obj_province_name->next_record();
      ?>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="state" value="<?php echo $obj_province_name->f('state_name'); ?>" /></span></td>
    </tr>
    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "Country";}elseif($_SESSION['langSessId']=='spn'){ echo "Pa&#237;s";}?></td>
      <th colspan="2"  style="float:left;margin-left: 6px;" >
	<select name="select2" class="selectbg12" >
	<?php 
	//list country
	$obj_countries = new user;
	$sel = "selected='selected'";
	$obj_countries->countries_list();
	while($obj_countries->next_record()){
	?>
		<option value="<?php echo $obj_countries->f('id'); ?>" <?php if($obj_countries->f('id') == $_REQUEST['country_id'] ) echo $sel; else echo '' ;?> >
		<?php echo $obj_countries->f('printable_name'); ?>
		</option>
	<?php }?>
	  </select></th>

    <tr>
      <td><?php if($_SESSION['langSessId']=='eng'){echo "Postal Code";}elseif($_SESSION['langSessId']=='spn'){ echo "C&#243;digo Postal";}?></td>
      <td colspan="2"><span class="textfield_reg"><input type="text" class="textbg_grey" name="zip"  value="<?php echo $_REQUEST['postal_code']; ?>" style="width:196px;"/></span></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="Submit52" value="<?php if($_SESSION['langSessId']=='eng'){echo "Submit";}elseif($_SESSION['langSessId']=='spn'){ echo "presentar";}?>" class="btn1_sudip" style="float:left;"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>
				  
				  </div></td>
                                </tr>
                               
                                <tr>
                                  <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>    
                               </table>
                
		<div style="text-align: right;"><a href="<?php echo $obj_base_path->base_path(); ?>/payment/<?php echo $_REQUEST['event_id']; ?>"><input type="button" class="btn1_sudip" value="<?php if($_SESSION['langSessId']=='eng'){echo "Cancel & Return to payment selection";}elseif($_SESSION['langSessId']=='spn'){ echo "Cancelar y Volver a la selecci&oacute;n de pago";}?>"></a></div>  
		         
                <div class="clear"></div>
            </div>
           <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
	</div>


<!--footer-->
<?php include("../include/frontend_footer.php");?>
<!--footer-->


</body>
</html>







