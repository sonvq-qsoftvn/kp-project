<?php
// require codebird
require_once('codebird/src/codebird.php');
 
\Codebird\Codebird::setConsumerKey("xALfAf6XtlK4weAoDg6Bdrs8X", "qzHcUXTY0HS5j2su5znPBsFYbvKsMSDfgGZBXjrScemDDs0w2a");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("2646958970-n7GrMWdE99R2O9gOHzTuOPME4rYGiQlGUSePWcZ", "yxT3ZNETekSTdmqDjBfdz0iBVyjKoPheznLatTPYRDjvJ");
 
$params = array(
  'status' => 'Test Account',
  'media[]' => 'http://kpasapp.com/auto_twitter/test.jpg'
);
$reply = $cb->statuses_updateWithMedia($params);

?>