<?php
//error_reporting(1);
//require 'fbsdk4/autoload.php';
//FacebookSession::setDefaultApplication('476596849151624', 'd5f988bb4d13f0957104b34cd1a4c5aa');
//
//echo "test";

require_once('facebookapi/facebook.php');

// configuration
 $appid = '476596849151624';
 $appsecret = 'd5f988bb4d13f0957104b34cd1a4c5aa';
 $pageId = '1439110063020924';
 $msg = 'Automatically post to Facebook from Your Website';
 $title = 'Automatically post to Facebook from Your Website';
 $uri = 'http://blog.phpinfinite.com/automatically-post-to-facebook-from-your-website';
 $desc = 'Facebook constantly changes their SDK and methods for communicating with Facebook. The script in this post supports the latest Facebook authentication changes that will be implemented i October 2012.';
 $pic = 'http://blog.phpinfinite.com/wp-content/uploads/2012/11/post_to_facebook_from_php.jpg';
 $action_name = 'Go to PHP Infinite';
 $action_link = 'http://blog.phpinfinte.com';

$facebook = new Facebook(array(
 'appId' => $appid,
 'secret' => $appsecret,
 'cookie' => false,
 ));

$user = $facebook->getUser();
//echo "hiqqqq!"."<br/>";

//print_r($facebook);
//print_r($user);
//print_r($facebook->getUser());
//exit();
// Contact Facebook and get token
 if ($user) {
	//echo "user";
	// you're logged in, and we'll get user acces token for posting on the wall
	try {
	       //echo "user TRY";
	       $page_info = $facebook->api("/$pageId?fields=access_token");
	       //echo "AT=".$page_info['access_token']."<br/>";
	       //exit();
	       if (!empty($page_info['access_token'])) {
	       //echo "AT HAS";
	       $attachment = array(
	       'access_token' => $page_info['access_token'],
	       'message' => $msg,
	       'name' => $title,
	       'link' => $uri,
	       'description' => $desc,
	       'picture'=>$pic,
	       'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
	       );
	      // echo "<pre>";
	      // print_r($attachment);
	       //echo "p_id= ".$pageId;
	       
	       $status = $facebook->api("/$pageId/feed", "post", $attachment);
	       
	      // echo "<br/>hello=".$status;
	       //exit();
	       
	       } else {
		       echo "else";
		       $status = 'No access token recieved';
	       }
	} catch (FacebookApiException $e) {
	       echo "user catch=".$e;
	       error_log($e);
	       $user = null;
	}
 } else {
   echo "else Np user";
 // you're not logged in, the application will try to log in to get a access token
 header("Location:{$facebook->getLoginUrl(array('scope' => 'photo_upload,publish_actions,user_status,publish_stream,user_photos,read_stream,manage_pages'))}");
      // $loginUrl = $facebook->getLoginUrl(array('scope' => 'photo_upload,publish_actions,user_status,publish_stream,user_photos,read_stream,manage_pages'));
 }

echo $status;


 ?>
 
