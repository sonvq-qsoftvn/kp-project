<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '476596849151624',
  'secret' => 'd5f988bb4d13f0957104b34cd1a4c5aa',
));

// Get User ID
$user = $facebook->getUser();
//$user=null;

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $post_url = '/1439110063020924/feed';   //your page id
  $page_access_token ='';
    $attachment_1 = array(
        'access_token' => $facebook->getAccessToken()
    );
   $result = $facebook->api("/me/accounts", $attachment_1);
    if(count($result["data"])!=0)  {
       

    foreach($result["data"] as $page) {
        if($page["id"] == '1439110063020924') {  //page  id
            $page_access_token = $page["access_token"];
            break;
        }
    }
    }
   
  
   
    $msg_body = array(
      'access_token' =>  $page_access_token,
      'source' => 'http://kpasapp.com/fb/fbmaster/examples/test.jpg',
    'subject' => 'sample event',
    'from' => '476596849151624',  //app id
    'to' => '1439110063020924',   //page  id
    'message' => 'This is test post to wall',
    'description'=>' asf dsf das fdas fdas fdas fdsfasdf das fds'
    );
    
    try {
            $postResult = $facebook->api($post_url, 'post', $msg_body );
            
            
        } catch (FacebookApiException $e) {
        echo $e->getMessage();
      }
          
          
  } catch (FacebookApiException $e) { 
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array("next"=>"http://kpasapp.com/fb/fbmaster/examples/logout.php"));
} else {
  
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'photo_upload,publish_actions,user_status,publish_stream,user_photos,read_stream,manage_pages'));
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/naitik');

/*-----------for  posting----------------*/



?>
<!--<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php //echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php //echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php// print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php //echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php //print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php //echo $naitik['name']; ?>
  </body>
</html>-->
