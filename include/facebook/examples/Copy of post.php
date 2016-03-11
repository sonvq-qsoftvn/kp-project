<?php
/*require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).

// Init facebook api.
$facebook = new Facebook(array(
        'appId' => '215231698575992',
        'secret' => '47ab97ae091119cf806e6f8ab8bbd385',
        'cookie' => true
));
 
// Get the url to redirect for login to facebook
// and request permission to write on the user's wall.
$login_url = $facebook->getLoginUrl(
    array('scope' => 'publish_stream')
);
 
// If not authenticated, redirect to the facebook login dialog.
// The $login_url will take care of redirecting back to us
// after successful login.
if (! $facebook->getUser()) {
    echo '
<script type="text/javascript">
top.location.href = "'.$login_url.'";
</script>;';
 
    exit;
}
 
// Do the wall post.
$facebook->api("/me/feed", "post", array(
    message => "YOUR_MESSAGE",
    picture => "YOUR_PICTURE_URL",
    link => "YOUR_LINK",
    name => "YOUR_LINK_NAME",
    caption => "YOUR_CAPTION"
));*/
?>
<?
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('php-sdk/facebook.php');

  $config = array(
    'appId' => '215231698575992',
    'secret' => '47ab97ae091119cf806e6f8ab8bbd385',
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
?>
<html>
  <head></head>
  <body>

  <?
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {
        $ret_obj = $facebook->api('/me/feed', 'POST',
                                    array(
                                      'link' => 'www.example.com',
                                      'message' => 'Posting with the PHP SDK!'
                                 ));
        echo '<pre>Post ID: ' . $ret_obj['id'] . '</pre>';

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl( array(
                       'scope' => 'publish_stream'
                       )); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
      // Give the user a logout link 
      echo '<br /><a href="' . $facebook->getLogoutUrl() . '">logout</a>';
    } else {

      // No user, so print a link for the user to login
      // To post to a user's wall, we need publish_stream permission
      // We'll use the current URL as the redirect_uri, so we don't
      // need to specify it here.
      $login_url = $facebook->getLoginUrl( array( 'scope' => 'publish_stream' ) );
      echo 'Please <a href="' . $login_url . '">login.</a>';

    } 

  ?>      

  </body> 
</html>  