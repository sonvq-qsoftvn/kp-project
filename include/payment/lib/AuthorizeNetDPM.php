<?php
/**
 * Demonstrates the Direct Post Method.
 *
 * To implement the Direct Post Method you need to implement 3 steps:
 *
 * Step 1: Add necessary hidden fields to your checkout form and make your form is set to post to AuthorizeNet.
 *
 * Step 2: Receive a response from AuthorizeNet, do your business logic, and return
 *         a relay response snippet with a url to redirect the customer to.
 *
 * Step 3: Show a receipt page to your customer.
 *
 * This class is more for demonstration purposes than actual production use.
 *
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */

/**
 * A class that demonstrates the DPM method.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */
class AuthorizeNetDPM extends AuthorizeNetSIM_Form
{

    const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';

    /**
     * Implements all 3 steps of the Direct Post Method for demonstration
     * purposes.
     */
    public static function directPostDemoAjax($url, $api_login_id, $transaction_key, $amount = "0.00", $md5_setting = "",$test_mode=true)
    {
      //  echo "$url, $api_login_id, $transaction_key";exit;
        // Step 1: Show checkout form to customer.
        if (!count($_POST) && !count($_GET['response_code']))
        {
            $fp_sequence = time(); // Any sequential number like an invoice number.
            echo AuthorizeNetDPM::getCreditCardFormAjax($amount, $fp_sequence, $url, $api_login_id, $transaction_key,$test_mode=true);
        }
        // Step 2: Handle AuthorizeNet Transaction Result & return snippet.
        elseif (count($_POST)) 
        {
			//print_r($_POST);
            $response = new AuthorizeNetSIM($api_login_id, $md5_setting);
            if ($response->isAuthorizeNet()) 
            {
                if ($response->approved) 
                {
                    // Do your processing here.
					//echo "Shantanu";
					
                    $redirect_url = $url . '?response_code=1&transaction_id=' . $response->transaction_id; 
                }
                else
                {
					//echo "INSERT INTO ticket_order date=now()";
					
                    // Redirect to error page.
                    $redirect_url = $url . '?response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
                }
                // Send the Javascript back to AuthorizeNet, which will redirect user back to your site.
              //  echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
            }
            else
            {
                echo "Error -- not AuthorizeNet. Check your MD5 Setting.";
            }
			//mysql_query("INSERT INTO ticket_order date=now()");
			//echo $redirect_url;
			//exit;
        }
        // Step 3: Show receipt page to customer.
        elseif (!count($_POST) && count($_GET))
        {
            if ($_GET['response_code'] == 1)
            {
                echo "Thank you for your purchase! Transaction id: " . htmlentities($_GET['transaction_id']);
            }
            else
            {
              echo "Sorry, an error occurred: " . htmlentities($_GET['response_reason_text']);
            }
        }
    }
	
    public static function directPostDemo($url, $api_login_id, $transaction_key, $amount = "0.00", $md5_setting = "",$test_mode=true)
    {
      //  echo "$url, $api_login_id, $transaction_key";exit;
        // Step 1: Show checkout form to customer.
        if (!count($_POST) && !count($_GET['response_code']))
        {
            $fp_sequence = time(); // Any sequential number like an invoice number.
            echo AuthorizeNetDPM::getCreditCardForm($amount, $fp_sequence, $url, $api_login_id, $transaction_key,$test_mode);
        }
        // Step 2: Handle AuthorizeNet Transaction Result & return snippet.
        elseif (count($_POST)) 
        {
			//print_r($_POST);
            $response = new AuthorizeNetSIM($api_login_id, $md5_setting);
            if ($response->isAuthorizeNet()) 
            {
                if ($response->approved) 
                {
                    // Do your processing here.
					//echo "Shantanu";
					
                    $redirect_url = $url . '?response_code=1&transaction_id=' . $response->transaction_id; 
                }
                else
                {
					//echo "INSERT INTO ticket_order date=now()";
					
                    // Redirect to error page.
                    $redirect_url = $url . '?response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
                }
                // Send the Javascript back to AuthorizeNet, which will redirect user back to your site.
              //  echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
            }
            else
            {
                echo "Error -- not AuthorizeNet. Check your MD5 Setting.";
            }
			//mysql_query("INSERT INTO ticket_order date=now()");
			//echo $redirect_url;
			//exit;
        }
        // Step 3: Show receipt page to customer.
        elseif (!count($_POST) && count($_GET))
        {
            if ($_GET['response_code'] == 1)
            {
                echo "Thank you for your purchase! Transaction id: " . htmlentities($_GET['transaction_id']);
            }
            else
            {
              echo "Sorry, an error occurred: " . htmlentities($_GET['response_reason_text']);
            }
        }
    }
    
