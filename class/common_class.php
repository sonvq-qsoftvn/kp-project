<?php

class Common extends DB_Sql {

    function getEventURLByEventID($eventId, $objectVenue, $language, $text, $eventName) {
       
        $stateName = $this->cleanName($objectVenue->f('state_name'));
        $countyName = $this->cleanName($objectVenue->f('county_name'));
        $cityName = $this->cleanName($objectVenue->f('city_name'));
		$eventName = $this->cleanName($eventName);

        $result = '/' . $language . '/' . $text . '/' . $eventId . '/' . $stateName . '/' . $countyName . '/' . $cityName . '/' . $eventName;
        return $result;
    }
    
    function getCleanVenueURL($venueId, $objectVenue, $language) {
       
        $stateName = $this->cleanName($objectVenue->f('state_name'));
        $countyName = $this->cleanName($objectVenue->f('county_name'));
        $cityName = $this->cleanName($objectVenue->f('city_name'));
        if($language == 'en') {
            $venueName = $this->cleanName($objectVenue->f('venue_name'));
        } else {
            $venueName = $this->cleanName($objectVenue->f('venue_name_sp'));
        }

        $result = '/' . $language . '/venue/' . $venueId . '/' . $stateName . '/' . $countyName . '/' . $cityName . '/' . $venueName;
        return $result;
    }
    
    function cleanName($name) {
        $result = preg_replace('#[^a-zA-Z0-9]#', ' ', trim($name));
        $result = preg_replace('/\s{2,}/',' ', $result);
        $result = str_replace(' ', '-',strtolower($result));
        
        return $result;
    }

}
