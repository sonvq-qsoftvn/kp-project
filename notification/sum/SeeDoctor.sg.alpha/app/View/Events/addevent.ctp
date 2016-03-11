<?php
$my_data=$this->request->data;

?>


<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinics">Events</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Edit Event</a> 
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
        
        <span>Edit Clinic Form</span>
    </div>

     <div class="row-fluid">
          <div class="utopia-widget-content">
               <div class="span12 utopia-form-freeSpace">
                    <div class="sample-form">
                         <?php echo $this->Form->create('Event',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
                        
                         <fieldset>
                             

                             
                             <div class="control-group">
                                 <label class="control-label" for="name">Event Name*:</label>
 
                                 <div class="controls">
                                     <?php
                                     echo $this->Form->input('event_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'event_name'));
                                     ?>
                                     
                                 </div>
                             </div>
                             <div class="control-group">
                                <label class="control-label" for="event_time">Event Date*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('event_time',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-medium', 'id' => 'event_time','value'=>date('Y/m/d')));
                                    ?>
                                    
                                </div>
                            </div>
                             
                            <div class="control-group">
                              <label class="control-label" for="logo">Event Logo:</label>

                              <div class="controls">
                                  <input class='input-fluid' id='logo' name='logo' type='file'/>
                                 
                              </div>
                            </div>
                              
                            <div class="control-group">
                                 <label class="control-label" for="brief_text">Brief Description*:</label>
 
                                 <div class="controls">
                                     
                                     <?php echo $this->Form->input('brief_text',array('type' => 'textarea','id' => 'brief_text','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid')); ?>
                                     
                                     
                                 </div>
                             </div>
                            
                            <div class="control-group">
                                 <label class="control-label" for="brief_text">Description*:</label>
 
                                 <div class="controls">
                                     
                                     <?php echo $this->Form->input('description',array('type' => 'textarea','id' => 'description','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                     
                                     
                                 </div>
                             </div>
                            
                            <div class="control-group">
                              <label class="control-label" for="poster_image">Poster Image:</label>

                              <div class="controls">
                                  <input class='input-fluid' id='poster_image' name='poster_image' type='file'/>
                                 
                              </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="license">Organizer Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('organizer_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'license'));
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                 <label class="control-label" for="address">Address*:</label>
 
                                 <div class="controls">
                                     
                                     <?php echo $this->Form->input('address',array('type' => 'textarea','id' => 'address','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                     
                                     
                                 </div>
                             </div>
                            
                             <div class="control-group">
                                 <label class="control-label" for="name">Admission Fees*:</label>
 
                                 <div class="controls">
                                     <?php
                                     echo $this->Form->input('admission_fees',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'admission_fees'));
                                     ?>
                                     
                                 </div>
                             </div>
                              <div class="control-group">
                                 <label class="control-label" for="name">Contact Email*:</label>
 
                                 <div class="controls">
                                     <?php
                                     echo $this->Form->input('contact_email',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'contact_email'));
                                     ?>
                                     
                                 </div>
                             </div>
                               <div class="control-group">
                                 <label class="control-label" for="name">Contact Number:</label>
 
                                 <div class="controls">
                                     <?php
                                     echo $this->Form->input('contact_number',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'contact_number'));
                                     ?>
                                     
                                 </div>
                             </div>
                              
                              <div class="control-group">
                                 <label class="control-label" for="address">Message To Participant*:</label>
 
                                 <div class="controls">
                                    <?php echo $this->Form->input('msg_to_participant',array('type' => 'textarea','id' => 'msg_to_participant','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                  
                                 </div>
                             </div>
                              
				
                          
                             <div class="utopia-from-action">
                                 <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                                <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinics'">Cancel</button>
                             </div>
                         </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
               </div>
          </div>
     </div>
</section>

<!--script for this page only-->
<script>
            
            
            //change handphone to 8 digit
            
            $(window).load(function(){v=$('#handphone').val();if(v.length==10){new_v='';for(i=2;i<v.length;i++){new_v+=v[i];}$('#handphone').val(new_v);}});
            
            //form validation
            
            function do_validate()
            {
                        
                        status=1;
                        //cm=document.getElementById('clinicmanagersid').value;
                         
                        n=document.getElementById('event_name').value;
                         
                        //l=document.getElementById('license').value;
                        // 
                        //hp=document.getElementById('handphone').value;
                        //
                        //hp='65'+hp;
                        //u=document.getElementById('url').value;
                        // 
                        //addr=CKEDITOR.instances.address.getData();
                        //cs=document.getElementById('type').value;
                        //a=CKEDITOR.instances.about.getData();
                        
                 
                        
                        //var phExp=/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
                         
                        if (n=='')
                        {
                                    alert('Please enter clinic name');
                                    document.getElementById('event_name').focus();
                                    status=0;
                        }
                        //else if (l=='')
                        //{
                        //            alert('Please enter clinic license number');
                        //            document.getElementById('license').focus();
                        //            status=0;
                        //}
                        //else if (cm=='')
                        //{
                        //            alert('Please select a clinic manager');
                        //            document.getElementById('clinicmanagersid').focus();
                        //            status=0;
                        //}
                        //else if (hp=='')
                        //{
                        //            alert('Please enter hand phone');
                        //            document.getElementById('handphone').focus();
                        //            status=0;
                        //}
                        ////else if (!hp.match(phExp))
                        ////{
                        ////         alert('Invalid hand phone');
                        ////         document.getElementById('handphone').focus();
                        ////         status=0;   
                        ////}
                        //else if (addr=='')
                        //{
                        //            alert('Please enter address');
                        //            document.getElementById('address').focus();
                        //            status=0;
                        //}
                        //else if (u=='')
                        //{
                        //            alert('Please enter url');
                        //            document.getElementById('url').focus();
                        //            status=0;
                        //}
                        //else if (!u.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/))
                        //{
                        //         alert('Invalid clinic url');
                        //         document.getElementById('url').focus();
                        //         status=0;   
                        //}
                        //else if (cs==''||cs==0)
                        //{
                        //            alert('Please enter speciality');
                        //            document.getElementById('type').focus();
                        //            status=0;
                        //}
                        //else if (a=='')
                        //{
                        //            alert('Please enter about');
                        //            document.getElementById('about').focus();
                        //            status=0;
                        //}
                        //else if (validation.elements["insurances[]"].selectedIndex == -1)
                        //{
                        //            alert("Please select an insurance.");
                        //            status=0;
                        //}
                        //else if (validation.elements["eligibilities[]"].selectedIndex == -1)
                        //{
                        //            alert("Please select an eligibility.");
                        //            status=0;
                        //}
                        //
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>