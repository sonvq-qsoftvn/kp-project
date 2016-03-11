<?php
// home page
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../include/admin_inc.php');
include('../twitteroauth/twitterStatus.php');
include('../facebookapi/facebookStatus.php');
include('../pinterestapi/pinterestStatus.php');

$objectEventList = new admin;

try {
    // First step is to get event to post
    

    // post to twitter
    $objLocation->getStateCountyByEventID($_POST['id']);
    $objLocation->next_record();  
    $objVenueLocation->getVenueLocationByVenueID($venue);
    $objVenueLocation->next_record();

    $urlEventEN = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($_POST['id'], $objLocation, 'en', 'event', $event_name_en);
    $urlEventES = $obj_base_path->base_path(). $objCommon->getEventURLByEventID($_POST['id'], $objLocation, 'es', 'evento', $event_name_sp);

    $twitterTime = substr($event_start_date_time, 0, 10);

    $dateEN = date_create_from_format('Y-m-d', $twitterTime);
    $twitterDateEN = date_format($dateEN, 'd-M');

    setlocale(LC_TIME, 'es_ES');
    $twitterDateES = strftime("%d-%b", strtotime($twitterTime));               

    $venueEN = $objVenueLocation->f('venue_name');
    $venueES = $objVenueLocation->f('venue_name_sp');
    $cityName = $objVenueLocation->f('city_name');

    $eventNameEN = $_POST['event_name_en'];
    $eventNameES = $_POST['event_name_sp'];

    $statusTwitterEN = "$eventNameEN, $twitterDateEN, $venueEN, $cityName, $urlEventEN via @Kpasapp";
    $statusTwitterES = "$eventNameES, $twitterDateES, $venueES, $cityName, $urlEventES via @Kpasapp";
    $objTwitter->postStatus($statusTwitterEN);
    $objTwitter->postStatus($statusTwitterES);

    // Post to facebook
    $statusFacebookEN = [
        'link' => $urlEventEN,
        'message' => "$eventNameEN, $twitterDateEN, $venueEN, $cityName",
    ];
    $statusFacebookES = [
        'link' => $urlEventES,
        'message' => "$eventNameES, $twitterDateES, $venueES, $cityName",
    ];
    $objFacebook->postStatus($statusFacebookEN);
    $objFacebook->postStatus($statusFacebookES);


    // Post to pinterest
    $imagePinterestDefault = $obj_base_path->base_path() . '/images/kpasapp_logo_fb.png';
    $obj_event_photo->getPhotoByEventId($_POST['id']);
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


    setlocale(LC_TIME, 'en_US');
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>
