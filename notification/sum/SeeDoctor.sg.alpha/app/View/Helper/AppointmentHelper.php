<?php
App::uses('AppHelper', 'View/Helper');

class AppointmentHelper extends AppHelper 
{
 													// function for calculating start hour and minutes
													function calculate_starthour_and_minutes($arr)
													{
														$starthour=$arr[0];
														$startminutes=$arr[1];
														
														$starthour--;
														$startminutes=$startminutes+60;
													
														if($startminutes<0)
														{
															return calculate_starthour_and_minutes(array($starthour,$startminutes));
														}	
														else 
														{
															return array($starthour,$startminutes);
															
														}
													}
}
?>