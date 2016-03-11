<?php


ini_set("memory_limit","1000M");
ini_set("upload_max_filesize","50M");
ini_set("post_max_size","80M");
ini_set("max_input_time","600");
ini_set("max_execution_time","600");
set_time_limit(0);


// Put your device token here (without spaces):
//$deviceToken = '8c27cff4271ed9ecda0f7facad2e9d839789a5feca539e11b5ebcde7a95b53c3';
//$deviceToken = 'd415860228d6f553e5f784f76e02095021275d26bd19042f0c12bfb8104e26b5';
//$deviceToken = '21e86bfc49fe350fafdd3a1105880767d79dd4d519612860bbddc97ba8c94641';
//$deviceToken = '1397e4277f13ee4e8f8af05fba71ea342e39b1e10031672d430afefdacb4c3d1';
$deviceToken = 'd415860228d6f553e5f784f76e02095021275d26bd19042f0c12bfb8104e26b5';
// Put your private key's passphrase here:
//$passphrase = '1234567890';
$passphrase = 'user123';

// Put your alert message here:
$message = 'My first push notification!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'EqDictationPushChat_Dev.pem');
stream_context_set_option($ctx, 'ssl', 'local_cert', 'comb.pem');
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'combEQDictationLive.pem');
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'combEQDictationLive.1.pem');

stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;


// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
//echo $result;
if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
