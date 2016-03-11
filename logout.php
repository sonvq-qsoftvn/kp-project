<?php 
// log out
//session_start();
include('include/user_inc.php');

if($_SESSION['login_mode'] == 'facebook'){
	
	require './Facebook_Twitter_Login/facebook/facebook.php';
	require './Facebook_Twitter_Login/config/fbconfig.php';
	
	$facebook = new Facebook(array(
				'appId' => APP_ID,
				'secret' => APP_SECRET,
				));
				
	$token = $facebook->getAccessToken();
	//$url = 'https://www.facebook.com/logout.php?next=http://phppowerhousedemo.com/webroot/team5/kcpasa/index&access_token='.$token;
	$url = 'https://www.facebook.com/logout.php?next=http://kpasapp.com&access_token='.$token;
	//echo $url;exit;	
	unset($_SESSION['name']);
	unset($_SESSION['admin_email']);
	unset($_SESSION['ses_admin_id']);
	unset($_SESSION['login_mode']);
	session_destroy();
	session_start();
	header('Location: '.$url);
	exit;
}
else if($_SESSION['login_mode'] == 'google'){
	unset($_SESSION['name']);
	unset($_SESSION['admin_email']);
	unset($_SESSION['ses_admin_id']);
	unset($_SESSION['login_mode']);
	session_destroy();
	session_start();
	header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://kpasapp.com');

}
else{
	unset($_SESSION['name']);
	unset($_SESSION['admin_email']);
	unset($_SESSION['ses_admin_id']);
	unset($_SESSION['login_mode']);
	$_SESSION['langSessId'] = $_SESSION['site_lang'];
	//setcookie('first_name1','',time()-3600);
	//session_destroy();
	header("Location:".$obj_base_path->base_path()."/index");
}

?>
