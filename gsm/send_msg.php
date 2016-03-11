<?php
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    //$message = $_GET["message"];
    $regId = 'APA91bHj8VetRAB0RUIojTsV2lxMQcFdi5UEKcmlWU9aZSBzr1U8xMfLtKs2YBQ6XhlBg9pq41KZjOZLQxm0dgOHOk9mrBT84JqLniefsXI3PZSRFBE2ab-3z81OEiVZo_YHv9SBH6-j5C4nr_S2wk5Ss62ajLXLoIcZG_Ewe3Ufx-yjZYfyGZY'; //ankan
        $message = 'hi! Ankan,Its working form kpasapp.. :)';
     
    include_once 'gcm.php';
   // include_once 'not_send.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
    
    //$registatoin_ids = $regId;
 
    $result = $gcm->send_notification($registatoin_ids, $message);
     //$result = $gcm->sendPushNotificationToGCM($registatoin_ids, $message);
 
    echo $result;
//}
?>