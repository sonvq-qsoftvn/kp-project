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

session_start();
//$_SESSION['account_type_fb'] = $_POST['account_type_facebook'];
//print_r($_POST);exit;

require './Facebook_Twitter_Login/facebook/facebook.php';
require './Facebook_Twitter_Login/config/fbconfig.php';
//require 'config/functions.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));

$user = $facebook->getUser();
//print_r($user);exit;

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }

//print_r($user_profile);
//exit;

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
					    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']);
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
					    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']);
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
			    header("location:".$obj_base_path->base_path()."/payment/".$_SESSION['event_id']);
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
} else {
	if($_REQUEST['error']=="access_denied" || $_REQUEST['error_code']!=""){
		//echo $_SERVER['REQUEST_URI'];
		$token = $facebook->getAccessToken();
		$url = 'https://www.facebook.com/logout.php?next=http://kpasapp.com/index&access_token='.$token;
		
		session_destroy();
		session_start();
		header('Location: '.$url);
		exit;
	}
	
    # There's no active session, let's generate one
	$login_url = $facebook->getLoginUrl(array('scope' => 'email'));
    header("Location: " . $login_url);
	exit;
}
?>
