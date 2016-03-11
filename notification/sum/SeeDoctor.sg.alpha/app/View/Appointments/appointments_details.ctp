<?php

foreach($slot_details as $slots)
{
	$det[] = $slots['Openinghour']['id'].'@'.$slots['Openinghour']['fromhour'].'.'.$slots['Openinghour']['fromminutes'].' - '.$slots['Openinghour']['tohour'].'.'.$slots['Openinghour']['tominutes'];
	
}

echo $app_details.'|@|'.$selected_slot.'|@|'.implode(',', $det);

?>