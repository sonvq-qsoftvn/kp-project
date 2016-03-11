<?php
$app_id = "508763702557865";
$app_secret = "fe6b7a9ffedf88df8f7c155ad81582d1";
$my_url = "http://kpasapp.com/test_fb_event.php/"; // mainly this should be the same URL to THIS page

$code = $_REQUEST["code"];

if(empty($code)) {
	$auth_url = "http://www.facebook.com/dialog/oauth?client_id="
	. $app_id . "&redirect_uri=" . urlencode($my_url)
	. "&scope=create_event";
	echo("<script>top.location.href='" . $auth_url . "'</script>");
}

$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
. $app_id . "&redirect_uri=" . urlencode($my_url)
. "&client_secret=" . $app_secret
. "&code=" . $code;
$access_token = file_get_contents($token_url);

if( !empty($_POST) && (empty($_POST['name']) || empty($_POST['start_time']) || empty($_POST['end_time'])) ) {
	$msg = "Please check your inputs!";
} elseif(!empty($_POST)) {
	$url = "https://graph.facebook.com/me/events?" . $access_token;
	$params = array();
	// Prepare Event fields
	foreach($_POST as $key=>$value)
		if(strlen($value))
			$params[$key] = $value;
	
	// Check if we have an image
	if( isset($_FILES) && !empty($_FILES['picture']['name']) ) {
		$uploaddir = './upload/';
		$uploadfile = $uploaddir . basename($_FILES['picture']['name']);
		if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
			$params['picture'] = "@" . realpath($uploadfile);
		}
	}	
	
	// Start the Graph API call
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	/*
		Next option is only used for 
		user from a local (WAMP) 
		machine. This should be removed
		when used on a live server!

https://github.com/facebook/php-sdk/issues/7

	*/
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $result = curl_exec($ch);
    $decoded = json_decode($result, true);
    curl_close($ch);
	if(is_array($decoded) && isset($decoded['id'])) {
		// Event created successfully, now we can
		// a) save event id to DB AND/OR
		// b) show success message AND/OR
		// c) optionally, delete image from our server (if any)
		$msg = "Event created successfully: {$decoded['id']}";
	}
}
?>
<!doctype html>
<html>
<head>
<title>Create An Event</title>
<style>
label {float: left; width: 100px;}
input[type=text],textarea {width: 210px;}
#msg {border: 1px solid #000; padding: 5px; color: red;}
</style>
</head>
<body>
<?php if( isset($msg) ) { ?>
<p id="msg"><?php echo $msg; ?></p>
<?php } ?>
<form enctype="multipart/form-data" action="" method="post">
	<p><label for="name">Event Name</label><input type="text" name="name" value="a" /></p>
	<p><label for="description">Event Description</label><textarea name="description"></textarea></p>
	<p><label for="location">Location</label><input type="text" name="location" value="" /></p>
	<p><label for="">Start Time</label><input type="text" name="start_time" value="<?php echo date('Y-m-d H:i:s'); ?>" /></p>
	<p><label for="end_time">End Time</label><input type="text" name="end_time" value="<?php echo date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))); ?>" /></p>
	<p><label for="picture">Event Picture</label><input type="file" name="picture" /></p>
	<p>
		<label for="privacy_type">Privacy</label>
		<input type="radio" name="privacy_type" value="OPEN" checked='checked'/>Open&nbsp;&nbsp;&nbsp;
		<input type="radio" name="privacy_type" value="CLOSED" />Closed&nbsp;&nbsp;&nbsp;
		<input type="radio" name="privacy_type" value="SECRET" />Secret&nbsp;&nbsp;&nbsp;
	</p>
	<p><input type="submit" value="Create Event" /></p>
</form>
</body>
</html>