<?php
// Newsletter generator - Spanish version
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=newsletter_sp.doc");

include('../include/admin_inc.php');
$objevent=new merchant_admin;

$cur = date("Y-m-d H:i:s",time());
$upto = date("Y-m-d H:i:s",strtotime('+30 days'));
$objevent->get_event($cur,$upto);
setlocale(LC_TIME, 'es_ES.UTF-8');

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";

if($objevent->num_rows()>0){
    while($objevent->next_record()){
        echo "<h2>".ucfirst(strftime("%A %e de %B",strtotime($objevent->f('event_start_date_time')))).":</h2>";   
        echo "<h3>"
	        .date("g:i A",strtotime($objevent->f('event_start_date_time'))).": ".
        	"<a href='".$obj_base_path->base_path()."/event/".$objevent->f('event_id')."'>".$objevent->f('event_name_sp')."</a>
        </h3>";
        echo "<h4>".$objevent->f('venue_name_sp').", ".$objevent->f('city_name')."</h4>";  

        //echo "".stripslashes($objevent->f('event_short_desc_sp'))."<br>";
        echo "".stripslashes($objevent->f('event_details_sp'))."";
        
    }
}

echo "</body>";
echo "</html>";
?>