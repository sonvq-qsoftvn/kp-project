<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinics">Clinics</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <span>Appointments</span>
                    </li>
                </ul>
            </div>
        </div>

<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the column name to sort by that column</marquee>

<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
			
                   <li>
                         <a href="<?php echo BASE_URL;?>administrator/appointments?clinicid=<?php echo $clinicid;?>">Approve</a> <span class="divider">|</span>
                    </li>
		   
                    <li>
			<a href="<?php echo BASE_URL;?>administrator/clinicownerappointments?clinicid=<?php echo $clinicid; ?>">Pending Approve From You</a><span class="divider">|</span>
                        
                    </li>
		    
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinicpendingappointments?clinicid=<?php echo $clinicid;?>">Pending Approve By Clinic Manager</a> 
                    </li><span class="divider">|</span>
		    
		    <li class='active disabled'>
                        <span>Past Appoinment</span>
                    </li>
                    
                </ul>
            </div>
        </div>

<!-- Message section Starts-->
<h2 style='color:tomato;font-weight:bolder;margin-left:4%;'><?php echo $msg;?></h2>
<!--  Message section Ends-->

<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span><?php echo $clinicname;?> ::Pending Approve Appointment List</span>
                        </div>

                        <div class="utopia-widget-content">
                                    
 
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">Sl No.</th>
                                    <th style="width: 23%;"><?php echo $this->Paginator->sort('User.username','Booked By');?></th>
                                    <th style="width: 22%;"><?php echo $this->Paginator->sort('Appointment.date','Date');?></th>
                                    <th style="width: 25%;">Time</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    //picking the paginator parameters
                                    $paginator_params=($this->paginator->params());
                                    
                                    //starting point of serial no. for current page
                                    $sl_start=($paginator_params['page']*$paginator_params['current'])-($paginator_params['current']-1);
                                    
                                    //listing all the pages in tabular form
                                    foreach($all_appointments as $k=>$individual)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo $individual['User']['username'];?></td>
                                            <td><?php echo $individual['Appointment']['date'];?></td>
                                            <td>
                                            	<?php
                                            		
                                            	//time calculation starts
                                            		
                                            	//picking up the appointment breakup time in minutes
                                            	$breakup=15;
                                            		
                                            	//picking up the basic slot first 
                                            	$fh=$individual['Oh']['fromhour'];
						$fm=$individual['Oh']['fromminutes'];
													
                                            	$th=$individual['Oh']['tohour'];
						$tm=$individual['Oh']['tominutes'];
						
						//picking up the multiplier
						$multiplier=$individual['Appointment']['multiplier'];
						
						$endhour=$fh;
						$endminutes=$fm+($breakup*$multiplier);
						if($endminutes>=60)
						{
							$endhour=$endhour+($endminutes/60);
							$endminutes=($endminutes%60);
						}
						$starthour=$endhour;
						$startminutes=$endminutes-$breakup;
						if($startminutes<0)
						{
							
							$arr=$this->Appointment->calculate_starthour_and_minutes(array($starthour,$startminutes));
							$starthour=$arr[0];
							$startminutes=$arr[1];
						}
						echo sprintf('%02d',$starthour)." : ".sprintf('%02d',$startminutes).' - '.sprintf('%02d',$endhour)." : ".sprintf('%02d',$endminutes);
						
													
                                            	?>
                                            </td>
                                           
                                
                                        </tr>
                                    <?php
                                    }
                                    
                                    ?>
                                </tbody>

                            </table>
                            <div class="row-fluid">
                                <div class="span6"><div class="dataTables_info" id="DataTables_Table_0_info"><?php echo $this->Paginator->counter(array(
    'format' => 'Page {:page} of {:pages}, showing {:current} records out of
             {:count} total'
));?></div></div>

                                <div class="span6">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul>
                                                            <?php
                                                                
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->prev(
                                                                  ' ←',
                                                                  $options=array('tag'=>'li','class'=>'prev','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'prev disabled')
                                                                );
                                                                
                                                                // Shows the page numbers
                                                                echo $this->Paginator->numbers($options=array('tag'=>'li','separator'=>'','currentTag'=>'a','currentClass'=>'active'));
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->next(
                                                                  '→ ',
                                                                  $options=array('tag'=>'li','class'=>'next','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'next disabled')
                                                                );
                    
                                                            ?>
                                                </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
</div>



<script>

function active(appoint_id,clinic_id,status)
{
         
     $.get("<?php echo BASE_URL;?>administrator/approveappoints"+"?appointmentid="+appoint_id+"&"+"clinicid="+clinic_id+"status="+status,function(data,status){
     window.location = "<?php echo BASE_URL;?>administrator/appointments?clinicid="+clinic_id;
  });

}
</script>