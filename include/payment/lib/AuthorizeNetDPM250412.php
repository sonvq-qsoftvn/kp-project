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
    public static function directPostDemo($url, $api_login_id, $transaction_key, $amount = "0.00", $md5_setting = "")
    {
        
        // Step 1: Show checkout form to customer.
        if (!count($_POST) && !count($_GET['response_code']))
        {
            $fp_sequence = time(); // Any sequential number like an invoice number.
            echo AuthorizeNetDPM::getCreditCardForm($amount, $fp_sequence, $url, $api_login_id, $transaction_key);
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
    public static function getCreditCardForm($amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $test_mode = false, $prefill = true)
    {
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
			'x_price_service_fee'  => $_SESSION['ses_price_service_fee'],
			'x_coupon_discount_amt'  => $_SESSION['ses_coupon_discount_amt'],
			'x_coupon_event_id'  => $_SESSION['ses_coupon_event_id'],
            )
        );
        $hidden_fields = $sim->getHiddenFieldString();
        $post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
        
        $form = '
       <form name=fm method="post" action="'.$post_url.'">
                '.$hidden_fields.'
            <div>
  		<tr><td>
		<table width="600" border="0" cellspacing="2" cellpadding="6">
		<tr>
          <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Billing Address</h5></td>
          </tr>
        <tr>
		<tr>
          <td width="240">Street address </td>
          <td width="330"><input type="text" name="x_address" id="x_address" value="'.$_GET['ticket_holder'].'" class="text_field1" /></td>
        </tr>
		<tr>
          <td>Street address 2 </td>
          <td><input type="text" name="address2" id="address2" value="'.$_GET['address2'].'" class="text_field1" /></td>
        </tr>
		<tr>
          <td>Country</td>
          <td ><input type="text" name="x_country" id="x_country" value="'.$_GET['x_country'].'" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>City</td>
          <td ><input type="text" name="x_city" id="x_city" value="'.$_GET['x_city'].'" class="textbg1_new" /></td>
        </tr>
		<tr style="display:none;">
          <td>Territory</td>
          <td ><input type="text" name="x_state" id="x_state" value="'.$_GET['x_state'].'" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>Zip</td>
          <td ><input type="text" name="x_zip" id="x_zip" value="'.$_GET['x_zip'].'" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>Phone</td>
          <td ><input type="text" name="x_phone" id="x_phone" value="'.$_GET['x_phone'].'" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>Email</td>
          <td ><input type="text" name="x_email" id="x_email" value="'.$_GET['x_email'].'" class="textbg1_new" /></td>
        </tr>
      	</table></td>
        </tr>
		<tr><td>
		<table width="600" border="0" cellspacing="2" cellpadding="6">
		<tr>
          <td colspan="2" style="border-bottom: 1px solid #cccccc;"><h5>Credit card information</h5></td>
          </tr>
        <tr>
		<tr>
          <td width="241">First Name</td>
          <td width="329"><input type="text" name="x_first_name" id="x_first_name" value="'.$_GET['x_first_name'].'" class="text_field1" /></td>
        </tr>		
		<tr>
          <td>Last Name</td>
          <td><input type="text" name="x_last_name" id="x_last_name" value="'.$_GET['x_last_name'].'" class="text_field1" /></td>
        </tr>';
		$op_val=explode(",",$_SESSION['ses_option_value']);
		$op_val_name=explode(",",$_SESSION['ses_option_value_name']);
		$k=1;
		for($i=0; $i < count($op_val); $i++){
		
		$price_id_val=explode("-",$op_val[$i]);
		$price_id_val_name=explode("-",$op_val_name[$i]);		
			if($price_id_val[1]!='' && $price_id_val[1]!=0){
				for($j=1;$j<=$price_id_val[1];$j++){
				
					$form .='<tr>
					  <td>Ticket Holder '.$k.' ('.$price_id_val_name[1].')</td>
					  <td><input type="text" name="ticket_holder'.$k.'" id="ticket_holder'.$k.'" value="'.$_GET['ticket_holder'].'" class="text_field1" /></td>
					</tr>';
					$k++;
					
				}
			}
		}
		$form .='<tr style="display:none;">
          <td>Card Type</td>
          <td ><input type="text" name="ticket_transaction_limit" id="ticket_transaction_limit" value="" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>Card Number</td>
          <td ><input type="text" name="x_card_num" id="x_card_num" value="" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>Expiration Date</td>
          <td ><input type="text" name="x_exp_date" id="x_exp_date" value="" class="textbg1_new" />(mm/dd)</td>
        </tr>
		<tr>
          <td>CCV Code</td>
          <td ><input type="text" name="x_card_code" id="x_card_code" value="" class="textbg1_new" /></td>
        </tr>
		<tr>
          <td>I agree to the <a href="javascript:void(0);" onClick="javascript:window.open(\'../../content/terms-conditions\',\'\',\'scrollbars=1,width=1000,height=1200\');" >Terms of Service</a></td>
          <td ><input type="checkbox" name="term_condition" id="term_condition" value="1"/></td>
        </tr>
		<tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="submit4" value="BUY" class="sent_btn" onclick = "show_val();" id="submit4"></td>
        </tr>
      	</table></td>
        </tr>	
				
      </table>
</div>
            
        </form>';
        return $form;
    }

}