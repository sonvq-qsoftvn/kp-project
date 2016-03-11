<?php
require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '215231698575992',
  'secret' => '47ab97ae091119cf806e6f8ab8bbd385',
 
));
setcookie('fbs_'.$facebook->getAppId(), '', time()-100, '/', 'unifiedinfotech.net');
session_destroy();
header("Location: http://unifiedinfotech.net/testfb/examples/example.php");

?>