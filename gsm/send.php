<?php
 
// API access key from Google API's Console
//define( 'API_ACCESS_KEY', 'AIzaSyBVLXvuYKpUM4K8DUGZPZlds1fQiPF2EWI' );
//define( 'API_ACCESS_KEY', 'AIzaSyAsdQVGBQD2cVvejqN3ID4Jig0gHeoAxi8' );
//define( 'API_ACCESS_KEY', 'AIzaSyA2p0A1OZpRCpgrFk1NSSD3R0YEONUJ0KA' );
define( 'API_ACCESS_KEY', 'AIzaSyCwwXXLLbxXKKFCTReJ_dyW1jpt7T_j7yw' );
//define( 'API_ACCESS_KEY', 'AIzaSyCmZ0o__GzDxow8L5PgU_EwTA-I9FUCozo' );
 
//$registrationIds = array( $_GET['id'] );
//$registrationIds =  array('APA91bEi31tv2RT3oJvwdiuEOpgK4Et9FoY-XkRAhKR4HcRQFCTxupVxdRkulPZxKyJhr7EDOzXkyU-C2sefrD_qv1cAmPyYdMSNzzJtS6tMHqAT4YkxnhgvKZMrmYVk8OWXxoa7HUbqdIHsU1PZM0gQ3CsHjrugIQ');
$registrationIds =  array('APA91bGqPMnbocdGiUvvp6uk03xSSPMijr3F-YpY2iw6rtGTr3qw3vQ7NAkEmJWAMXl8Wc14GD-upNoFz6XBnZfac3jBnyPkMdk0s-eatuiq4OnswEDXBEsfnNJ9GbTOCIRJ1OqGpcmm6wzdhXPzvzwXDj5fiF8gWA');
// prep the bundle
$msg = array
(
    'message' 		=> 'here is a message. message',
	'title'			=> 'This is a title. title',
	'subtitle'		=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1
);
 
 //print_r($msg);
 
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'				=> $msg
);
 // print_r($fields);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 //print_r($headers);
$ch = curl_init();
//echo "h= ".$ch;
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
 
echo $result;
?>