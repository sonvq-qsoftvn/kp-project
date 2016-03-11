<?php
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    //$message = $_GET["message"];
    $regId = ' APA91bEi31tv2RT3oJvwdiuEOpgK4Et9FoY-XkRAhKR4HcRQFCTxupVxdRkulPZxKyJhr7EDOzXkyU-C2sefrD_qv1cAmPyYdMSNzzJtS6tMHqAT4YkxnhgvKZMrmYVk8OWXxoa7HUbqdIHsU1PZM0gQ3CsHjrugIQ';
    $message = 'test notification!!';
     
    include_once 'gcm.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
//}
?>