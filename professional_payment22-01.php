<?php
include('include/user_inc.php');
//print_r($_SESSION);


$obj=new user;
$obj_country=new user;
$obj_country1=new user;
$obj_sendmail=new user;
$faq = new User;
$edit_admin= new User;
$obj_venuestate= new User;
$obj_page = new user;
$obj_page1 = new user;
$obj_coun = new user;
$faq=new user;
$edit_pay = new user;
$add_pay = new user;

//print_r($_SESSION);

if($_SESSION['ses_admin_id']==""){
	header("Location:".$obj_base_path->base_path()."/index");
}


$obj->getAdminById($_SESSION['ses_admin_id']);
$obj->next_record();
//echo 1;exit;

$faq->checkPaymentByuser($_SESSION['ses_admin_id']);
$faq->next_record();
list($mon,$yr) = explode("-",$faq->f('chrg_exp'));


if(isset($_POST['hid_edit']))
{
	//print_r($_POST);exit;
	
	$dep_bank_acount=$_POST["dep_bank_acount"];
	$dep_bank_account_no=$_POST["dep_bank_account_no"];
	$dep_bank_account_hold_name=$_POST["dep_bank_account_hold_name"];
	$dep_bank_account_country=$_POST["dep_bank_account_country"];
	$inter_bank_key=$_POST["inter_bank_key"];
	$routing_number=$_POST["routing_number"];
	$swift_code=$_POST["swift_code"];
	$chrg_credit_card_type=$_POST["chrg_credit_card_type"];
	$chrg_credit_crd_no=$_POST["chrg_credit_crd_no"];
	$chrg_exp_mon=$_POST["chrg_exp_mon"];
	$chrg_exp_yr=$_POST["chrg_exp_yr"];
	$chrg_exp = '';
	if($chrg_exp_mon!="" && $chrg_exp_yr!="")
		$chrg_exp = $chrg_exp_mon."-".$chrg_exp_yr;
	
	$chrg_card_hold_name=$_POST["chrg_card_hold_name"];
	$chrg_billing_zip=$_POST["chrg_billing_zip"];
	$chrg_bank_account_no=$_POST["chrg_bank_account_no"];
	$chrg_bank_account_hold_name=$_POST["chrg_bank_account_hold_name"];
	$chrg_bank_account_country=$_POST["chrg_bank_account_country"];
	$chrg_bank_acount=$_POST["chrg_bank_acount"];
	$chrg_routing_number=$_POST["chrg_routing_number"];
	$chrg_swift_code=$_POST["chrg_swift_code"];
	$chrg_inter_bank_key=$_POST["chrg_inter_bank_key"];
	$chrg_card_account_country=$_POST["chrg_card_account_country"];
	
	// Set null ...
	if($_POST['dep_paypal']==1){
		$dep_paypal_text = $_POST['dep_paypal_text'];
		
		$dep_bank_acount 			= '';
		$dep_bank_account_no		= '';
		$dep_bank_account_hold_name	= '';
		$dep_bank_account_country	= '';
		$inter_bank_key				= '';
		$routing_number				= ''; 
		$swift_code					= '';
	}
	else{
		$dep_paypal_text = '';
	}
	
	if($_POST['charg_paypal']==1){
		$charg_paypal_text = $_POST['charg_paypal_text'];
		
		$chrg_credit_card_type='';
		$chrg_credit_crd_no='';
		$chrg_exp = '';
		$chrg_card_hold_name='';
		$chrg_billing_zip='';
		
		$chrg_bank_account_no='';
		$chrg_bank_account_hold_name='';
		$chrg_bank_account_country='';
		$chrg_bank_acount= '';
		$chrg_inter_bank_key= '';
		$chrg_routing_number= '';
		$chrg_swift_code= '';
		$chrg_card_account_country= '';
		
	}
	elseif($_POST['charg_paypal']==2){
		$charg_paypal_text = '';
		
		$chrg_bank_account_no='';
		$chrg_bank_account_hold_name='';
		$chrg_bank_account_country='';
		$chrg_bank_acount= '';
		$chrg_inter_bank_key= '';
		$chrg_routing_number= '';
		$chrg_swift_code= '';
		
	}
	else{
		$charg_paypal_text = '';
		
		$chrg_credit_card_type='';
		$chrg_credit_crd_no='';
		$chrg_exp = '';
		$chrg_card_hold_name='';
		$chrg_billing_zip='';
		$chrg_card_account_country= '';
	}
	// Set null ...
	
	if($faq->num_rows()>0){	
		$edit_pay->edit_user_payment($_POST['dep_paypal'],$dep_paypal_text,$dep_bank_acount,$dep_bank_account_no,$dep_bank_account_hold_name,$inter_bank_key,$routing_number,$swift_code,$dep_bank_account_country,$_POST['charg_paypal'],$charg_paypal_text,$chrg_credit_card_type,$chrg_credit_crd_no,$chrg_exp,$chrg_card_hold_name,$chrg_billing_zip,$chrg_bank_acount,$chrg_bank_account_no,$chrg_inter_bank_key,$chrg_routing_number,$chrg_swift_code,$chrg_bank_account_hold_name,$chrg_bank_account_country,$chrg_card_account_country,$_SESSION['ses_admin_id']);
	}
	else{
		$add_pay->add_user_payment($_POST['dep_paypal'],$dep_paypal_text,$dep_bank_acount,$dep_bank_account_no,$dep_bank_account_hold_name,$inter_bank_key,$routing_number,$swift_code,$dep_bank_account_country,$_POST['charg_paypal'],$charg_paypal_text,$chrg_credit_card_type,$chrg_credit_crd_no,$chrg_exp,$chrg_card_hold_name,$chrg_billing_zip,$chrg_bank_acount,$chrg_bank_account_no,$chrg_inter_bank_key,$chrg_routing_number,$chrg_swift_code,$chrg_bank_account_hold_name,$chrg_bank_account_country,$chrg_card_account_country,$_SESSION['ses_admin_id']);
	}

	if($_POST['set_param']==1){
		//redirect
		header("Location:".$obj_base_path->base_path()."/professional_preference");
		exit;
	}
	else{
		header("Location:".$obj_base_path->base_path()."");
		exit;
	}

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profile Setting</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />

  

<script language="javascript" type="text/javascript">
function IsEmail() {
  var email = $('#email').val();
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  //alert(regex.test(email));
  
  if(regex.test(email) == false){
  	$('#email_err').html("Incorrect Email!");
  }
  
  return regex.test(email);
}





function save_password(param)
{
	if($('#current_pass').val() == ''){
		$('#sh_current_pass').html("Please Enter Password");
		setTimeout('$("#sh_current_pass").html("")',3000);
		return false;
	}
	if($('#current_pass').val() != $('#pass_orig_hid').val()){
		$('#sh_current_pass').html("Please Enter Old Password");
		setTimeout('$("#sh_current_pass").html("")',3000);
		return false;
	}
	if($('#new_pass').val() == ''){
		$('#sh_new_pass').html("Please Enter New Password");
		setTimeout('$("#sh_new_pass").html("")',3000);
		return false;
	}
	if($('#re_pass').val() == '' || $('#re_pass').val() != $('#new_pass').val()){
		$('#sh_new_pass').html("Please Re-Enter Password");
		setTimeout('$("#sh_new_pass").html("")',3000);
		return false;
	}
	
	
	
	
}

function redirectPage(param)
{
	/*if(document.getElementById("terms_condition").checked == false) 
    {
        alert ('You didn\'t choose terms and conditon.');
        return false;
	}*/
	$('#set_param').val(param);
	$('#edit_pro').submit();
}
</script>
<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        <div class="left_panel bg" style="width:978px;">
         <div class="cheese_box">
            <div class="blue_box1" style="width:976px;">
             <div class="blue_boxh"><p style="font-size: 28px; line-height: 30px;"><?php echo MYKPASAPP."<br/><span>".PROFPRO."</span>";?></p></div>
             <div class="blue_boxr" style="width:754px;">
               <ul>
                <li><a href="<?php echo $obj_base_path->base_path(); ?>/professional_userprofile"><?php echo ACCOUNT; ?><!--Account--></a></li>
                <li><a href="<?php echo $obj_base_path->base_path(); ?>/professional_preference"><?php echo PREFERENCES; ?><!--Preferences--></a></li>
                <li><a class="here" href="<?php echo $obj_base_path->base_path(); ?>/professional_payment"><?php echo PAYMENT; ?><!--Payment--></a></li>
               </ul>
             </div>
            </div>
            <div class="clear"></div>                    
            <div style="width: 976px; float: none; margin: 0 auto;">
            <div class="clear"></div>    
              <form method="post" action="" enctype="multipart/form-data" name="edit_pro" id="edit_pro" autocomplete="off" onsubmit="return IsEmail();">
              <input type="hidden" name="hid_edit" id="hid_edit" value="1" />
              <input type="hidden" name="set_param" id="set_param" value="" />
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td style="width: 434px;"><table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" class="prefer_pro1" style="width: 419px;">
                       <tr>
                        <td colspan="2"><strong><?php echo DEPOSIT_METHOD;?></strong></td>
                       </tr>
                       <tr>
                        <td width="41%"><input type="radio" name="dep_paypal" id="dep_paypal" <?php if($faq->f('dep_method')==1){?> checked="checked"<?php }?> value="1" />&nbsp;<strong><?php echo PAYPAL_ACCOUNT;?></strong></td> 
                        <td width="59%"><input type="text" name="dep_paypal_text" id="dep_paypal_text" class="textbg_grey" value="<?php echo $faq->f('dep_paypal_text');?>" style="width: 190px; margin-right: 6px;" /></td>
                       </tr>
                       <tr>
                        <td colspan="2"><div id="showStatus"></div></td>
                       </tr>
                       <tr>
                        <td colspan="2"><input type="radio" name="dep_paypal" id="dep_paypal" value="2" <?php if($faq->f('dep_method')==2){?> checked="checked"<?php }?> /><strong><?php echo WIRE_TRANSFER;?></strong></td>
                       </tr>
                       <tr>
                        <td style="padding-left:30px;"><?php echo BANK_ACCOUNT;?><span style="color:red;">*</span></td>
                        <td>
                            <input type="text" name="dep_bank_acount" id="dep_bank_acount" class="textbg_grey" value="<?php echo $faq->f('dep_bank_acount');?>" style="width: 190px;"/><span class="err" id="err_lname"></span>  </td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo BANK_ACCOUNT_NUMBER;?> <span style="color:red;">*</span></td>
                        <td><input type="text" name="dep_bank_account_no" id="dep_bank_account_no" class="textbg_grey" value="<?php echo $faq->f('dep_bank_account_no')?>" style="width: 190px;"/><span class="err" id="err_name"></span></td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo BANK_ACC_HOL_NAME;?>:</td>
                        <td>
                        <input type="text" name="dep_bank_account_hold_name" id="dep_bank_account_hold_name" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('dep_bank_account_hold_name')?>" /> </td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo INTER_BANK_KEY;?>:</td>
                        <td>
                        <input type="text" name="inter_bank_key" id="inter_bank_key" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('inter_bank_key')?>" /> </td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo ROUTING_NUMBER;?>:</td>
                        <td>
                        <input type="text" name="routing_number" id="routing_number" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('routing_number')?>" /> </td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo SWIFT_CODE;?>:</td>
                        <td>
                        <input type="text" name="swift_code" id="swift_code" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('swift_code')?>" /> </td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo BANK_ACC_COUNTRY;?>:</td>
                        <td>
                            <select name="dep_bank_account_country" id="dep_bank_account_country" class="selectbg12" style="width:205px; margin-left:5px;">
                                <option value="">Choose Country</option>
                            <?php
                            $obj_country1->countries_list();
                            while($obj_country1->next_record())
                            {
                            ?>
                            <option value="<?php echo $obj_country1->f('id');?>" <?php if($faq->f('dep_bank_account_country')==$obj_country1->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_country1->f('nicename');?></option>
                            <?php
                            }
                            ?>
                            </select></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left: 132px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left: 132px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left: 132px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left: 132px;">&nbsp;</td>
                      </tr>
                    </table></td>
                   <td align="left" valign="top">
                   <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" class="prefer_pro">
                     <tr>
                        <td colspan="2"><strong><?php echo CHARGE_METHOD;?></strong></td>
                     </tr>
                     <tr>
                        <td width="49%"><input type="radio" name="charg_paypal" id="charg_paypal" <?php if($faq->f('chrg_method')==1){?> checked="checked"<?php }?> value="1" />&nbsp;<strong><?php echo PAYPAL_ACCOUNT;?> </strong>
                        <td width="51%"> <input type="text" name="charg_paypal_text" id="charg_paypal_text" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('charg_paypal_text')?>" /></td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align:left;"><input type="radio" name="charg_paypal" id="charg_paypal" <?php if($faq->f('chrg_method')==2){?> checked="checked"<?php }?> value="2" />&nbsp;<strong><?php echo CREDIT_CARD;?></strong></td>
                      </tr>
                      <tr>
                        <td style="padding-left:30px;"><?php echo CREDIT_CARD_TYPE;?></td>
                        <td>
                           <select name="chrg_credit_card_type" id="chrg_credit_card_type" class="textbg_grey" style="width:205px; margin-left:5px;">
                            <option value="Visa" <?php if($faq->f('chrg_credit_card_type')=="Visa"){?> selected="selected"<?php } ?>>Visa</option>
                            <option value="MasterCard" <?php if($faq->f('chrg_credit_card_type')=="MasterCard"){?> selected="selected"<?php } ?>>MasterCard</option>
                            <option value="American Express" <?php if($faq->f('chrg_credit_card_type')=="American Express"){?> selected="selected"<?php } ?>>American Express</option>
                            <option value="Diners Club" <?php if($faq->f('chrg_credit_card_type')=="Diners Club"){?> selected="selected"<?php } ?>>Diners Club</option>
                           </select>
                        </td>
                      </tr>						  
                      <tr>
                        <td style="padding-left:30px;"><?php echo CREDIT_CARD_NUMBER;?>:</td>
                        <td><input type="text" name="chrg_credit_crd_no" id="chrg_credit_crd_no" class="textbg_grey" value="<?php echo $faq->f('chrg_credit_crd_no')?>" style="width: 190px;"/><span class="err" id="err_name"></span></td>
                      </tr>
                    <tr>
                        <td style="padding-left:30px;"><?php echo EXP_DATE.$yr;?>:</td>
                        <td>Mon<span style="float: right; font: normal 14px/18px Arial, Helvetica, sans-serif; color: #01242F; width: 165px;">Year</span><br/>
                         <select name="chrg_exp_mon" id="chrg_exp_mon" class="textbg_grey" style="width:55px; margin-left:5px;">
                         <?php for($i=1;$i<=12;$i++){?>
                            <option value="<?php echo $i; ?>" <?php if($i==$mon){?> selected="selected"<?php } ?>><?php echo $i;?></option>
                            <?php } ?>
                         </select>
                         <select name="chrg_exp_yr" id="chrg_exp_yr" class="textbg_grey" style="width:105px; margin-left:5px;">
                         <?php $after_two_ry = date("Y");
						 $after_two_ry = $after_two_ry+2;
						  for($j=1990;$j<=2050;$j++){?>
                            <option value="<?php echo $j; ?>" <?php if($j==$yr){ echo 'selected="selected"'; } else if($after_two_ry==$j) { echo 'selected="selected"';} ?>><?php echo $j;?></option>
                            <?php } ?>
                         </select>
                       </td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px;"><?php echo CARD_HOLDER_NAME;?>:</td>
                        <td>
                        <input type="text" name="chrg_card_hold_name" id="chrg_card_hold_name" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_card_hold_name');?>"  /></td>
                    </tr>
                    <tr>
                    <td style="padding-left:30px;"><?php echo CREDIT_COUNTRY;?>:</td>
                    <td>
                      <select name="chrg_card_account_country" id="chrg_card_account_country" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">Choose Country</option>
                        <?php
                        $obj_country->countries_list();
                        while($obj_country->next_record())
                        {
                        ?>
                        <option value="<?php echo $obj_country->f('id');?>" <?php if($faq->f('chrg_card_account_country')==$obj_country->f('id')){?> selected="selected"<?php }?>>
                        <?php echo $obj_country->f('nicename');?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </td>
                </tr>
                    <tr>
                        <td style="padding-left:30px;"><?php echo BILLING_ZIP;?>:</td>
                        <td><input type="text" name="chrg_billing_zip" id="chrg_billing_zip" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_billing_zip');?>"  /></td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="charg_paypal" id="charg_paypal" value="3" <?php if($faq->f('chrg_method')==3){?> checked="checked"<?php }?> />&nbsp;<strong><?php echo WIRE_TRANSFER;?></strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px;"><?php echo BANK_ACCOUNT;?>:</td>
                        <td><input type="text" name="chrg_bank_acount" id="chrg_bank_acount" class="textbg_grey" value="<?php echo $faq->f('chrg_bank_acount');?>" style="width: 190px;"/>  </td>
                   </tr>
                    
                    <tr>
                    <td style="padding-left:30px;"><?php echo BANK_ACCOUNT_NUMBER;?>:</td>
                    <td><input type="text" name="chrg_bank_account_no" id="chrg_bank_account_no" class="textbg_grey" style="width: 190px;margin-right:6px;" value="<?php echo $faq->f('chrg_bank_account_no');?>"  /></td>
                  </tr>
                     <tr>
                        <td style="padding-left:30px;"><?php echo INTER_BANK_KEY;?>:</td>
                        <td>
                        <input type="text" name="chrg_inter_bank_key" id="chrg_inter_bank_key" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_inter_bank_key')?>" /> </td>
                  </tr>
                  <tr>
                    <td style="padding-left:30px;"><?php echo ROUTING_NUMBER;?>:</td>
                    <td>
                    <input type="text" name="chrg_routing_number" id="chrg_routing_number" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_routing_number')?>" /> </td>
                  </tr>
                  <tr>
                    <td style="padding-left:30px;"><?php echo SWIFT_CODE;?>:</td>
                    <td>
                    <input type="text" name="chrg_swift_code" id="chrg_swift_code" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_swift_code')?>" /> </td>
                  </tr>
                  <tr>
                    <td style="padding-left:30px;"><?php echo BANK_ACC_HOL_NAME;?>:</td>
                    <td> <input type="text" name="chrg_bank_account_hold_name" id="chrg_bank_account_hold_name" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $faq->f('chrg_bank_account_hold_name');?>"  /></td>
                </tr>
                <tr>
                    <td style="padding-left:30px;"><?php echo BANK_ACC_COUNTRY_CHARGE;?>:<span style="color:red; display:none;" id="star1">*</span></td>
                    <td>
                      <select name="chrg_bank_account_country" id="chrg_bank_account_country" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">Choose Country</option>
                        <?php
                        $obj_country->countries_list();
                        while($obj_country->next_record())
                        {
                        ?>
                        <option value="<?php echo $obj_country->f('id');?>" <?php if($faq->f('chrg_bank_account_country')==$obj_country->f('id')){?> selected="selected"<?php }?>>
                        <?php echo $obj_country->f('nicename');?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </td>
                </tr>                      
                </table>
                   </td>
                 </tr>
               </table> 
               <div class="clear"></div>
               <div style="margin: 0 auto; float: right; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:8px; <?php /*?> width:508px;<?php */?> width: 547px;">
               		<!--<input type="checkbox" name="terms_condition" id="terms_condition" value="1" />--><?php echo TERMS_CONDITION;?>
               </div>
               <div style="margin: 0 auto; float: right; width: 620px;"><input type="button" name="submit1" id="submit1" value="<?php echo PREVIOUS;?>" style="cursor:pointer;" class="event_save" onclick="redirectPage(1)" /><span><input type="button" name="submit1" id="submit1" value="<?php echo SAVE_EXIT;?>" style=" cursor:pointer;"  class="event_save"  onclick="redirectPage(2)" /></span>
               </div>               	
              </form>                    
            </div>
         </div>
         <div class="clear"></div>
        </div>
       <div class="clear"></div>
       </div>

    </div>
    <div class="clear"></div>
	</div>
<div class="clear"></div>
<?php include("include/frontend_footer.php");
		
?>
</div>


</body>

</html>
