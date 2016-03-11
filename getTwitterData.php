<?php
//include('./include/user_inc.php');
require("./Facebook_Twitter_Login/twitter/twitteroauth.php");
require './Facebook_Twitter_Login/config/twconfig.php';

//session_start();


/*print_r($_GET);
echo "<br />";
print_r($_SESSION);*/

//echo $_SESSION['rand_password'];exit;
if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');

	
// Print user's info
    echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';exit;
	
	$objlogin=new user;
	$obj_already_reg=new user;
	$objlist=new user;
	$obj_get_pass=new user;
	$obj_add=new user;
	$obj_update_stat=new user;

	
	
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
    } else {
	   $twitter_otoken=$_SESSION['oauth_token'];
	   $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
	    $email='';
        $uid = $user_info->id;
        $username = $user_info->screen_name;
		
		
		//check already insert or not
		$obj_already_reg->already_register($uid,'twitter');
		if(!$obj_already_reg->num_rows())
		{
        	$userdata = $objlogin->checkUser($uid, 'twitter', $username,$email,$twitter_otoken,$twitter_otoken_secret);
			//echo $username;exit;
			if(!empty($userdata)){
				
			$fullname = $user_info->name;	
			list($f_name,$l_name) = explode(" ",$fullname);
			
			$objlist->user_exist($username,$email);
			if(!$objlist->num_rows()>0){
				
				$password=$obj_get_pass->str_rand();
				
				// Set value to null
				$phone_no = '';
				$dob = '';
				$display_email = 0;
				$photo = '';
				$company_logo = '';
				$address = '';
				$country = '';
				$state = '';
				$city = '';
				$zipcode = '';
				$mobile_no = '';
				$paypal_email = '';
				$paypal_address = '';
				$paypal_zip = '';
				$gender = '';
				
				
				//insert value
			$user_id=$obj_add->register_user_detail($f_name,$l_name,$email,$username,$_SESSION['rand_password'],$phone_no,$dob,$gender,$display_email,$photo,$company_logo,$address,$country,$state,$city,$zipcode,$mobile_no,$paypal_email,$paypal_address,$paypal_zip);
			
			// update status of user
			$obj_update_stat->updateuser_status($user_id);
						
			//redirect success
			header("location:".$obj_base_path->base_path()."/register-success");
		
			}
			else
			{
				$_SESSION['alrdy_reg'] = "This email address already exists.";
				header("location:".$obj_base_path->base_path()."/registration");			
			}
		  }
		}
		else
		{
			$_SESSION['alrdy_reg'] = "Already register.";
			header("location:".$obj_base_path->base_path()."/registration");
		}
		
		
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>
