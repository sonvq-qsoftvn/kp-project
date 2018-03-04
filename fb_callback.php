<?php 

include('./include/user_inc.php');
$objlogin=new user;
$obj_get_pass=new user;
$obj_add=new user;
$objlist=new user;
$obj_already_reg=new user;
$obj_adduser=new user;
$obj_sendmail=new user;
$obj_activate=new user;
$obj_user=new user;
$obj_cart=new user;

if (!session_id()) {
    session_start();
}

require './facebook-php/src/Facebook/autoload.php';
$fb = new \Facebook\Facebook(array(
      'app_id' => '445192265673724',
      'app_secret' => '41f5bccae260641bce323da48eb35776',
			'default_graph_version' => 'v2.5',
      'default_access_token' => '445192265673724|41f5bccae260641bce323da48eb35776'
));

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('445192265673724');
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

}

$_SESSION['fb_access_token'] = (string) $accessToken;

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,email,first_name,last_name,gender', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user_profile = $response->getGraphUser();

if (!empty($user_profile )) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
  		// session_start();
		 
       	$uid = $user_profile['id'];
	    $username = $user_profile['username'];
		
		$email = $user_profile['email'];
		$obj_already_reg->already_register($uid,'facebook');

		// Get User details
		$obj_user->getAdminByEmail($email);
		$obj_user->next_record();

		
		if(!$obj_already_reg->num_rows())
		{
        	$userdata = $objlogin->checkUser($uid, 'facebook', $username,$email,$twitter_otoken,$twitter_otoken_secret);
			
		
        	if(!empty($userdata))
			{
				$fname = $user_profile['first_name'];
				$lname = $user_profile['last_name'];
				$gender = $user_profile['gender'];
				
					
				//$account_type = $_SESSION['account_type_fb'];
				$account_type = 0;
								
				$objlist->user_exist($email);
				if(!$objlist->num_rows()>0){
					
					$rem_password = $obj_get_pass->str_rand();
					$password=md5($rem_password);
					
					// Set value to null
					$phone_no = '';
					$country_id = '';
					$country_code = 0;
					
					$language = 'English';						
					if($_SESSION['langSessId'] == 'eng'){
						$language = 'English'; 
					} elseif($_SESSION['langSessId'] == 'spn') {
						$language = 'Spanish';
					}
					//insert value
					$user_id = $obj_adduser->register_user($fname,$lname,$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type, $language);
					
					//Update value
					$obj_activate->activateUser($user_id);
					$obj_activate->next_record();
					
					//send password email
					//$obj_sendmail->merchant_login_pass_mail($rem_password,$email);			
					

					$_SESSION['admin_email'] = $email;
					$_SESSION['ses_admin_id'] = $user_id;	
					$_SESSION['name'] = $fname." ". $lname;
					$_SESSION['login_mode'] = 'facebook';
					//redirect success
					
					if($_SESSION['event_id']){
						if($_SESSION['cid'] != ''){
							foreach($_SESSION['cid'] as $data){
								$obj_cart->update_cart($data,$_SESSION['ses_admin_id'],$_SESSION['unique']);
							}
						}
						$attempt = 0;
						if (isset($_SESSION['attempt_id'])) {
							$attempt = $_SESSION['attempt_id'];
						}
					    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']."/attempt/".$attempt);
					}
					else
					{
					  header("location:".$obj_base_path->base_path()."/userprofile");
					}

					
					//header("location:".$obj_base_path->base_path()."/userprofile");
					exit;			
				}
				else
				{
					$_SESSION['admin_email'] = $email;
					$_SESSION['name'] = $fname." ". $lname;
					$_SESSION['ses_admin_id'] = $obj_user->f('admin_id');
					$_SESSION['login_mode'] = 'facebook';
					
					if($_SESSION['event_id']){
						if($_SESSION['cid'] != ''){
							foreach($_SESSION['cid'] as $data){
								$obj_cart->update_cart($data,$_SESSION['ses_admin_id'],$_SESSION['unique']);
							}
						}
						$attempt = 0;
						if (isset($_SESSION['attempt_id'])) {
							$attempt = $_SESSION['attempt_id'];
						}
					    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']."/attempt/".$attempt);
					}
					else
					{
					  header("location:".$obj_base_path->base_path()."");
					}
					
					//header("location:".$obj_base_path->base_path()."");
					exit;
				}
		  	}
		}
		else {
			
			$_SESSION['admin_email'] = $email;
			$_SESSION['ses_admin_id'] = $obj_user->f('admin_id');
			$_SESSION['name'] = $obj_user->f('fname')." ". $obj_user->f('lname');
			$_SESSION['login_mode'] = 'facebook';
			
			if($_SESSION['event_id']){
				if($_SESSION['cid'] != ''){
					foreach($_SESSION['cid'] as $data){
						$obj_cart->update_cart($data,$_SESSION['ses_admin_id'],$_SESSION['unique']);
					}
				}
				$attempt = 0;
				if (isset($_SESSION['attempt_id'])) {
					$attempt = $_SESSION['attempt_id'];
				}
			    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']."/attempt/".$attempt);
			}
			else
			{
			  header("location:".$obj_base_path->base_path()."");
			}

			
			//header("location:".$obj_base_path->base_path()."");
			exit;
			
			
			/*$token = $facebook->getAccessToken();
			$url = 'https://www.facebook.com/logout.php?next=http://phppowerhousedemo.com/webroot/team5/kcpasa/registration&access_token='.$token;
			//echo $url;exit;
			session_destroy();
			session_start();
			$_SESSION['user_msg'] = "This email address already exists!";	
			header('Location: '.$url);*/
    	}
    } else {
		echo "enter";
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');