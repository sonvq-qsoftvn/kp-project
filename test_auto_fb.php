<?php

 require_once 'http://kpasapp.com/Facebook_Twitter_Login/facebook/facebook.php';

// configuration
 $appid = '508763702557865';
 $appsecret = 'fe6b7a9ffedf88df8f7c155ad81582d1';
 $pageId = '142986309080397';
 $msg = 'test';
 $title = 'pagetitle';
 $uri = 'http://google.com/';
 $desc = 'description here';
 $pic = 'http://google.com/test/2.png';
 $action_name = 'Go to my site';
 $action_link = 'http://www.google.com';
 
$facebook = new Facebook(array(
 'appId' => $appid,
 'secret' => $appsecret,
 'cookie' => false,
 ));
echo "hi!";
 
$user = $facebook->getUser();
print_r($user);
exit();
// Contact Facebook and get token
 if ($user) {
 // you're logged in, and we'll get user acces token for posting on the wall
 try {
 $page_info = $facebook->api("/$pageId?fields=access_token");
 if (!empty($page_info['access_token'])) {
 $attachment = array(
 'access_token' => $page_info['access_token'],
 'message' => $msg,
 'name' => $title,
 'link' => $uri,
 'description' => $desc,
 'picture'=>$pic,
 'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
 );

$status = $facebook->api("/$pageId/feed", "post", $attachment);
 } else {
 $status = 'No access token recieved';
 }
 } catch (FacebookApiException $e) {
 error_log($e);
 $user = null;
 }
 } else {
 // you're not logged in, the application will try to log in to get a access token
 header("Location:{$facebook->getLoginUrl(array('scope' => 'photo_upload,user_status,publish_stream,user_photos,manage_pages'))}");
 }

echo $status;

/*-------------------auto post--------------------------------------------*/
/*
require_once("/path/to/facebook_php_sdk/facebook.php"); // set the right path
 
$config = array();
$config['appId'] = '167252680143474';
$config['secret'] = '29d8d368420dc1e81198fce224ac71c9';
$config['fileUpload'] = true;
$fb = new Facebook($config);
 
$params = array(
  // this is the access token for Fan Page
  "access_token" => "CAACYHYyWcnIBAMK1y2tqiRKx8bBXGFFzjdUamOlMZCBJrTSL8ic1z5sZBarBi3DbTh9mMUz3aiZCAQRNHvOmcMxLZC53FNtkrVCq8rZCLsyjbQVZAt8o7S6Rd1UT0LK7AkgyZAlu11MC9rWND8eZBiKjjiYjwmBMLWko7k6GGPZCREehKRNFCsyM1Ll7sFb1hXycZD",
  "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
  "source" => "@" . "/home/pontikis/photo.png", // ATTENTION give the PATH not URL
);
 
try {
  // 466400200079875 is Facebook id of Fan page https://www.facebook.com/pontikis.net
  $ret = $fb->api('/466400200079875/photos', 'POST', $params);
  echo 'Photo successfully uploaded to Facebook Album';
} catch(Exception $e) {
  echo $e->getMessage();
}
*/
/*------------------------auto post end----------------------------------------------*/
//$homepage = file_get_contents('https://www.facebook.com/groups/399192470215912/',false);
//echo "hell= ".$homepage;
// echo "boom=". $_SERVER['REQUEST_URI'];
//
//$url= "https://www.facebook.com/master.kpasapp";
//echo $url;
//function getFacebookId($url) {
//
//    $id =  substr(strrchr($url,'/'),1); 
//echo "id= ".$id;
//    $json = file_get_contents('http://graph.facebook.com/'.$id);
//
//    $json = json_decode($json);
//
//    return $json->id;
//
//}
//
//
//echo "".getFacebookId($url);
//
//

?>