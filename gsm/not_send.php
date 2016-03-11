<?php
//$registatoin_ids = 'APA91bEi31tv2RT3oJvwdiuEOpgK4Et9FoY-XkRAhKR4HcRQFCTxupVxdRkulPZxKyJhr7EDOzXkyU-C2sefrD_qv1cAmPyYdMSNzzJtS6tMHqAT4YkxnhgvKZMrmYVk8OWXxoa7HUbqdIHsU1PZM0gQ3CsHjrugIQ';
//$message ="hello";

class GCM {
 
    //put your code here
    // constructor
    function __construct() {
         
    }
    
            function sendPushNotificationToGCM($registatoin_ids, $message) {
                //Google cloud messaging GCM-API url
                 $url        = 'https://android.googleapis.com/gcm/send';
                $fields     = array(
                'registration_ids' => $registatoin_ids,
                'data' => $message,
		
            );
            // Google Cloud Messaging GCM API Key
            //define("GOOGLE_API_KEY", "AIzaSyBVLXvuYKpUM4K8DUGZPZlds1fQiPF2EWI");
           define("GOOGLE_API_KEY", "AIzaSyCwwXXLLbxXKKFCTReJ_dyW1jpt7T_j7yw");
		   $headers = array(
                'Authorization: key=' . GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result == FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            curl_close($ch);
            return $result;
            }
            
}
?>
