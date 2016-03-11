
<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinics">Clinics</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/appointments?clinicid=<?php echo $clinicid;?>">Appointments</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <span>Add Appointtment</span> 
                    </li>
                </ul>
            </div>
        </div>
<?php
if($msg!=array())
{
?>
<div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        <ul>
                                    
                        <?php
                        foreach($msg as $k=>$v)
                        {
                        ?>
                                                <li><?php echo $v;?></li>
                                    
                        <?php
                                    
                        }
                        ?>
                        </ul>
            </div>
<?php
}
?>

<section id="utopia-wizard-form" class="utopia-widget utopia-form-box">
    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>Add Appointment Form</span>
    </div>
	<h2 id='noslot' style='display:none;color:red;'> Sorry clinic will remain closed on this date</h2>
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Appointment',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','onsubmit'=>'return do_validate();')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="uid">Booked By (email id)*:</label>

                                <div class="controls">
                                   
                                    <?php
                                        $options_arr=array();
                                        $options_arr['']='Please Select An User';
                                       foreach($all_users as $k=>$v)
                                        {
                                           $options_arr[$v['User']['id']]=$v['User']['email'];
                                        }
                                         
                                        echo $this->Form->input('uid',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'uid', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select a user','class'=>'chzn-select-deselect'));
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="date">Appointment date*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('date',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-medium', 'id' => 'date','value'=>date("Y/m/d")));
                                    ?>
                                    
                                </div>
                            </div>

                            
                            <div class="control-group">
                                <label class="control-label myshowhide" for="cancelledslotid" style='display:none;'>Choose base timing* :</label>

                                <div class="controls" id='forslotlist'>
                                    
                                    
                                </div>
                            </div>
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label myshowhide2" for="slotid" style='display:none;'>Choose slot* :</label>

                                <div class="controls" id='formainslotlist'>
                                    
                                    
                                </div>
                            </div>
                            
                             <div class="utopia-from-action myshowhide2" style='display:none;'>
                                <button class="btn btn-primary span2" type="submit" style="margin-left:15%;">Save changes</button>
                               <button class="btn span2" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/appointments?clinicid=<?php echo $clinicid;?>'">Cancel</button>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
     ////////////////////////////////////////////////////validation starts//////////////////////////////////////////////////////////
     
     function do_validate()
     {
     	uid=document.getElementById('uid').value;
     	dt=document.getElementById('date').value;
     	
     	multiplier=document.validation.multiplier;
     	error_status=0;
     	if(uid=='')
     	{
     		error_status=1;
     		alert('Please select a user email id');
     	}
     	else if(dt=='')
     	{
     		error_status=1;
     		alert('Please select a date');
     	}
     	else
     	{
     		error_status=1;
     		for(i=0;i<multiplier.length;i++)
     		{
     			if(multiplier[i].checked)
     			{
     				error_status=0;
     				break;
     			}
     		}
     		if(error_status==1)
     		{
     			alert('Please select a slot');
     		}
     	}
     	
     	
     	if(error_status==1)
     	return false;
     }
     
     
     
     
     
     
     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////       
            // ajax call for getting slot lists
            
            function ajax_list2(u)
    		{
    			          var the_date=document.getElementById('date').value;
				          var slotid=document.getElementById('cancelledslotid').value;
				          
				            
				           var xmlhttp;
				            if (window.XMLHttpRequest)
				              {
				                        // code for IE7+, Firefox, Chrome, Opera, Safari
				                        xmlhttp=new XMLHttpRequest();
				              }
				            else
				              {
				                        // code for IE6, IE5
				                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				              }
				            xmlhttp.onreadystatechange=function()
				              {
				              	if (xmlhttp.readyState==4)
				                {
				                        
				                        
				                        
				                                    $('.myshowhide2').css('display','inline');
				                                    $('#noslot').hide();
				                                    document.getElementById("formainslotlist").innerHTML=xmlhttp.responseText;
				                                    
				                                    
				                       
				                        
				                }
				              }
				            xmlhttp.open("GET",u+"?slotid="+slotid+"&dt="+the_date,true);
				            xmlhttp.send();     
			           
    		}
            // ajax call for getting opening hours
            function ajax_list(u)
    		{
				           dt=document.getElementById('date').value;
				           arr=dt.split('/');
				           d=arr[2];
				           m=arr[1];
				           y=arr[0];
				            
				           var xmlhttp;
				            if (window.XMLHttpRequest)
				              {
				                        // code for IE7+, Firefox, Chrome, Opera, Safari
				                        xmlhttp=new XMLHttpRequest();
				              }
				            else
				              {
				                        // code for IE6, IE5
				                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				              }
				            xmlhttp.onreadystatechange=function()
				              {
				              if (xmlhttp.readyState==4)
				                {
				                        
				                        
				                        if (!(xmlhttp.responseText=='Sorry no slot to be cancelled on this date!!!'))
				                        {
				                                    $('.myshowhide').css('display','inline');
				                                    $('#noslot').hide();
				                                    document.getElementById("forslotlist").innerHTML=xmlhttp.responseText;
				                                    $('.myshowhide2').css('display','none');
				                                    
				                                    document.getElementById("formainslotlist").innerHTML='';
				                                    ajax_list2('<?php echo BASE_URL;?>administrator/slotlist2');
				                                    $('#cancelledslotid').change(function(){ajax_list2('<?php echo BASE_URL;?>administrator/slotlist2');});
				                                    
				                        }
				                        else
				                        {
				                                    $('.myshowhide').css('display','none');
				                                    $('.myshowhide2').css('display','none');
				                                    $('#noslot').show();
				                                    document.getElementById("forslotlist").innerHTML='';
				                                    $('.myshowhide2').css('display','none');
				                                    
				                                    document.getElementById("formainslotlist").innerHTML='';
				                        }
				                }
				              }
				            xmlhttp.open("GET",u+"?d="+d+"&m="+m+"&y="+y+"&clinicid=<?php echo $clinicid;?>",true);
				            xmlhttp.send();     
			           
    		}
    		
    		//calling the ajax functions on change
    		$(document).ready(function(){ajax_list('<?php echo BASE_URL;?>administrator/slotlist');$('#date').change(function(){ajax_list('<?php echo BASE_URL;?>administrator/slotlist');});});
</script>
