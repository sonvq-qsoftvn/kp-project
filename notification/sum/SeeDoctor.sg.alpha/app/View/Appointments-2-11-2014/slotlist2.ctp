<?php
$start=$the_opening_hour['Openinghour']['fromhour']*60+$the_opening_hour['Openinghour']['fromminutes']; //calculating starting point
$end=$the_opening_hour['Openinghour']['tohour']*60+$the_opening_hour['Openinghour']['tominutes']; //calculating end point
$increment=$breakup;

//collecting the booked and pending slot multipliers in array

$booked_slots=array();
$pending_slots=array();

if(count($all_slots)!=0)
{
	foreach($all_slots as $individual_slot)
	{
		
		if($individual_slot['Appointment']['status']==1||$individual_slot['Appointment']['status']==0)
		{
			$pending_slots[]=$individual_slot['Appointment']['multiplier'];
		}
		else if($individual_slot['Appointment']['status']==2) 
		{
			$booked_slots[]=$individual_slot['Appointment']['multiplier'];
		}
	}

}


?>
<div style='float:left; color:black;margin-top:2%;padding:1%;height:auto;'> 
	
	<div style='float:left;'>
		<div style="background-color:#005C00;width:10%;float:left;">
		&nbsp;&nbsp;&nbsp;
		</div>
		<div style="float:left;">
			 &nbsp;&nbsp;= available,
		</div>
		
	</div>
	<div style='float:left;'>
		<div style="background-color:#99995C;width:10%;float:left;">
		&nbsp;&nbsp;&nbsp;
		</div>
		<div style="float:left;">
			 &nbsp;&nbsp;= pending, 
		</div>
		
	</div>
	<div style='float:left;'>
		<div style="background-color:#801A00;width:10%;float:left;">
		&nbsp;&nbsp;&nbsp;
		</div>
		<div style="float:left;">
			 &nbsp;&nbsp;= booked 
		</div>
		
	</div>
		
	
</div>
<div style='background-color: black;float:left; width:86%; color:white;margin-top:2%;padding:2%;height:auto;'>
	<?php
	 for($i=$start,$multiplier=1;$i<$end;$i=$i+$increment,$multiplier++)
	 {
	 	//finding if the current slot is already booked or pending booking
	 	if(gettype(array_search($multiplier, $booked_slots))!='boolean')
		{
			$input='off';
			$backgroundcolor='#801A00';
		}
		else if(gettype(array_search($multiplier, $pending_slots))!='boolean')
		{
			$input='off';
			$backgroundcolor='#99995C';
		}
		else 
		{
			$input='on';
			$backgroundcolor='#005C00';
		}
		$fh=(int)($i/60);
		$fm=$i%60;
		$th=(int)(($i+$increment)/60);
		$tm=(($i+$increment)%60);
	?>
		<div style="width:17%;float:left;margin:2%;padding:2%;background-color: <?php echo $backgroundcolor;?>;">
			<?php
				if($input=='on')
				{
					?>
					<input type='radio' name='multiplier' value='<?php echo $multiplier;?>'>
			
					<?php
				}
			?>
			<br/>
			From&nbsp;:&nbsp;<?php echo sprintf("%02d", $fh).' : '.sprintf("%02d", $fm);?><br/>
			To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo sprintf("%02d", $th).' : '.sprintf("%02d", $tm);?> 
		</div> 	
	<?php
	 }
	?>
	
	
	
</div>