    /**
     * A snippet to send to AuthorizeNet to redirect the user back to the
     * merchant's server. Use this on your relay response page.
     *
     * @param string $redirect_url Where to redirect the user.
     *
     * @return string
     */
    public static function getRelayResponseSnippet($redirect_url)
    {
        return "<html><head><script language=\"javascript\">
                <!--
                window.location=\"{$redirect_url}\";
                //-->
                </script>
                </head><body><noscript><meta http-equiv=\"refresh\" content=\"1;url={$redirect_url}\"></noscript></body></html>";
    }
    
    /**
     * Generate a sample form for use in a demo Direct Post implementation.
     *
     * @param string $amount                   Amount of the transaction.
     * @param string $fp_sequence              Sequential number(ie. Invoice #)
     * @param string $relay_response_url       The Relay Response URL
     * @param string $api_login_id             Your API Login ID
     * @param string $transaction_key          Your API Tran Key.
     * @param bool   $test_mode                Use the sandbox?
     * @param bool   $prefill                  Prefill sample values(for test purposes).
     *
     * @return string
     */
    public static function getCreditCardFormAjax($amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $test_mode = true, $prefill = true)
    {
        
		
		$obj_country=new user;
		
		$obj_country->countries_list();
		$selcountry='<select name="x_country" id="x_country" class="selectbg" style="width:150px;" onchange=check_field(this.value,"country_valid")>
			<option value="">Select Country</option>';
		while($obj_country->next_record()){
			if($_GET['x_country']==$obj_country->f('printable_name')){
			$selcountry .='<option value="'. $obj_country->f('printable_name').'" selected="selected">'.$obj_country->f('printable_name').'</option>';
			}else{
				$selcountry .='<option value="'. $obj_country->f('printable_name').'">'.$obj_country->f('printable_name').'</option>';
			}
		}
        $selcountry .='</select>';
		
		$time = time();
        $fp = self::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
        $sim = new AuthorizeNetSIM_Form(
            array(
            'x_amount'        => $amount,
            'x_fp_sequence'   => $fp_sequence,
            'x_fp_hash'       => $fp,
            'x_fp_timestamp'  => $time,
            'x_relay_response'=> "TRUE",
            'x_relay_url'     => $relay_response_url,
            'x_login'         => $api_login_id,
			'x_event_id'      => $_REQUEST['event_id'],
			'x_option_value'  => $_SESSION['ses_option_value'],
			'x_delivery_option'  => $_SESSION['ses_delivery_option'],
			
			'x_price_service_fee'  => $_SESSION['ses_price_service_fee'],
			'x_coupon_discount_amt'  => $_SESSION['ses_coupon_discount_amt'],
			'x_coupon_event_id'  => $_SESSION['ses_coupon_event_id'],
            )
        );
        $hidden_fields = $sim->getHiddenFieldString();
        $post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
		//$post_url = ($test_mode ? self::SANDBOX_URL : self::SANDBOX_URL);
        
		$form = '
		       <form name=fm1 id="fm1" method="post" action="'.$post_url.'">
                '.$hidden_fields.'
				<input type="hidden" name="hiddernUrl" id="hiddernUrl" value="'.$post_url.'" />
		<table width="100%" border="0" cellpadding="8" cellspacing="2" align="center">
 		   <tr>
            <td align="center">card#</td>
            <td height="30" align="left"><input type="text" name="x_card_num" id="x_card_num" value="'.($prefill ? '6011000000000012' : '').'" /></td>
          </tr>
 		   <tr>
            <td align="center">Expiration</td>
            <td height="30" align="left">
            	 <input type="text" class="text" size="4" name="x_exp_date" value="'.($prefill ? '04/17' : '').'"></input>
            </td>
          </tr>
 		   <tr>
            <td align="center">First Name</td>
            <td height="30" align="left"><input type="text" name="x_first_name" id="x_first_name" value="'.($prefill ? 'John' : '').'" /></td>
          </tr>
 		   <tr>
            <td align="center">Last Name</td>
            <td height="30" align="left"><input type="text" name="x_last_name" id="x_last_name" value="'.($prefill ? 'Doe' : '').'"  /></td>
          </tr>
 		   <tr>
            <td align="center">Card Bill to Address</td>
            <td height="30" align="left"><input type="text" name="x_address" id="x_address" value="'.($prefill ? '123 Main Street' : '').'"/></td>
          </tr>
 		   <tr>
            <td align="center">City</td>
            <td height="30" align="left"><input type="text" name="x_city" id="x_city" value="'.($prefill ? 'Boston' : '').'" /></td>
          </tr>
 		   <tr>
            <td align="center">Country</td>
            <td height="30" align="left">'.$selcountry.'</td>
          </tr>
 		   <tr>
            <td align="center">State</td>
            <td height="30" align="left">
            	<input type="text" name="x_state" id="x_state" value="'.($prefill ? 'MA' : '').'" />
                &nbsp;&nbsp;<span>ZIP</span>
                <span><input type="text" name="x_zip" id="x_zip" style="width:80px;" value="'.($prefill ? '02142' : '').'" /></span>
            </td>
          </tr>
 		   <tr>
            <td align="center">Email</td>
            <td height="30" align="left"><input type="text" name="email" id="email" value="amit.unified@gmail.com" />
            	&nbsp;&nbsp;<span>PHONE</span>
                <span><input type="text" name="phone" id="phone" style="width:100px;" value="9902191992"  /></span>
            </td>
          </tr>
 		  <tr>
            <td align="left"><input type="checkbox" name="overCheck" id="overCheck"  />&nbsp;&nbsp;I confirm I am over 21</td>
            <td height="30" align="right"><span style=" width:50px; margin-right:50px;"> SUB TOTAL</span>&nbsp; <span id=""> $0</span></td>
          </tr>
 		  <tr>
            <td align="left"><input type="checkbox" name="trm_condition" id="trm_condition"  />&nbsp;&nbsp;I have read Tems & Condtions</td>
            <td height="30" align="right"><span style=" width:50px; margin-right:50px;"> Tax + Tip</span>&nbsp; <span id=""> $144</span></td>
          </tr>
 		  <tr>
            <td align="left"><input type="checkbox" name="trm_condition" id="trm_condition"  />&nbsp;&nbsp;Cancellation Insurance (adds $10)</td>
            <td height="30" align="right"><span style=" width:50px; margin-right:50px;">Promocode</span>&nbsp; <span id=""> $0</span><br /> 
            	<strong>Grand Total</strong></span> <span id="grand_tot"></span>
            </td>
          </tr>
 		  <tr>
            <td align="left" colspan="2">
            	Enter a promo code (optional) <br />
				<input type="text" name="promocode" id="promocode"  /> 
             </td>
          </tr>
          

 		   <tr>
            <td align="center"><button onclick="confirmation()" class="blue-pill">BACK</button></td>
            <td align="center"><input type="submit" value="clcik"> <button onclick="return Check()" class="blue-pill">CONTINUE</button></td>
          </tr>
        </table>
		</form>
		';
        return $form;
    }
	
