<?php
$app_id = "792721674074405";
$app_secret = "28d0955813646834bcf8302fd6087d2f";
$redirect_url = "http://kpasapp.com/tfe.php";  
$accesstoken= $_REQUEST["accesstoken"];
  
if(empty($accesstoken)) 
{
    $authurl = "http://www.facebook.com/dialog/oauth?client_id="
    . $app_id . "&redirect_uri=" . urlencode($redirect_url)
    . "&scope=create_event";
    echo("<script>window.location='" . $authurl . "'</script>");
}
  
$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
. $app_id . "&redirect_uri=" . urlencode($redirect_url)
. "&client_secret=" . $app_secret
. "&code=" . $accesstoken;
$accesstoken = file_get_contents($token_url);
 
//Lets create the event now
$url = "https://graph.facebook.com/me/events?" . $access_token;
$params = array();
$params['name'] = "New Event";
$params['link'] = "Link";
$params['message'] = "Your Message";
$params['description'] = "Teste Event";
 
// Check Image
if( isset($_FILES) && !empty($_FILES['picture']['name']) ) 
{
   $uploaddir = './upload/';
   $uploadfile = $uploaddir . basename($_FILES['picture']['name']);
   if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile))
   {
      $params['picture'] = "@" . realpath($uploadfile);
   }
}
   
// Call Graph API 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$result = curl_exec($ch);
$decoded = json_decode($result, true);
curl_close($ch);
//Check Success
if(is_array($decoded) && isset($decoded['id'])) 
{        
   //Event Created
   echo"helloo created.";
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>