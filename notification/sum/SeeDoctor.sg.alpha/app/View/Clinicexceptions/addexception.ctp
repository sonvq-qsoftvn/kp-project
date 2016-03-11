<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinicexceptions?clinicid=<?php echo $clinicid;?>">Exceptions</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Add Exception</a> 
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
        
        <span>Add Exception Form</span>
    </div>
<h2 id='noslot' style='display:none;color:red;'> Sorry no slots to be cancelled for this clinic</h2>
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Clinicexception',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                        <fieldset>

                            <div class="control-group">
                                <label class="control-label" for="date">Date* :</label>

                                <div class="controls">
                                    <select name='year' id='year'>
                                     
                                     <?php
                                     for($i=date('Y'),$j=0;$j<10;$i++,$j++)
                                     {
                                                ?>
                                                <option><?php echo $i;?></option>
                                                <?php
                                     }
                                     ?>
                                     
                                    </select>
                                    <select name='month' id='month'>
                                    
                                    <?php
                                     for($i=1;$i<=12;$i++)
                                     {
                                                ?>
                                                <option <?php if($i==date('m')){?>selected='selected'<?php }?> ><?php echo sprintf('%02d',$i);?></option>
                                                <?php
                                     }
                                     ?>
                                     
                                    </select>
                                    <select name='date' id='date' >
                                    
                                    <?php
                                     for($i=1;$i<=31;$i++)
                                     {
                                                ?>
                                                <option <?php if($i==date('d')){?>selected='selected'<?php }?>><?php echo sprintf('%02d',$i);?></option>
                                                <?php
                                     }
                                     ?>
                                    
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                    <div class="controls">
                                                <button onclick="ajax_list('<?php echo BASE_URL;?>administrator/slotlist')" class="btn btn-primary span2" type="button">Show Slot List</button>
                                                
                                    </div>
                                                
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label myshowhide" for="cancelledslotid" style='display:none;'>Choose Slot* :</label>

                                <div class="controls" id='forslotlist'>
                                    
                                    
                                </div>
                            </div>
                            <input type='hidden' name='clinicid' value='<?php echo $clinicid;?>'/>
            <div class="utopia-from-action myshowhide" style='display:none;'>
                                <button class="btn btn-primary span2" type="submit" style="margin-left:15%;">Save changes</button>
                               <button class="btn span2" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinics'">Cancel</button>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    //ajax_call
    function ajax_list(u)
    {
           var d=document.getElementById('date').value;
            var m=document.getElementById('month').value;
            var y=document.getElementById('year').value;
            arr=new Array();
            arr[1]=31;
            arr[2]=28;
            arr[3]=31;
            arr[4]=30;
            arr[5]=31;
            arr[6]=30;
            arr[7]=31;
            arr[8]=31;
            arr[9]=30;
            arr[10]=31;
            arr[11]=30;
            arr[12]=31;
            if((((parseInt(y)%4)==0)&&((parseInt(y)%100)!=0))||(parseInt(y)%400==0))
            {
            	arr[2]=29;
            }
            
            if(parseInt(d)>arr[parseInt(m)])
            {
            	alert('Invalid date');
            }
            else
            {
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
	                                    
	                        }
	                        else
	                        {
	                                    $('.myshowhide').css('display','none');
	                                    $('#noslot').show();
	                                    document.getElementById("forslotlist").innerHTML='';
	                        }
	                }
	              }
	            xmlhttp.open("GET",u+"?d="+d+"&m="+m+"&y="+y+"&clinicid=<?php echo $clinicid;?>",true);
	            xmlhttp.send();     
           }
    }
</script>