    public static function getCreditCardForm($amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $test_mode = true, $prefill = true)
    {
        
		
		$obj_country=new user;
		
		$obj_country->countries_list();
		$selcountry='<select name="x_country" id="x_country" class="selectbg" style="width:105px;" onchange=check_field(this.value,"country_valid")>
			<option value="">Select Country</option>';
		while($obj_country->next_record()){
			if($_GET['x_country']==$obj_country->f('printable_name')){
			$selcountry .='<option value="'. $obj_country->f('printable_name').'" selected="selected">'.$obj_country->f('printable_name').'</option>';
			}else{
				$selcountry .='<option value="'. $obj_country->f('printable_name').'">'.$obj_country->f('printable_name').'</option>';
			}
		}
        $selcountry .='</select>';
		
		$time = time();
        $fp = self::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
        $sim = new AuthorizeNetSIM_Form(
            array(
            'x_amount'        => $amount,
            'x_fp_sequence'   => $fp_sequence,
            'x_fp_hash'       => $fp,
            'x_fp_timestamp'  => $time,
            'x_relay_response'=> "TRUE",
            'x_relay_url'     => $relay_response_url,
            'x_login'         => $api_login_id,
			'x_event_id'      => $_REQUEST['event_id'],
			'x_option_value'  => $_SESSION['ses_option_value'],
			'x_delivery_option'  => $_SESSION['ses_delivery_option'],
			
			'x_price_service_fee'  => $_SESSION['ses_price_service_fee'],
			'x_coupon_discount_amt'  => $_SESSION['ses_coupon_discount_amt'],
			'x_coupon_event_id'  => $_SESSION['ses_coupon_event_id'],
            )
        );
        $hidden_fields = $sim->getHiddenFieldString();
        $post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
		//$post_url = ($test_mode ? self::SANDBOX_URL : self::SANDBOX_URL);
       // echo $post_url;exit;
        $form = '
       <form name=fm method="post" action="'.$post_url.'">
                '.$hidden_fields.'
		<div class="address_top">BILLING ADDRESS</div>
		<div class="wrapper address">
                              <ul>
                                <li><span>Street Address </span><input name="x_address" id="x_address" type="text" value="'.$_GET['x_address'].'"  class="textfield2" style="width:532px;" onblur=check_field(this.value,"strt_ad") /><spand id="strt_ad" class="field_valid"></span></li>
                                <li><span>Street Address 2 </span><input name="address2" id="address2" type="text" value="'.$_GET['address2'].'" class="textfield2" style="width:522px;" onblur=check_field(this.value,"strt_ad2") /><spand id="strt_ad2" class="field_valid"></span></li>
                                <li><span>City</span><input name="x_city" id="x_city" type="text" value="'.$_GET['x_city'].'" class="textfield2" onblur=check_field(this.value,"city_vld")/><spand id="city_vld" class="field_valid"></span>
                                <span>State</span><input name="x_state" id="x_state" type="text" value="'.$_GET['x_state'].'" class="textfield2" style="width:98px; onblur=check_field(this.value,"state_vld") /><spand id="state_vld" class="field_valid"></span>
								<span>Zip</span><input name="x_zip" id="x_zip" type="text" value="'.$_GET['x_zip'].'" class="textfield2" onblur=check_field(this.value,"zip_vld")/><spand id="zip_vld" class="field_valid"></span>
                                <span>Country</span>'.$selcountry.'</li>
                                <li><span>Phone</span><input name="x_phone" id="x_phone" type="text" value="'.$_GET['x_phone'].'" class="textfield2" style="width:270px;" onblur=check_field(this.value,"ph_vld")/><spand id="ph_vld" class="field_valid"></span>
								<span>Email</span><input name="x_email" id="x_email" type="text" value="'.$_GET['x_email'].'" class="textfield2" style="width:265px;" onblur=check_field(this.value,"mail_vld") /><spand id="mail_vld" class="field_valid"></span></li>
					<li><span>Confirm Email</span><input name="x_cemail" id="x_cemail" type="text" value="'.$_GET['x_cemail'].'" class="textfield2" style="width:270px;" onblur=check_field(this.value,"cmail_vld") /><spand id="cmail_vld" class="field_valid"></span></li>
                              </ul>
                             <div class="clear"></div>
                           </div>
						   
						   <div class="address_top">CREDIT CARD INFORMATION</div>
                           
                           <div class="wrapper address">
                            <ul>
							   <li><span>First Name</span><input name= "x_first_name" id="x_first_name" type="text" value="'.$_GET['x_first_name'].'" class="textfield2" style="width:240px;" onblur=check_field(this.value,"fna_vld") style="width:532px;"/><spand id="fna_vld" class="field_valid">
                               <span>Last Name</span><input name="x_last_name" id="x_last_name" type="text" value="'.$_GET['x_last_name'].'" class="textfield2" style="width:240px;" onblur=check_field(this.value,"lna_vld") style="width:522px;"/><spand id="lna_vld" class="field_valid"></span></li>';
                         
						  $op_val=explode(",",$_SESSION['ses_option_value']);
						$op_val_name=explode(",",$_SESSION['ses_option_value_name']);
						$k=1;
						for($i=0; $i < count($op_val); $i++){
			
						$price_id_val=explode("-",$op_val[$i]);
						$price_id_val_name=explode("-",$op_val_name[$i]);		
						if($price_id_val[1]!='' && $price_id_val[1]!=0){
							for($j=1;$j<=$price_id_val[1];$j++){
						
						 $form .=' <li><span>Ticket Holder'.$k.' ('.$price_id_val_name[1].')</span><input name="ticket_holder'.$k.'" id="ticket_holder'.$k.'" type="text" value="'.$_GET['ticket_holder'].'" class="textfield2" style="width:217px;" onblur=check_field(this.value,"hold_vld'.$k.'") /><spand id="hold_vld'.$k.'" class="field_valid"></span></li>';
						$k++;
					
							}
						}
					}
                                 $form .='<li><span>Card Type</span><select name="ticket_transaction_limit" id="ticket_transaction_limit"  class="dropdown1" style="width:240px; margin:0 0 0 6px;" onchange=check_field(this.value,"tmlt_vld")>
								<option value="">Select Card</option>
								<option value="1">American Express</option>
								<option value="2">Diners Club</option>
								<option value="3">Debit MasterCard</option>
								<option value="4">Maestro</option>
								<option value="5">Visa Debit</option>
								<option value="6">Visa Electron</option>
								</select>
								 <span>Card Number</span><input name="x_card_num" id="x_card_num" type="text" value="" class="textfield2" style="width:235px;" onblur=check_field(this.value,"cnum_vld") /><span id="cnum_vld" class="field_valid"></span></li>
                                <li><span>Exp. Date</span><input name="x_exp_date" id="x_exp_date" type="text" value="" class="textfield2" style="width:88px;" onblur=check_field(this.value,"exp_vld") />(mm/yy)<span id="exp_vld" class="field_valid"></span>
                                <span>CVV Code</span><input name="x_card_code" id="x_card_code" type="text" value="" class="textfield2" onblur=check_field(this.value,"code_vld") /><span id="code_vld" class="field_valid"></span></li>
                                <li class="font11"> 
                                <input name="term_condition" id="term_condition" type="checkbox" value="1" style="border:0px; float:left;"/> I Agree to the <a href="javascript:void(0);" onClick="javascript:window.open(\'../../content/terms-conditions\',\'\',\'scrollbars=1,width=1000,height=1200\');">Terms of Service</a><input name="submit4" id="submit4" type="submit" value="BUY" class="btn_bg2 right" onclick = "show_val();"/></li>
                            </ul>
                        <div class="clear"></div>
                        </div>
            
        </form>';
        return $form;
    }

}