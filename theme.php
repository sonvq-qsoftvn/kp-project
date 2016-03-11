<?php
//index page
include('include/user_inc.php');

	

?>

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/theme.css' />
<link href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/jquery-1.9.1.min.js'></script>
<script src='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/jquery-ui-1.10.2.custom.min.js'></script>
<script src='<?php echo $obj_base_path->base_path(); ?>/fullcalendar/fullcalendar.js'></script>
<script>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		
		$('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			
			events: [
			
			<?php
			$objEvent=new user;
			$objEvent->eventDetails();
			if($objEvent->num_rows())
			{
				while($objEvent->next_record())
				{
				   list($startdate,$starttime) = explode(" ",$objEvent->f('event_start_date_time'));
				   list($enddate,$endTime) = explode(" ",$objEvent->f('event_end_date_time'));
				   
				   list($st_yr,$st_mn,$st_day) = explode("-",$startdate);
				   list($en_yr,$en_mn,$en_day) = explode("-",$enddate);
			?>
					{
						title: '<?php echo $objEvent->f('event_name_en'); ?>',
						start: new Date(<?php echo $st_yr?>, <?php echo ($st_mn-1);?>, <?php echo $st_day?>),
						end: new Date(<?php echo $en_yr?>, <?php echo ($en_mn-1);?>,<?php echo $en_day?>),
						url: 'http://google.com/'
					},
			<?php
				}
			}
			 ?>

				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
		
	});

</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 13px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<body>
<div id='calendar'></div>
</body>
</html>
