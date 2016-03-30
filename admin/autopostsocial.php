<?php
// home page
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../include/admin_inc.php');
include('../twitteroauth/twitterStatus.php');
include('../facebookapi/facebookStatusExtra.php');
include('../pinterestapi/pinterestStatus.php');

$objectEventList = new admin;
$objectScheduleList = new admin;
$objLocation = new user;
$objVenueLocation = new user;
$objEvent = new user;
$obj_event_photo = new admin;
$objCommon = new Common();
$objScheduleListUpdated = new admin;

$objTwitter = new twitterStatus();
$objFacebook = new facebookStatusExtra();
$objPinterest = new pinterestStatus();

$currentDatePHP = date("Y-m-d");
$objectScheduleList->getScheduleEvent($currentDatePHP);

// Find the record with current datetime = date_time field
$currentDateTimePHP = date("Y-m-d H:i");

echo "<p>Current Date Time is: " . $currentDateTimePHP . "</p>";
if($objectScheduleList->num_rows()){
	while($objectScheduleList->next_record()){ 
        $scheduleDateTime = $objectScheduleList->f('date_time');
        echo "<p>Found event with scheduled Date time: " . substr($scheduleDateTime, 0, -3) . "</p>";    
        if (substr($scheduleDateTime, 0, -3) != $currentDateTimePHP) {
            echo "<p>The scheduled time doesnot match current time, skip posting!</p>";
        } else {
            echo "<p>Scheduled time matches current time, TIME FOR SOCIAL POSTING!!!</p>";
            
            // Update the objectScheduleList with published status = 1
            $objScheduleListUpdated->updateScheduleEventToPublished($objectScheduleList->f('id'));
            
			$eventId = $objectScheduleList->f('event_id');
			echo "<p>Event ID = " . $eventId . "</p>";
            $social = $objectScheduleList->f('social_id');
            
            $objEvent->getEventDetails($eventId);
            $objEvent->next_record();
            
            $objLocation->getStateCountyByEventID($eventId);
            $objLocation->next_record();  
            $objVenueLocation->getVenueLocationByVenueID($objEvent->f('event_venue'));
            $objVenueLocation->next_record();                        

            $event_name_en = $objEvent->f('event_name_en');
            $event_name_sp = $objEvent->f('event_name_sp');
            $event_start_date_time = $objEvent->f('event_start_date_time');
            
            $urlEventEN = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($eventId, $objLocation, 'en', 'event', $event_name_en);
            $urlEventES = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($eventId, $objLocation, 'es', 'evento', $event_name_sp);
            $eventNameEN = $event_name_en;
            $eventNameES = $event_name_sp;
            
            $twitterTime = substr($event_start_date_time, 0, 10);

            $dateEN = date_create_from_format('Y-m-d', $twitterTime);
            $twitterDateEN = date_format($dateEN, 'd-M');

            setlocale(LC_TIME, 'es_ES');
            $twitterDateES = strftime("%d-%b", strtotime($twitterTime));
                
            $venueEN = $objVenueLocation->f('venue_name');
            $venueES = $objVenueLocation->f('venue_name_sp');
            $cityName = $objVenueLocation->f('city_name');
                
            try {
                $arrayFBid = array("50","51", "52", "53", "54", "55", "56");
                if (in_array($social, $arrayFBid)) {
                    echo "<p>Post on Facebook</p>";

                    // Post to facebook
                    $statusFacebookEN = [
                        'link' => $urlEventEN,
                        'message' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
                    ];
                    $statusFacebookES = [
                        'link' => $urlEventES,
                        'message' => "$eventNameES, $twitterDateES, $venueES, $cityName",
                    ];
                    $socialLang = $objectScheduleList->f('social_lang');
                    if ($socialLang == "es,en") {
                        $objFacebook->postStatus($statusFacebookEN, $social);
                        $objFacebook->postStatus($statusFacebookES, $social);
                    } else if ($socialLang == "en") {
                        $objFacebook->postStatus($statusFacebookEN, $social);
                    } else {
                        $objFacebook->postStatus($statusFacebookES, $social);
                    }
                
                } else if ($social == "46") {
                    echo "<p>Post on Twitter</p>";
                    // post to twitter                               
                    $statusTwitterEN = "$eventNameEN, $twitterDateEN, $venueEN, $cityName, $urlEventEN via @Kpasapp";
                    $statusTwitterES = "$eventNameES, $twitterDateES, $venueES, $cityName, $urlEventES via @Kpasapp";
                    $objTwitter->postStatus($statusTwitterEN);
                    $objTwitter->postStatus($statusTwitterES);

                } else if ($social == "47") {
                    echo "<p>Post on Pinterest</p>";

                    // Post to pinterest
                    $imagePinterestDefault = $obj_base_path->base_path() . '/images/kpasapp_logo_fb.png';
                    $obj_event_photo->getPhotoByEventId($eventId);
                    if($obj_event_photo->num_rows()){
                        $obj_event_photo->next_record();
                        if($obj_event_photo->f('event_photo') != "") {
                            $imagePinterestDefault = $obj_base_path->base_path() . '/files/event/large/' . $obj_event_photo->f('event_photo');
                        }
                    }
                    $statusPinterestEN = [
                        'url' => $urlEventEN,
                        'description' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
                        'image' => $imagePinterestDefault
                    ];
                    $statusPinterestES = [
                        'url' => $urlEventES,
                        'description' => "$eventNameES, $twitterDateES, $venueES, $cityName",
                        'image' => $imagePinterestDefault
                    ];

                    $objPinterest->postStatus($statusPinterestEN, $venue_county, 'en');
                    $objPinterest->postStatus($statusPinterestES, $venue_county, 'es');
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            
            setlocale(LC_TIME, 'en_US');
        }
	}
}


?>
