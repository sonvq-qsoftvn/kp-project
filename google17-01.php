<?php
include('include/user_inc.php');
$obj=new user;
$obj_google=new user;
$obj_get_pass=new user;
$obj_adduser=new user;
$obj_activate=new user;
$obj_sendmail=new user;
$obj_ad=new user;
$obj_user=new user;


########## Google Settings.. Client ID, Client Secret #############
$google_client_id 		= '256208379976-qn6714nedvs4ci49mlfm1o988q6dhqld.apps.googleusercontent.com';
$google_client_secret 	= 'OmTKyOc5XDUNqs9_taw_GP9l';
$google_redirect_url 	= 'http://kpasapp.com/google.php';
$google_developer_key 	= 'AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s';


//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

//start session
session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('Login to saaraan.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])) 
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
}

//Redirect user to google authentication page for code, if code is empty.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}


if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
	  //Get user details if user is logged in
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
}
else 
{
	//get google login url
	$authUrl = $gClient->createAuthUrl();
}


if(isset($authUrl)) //user is not logged in, show login button
{
	//echo 1;exit;
	header("location:".$obj_base_path->base_path()."/userprofile");
	//header("Location:".$obj_base_path->base_path()."/registration");
	echo '<a class="login" href="'.$authUrl.'">aa<img src="images/google-login-button.png" /></a>';
} 
else // user logged in 
{
	//echo 2;exit;
	$obj->checkGoogleUser($user_id,$email);
	$obj->next_record();
	if($obj->num_rows()){

		// Get User details
		$obj_user->getAdminByEmail($email);
		$obj_user->next_record();

		$_SESSION['admin_email'] = $email;
		$_SESSION['ses_admin_id'] = $obj_user->f('admin_id');
		$_SESSION['name'] = $obj_user->f('fname')." ". $obj_user->f('lname');
		$_SESSION['login_mode'] = 'google';
		header("location:".$obj_base_path->base_path()."");
		exit;
	}
	else{
		
		$obj_ad->userDetailByemail($email);
		$obj_ad->next_record();
		if($obj_ad->num_rows()){
			
			// Get User details
			$obj_user->getAdminByEmail($email);
			$obj_user->next_record();
	
			$_SESSION['admin_email'] = $email;
			$_SESSION['ses_admin_id'] = $obj_user->f('admin_id');
			$_SESSION['name'] = $obj_user->f('fname')." ". $obj_user->f('lname');
			$_SESSION['login_mode'] = 'google';
			header("location:".$obj_base_path->base_path()."/userprofile");
			exit;
		}

		$obj_google->insertGoogleUser($user_id,$email);
		$obj_google->next_record();
		
		$rem_password = $obj_get_pass->str_rand();
		$password=md5($rem_password);
		
		// Set value to null
		$phone_no = '';
		$country_id = '';
		$country_code = 0;
		$account_type = 0;
		//$account_type = $_SESSION['account_type_google'];
		
		//insert value
		$user_id_admin = $obj_adduser->register_user($user['given_name'],$user['family_name'],$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type);
		
		//Update value
		$obj_activate->activateUser($user_id_admin);
		$obj_activate->next_record();

		$_SESSION['admin_email'] = $email;
		$_SESSION['name'] = $user['given_name']." ". $user['family_name'];
		$_SESSION['ses_admin_id'] = $user_id_admin;
		$_SESSION['login_mode'] = 'google';
		
		//send password email
		//$obj_sendmail->merchant_login_pass_mail($rem_password,$email);			
		//$_SESSION['user_msg'] = "Please check email to find your temporary password!";	

		header("Location:".$obj_base_path->base_path()."/google.php?reset=1");
		exit;
	}
	
}
?>
