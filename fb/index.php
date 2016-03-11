<?php
phpinfo();
require 'fbsdk4/autoload.php';
FacebookSession::setDefaultApplication('476596849151624', 'd5f988bb4d13f0957104b34cd1a4c5aa');
/*session_start();
    require_once('facebookapi/facebook.php');
    //require_once ("../admin/config.php");
    $appid = '476596849151624';
    $appsecret = 'd5f988bb4d13f0957104b34cd1a4c5aa';
    $pageId = '374357489339625';
    $msg = 'Automatically post to Facebook from Your Website';
    $title = 'Automatically post to Facebook from Your Website';
    $uri = 'http://blog.phpinfinite.com/automatically-post-to-facebook-from-your-website';
    $desc = 'Facebook constantly changes their SDK and methods for communicating with Facebook. The script in this post supports the latest Facebook authentication changes that    will be implemented i October 2012.';
    $pic = 'http://blog.phpinfinite.com/wp-content/uploads/2012/11/post_to_facebook_from_php.jpg';
    $action_name = 'Go to PHP Infinite';
    $action_link = 'http://blog.phpinfinte.com';
    $facebook = new Facebook(array(
        'appId' => $appid,
        'secret' => $appsecret,
        'cookie' => true,
    ));
     echo $user = $facebook->getUser();
       if(!$user){
     // you're not logged in, the application will try to log in to get a access token
        header("Location:{$facebook->getLoginUrl(array(
            'scope' => 'publish_stream'
        )) }");
	
	
    }else{
  
	$_SESSION['user']=$user;
	
	//$params = array( 'next' => 'http://phppowerhousedemo.com/webroot/team11/fb/' );

	echo '<a href="'.$facebook->getLogoutUrl().'">Logout</a>';

        // you're logged in, and we'll get user acces token for posting on the wall
       
                $page_info = $facebook->api("/$pageId?fields=access_token");
               echo "<pre>";print_r($page_info);
                exit;
                
                if (!empty($page_info['access_token']))
                {
                    //echo $pageId;
                    $attachment = array(
                        'access_token' => $page_info['access_token'],
                        'message' => $msg,
                        'name' => $title,
                        'link' => $uri,
                        'description' => $desc,
                        'picture' => $pic,
                        'actions' => json_encode(array(
                            'name' => $action_name,
                            'link' => $action_link
                        ))
                    );
                    //$status = $facebook->api("/".$pageId."/feed/", 'POST', $attachment);
                    $url = "https://graph.facebook.com/$pageId/feed";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
                    $result = curl_exec($ch);
                    curl_close ($ch);
                    //print_r($result);
                    echo "<pre>";print_r($result);
                    exit;
                    
                }
                else
                {
                    $status = 'No access token recieved';
                }
            
    }
 
echo $status;*/