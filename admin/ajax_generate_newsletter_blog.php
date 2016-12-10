<?php
session_start();

include('../include/admin_inc.php');

$objAdd = new admin;
$objEventShowcase = new admin;
$objEventListing = new admin;
$obj_base_path = new DB_Sql;
$objCommon = new Common();
$objfeatureimage = new user; 
$objEventCategoryById = new user;
$objSubEventCategoryById = new user;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newsletter_type']) && ($_POST['newsletter_type'] == 'listing')) {
        $title_en = isset($_POST['title_en']) ? $_POST['title_en'] : 'Baja Sur Events';
        $title_sp = isset($_POST['title_sp']) ? $_POST['title_sp'] : 'Eventos Baja Sur';

        $page_link = preg_replace("%[^-/+|\w ]%", '', $title_en);
        $page_link = strtolower(trim(substr($page_link, 0, 255), '-'));
        $page_link = preg_replace("/[\/_|+ -]+/", '-', $page_link);

        $selected_event_id = $_POST['selected_event_id'];
        $selected_showcase_id = $_POST['selected_showcase_id'];
        
        $array_selected_showcase_id = array();
        $array_showcase_eventEN = array();
        $array_showcase_eventSP = array();
        
        /*
         * Style string
         */
        $paragraphStyleStr = "font-size: 15px; font-family: Arial; color: rgb(0, 0, 0); line-height: 1.38;";        
        $normalLinkStyleStr = "font-size: 15px; font-family: Arial; color: rgb(17, 85, 204);"
                . "text-decoration: underline;";

        $headerStyleStr = "font-size: 27px; font-family: Arial; "
                . "line-height: 1.38; color: rgb(0, 0, 0); font-weight: 400;";        
                
        if (!empty($selected_showcase_id)) {
            $objEventShowcase->getEventByArrayID($selected_showcase_id);
            if ($objEventShowcase->num_rows() > 0) {
                while($objEventShowcase->next_record()){                
                    
                    $event_name_en = $objEventShowcase->f('event_name_en');
                    $event_name_sp = $objEventShowcase->f('event_name_sp');
                    $event_id = $objEventShowcase->f('event_id');
                    $state_name = $objEventShowcase->f('state_name');
                    $county_name = $objEventShowcase->f('county_name');
                    $city_name = $objEventShowcase->f('city_name');
                    $event_link_en = $obj_base_path->base_path() . 
                            $objCommon->getEventURLByEventAndVenue($event_id, 
                                    $state_name, $county_name,
                                    $city_name, 'en', 'event', 
                                    $event_name_en);
                    $event_link_sp = $obj_base_path->base_path() . 
                            $objCommon->getEventURLByEventAndVenue($event_id, 
                                    $state_name, $county_name,
                                    $city_name, 'es', 'evento', 
                                    $event_name_sp);
                    
                    $array_showcase_eventEN[] = '<a style="' . $normalLinkStyleStr .
                            '" target="blank" href="' . $event_link_en . '">' .
                            $event_name_en . '</a>';
                    $array_showcase_eventSP[] = '<a style="' . $normalLinkStyleStr .
                            '" target="blank" href="' . $event_link_sp . '">' .
                            $event_name_sp . '</a>';
                } 
            }
        }
        
        $headerSectionEN = '';
        $headerSectionSP = '';
        
        if (count($array_showcase_eventEN) > 0) {
            $headerSectionEN = $headerSectionEN . '<p style="' . $paragraphStyleStr . '">' 
                    . implode('<br>', $array_showcase_eventEN) . '</p>';
        }
        
        if (count($headerSectionSP) > 0) {
            $headerSectionSP = $headerSectionSP . '<p style="' . $paragraphStyleStr . '">' 
                    . implode('<br>', $array_showcase_eventSP) . '</p>';
        }
        
        $headerSectionFixedEN = '<p style="' . $paragraphStyleStr . '">Here is our selection of events for '
                . 'the upcoming weekends. You can of course check the '
                . '<a target="blank" style="' . $normalLinkStyleStr . '" href="http://kpasapp.com/en/home">complete '
                . 'schedule of upcoming events in La Paz, Los Cabos and all of Baja California Sur</a></p>';
        
        $headerSectionFixedSP = '<p style="' . $paragraphStyleStr . '">'
                . 'Por favor, revisa nuestra selecci&oacute;n de eventos para los pr&oacute;ximos fines de semana. Puede, por supuesto, consultar la '
                . '<a target="blank" style="' . $normalLinkStyleStr . '" href="http://kpasapp.com/es/inicio">'
                . 'programaci&oacute;n completa de los pr&oacute;ximos eventos en La Paz, Los Cabos y toda la Baja California Sur'
                . '</a></p>';
                
        $eventListHTMLEN = '';
        $eventListHTMLSP = '';
        if (!empty($selected_event_id)) {
            $objEventListing->getEventByArrayID($selected_event_id);
            if ($objEventListing->num_rows() > 0) {
                while($objEventListing->next_record()){
                    
                    $objfeatureimage->isfeatureImage($objEventListing->f('event_id')); 
                    $objfeatureimage->next_record();                    
                    $singleBlockEventEN = "";
                    $singleBlockEventSP = "";
                    $htmlEventContentEN = "";
                    $htmlEventContentSP = "";
                    
                    // Get content of event                    
                    $event_name_en = $objEventListing->f('event_name_en');
                    $event_name_sp = $objEventListing->f('event_name_sp');
                    $event_id = $objEventListing->f('event_id');
                    $state_name = $objEventListing->f('state_name');
                    $county_name = $objEventListing->f('county_name');
                    $city_name = $objEventListing->f('city_name');
                    $event_link_en = $obj_base_path->base_path() . 
                            $objCommon->getEventURLByEventAndVenue($event_id, 
                                    $state_name, $county_name,
                                    $city_name, 'en', 'event', 
                                    $event_name_en);
                    $event_link_sp = $obj_base_path->base_path() . 
                            $objCommon->getEventURLByEventAndVenue($event_id, 
                                    $state_name, $county_name,
                                    $city_name, 'es', 'evento', 
                                    $event_name_sp);
                    
                    /*
                     * Styleing sheet
                     */
                    $imgFeatureStyleStr = "width:100%; height: auto; margin-bottom:20px;";
                    $divFeatureStyleStr = "width:25%; float: left; display: inline-block";
                    $divEventContentStyleStr = "padding-left: 15px; box-sizing: border-box; width: 74%; float: left; display: inline-block; margin-bottom: 20px;";
                    $styleEventContentTitle = "font-size: 20px; text-decoration: underline; color: rgb(17, 85, 204); font-weight: 400; font-family: Arial;";
                    $styleDivContainer = "margin-top: 15px;";
                    
                    /*
                     * Get category for event
                     */
                    $htmlCategoryEN = '';
                    $htmlCategorySP = '';
                    $objEventCategoryById->getCategoryByEventId($event_id); 
                    if ($objEventCategoryById->num_rows() > 0) {
                        $htmlCategoryEN = '<p style="' . $paragraphStyleStr . '">';
                        $htmlCategorySP = '<p style="' . $paragraphStyleStr . '">';
                        while($objEventCategoryById->next_record()){				
                            $htmlCategoryEN = $htmlCategoryEN . $objEventCategoryById->f('category_name');
                            
                            $htmlCategorySP = $htmlCategorySP . $objEventCategoryById->f('category_name_sp');
                            
                            $objSubEventCategoryById->getSubCategoryByCategoryIdAndEventId($event_id, $objEventCategoryById->f('category_id'));
                            $subCategoryStrEN = $subCategoryStrSP = '';
                            if ($objSubEventCategoryById->num_rows()) {
                                $count = 0;
                                $subCategoryStrEN = $subCategoryStrSP = ' (';
                                while($objSubEventCategoryById->next_record()){
                                    if ($count > 0) {
                                        $subCategoryStrEN = $subCategoryStrSP . ", ";
                                        $subCategoryStrSP = $subCategoryStrSP . ", ";
                                    }
                                    
                                    $subCategoryStrEN = $subCategoryStrEN . $objSubEventCategoryById->f('category_name');
                                    $subCategoryStrSP = $subCategoryStrSP . $objSubEventCategoryById->f('category_name_sp');

                                    $count++;
                                }   
                                $subCategoryStrEN = $subCategoryStrEN . ')';
                                $subCategoryStrSP = $subCategoryStrSP . ')';
                            } 
                            $htmlCategoryEN = $htmlCategoryEN . $subCategoryStrEN . '<br>';
                            $htmlCategorySP = $htmlCategorySP . $subCategoryStrSP . '<br>';
                        } 
                        $htmlCategoryEN = $htmlCategoryEN . '</p>';
                        $htmlCategorySP = $htmlCategorySP . '</p>';
                    }
                    
                    // get datetime of event
                    $event_start_date_time = $objEventListing->f('event_start_date_time');
                    $event_start_ampm = $objEventListing->f('event_start_ampm');
                    $event_end_date_time = $objEventListing->f('event_end_date_time');
                    $event_end_ampm = $objEventListing->f('event_end_ampm');
                    
                    $event_start_date = substr($event_start_date_time, 0, 10);
                    $event_end_date = substr($event_end_date_time, 0, 10);
                    $htmlDatePeriodEN = "";
                    $htmlDatePeriodSP = "";                    
                    
                    if ($event_start_date == $event_end_date) {
                        setlocale(LC_TIME, 'en_US.UTF-8');                        
                        $htmlDatePeriodEN = '<p style="' . $paragraphStyleStr . '">' . 
                                strftime('%a %b %d, %Y, %l:%M',strtotime($event_start_date_time)) . ' ' .
                                $event_start_ampm . ' to ' . strftime('%l:%M',strtotime($event_end_date_time)) . 
                                ' ' . $event_end_ampm . '</p>';
                        
                        setlocale(LC_TIME, 'es_ES.UTF-8');
                        $htmlDatePeriodSP = '<p style="' . $paragraphStyleStr . '">' . 
                                strftime('%a %b %d, %Y, %l:%M',strtotime($event_start_date_time)) . ' ' .
                                $event_start_ampm . ' to ' . strftime('%l:%M',strtotime($event_end_date_time)) .
                                ' ' . $event_end_ampm . '</p>';
                    } else {
                        setlocale(LC_TIME, 'en_US.UTF-8');                        
                        $htmlDatePeriodEN = '<p style="' . $paragraphStyleStr . '">' . 
                                strftime('%a %b %d, %Y, %l:%M',strtotime($event_start_date_time)) . ' ' .
                                $event_start_ampm . ' to ' . strftime('%a %b %d, %Y, %l:%M',strtotime($event_end_date_time)) .
                                ' ' . $event_end_ampm . '</p>';
                        
                        setlocale(LC_TIME, 'es_ES.UTF-8');
                        $htmlDatePeriodSP = '<p style="' . $paragraphStyleStr . '">' . 
                                strftime('%a %b %d, %Y, %l:%M',strtotime($event_start_date_time)) . ' ' .
                                $event_start_ampm . ' to ' . strftime('%a %b %d, %Y, %l:%M',strtotime($event_end_date_time)) .
                                ' ' . $event_end_ampm . '</p>';
                    }
                    
                    /*
                     * Short description
                     */
                    
                    $htmlShortDescEN = "";
                    $htmlShortDescSP = "";
                    
                    $styleMoreButton = "padding: 5px 11px; background: none repeat scroll 0 0 #23446d; "
                            . "color: #fff; font-family: arial; font-size: 15px; text-decoration: none; "
                            . "display: inline-block; margin-left: 10px";
                    if ($objEventListing->f('event_short_desc_en')) {
                        $htmlShortDescEN = '<p style="' . $paragraphStyleStr . '">' .
                                $objEventListing->f('event_short_desc_en')
                                . '<a style="' . $styleMoreButton . '" target="blank" href="' 
                                . $event_link_en . '">More >></a></p>';
                    }
                    
                    if ($objEventListing->f('event_short_desc_sp')) {
                        $htmlShortDescSP = '<p style="' . $paragraphStyleStr . '">' .
                                $objEventListing->f('event_short_desc_sp')
                                . '<a style="' . $styleMoreButton . '" target="blank" href="' 
                                . $event_link_sp . '">More >></a></p>';
                    }
                    
                    $htmlVenueEN = "";
                    $htmlVenueSP = "";
                    if ($objEventListing->f('venue_name')) {
                        $htmlVenueEN = '<p style="' . $paragraphStyleStr . '">'
                                . '<a style="' . $normalLinkStyleStr . '" target="blank" href="' .
                                $obj_base_path->base_path(). $objCommon->getCleanVenueURLNewsletter('en', 'venue',
                                        $objEventListing->f('venue_id'), $objEventListing->f('state_name'),
                                        $objEventListing->f('county_name'), $objEventListing->f('city_name'),
                                        $objEventListing->f('venue_name')) . '">' .
                                $objEventListing->f('venue_name') . '</a>, ' . $objEventListing->f('city_name') . '</p>';
                    }
                    
                    if ($objEventListing->f('venue_name_sp')) {
                        $htmlVenueSP = '<p style="' . $paragraphStyleStr . '">'
                                . '<a style="' . $normalLinkStyleStr . '" target="blank" href="' .
                                $obj_base_path->base_path(). $objCommon->getCleanVenueURLNewsletter('es', 'lugares',
                                        $objEventListing->f('venue_id'), $objEventListing->f('state_name'),
                                        $objEventListing->f('county_name'), $objEventListing->f('city_name'),
                                        $objEventListing->f('venue_name_sp')) . '">' .
                                $objEventListing->f('venue_name_sp') . '</a>, ' . $objEventListing->f('city_name') . '</p>';
                    }
                    
                    $htmlEventContentEN = '<div style="' . $divEventContentStyleStr . '">' . 
                            '<h3><a target="blank" style="' . $styleEventContentTitle . '" href="' .                             
                            $event_link_en . '">' . $event_name_en . '</a></h3>' . 
                            $htmlDatePeriodEN .
                            $htmlVenueEN .
                            $htmlShortDescEN .
                            $htmlCategoryEN . 
                            '</div>';
                    
                    $htmlEventContentSP = '<div style="' . $divEventContentStyleStr . '">' . 
                            '<h3><a target="blank" style="' . $styleEventContentTitle . '" href="' . 
                            $event_link_sp . '">' . $event_name_sp . '</a></h3>' .
                            $htmlDatePeriodSP .
                            $htmlVenueSP .
                            $htmlShortDescSP .
                            $htmlCategorySP . 
                            '</div>';
                    
                    $htmlFeatureImageEN = '<div style="' . $divFeatureStyleStr . ';height:20px;"></div>';
                    $htmlFeatureImageSP = '<div style="' . $divFeatureStyleStr . ';height:20px;"></div>';                    
                    
                    if($objfeatureimage->num_rows()) {
                        if ($objfeatureimage->f('media_url')) {
                            $featureImageLink = $obj_base_path->base_path() . '/files/event/medium/' . 
                                htmlentities(stripslashes($objfeatureimage->f('media_url')));

                            $htmlFeatureImageEN = '<div style="' . $divFeatureStyleStr . '">'
                                . '<a style="display: inline-block" target="blank" href="' . $event_link_en . '">'
                                . '<img style="' . $imgFeatureStyleStr . '" src="' . $featureImageLink . '"  border="0" />'
                                . '</a></div>';
                            
                            $htmlFeatureImageSP = '<div style="' . $divFeatureStyleStr . '">'
                                . '<a style="display: inline-block" target="blank" href="' . $event_link_sp . '">'
                                . '<img style="' . $imgFeatureStyleStr . '" src="' . $featureImageLink . '"  border="0" />'
                                . '</a></div>';
                        }
                    } else {
                        if($objEventListing->f('event_photo')) {
                            $featureImageLink = $obj_base_path->base_path() . '/files/event/medium/' . 
                                htmlentities(stripslashes($objEventListing->f('event_photo')));
                            
                            $htmlFeatureImageEN = '<div style="' . $divFeatureStyleStr . '">'
                                . '<a style="display: inline-block" target="blank" href="' . $event_link_en . '">'
                                . '<img style="' . $imgFeatureStyleStr . '" src="' . $featureImageLink . '"  border="0" />'
                                . '</a></div>';
                            
                            $htmlFeatureImageSP = '<div style="' . $divFeatureStyleStr . '">'
                                . '<a style="display: inline-block" target="blank" href="' . $event_link_en . '">'
                                . '<img style="' . $imgFeatureStyleStr . '" src="' . $featureImageLink . '"  border="0" />'
                                . '</a></div>';
                        }
                    }                                        
                    
                    $htmlDivClearBoth = '<div style="clear: both; height: 0px; line-height: 0px;"></div>';
                    
                    $singleBlockEventEN = '<div style ="' . $styleDivContainer . '">' . 
                            $htmlFeatureImageEN . $htmlEventContentEN . '</div>' . $htmlDivClearBoth;
                    $singleBlockEventSP = '<div style ="' . $styleDivContainer . '">' . 
                            $htmlFeatureImageSP . $htmlEventContentSP . '</div>' . $htmlDivClearBoth;
                    
                    $eventListHTMLEN = $eventListHTMLEN . $singleBlockEventEN;
                    $eventListHTMLSP = $eventListHTMLSP . $singleBlockEventSP;
                } 
            }
        }
        
        $footerSectionFixedEN = '<p style="' . $paragraphStyleStr . '">Check the '
                . '<a target="blank" style="' . $normalLinkStyleStr . '" href="http://kpasapp.com/en/home">'
                . 'complete schedule of upcoming events in La Paz, Los Cabos and all of Baja California Sur</a>'
                . '<br>Thank you for sharing with your friends.</p>';
        
        $footerSectionFixedSP = '<p style="' . $paragraphStyleStr . '">Revise la '
                . '<a target="blank" style="' . $normalLinkStyleStr . '" href="http://kpasapp.com/es/inicio">'
                . 'programaci&oacute;n completa de los pr&oacute;ximos eventos en La Paz, Los Cabos y todo Baja California Sur</a>'
                . '<br>Gracias por compartir con tus amigos.</p>';
        
        
        $page_content_en = '<h1 style="' . $headerStyleStr . '">' . $title_en . '</h1>';
        if (!empty($headerSectionEN)) {
            $page_content_en = $page_content_en . $headerSectionEN . $headerSectionFixedEN;
        }
        if (!empty($eventListHTMLEN)) {
            $page_content_en = $page_content_en . $eventListHTMLEN;
        }
        
        $page_content_sp = '<h1 style="' . $headerStyleStr . '">' . $title_sp . '</h1>';
        if (!empty($headerSectionSP)) {
            $page_content_sp = $page_content_sp . $headerSectionSP . $headerSectionFixedSP;
        }
        if (!empty($eventListHTMLSP)) {
            $page_content_sp = $page_content_sp . $eventListHTMLSP;
        }
        
        // Append footer section
        $page_content_en = $page_content_en . $footerSectionFixedEN;
        $page_content_sp = $page_content_sp . $footerSectionFixedSP;
        

        $social = 1;

        $path = 'blog';    

        $file_name = "";

        $publish = 1;
        
    } else {
        
    }
    
    $objAdd->add_page($title_en, $title_sp, $page_content_en, $page_content_sp, $page_link, 
                    $social, $path, $file_name, $publish);
    echo mysql_insert_id();
}


