<?php

require_once 'vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '445192265673724',
  'app_secret' => '41f5bccae260641bce323da48eb35776',
  'default_graph_version' => 'v2.5',
 // 'default_access_token' => '148575668855175|ZT1YscO4-NCRuca5uV9xtNXucrc', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

try {
  // Get the Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me', 'CAAGU5mbaKZCwBAOk1UZBW6ZA2M4OwnwZCYCZCJUBfpFZBS5h5TXezOyL22pGLPircEyWiZBjYaQ7PiduPa38doAON7mzZBf6OqA2wnQ8fKhZAVKNEkB9TFOx3aRD5jgCd9omZABSaFDqBCg03WPwzQlCZAbmTUu6xMBEILhZC5N0agxdb5qQdR8EZA5C3');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();

$linkData = [
  'link' => 'http://kpasapp.com',
  'message' => 'Visit kpasapp, Eventos Baja California Sur',
  ];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed', $linkData, 'CAAGU5mbaKZCwBAOk1UZBW6ZA2M4OwnwZCYCZCJUBfpFZBS5h5TXezOyL22pGLPircEyWiZBjYaQ7PiduPa38doAON7mzZBf6OqA2wnQ8fKhZAVKNEkB9TFOx3aRD5jgCd9omZABSaFDqBCg03WPwzQlCZAbmTUu6xMBEILhZC5N0agxdb5qQdR8EZA5C3');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Posted with id: ' . $graphNode['id'];