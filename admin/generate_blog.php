<?php

$language = 'en';
if ($_GET['language'] == 'English') {
    $language = 'en';    
} else if ($_GET['language'] == 'Espanol') {
    $language = 'sp';
}

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=blog_" . $language . ".doc");

include('../include/admin_inc.php');

$objevent = new merchant_admin;

$cur = date_format(date_create_from_format('d/m/Y', $_GET['from_date']), 'Y-m-d 00:00:00');
$upto = date_format(date_create_from_format('d/m/Y', $_GET['to_date']), 'Y-m-d 00:00:00');

$objevent->get_event($cur,$upto);

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";

if($objevent->num_rows()>0){
    while($objevent->next_record()){
        echo "<h2>".date("l, F j",strtotime($objevent->f('event_start_date_time'))).":</h2>";   
        echo "<h3>"
	        .date("g:i A",strtotime($objevent->f('event_start_date_time'))).": ".
        	"<a href='".$obj_base_path->base_path()."/event/".$objevent->f('event_id')."'>".$objevent->f('event_name_' . $language)."</a>
        </h3>";
        echo "<h4>".$objevent->f('venue_name').", ".$objevent->f('city_name')."</h4>";  

        echo "".stripslashes($objevent->f('event_details_' . $language))."";
    }
}

echo "</body>";
echo "</html>";
?>
